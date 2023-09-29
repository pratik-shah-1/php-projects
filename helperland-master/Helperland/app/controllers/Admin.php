<?php

namespace app\controllers;

use core\Request;
use core\Response;
use core\Mail;
use core\Database;

use app\models\User;
use app\models\Service;
use app\models\ServiceAddress;
use app\models\Rating;
use app\services\Functions;

class Admin{

    private $NEW_STATUS       = 0;
    private $ASSIGNED_STATUS  = 1; // (ACCEPTED BY SP BUT NOT COMPLETED)
    private $COMPLETED_STATUS = 2;
    private $CANCELLED_STATUS = 3;

    // ----------USER-MANAGEMENT----------
    public function userManagement(Request $req, Response $res){
        $db = new Database();
        $sql = "SELECT user.UserId,
                       CONCAT(user.FirstName,' ',user.LastName) AS UserName,
                       user.CreatedDate,
                       user.RoleId,
                       user.Mobile,
                       user.IsActive,
                       address.PostalCode
                FROM user
                LEFT JOIN useraddress AS address ON user.UserId = address.UserId
                WHERE user.RoleId != 3
                GROUP BY user.UserId";
        $data = $db->query($sql);
        foreach($data as $key){
            $key->CreatedDate = date('d/m/Y', strtotime($key->CreatedDate));
        }
        $res->json($data);
    }

    // --------SERVICE-REQUEST----------
    public function serviceRequests(Request $req, Response $res){
        $db = new Database();
        $sql = "SELECT service.ServiceRequestId,
                       service.UserId AS CustomerId,
                       service.ServiceProviderId,
                       service.ServiceStartDate, 
                       service.TotalCost,
                       service.ExtraHours + service.ServiceHours AS Duration,
                       service.Comments,
                       service.HasPets,
                       service.Status,
                       address.AddressLine1,
                       address.AddressLine2,
                       address.PostalCode,
                       address.City,
                       address.Mobile,
                       address.Email,
                       rating.Ratings,
                       CONCAT(customer.FirstName,' ',customer.LastName) AS CustomerName,
                       CONCAT(serviceProvider.FirstName,' ',serviceProvider.LastName) AS ServiceProviderName,
                       serviceProvider.UserProfilePicture AS ServiceProviderProfilePicture,
                       GROUP_CONCAT(extraService.ServiceExtraId) AS ExtraService
                FROM servicerequest AS service
                INNER JOIN servicerequestaddress AS address ON service.ServiceRequestId = address.ServiceRequestId
                LEFT JOIN servicerequestextra AS extraService ON service.ServiceRequestId = extraService.ServiceRequestId
                INNER JOIN user AS customer ON service.UserId = customer.UserId
                LEFT JOIN user AS serviceProvider ON service.ServiceProviderId = serviceProvider.UserId
                LEFT JOIN rating ON service.ServiceRequestId = rating.ServiceRequestId
                GROUP BY service.ServiceRequestId
                ORDER BY service.ServiceRequestId";
    
        $data = $db->query($sql);
    
        for($i=0; $i<count($data); $i++){
            $data[$i]->TotalCost = (int) $data[$i]->TotalCost;
            $data[$i]->ServiceDate = date('d/m/Y', strtotime($data[$i]->ServiceStartDate));
            $data[$i]->StartTime = date('H:i', strtotime($data[$i]->ServiceStartDate));
            $data[$i]->EndTime = date('H:i', strtotime("+".($data[$i]->Duration*60)." minutes", strtotime($data[$i]->ServiceStartDate)));
            $data[$i]->Duration = date('H:i', mktime(0, $data[$i]->Duration*60) );
            if($data[$i]->ExtraService!=null){
                $data[$i]->ExtraService = array_map('intval', explode(',', $data[$i]->ExtraService));
            }            
            // ----------FOR MAKING DATA AS NESTED OBJECT----------
            $data[$i] = [
                'Service' => [
                    'Id' => $data[$i]->ServiceRequestId,
                    'ServiceStartDate' => $data[$i]->ServiceStartDate,
                    'ServiceDate' => $data[$i]->ServiceDate,
                    'StartTime' => $data[$i]->StartTime,
                    'EndTime' => $data[$i]->EndTime,
                    'Duration' => $data[$i]->Duration,
                    'TotalCost' => $data[$i]->TotalCost,
                    'Comments' => $data[$i]->Comments,
                    'HasPets' => $data[$i]->HasPets,
                    'Status' => $data[$i]->Status,
                    'ExtraService' => $data[$i]->ExtraService
                ],
                'ServiceAddress' => [
                    'AddressLine1' => $data[$i]->AddressLine1,
                    'AddressLine2' => $data[$i]->AddressLine2,
                    'City' => $data[$i]->City,
                    'PostalCode' => $data[$i]->PostalCode
                ],
                'Customer' => [
                    'Id' => $data[$i]->CustomerId,
                    'Name' => $data[$i]->CustomerName,
                ],
                'ServiceProvider' => [
                    'Id' => $data[$i]->ServiceProviderId,
                    'Name' => $data[$i]->ServiceProviderName,
                    'ProfilePicture' => $data[$i]->ServiceProviderProfilePicture,
                    'Ratings' => $data[$i]->Ratings
                ],
            ];
        }
    
        $res->status(200)->json($data);
    }

