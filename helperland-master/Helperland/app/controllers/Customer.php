<?php

namespace app\controllers;

use core\Request;
use core\Response;
use core\Validation;
use core\Database;
use core\Mail;

use app\models\Service;
use app\models\ExtraService;
use app\models\User;
use app\models\Rating;
use app\models\Favorite;
use app\services\Functions;

class Customer{

    private $NEW_STATUS       = 0;
    private $ASSIGNED_STATUS  = 1; // (ACCEPTED BY SP BUT NOT COMPLETED)
    private $COMPLETED_STATUS = 2;
    private $CANCELLED_STATUS = 3;

    // ----------SERVICES HISTORY (COMPLETED & CANCELLED)----------
    public function serviceHistory(Request $req, Response $res){
        $customerId = session('userId');
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
                WHERE service.UserId = {$customerId} AND (service.Status = {$this->COMPLETED_STATUS} OR service.Status = {$this->CANCELLED_STATUS})
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
                    'PostalCode' => $data[$i]->PostalCode,
                    'Mobile' => $data[$i]->Mobile,
                    'Email' => $data[$i]->Email
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

    // ----------CURRENT SERVICES----------
    public function currentServices(Request $req, Response $res){
        $customerId = session('userId');
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
                       CONCAT(customer.FirstName,' ',customer.LastName) AS CustomerName,
                       CONCAT(serviceProvider.FirstName,' ',serviceProvider.LastName) AS ServiceProviderName,
                       serviceProvider.UserProfilePicture AS ServiceProviderProfilePicture,
                       (SELECT ROUND(AVG(Ratings), 2) FROM rating WHERE RatingTo = service.ServiceProviderId) AS Ratings,
                       GROUP_CONCAT(extraService.ServiceExtraId) AS ExtraService
                FROM servicerequest AS service
                INNER JOIN servicerequestaddress AS address ON service.ServiceRequestId = address.ServiceRequestId
                LEFT JOIN servicerequestextra AS extraService ON service.ServiceRequestId = extraService.ServiceRequestId
                INNER JOIN user AS customer ON service.UserId = customer.UserId
                LEFT JOIN user AS serviceProvider ON service.ServiceProviderId = serviceProvider.UserId
                LEFT JOIN rating ON service.ServiceRequestId = rating.ServiceRequestId
                WHERE service.UserId = {$customerId} AND (service.Status = {$this->ASSIGNED_STATUS} OR service.Status = {$this->NEW_STATUS})
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
                    'PostalCode' => $data[$i]->PostalCode,
                    'Mobile' => $data[$i]->Mobile,
                    'Email' => $data[$i]->Email
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

    // ----------CANCEL SERVICE----------
    public function cancelService(Request $req, Response $res){
        $serviceId = $req->params->id;
        $service = new Service();
        $service->where('ServiceRequestId', '=', $serviceId)->update([
            'Status' => $this->CANCELLED_STATUS,
        ]);

        if(RES_WITH_MAIL){
            // ----------MAIL----------
            $fun = new Functions();
            $temp = $fun->getServiceDetailsByServiceId($serviceId);
            $emailReceiver = $temp->Email;
            $emailSubject = "Service Cancel";
            $emailData = [];
            foreach($temp as $key => $value){
                $emailData['$'.$key] = $value;
            }
            $emailBody = $res->template('customer/cancel-service-to-customer', $emailData);
            Mail::send($emailReceiver, $emailSubject, $emailBody);

            $spEmail = $fun->getSPEmailByServiceId($serviceId);
            if($spEmail!=null){
                // SEND EMAIL TO SP IF SP IS ACCEPTED SERVICE.
                $emailReceiver = $spEmail;
                $emailSubject = "Service Cancel";
                $emailBody = $res->template('customer/cancel-service-to-sp', $emailData);
                Mail::send($emailReceiver, $emailSubject, $emailBody);
            }
            $res->status(200)->json(['message'=>'Service cancelled successfully.']);

        }
        else{
            $res->status(200)->json(['message'=>'Service cancelled successfully.']);
        }
    }
    
    // ----------RESCHEDULE SERVICE----------
    public function rescheduleService(Request $req, Response $res){

        // DATE & TIME PROPER VALIDATION PENDING...
        Validation::check($req->body, [
            'date' => ['required'],
            'time' => ['required']
        ]);

        $serviceId = $req->params->id;
        $date = $req->body->date;
        $time = $req->body->time;
        $serviceDate = date('Y-m-d H:i:s', strtotime($date.' '.$time));
        $service = new Service();
        $serviceData = $service->where('ServiceRequestId', '=', $serviceId)->read();
        $service->where('ServiceRequestId', '=', $serviceId)->update([
            'ServiceStartDate' => $serviceDate,
            'Status' => $serviceData[0]->ServiceProviderId==0? $this->NEW_STATUS : $this->ASSIGNED_STATUS
        ]);

        if(RES_WITH_MAIL){
            // ----------SEND-MAIL----------
            // SEND MAIL TO CUSTOMER FOR THEIR CONFIRMATION...
            $fun = new Functions();
            $temp = $fun->getServiceDetailsByServiceId($serviceId);
            $emailReceiver = $temp->Email;
            $emailSubject = "Service Reschedule";
            $emailData = [];
            foreach($temp as $key => $value){
                $emailData['$'.$key] = $value;
            }
            $emailBody = $res->template('/customer/reschedule-service-to-customer', $emailData);
            Mail::send($emailReceiver, $emailSubject, $emailBody);
            $spEmail = $fun->getSPEmailByServiceId($serviceId);
            if($spEmail!=null){
                // SEND MAIL TO ASSIGNED SP 
                $emailReceiver = $spEmail;
                $emailSubject = 'Service Reschedule';
                $emailBody = $res->template('/customer/reschedule-service-to-sp', $emailData);
                Mail::send($emailReceiver, $emailSubject, $emailBody);
                $res->status(200)->json(['message'=>'Service has been reschedule successfully.']);
            }
            $res->status(200)->json(['message'=>'Service has been reschedule successfully.']);
        }
        else{
            $res->status(200)->json(['message'=>'Service has been reschedule successfully.']);
        }

    }

    // ----------RATE SERVICE PROVIDER----------
    public function rateServiceProvider(Request $req, Response $res){

        Validation::check($req->body, [
            'arrivalRating' => ['required'],
            'friendlyRating' => ['required'],
            'qualityRating' => ['required'],
            'ratingFeedback' => ['required'],
        ]);

        $serviceId = $req->params->id;
        $arrivalRating = (int) $req->body->arrivalRating;
        $qualityRating = (int) $req->body->qualityRating;
        $friendlyRating = (int) $req->body->friendlyRating;
        $ratingFeedback = $req->body->ratingFeedback;
        $averageRating =  (float) ($arrivalRating + $qualityRating + $friendlyRating )/3;

        $service = new Service();
        $data = $service->where('ServiceRequestId', '=', $serviceId)->read();
        $customerId = $data[0]->UserId;
        $serviceProviderId = $data[0]->ServiceProviderId;

        $rating = new Rating();
        if(!$rating->where('ServiceRequestId', '=', $serviceId)->exists()){
            $rating->create([
                'ServiceRequestId' => $serviceId,
                'RatingFrom' => $customerId,
                'RatingTo' => $serviceProviderId,
                'Ratings' => $averageRating,
                'Comments' => $ratingFeedback,
                'RatingDate' => date('Y-m-d H:i:s'),
                'OnTimeArrival' => $arrivalRating,
                'Friendly' => $friendlyRating,
                'QualityOfService' => $qualityRating,
            ]);            
            $res->status(200)->json(['message'=>'Thanks for feedback Us.']);    
        }
        else{
            $res->status(400)->json(['message'=>'You already given feedback!']);
        }
    }

    // ----------CUSTOMER SP LIST---------- 
    public function myServiceProvider(Request $req, Response $res){
        // (SP WHO COMPLETED CUSTOMER'S SERVICE SUCCESSFULLY IN PAST...)
        $customerId = session('userId');
        $db = new Database();
        $sql = "SELECT service.ServiceProviderId AS Id,
                       CONCAT(serviceProvider.FirstName, ' ', serviceProvider.LastName) AS Name,
                       serviceProvider.UserProfilePicture AS ProfilePicture,
                       favorite_and_blocked.IsBlocked,
                       favorite_and_blocked.IsFavorite,
                       ROUND(AVG(rating.Ratings), 2) AS Ratings
                FROM servicerequest AS service
                LEFT JOIN user AS serviceProvider ON service.ServiceProviderId = serviceProvider.UserId
                LEFT JOIN rating ON service.ServiceProviderId = rating.RatingTo
                LEFT JOIN favoriteandblocked AS favorite_and_blocked ON service.ServiceProviderId = favorite_and_blocked.TargetUserId
                WHERE service.UserId = {$customerId} AND service.Status = {$this->COMPLETED_STATUS}
                GROUP BY service.ServiceProviderId";
        $data = $db->query($sql);
        $res->status(200)->json($data);
    }

    // ----------ADD TO FAVORITE LIST----------
    public function addToFavorite(Request $req, Response $res){
        $customerId = session('userId');
        $serviceProviderId = $req->params->id;   
        $fav = new Favorite();
        $where = "UserId = {$customerId} AND TargetUserId = {$serviceProviderId}";
        if($fav->where($where)->exists()){
            $fav->where($where)->update([
                'IsFavorite' => 1
            ]);    
        }
        else{
            $fav->create([
                'IsFavorite' => 1,
                'IsBlocked' => 0,
                'UserId' => $customerId,
                'TargetUserId' => $serviceProviderId
            ]);    
        }
        $res->status(200)->json(['message'=>'Added to favorite list']);
    }

    // ----------REMOVE FROM FAVORITE LIST----------
    public function removeFromFavorite(Request $req, Response $res){
        $customerId = session('userId');
        $serviceProviderId = $req->params->id;   
        $fav = new Favorite();
        $where = "UserId = {$customerId} AND TargetUserId = {$serviceProviderId}";
        if($fav->where($where)->exists()){
            $fav->where($where)->update([
                'IsFavorite' => 0
            ]);    
        }
        $res->status(200)->json(['message'=>'Remove from favorite list']);
    }

    // ----------BLOCK SP----------
    public function blockServiceProvider(Request $req, Response $res){
        $customerId = session('userId');
        $serviceProviderId = $req->params->id;   
        $fav = new Favorite();
        $where = "UserId = {$customerId} AND TargetUserId = {$serviceProviderId}";
        if($fav->where($where)->exists()){
            $fav->where($where)->update([
                'IsBlocked' => 1
            ]);    
        }
        else{
            $fav->create([
                'IsFavorite' => 0,
                'IsBlocked' => 1,
                'UserId' => $customerId,
                'TargetUserId' => $serviceProviderId
            ]);    
        }
        $res->status(200)->json(['message'=>'ServiceProvider blocked successfully.']);
    }

    // ----------UNBLOCK SP----------
    public function unblockServiceProvider(Request $req, Response $res){
        $customerId = session('userId');
        $serviceProviderId = $req->params->id;   
        $fav = new Favorite();
        $where = "UserId = {$customerId} AND TargetUserId = {$serviceProviderId}";
        if($fav->where($where)->exists()){
            $fav->where($where)->update([
                'IsBlocked' => 0
            ]);    
        }
        $res->status(200)->json(['message'=>'ServiceProvider unblocked successfully.']);
    }
}
