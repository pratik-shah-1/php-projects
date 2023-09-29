<?php

namespace app\controllers;

use core\Request;
use core\Response;
use core\Validation;
use core\Database;
use core\Mail;

use app\models\User;
use app\models\UserAddress;
use app\models\Service;
use app\models\ServiceAddress;
use app\models\ExtraService;
use app\models\Favorite;
use app\services\Functions;

class BookNow{

    // ----------CHECK POSTAL CODE---------- 
    public function checkPostalCode(Request $req, Response $res){

        Validation::check($req->body, [
            'postalCode' => ['postal-code']
        ]);

        $user = new User();
        $where = "RoleId = 2 AND PostalCode = {$req->body->postalCode}";
        $users = $user->join('UserId', 'UserId', 'useraddress')->where($where)->read();
        if(count($users)>0){
            $res->status(200)->json(['message'=>'User availabe']);
        }
        else{
            $res->status(404)->json(['message'=>'No service providing in this area!']);
        }    

    }

    // ----------BOOK SERVICE----------
    public function bookService(Request $req, Response $res){

        Validation::check($req->body, [
            'postalCode' => ['postal-code'],
            'date' => ['required'],
            'time' => ['required'],
            'duration' => ['number'],
            'extraService' => ['optional'],
            'extraTime' => ['optional'],
            'comments' => ['optional'],
            'hasPets' => ['optional'],
            'serviceProviderId' => ['optional'],
            'address' => ['object'],
        ]);

        // INITIALIZE REQUIRED VARIABLE...
        $service = new Service();
        $serviceAddress = new ServiceAddress();

        $customerId = session('userId');
        $postalCode = $req->body->postalCode;
        $date = strtotime($req->body->date.' '.$req->body->time);
        $date = date('Y-m-d H:i:s', $date);
        $duration = (int) $req->body->duration;
        // OPTIONAL PARAMERTERS...
        $extraService =  isset($req->body->extraService)? $req->body->extraService : [];
        $extraTime = isset($req->body->extraTime)? $req->body->extraTime : null;
        $comments = isset($req->body->comments)? $req->body->comments : null;
        $hasPets = (isset($req->body->hasPets) && $req->body->hasPets==true)? 1 : null;
        $serviceProviderId = null;
        if(isset($req->body->serviceProviderId)){
            if($req->body->serviceProviderId!=null && $req->body->serviceProviderId!=''){
                $serviceProviderId = $req->body->serviceProviderId;
            }
        }
        $hourlyRate = 20;
        $totalCost = $hourlyRate*$duration + ($hourlyRate/2)*count($extraService);
        // ADD SERVICE_REQUEST IN DATABASE TABLE...
        $serviceId = $service->create([
            'UserId' => $customerId,
            'ServiceStartDate' => $date,
            'ZipCode' => $postalCode,
            'ServiceHourlyRate' => $hourlyRate,
            'ServiceHours' => $duration,
            'ExtraHours' => $extraTime,
            'SubTotal' => $totalCost,
            'TotalCost' => $totalCost,
            'Comments' => $comments,
            'ServiceProviderId' => $serviceProviderId,
            'HasPets' => $hasPets,
            'Status' => $serviceProviderId!=null? 1 : 0, //STATUS ZERO MEANS NEW REQUEST...
            'SPAcceptedDate' => $serviceProviderId!=null? date('Y-m-d H:i:s') : null,
            'CreatedDate' => date('Y-m-d H:i:s'),
            'ModifiedDate' => date('Y-m-d H:i:s')
        ]);

        // ADD SERVICE_REQUEST_ADDRESS IN DATABASE TABLE...
        $serviceAddress->create([
            'ServiceRequestId' => $serviceId,
            'AddressLine1' => $req->body->address->AddressLine1,
            'AddressLine2' => $req->body->address->AddressLine2,
            'City' => $req->body->address->City,
            'State' => $req->body->address->State,
            'PostalCode' => $req->body->address->PostalCode,
            'Mobile' => $req->body->address->Mobile,
            'Email' => $req->body->address->Email,
        ]);

        // ADD EXTRA SERVICES IN DATABASE IF USER WANT'S...
        if(count($extraService)>0){
            $temp = '';
            for($i=0; $i<count($extraService); $i++){
                $temp .= "( {$serviceId}, {$extraService[$i]} ), ";
            }    
            $temp = rtrim($temp, ', ');
            $sql = "INSERT INTO servicerequestextra (ServiceRequestId, ServiceExtraId) VALUES {$temp}";
            $db = new Database();
            $db->query($sql);        
        }

        if(RES_WITH_MAIL){
            // ----------SEND MAIL----------
            // SEND MAIL TO CUSTOMER WHO MADE A REQUEST (FOR THEIR CONFIRMATION)
            $fun = new Functions();
            $customer = $fun->getUserDetailsByUserId($customerId);
            $emailReceiver = $customer->Email;
            $emailSubject = 'Service Booking';
            $temp = $fun->getServiceDetailsByServiceId($serviceId);
            $emailData = [];
            foreach($temp as $key => $value){
                $emailData['$'.$key] = $value;
            }
            $emailBody = $res->template('/book-service/customer', $emailData);

            Mail::send($emailReceiver, $emailSubject, $emailBody);

            // DIRECT ASSIGNMENT OF USER BY SERVICE PROVIDER ID...
            if($serviceProviderId!=null){
                if(!$fun->isUserBlockedByAnotherUser($serviceProviderId)){
                    $emailReceiver = $fun->getUserEmailByUserId($serviceProviderId);
                    $emailSubject = 'Assigned for Service Cleaning';
                    $emailBody = $res->template('book-service/single-sp', $emailData); 
                    Mail::send($emailReceiver, $emailSubject, $emailBody);
                    $res->status(201)->json(['message'=>'Service Book Successfully.', 'id'=>$serviceId]);
                }
            }
            else{
                // SERVICE POOL [SEND MAIL TO ALL SP ACCORDING TO POSTAL CODE]
                $emailReceivers = $fun->getSPEmailsByPostalCode($postalCode);
                $emailSubject = 'Service Booked In Your Area';
                $emailBody = $res->template('/book-service/multiple-sp', $emailData);
                Mail::send($emailReceivers[0], $emailSubject, $emailBody, $emailReceivers);
                $res->status(201)->json(['message'=>'Service Book Successfully.', 'id'=>$serviceId]);
            }
        }
        else{
            $res->status(201)->json(['message'=>'Service Book Successfully.', 'id'=>$serviceId]);
        }
    }

    // ----------GET FAVORITE SP----------
    public function getFavoriteServiceProvider(Request $req, Response $res){
        $customerId = session('userId');
        $db = new Database();
        $sql = "SELECT user.UserId,
                       user.FirstName,
                       user.LastName,
                       user.UserProfilePicture
                FROM user
                INNER JOIN favoriteandblocked AS favorite ON user.UserId = favorite.TargetUserId 
                WHERE favorite.UserId = {$customerId} AND favorite.IsFavorite=1
                HAVING (
                         SELECT COUNT(*) FROM favoriteandblocked WHERE
                         (UserId = {$customerId} AND TargetUserId = user.UserId AND IsBlocked = 1 ) OR
                         (TargetUserId = {$customerId} AND UserId = user.UserId AND IsBlocked = 1)
                        )=0";
        $data = $db->query($sql);
        $res->status(200)->json($data);
    }

}