    // --------MAKE-USER-ACTIVE----------
    public function makeUserActive(Request $req, Response $res){
        $userId = $req->params->id;
        $user = new User();
        $user->where('UserId', '=', $userId)->update([
            'IsActive' => 1
        ]);

        // ----------SEND EMAIL----------
        if(RES_WITH_MAIL){
            $fun = new Functions();
            $emailReceiver = $fun->getUserEmailByUserId($userId);
            $emailSubject = 'Account Activated by Admin';
            $emailBody = $res->template('admin/active-user',  ['$contactLink'=> BASE_URL.'/contact', '$loginLink' => BASE_URL.'/login']);
            Mail::send($emailReceiver, $emailSubject, $emailBody);
            $res->status(200)->json(['message'=>'User actived successfully.']);                
        }
        else{
            $res->status(200)->json(['message'=>'User actived successfully.']);
        }
    }

    // --------MAKE-USER-INSACTIVE----------
    public function makeUserInactive(Request $req, Response $res){
        $userId = $req->params->id;
        $user = new User();
        $user->where('UserId', '=', $userId)->update([
            'IsActive' => 0
        ]);

        if(RES_WITH_MAIL){
            // ----------SEND-MAIL----------
            $fun = new Functions();
            $contactUsLink = BASE_URL.'/contact';
            $emailReceiver = $fun->getUserEmailByUserId($userId);
            $emailSubject = 'Account Diactivated by Admin';
            $emailBody = $res->template('admin/inactive-user', ['$contactLink'=> BASE_URL.'/contact']);
            Mail::send($emailReceiver, $emailSubject, $emailBody);
            $res->status(200)->json(['message'=>'User actived successfully.']);
        }
        else{
            $res->status(200)->json(['message'=>'User inactived successfully.']);
        }

    }

    // --------RESCHEDULE_SERVICE----------
    public function rescheduleService(Request $req, Response $res){
        // REQUIRED VALIDATION PENDING...
        $serviceId = $req->params->id;
        $service = new Service();
        $serviceAddress = new ServiceAddress();
        $serviceStartDate = $req->body->date.' '.$req->body->time;
        $serviceStartDate = date('y-m-d h:i:s', strtotime($serviceStartDate));
        $serviceData = $service->where('ServiceRequestId', '=', $serviceId)->read();
        // UPDATE SERVICE
        $service->where('ServiceRequestId', '=', $serviceId)->update([
            'Status' => $serviceData[0]->ServiceProviderId==0? $this->NEW_STATUS : $this->ASSIGNED_STATUS,
            'ServiceStartDate' => $serviceStartDate
        ]);

        // UPDATE SERVICE ADDRESS
        $serviceAddress->where('ServiceRequestId', '=', $serviceId)->update([
            'AddressLine1' => $req->body->street_name,
            'AddressLine2' => $req->body->house_number,
            'PostalCode' => $req->body->postal_code,
            'City' => $req->body->city
        ]);

        if(RES_WITH_MAIL){
            // (CUSTOMER EMAIL)
            // ----------SEND-MAIL----------
            $fun = new Functions();
            $temp = $fun->getServiceDetailsByServiceId($serviceId);
            $emailReceiver = $temp->Email;
            $emailData = [];
            foreach($temp as $key => $value){
                $emailData['$'.$key] = $value;
            }
            $emailSubject = "Service Rescheduled By Admin";
            $emailBody = $res->template('/admin/reschedule-service', $emailData);
            Mail::send($emailReceiver, $emailSubject, $emailBody);
            $res->status(200)->json(['message'=>'Service Reschedule successfully.']);
        }
        else{
            $res->status(200)->json(['message'=>'Service Rescheduled By Admin']);
        }

    }

    // --------CANCEL_SERVICE----------
    public function cancelService(Request $req, Response $res){
        $serviceId = $req->params->id;
        $service = new Service();
        $service->where('ServiceRequestId', '=', $serviceId)->update([
            'Status' => $this->CANCELLED_STATUS
        ]);

        if(RES_WITH_MAIL){
            // (CUSTOMER EMAIL)
            // ----------SEND-MAIL----------
            $fun = new Functions();
            $temp = $fun->getServiceDetailsByServiceId($serviceId);
            $emailData = [];
            $emailReceiver = $temp->Email;
            $emailSubject = "Service Cancled by Admin";
            foreach($temp as $key => $value){
                $emailData['$'.$key] = $value;
            }
            $emailBody = $res->template('/admin/cancel-service', $emailData);
            Mail::send($emailReceiver, $emailSubject, $emailBody);
            $res->status(200)->json(['message'=>'Service cancelled successfully.']);
        }
        else{
            $res->status(200)->json(['message'=>'Service Canceled By Admin']);
        }

    }


}