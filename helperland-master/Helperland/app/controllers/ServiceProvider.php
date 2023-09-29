<?php

namespace app\controllers;

use core\Request;
use core\Response;
use core\Mail;
use core\Database;

use app\models\Service;
use app\models\User;
use app\models\UserAddress;
use app\models\ExtraService;
use app\models\Favorite;
use app\services\Functions;

class ServiceProvider{

    private $NEW_STATUS       = 0;
    private $ASSIGNED_STATUS  = 1; // (ACCEPTED BY SP BUT NOT COMPLETED)
    private $COMPLETED_STATUS = 2;
    private $CANCELLED_STATUS = 3;
    
    // ----------NEW-SERVICES [NEW REQUESTS ONLY BY SP ZIPCODE]----------
    public function newServices(Request $req, Response $res){
        $serviceProviderId = session('userId');
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
                       GROUP_CONCAT(extraService.ServiceExtraId) AS ExtraService
                FROM servicerequest AS service
                INNER JOIN servicerequestaddress AS address ON service.ServiceRequestId = address.ServiceRequestId
                LEFT JOIN servicerequestextra AS extraService ON service.ServiceRequestId = extraService.ServiceRequestId
                INNER JOIN user AS customer ON service.UserId = customer.UserId
                LEFT JOIN user AS serviceProvider ON service.ServiceProviderId = serviceProvider.UserId
                WHERE service.Status = {$this->NEW_STATUS} 
                GROUP BY service.ServiceRequestId
                HAVING  (   
                            SELECT count(*) FROM user AS sp 
                            LEFT JOIN useraddress AS spAddress ON sp.UserId = spAddress.UserId 
                            WHERE spAddress.PostalCode = address.PostalCode AND sp.UserId = {$serviceProviderId}
                        )>0 AND 
                        (
                            SELECT COUNT(*) FROM favoriteandblocked WHERE 
                            (UserId = service.UserId AND TargetUserId = {$serviceProviderId} AND IsBlocked=1) OR 
                            (TargetUserId = service.UserId AND UserId = {$serviceProviderId} AND IsBlocked=1)
                        )=0
                ORDER BY service.ServiceRequestId";
    
        $data = $db->query($sql);
    
        if(count($data)>0){
            for($i=0; $i<count($data); $i++){
                $data[$i]->TotalCost = (int) $data[$i]->TotalCost;
                $data[$i]->ServiceDate = date('d/m/Y', strtotime($data[$i]->ServiceStartDate));
                $data[$i]->StartTime = date('H:i', strtotime($data[$i]->ServiceStartDate));
                $data[$i]->EndTime = date('H:i', strtotime("+".($data[$i]->Duration*60)." minutes", strtotime($data[$i]->ServiceStartDate)));
                $data[$i]->Duration = date('H:i', mktime(0, $data[$i]->Duration*60) );
                if($data[$i]->ExtraService!=null){
                    $data[$i]->ExtraService = array_map('intval', explode(',', $data[$i]->ExtraService));
                }            
                $data[$i]->IsExpired = strtotime($data[$i]->ServiceStartDate) < strtotime(date('Y-m-d H:i:s'))
                                        ? 1 
                                        : 0;
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
                        'ExtraService' => $data[$i]->ExtraService,
                        'IsExpired' => $data[$i]->IsExpired,
                    ],
                    'ServiceAddress' => [
                        'AddressLine1' => $data[$i]->AddressLine1,
                        'AddressLine2' => $data[$i]->AddressLine2,
                        'City' => $data[$i]->City,
                        'PostalCode' => $data[$i]->PostalCode,
                        'Mobile' => $data[$i]->Mobile,
                        'Email' => $data[$i]->Email,
                    ],
                    'Customer' => [
                        'Id' => $data[$i]->CustomerId,
                        'Name' => $data[$i]->CustomerName,
                    ],
                    'ServiceProvider' => [
                        'Id' => $data[$i]->ServiceProviderId,
                        'Name' => $data[$i]->ServiceProviderName,
                    ],
                ];
            }        
        }
        $res->json($data);
    }

    // ----------UPCOMING-SERVICES[ALREADY ASSIGNED TO SP]----------
    public function upcomingServices(Request $req, Response $res){
        $serviceProviderId = session('userId');
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
                       GROUP_CONCAT(extraService.ServiceExtraId) AS ExtraService
                FROM servicerequest AS service
                INNER JOIN servicerequestaddress AS address ON service.ServiceRequestId = address.ServiceRequestId
                LEFT JOIN servicerequestextra AS extraService ON service.ServiceRequestId = extraService.ServiceRequestId
                INNER JOIN user AS customer ON service.UserId = customer.UserId
                LEFT JOIN user AS serviceProvider ON service.ServiceProviderId = serviceProvider.UserId
                WHERE service.Status = {$this->ASSIGNED_STATUS} AND service.ServiceProviderId = {$serviceProviderId}
                GROUP BY service.ServiceRequestId
                HAVING (
                            SELECT COUNT(*) FROM favoriteandblocked WHERE 
                            (UserId = service.UserId AND TargetUserId = service.ServiceProviderId AND IsBlocked=1) OR 
                            (TargetUserId = service.UserId AND UserId = service.ServiceProviderId AND IsBlocked=1)
                        )=0
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
            $data[$i]->IsExpired = strtotime($data[$i]->ServiceStartDate) < strtotime(date('Y-m-d H:i:s'))
                                    ? 1 
                                    : 0;
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
                    'ExtraService' => $data[$i]->ExtraService,
                    'IsExpired' => $data[$i]->IsExpired,
                ],
                'ServiceAddress' => [
                    'AddressLine1' => $data[$i]->AddressLine1,
                    'AddressLine2' => $data[$i]->AddressLine2,
                    'City' => $data[$i]->City,
                    'PostalCode' => $data[$i]->PostalCode,
                    'Mobile' => $data[$i]->Mobile,
                    'Email' => $data[$i]->Email,
                ],
                'Customer' => [
                    'Id' => $data[$i]->CustomerId,
                    'Name' => $data[$i]->CustomerName,
                ],
                'ServiceProvider' => [
                    'Id' => $data[$i]->ServiceProviderId,
                    'Name' => $data[$i]->ServiceProviderName,
                ],
            ];
        }
        $res->json($data);
    }

    // ----------SERVICE_HISTORY(CANCELLED OR COMPLETED)----------
    public function serviceHistory(Request $req, Response $res){
        $serviceProviderId = session('userId');
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
                       GROUP_CONCAT(extraService.ServiceExtraId) AS ExtraService
                FROM servicerequest AS service
                INNER JOIN servicerequestaddress AS address ON service.ServiceRequestId = address.ServiceRequestId
                LEFT JOIN servicerequestextra AS extraService ON service.ServiceRequestId = extraService.ServiceRequestId
                INNER JOIN user AS customer ON service.UserId = customer.UserId
                LEFT JOIN user AS serviceProvider ON service.ServiceProviderId = serviceProvider.UserId
                WHERE (service.Status = {$this->COMPLETED_STATUS} OR service.Status = {$this->CANCELLED_STATUS}) AND service.ServiceProviderId = {$serviceProviderId}
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
            $data[$i]->IsExpired = strtotime($data[$i]->ServiceStartDate) < strtotime(date('Y-m-d H:i:s'))
                                    ? 1 
                                    : 0;
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
                    'ExtraService' => $data[$i]->ExtraService,
                    'IsExpired' => $data[$i]->IsExpired,
                ],
                'ServiceAddress' => [
                    'AddressLine1' => $data[$i]->AddressLine1,
                    'AddressLine2' => $data[$i]->AddressLine2,
                    'City' => $data[$i]->City,
                    'PostalCode' => $data[$i]->PostalCode,
                    'Mobile' => $data[$i]->Mobile,
                    'Email' => $data[$i]->Email,
                ],
                'Customer' => [
                    'Id' => $data[$i]->CustomerId,
                    'Name' => $data[$i]->CustomerName,
                ],
                'ServiceProvider' => [
                    'Id' => $data[$i]->ServiceProviderId,
                    'Name' => $data[$i]->ServiceProviderName,
                ],
            ];
        }
        $res->json($data);
    }

    // ----------SERVICE SCHEDULE----------
    public function serviceSchedule(Request $req, Response $res){
        $serviceProviderId = session('userId');
        $db = new Database();
        $sql = "SELECT service.ServiceRequestId,
                       service.UserId AS CustomerId,
                       service.ServiceProviderId,
                       service.ServiceStartDate,
                       service.Status,
                       service.ServiceHours + service.ExtraHours AS Duration,
                       CONCAT(customer.FirstName,' ',customer.LastName) AS CustomerName
                FROM servicerequest AS service
                INNER JOIN user AS customer ON service.UserId = customer.UserId
                WHERE (service.Status = {$this->NEW_STATUS} OR service.Status = {$this->ASSIGNED_STATUS}) AND service.ServiceProviderId = {$serviceProviderId}
                ORDER BY service.ServiceRequestId";
    
        $data = $db->query($sql);

        $services = [];
        for($i=0; $i<count($data); $i++){
            $data[$i]->ServiceDate = date('Y-m-d', strtotime($data[$i]->ServiceStartDate));
            $data[$i]->StartTime = date('H:i', strtotime($data[$i]->ServiceStartDate));
            $data[$i]->EndTime = date('H:i', strtotime("+".($data[$i]->Duration*60)." minutes", strtotime($data[$i]->ServiceStartDate)));
            $data[$i]->Duration = date('H:i', mktime(0, $data[$i]->Duration*60) );
            $data[$i]->IsExpired = strtotime($data[$i]->ServiceStartDate) < strtotime(date('Y-m-d H:i:s'))
                                    ? 1 
                                    : 0;
            if(!$data[$i]->IsExpired){
                $services[] = $data[$i];
            }    
            // ----------FOR MAKING DATA AS NESTED OBJECT----------
        }
        $res->json($services);
    }

    // ----------MY-RATING----------
    public function myRating(Request $req, Response $res){
        $serviceProviderId = session('userId');
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
                       rating.Comments as Feedback,
                       rating.OnTimeArrival,
                       rating.QualityOfService,
                       rating.Friendly,
                       CONCAT(customer.FirstName,' ',customer.LastName) AS CustomerName,
                       CONCAT(serviceProvider.FirstName,' ',serviceProvider.LastName) AS ServiceProviderName,
                       GROUP_CONCAT(extraService.ServiceExtraId) AS ExtraService
                FROM servicerequest AS service
                INNER JOIN servicerequestaddress AS address ON service.ServiceRequestId = address.ServiceRequestId
                LEFT JOIN servicerequestextra AS extraService ON service.ServiceRequestId = extraService.ServiceRequestId
                INNER JOIN user AS customer ON service.UserId = customer.UserId
                LEFT JOIN user AS serviceProvider ON service.ServiceProviderId = serviceProvider.UserId
                LEFT JOIN rating ON rating.ServiceRequestId = service.ServiceRequestId
                WHERE (service.Status = {$this->COMPLETED_STATUS} OR service.Status = {$this->CANCELLED_STATUS}) AND service.ServiceProviderId = {$serviceProviderId}
                GROUP BY service.ServiceRequestId
                ORDER BY service.ServiceRequestId";
    
        $data = $db->query($sql);
        $temp = [];
        if(count($data)>0){
            for($i=0; $i<count($data); $i++){
                $data[$i]->TotalCost = (int) $data[$i]->TotalCost;
                $data[$i]->ServiceDate = date('d/m/Y', strtotime($data[$i]->ServiceStartDate));
                $data[$i]->StartTime = date('H:i', strtotime($data[$i]->ServiceStartDate));
                $data[$i]->EndTime = date('H:i', strtotime("+".($data[$i]->Duration*60)." minutes", strtotime($data[$i]->ServiceStartDate)));
                $data[$i]->Duration = date('H:i', mktime(0, $data[$i]->Duration*60) );
                if($data[$i]->ExtraService!=null){
                    $data[$i]->ExtraService = array_map('intval', explode(',', $data[$i]->ExtraService));
                }            
                $data[$i]->IsExpired = strtotime($data[$i]->ServiceStartDate) < strtotime(date('Y-m-d H:i:s'))
                                        ? 1 
                                        : 0;
                if($data[$i]->Ratings!=null){
                    $ratingArr = [
                        (float) $data[$i]->OnTimeArrival,
                        (float) $data[$i]->Friendly,
                        (float) $data[$i]->QualityOfService
                    ];
                    $HighestRating = max($ratingArr);
                    switch($HighestRating){
                        case $ratingArr[0]:
                            $data[$i]->HighestRating = 'On Time Arrival';
                            break;
                        case $ratingArr[1]:
                            $data[$i]->HighestRating = 'Friendly';
                            break;
                        case $ratingArr[2]:
                            $data[$i]->HighestRating = 'Quality Of Service';
                            break;
                        default : 
                            $data[$i]->HighestRating = null;
                    }
                    // ----------FOR MAKING DATA AS NESTED OBJECT----------
                    $temp[] = [
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
                            'PostalCode' => $data[$i]->PostalCode
                        ],
                        'Customer' => [
                            'Id' => $data[$i]->CustomerId,
                            'Name' => $data[$i]->CustomerName,
                        ],
                        'ServiceProvider' => [
                            'Id' => $data[$i]->ServiceProviderId,
                            'Name' => $data[$i]->ServiceProviderName,
                            'Rating' => [
                                'Ratings' => $data[$i]->Ratings,
                                'Feedback' => $data[$i]->Feedback,
                                'OnTimeArrival' => $data[$i]->OnTimeArrival,
                                'QualityOfService' => $data[$i]->QualityOfService,
                                'Friendly' => $data[$i]->Friendly,
                                'HighestRating' => $data[$i]->HighestRating
                            ]
                        ],
                    ];    
                }    
        }    
        }
        $res->json($temp);

    }

    // ----------SERVICE-PROVIDER'S CUSTOMER LIST----------
    public function myCustomer(Request $req, Response $res){
        $serviceProviderId = session('userId');
        $db = new Database();
        $sql = "SELECT service.UserId AS Id,
                       CONCAT(customer.FirstName, ' ', customer.LastName) AS Name,
                       customer.UserProfilePicture AS ProfilePicture,
                       favorite_and_blocked.IsBlocked,
                       favorite_and_blocked.IsFavorite
                FROM servicerequest AS service
                LEFT JOIN user AS customer ON service.UserId = customer.UserId
                LEFT JOIN favoriteandblocked AS favorite_and_blocked ON service.ServiceProviderId = favorite_and_blocked.UserId
                WHERE service.ServiceProviderId = {$serviceProviderId} AND service.Status = {$this->COMPLETED_STATUS}
                GROUP BY service.UserId";
        $data = $db->query($sql);
        $res->status(200)->json($data);    
    }    

    // ----------ACCEPT-SERVICE----------
    public function acceptService(Request $req, Response $res){
        $serviceId = $req->params->id;
        $service = new Service();
        $where = "Status = {$this->ASSIGNED_STATUS} AND ServiceRequestId = {$serviceId}";
        if(!$service->where($where)->exists()){
            $service->where('ServiceRequestId', '=', $serviceId)->update([
                'ServiceProviderId' => session('userId'),
                'SPAcceptedDate' => date('Y-m-d H:i:s'),
                'Status' => $this->ASSIGNED_STATUS,
                'ModifiedDate' => date('Y-m-d H:i:s'),
            ]);

            if(RES_WITH_MAIL){
                // ----------SEND-MAIL----------
                // SEND EMAIL TO SP FOR THEIR CONFIRMATION...
                $fun = new Functions();
                $serviceProvider = $fun->getUserDetailsByUserId(session('userId'));
                $temp = $fun->getServiceDetailsByServiceId($serviceId);
                $emailReceiver = $serviceProvider->Email;
                $emailSubject = 'Service Accept';
                $emailData = [];
                $emailData['$ServiceProviderName'] = $serviceProvider->FirstName.''.$serviceProvider->LastName;
                $emailData['$ServiceProviderEmail'] = $serviceProvider->Email;
                $emailData['$ServiceProviderMobile'] = $serviceProvider->Mobile;
                foreach($temp as $key => $value){
                    $emailData['$'.$key] = $value;
                }
                $emailBody = $res->template('service-provider/accept-service-to-sp', $emailData);
                Mail::send($emailReceiver, $emailSubject, $emailBody);
                // SEND MAIL TO CUSTOMER
                $emailReceiver = $temp->Email;
                $emailSubject = 'Service Accept';
                $emailBody = $res->template('service-provider/accept-service-to-customer', $emailData);
                Mail::send($emailReceiver, $emailSubject, $emailBody);
                $res->status(200)->json(['message'=>'Service accepted successfully.']);
            }
            else{
                $res->status(200)->json(['message'=>'Service accepted successfully.']);
            }            
        }
        else{
            $res->status(400)->json(['message'=>'This Service is no more available!']);
        }
    }

    // ----------COMPLETE-SERVICE----------
    public function completeService(Request $req, Response $res){
        $serviceId = $req->params->id;
        $service = new Service();

        // CHECK IS SERVICE EXPIRE...
        $serviceData = $service->where('ServiceRequestId', '=', $serviceId)->read();
        $serviceDate = strtotime($serviceData[0]->ServiceStartDate);
        $todayDate = strtotime(date('Y-m-d H:i:s'));
        $isExpired = $serviceDate < $todayDate ? 1 : 0;

        if($isExpired){
            $service->where('ServiceRequestId', '=', $serviceId)->update([
                'ServiceProviderId' => session('userId'),
                'Status' => $this->COMPLETED_STATUS,
                'ModifiedDate' => date('Y-m-d H:i:s'),
            ]);

            if(RES_WITH_MAIL){
                // ----------MAIL----------
                // SEND EMAIL TO SP FOR THEIR CONFIRMATION...
                $fun = new Functions();
                $serviceProvider = $fun->getUserDetailsByUserId(session('userId'));
                $temp = $fun->getServiceDetailsByServiceId($serviceId);
                $emailReceiver = $serviceProvider->Email;
                $emailSubject = 'Complete Service';
                $emailData = [];
                $emailData['$ServiceProviderName'] = $serviceProvider->FirstName.''.$serviceProvider->LastName;
                $emailData['$ServiceProviderEmail'] = $serviceProvider->Email;
                $emailData['$ServiceProviderMobile'] = $serviceProvider->Mobile;
                foreach($temp as $key => $value){
                    $emailData['$'.$key] = $value;
                }
                $emailBody = $res->template('/service-provider/complete-service-to-sp', $emailData);
                Mail::send($emailReceiver, $emailSubject, $emailBody);

                $emailReceiver = $temp->Email;//CUSTOMER EMAIL
                $emailSubject = 'Complete Service';
                $emailBody = $res->template('/service-provider/complete-service-to-customer', $emailData);
                Mail::send($emailReceiver, $emailSubject, $emailBody);
                $res->status(200)->json(['message'=>'Service Completed Successfully.']);    

            }
            else{
                $res->status(200)->json(['message'=>'Service Completed Successfully.']);    
            }
        }
        else{
            $res->status(401)->json(['message'=>'Service not able to completed']);
        }

    }
   
    // ----------CANCEL-OR-REJECT-SERVICE----------
    public function rejectService(Request $req, Response $res){
        $serviceId = $req->params->id;
        $service = new Service();
        $where = "ServiceRequestId = {$serviceId} AND Status = {$this->ASSIGNED_STATUS}";
        if($service->where($where)->exists()){
            $service->where('ServiceRequestId', '=', $serviceId)->update([
                'ServiceProviderId' => session('userId'),
                'SPAcceptedDate' => date('Y-m-d H:i:s'),
                'Status' => 3,
                'ModifiedDate' => date('Y-m-d H:i:s'),
            ]);

            if(RES_WITH_MAIL){
                // ----------SEND-EMAIL----------
                $fun = new Functions();
                $serviceProvider = $fun->getUserDetailsByUserId(session('userId'));
                $temp = $fun->getServiceDetailsByServiceId($serviceId);
                $emailReceiver = $serviceProvider->Email;
                $emailSubject = 'Service Reject';
                $emailData = [];
                $emailData['$ServiceProviderName'] = $serviceProvider->FirstName.''.$serviceProvider->LastName;
                $emailData['$ServiceProviderEmail'] = $serviceProvider->Email;
                $emailData['$ServiceProviderMobile'] = $serviceProvider->Mobile;
                foreach($temp as $key => $value){
                    $emailData['$'.$key] = $value;
                }
                $emailBody = $res->template('/service-provider/reject-service-to-sp', $emailData);
                Mail::send($emailReceiver, $emailSubject, $emailBody);
                $emailReceiver = $temp->Email;// CUSTOMER EMAIL...
                $emailSubject = 'Service Reject';
                $emailBody = $res->template('/service-provider/reject-service-to-customer', $emailData);
                Mail::send($emailReceiver, $emailSubject, $emailBody);            
                $res->status(200)->json(['message'=>'Service rejected Successfully.']);    
            }
            else{
                $res->status(200)->json(['message'=>'Service rejected successfully.']);
            }
        }
        else{
            $res->status(404)->json(['message'=>'No service available!']);    
        }
    }

    // ----------BLOCK-CUSTOMER----------
    public function blockCustomer(Request $req, Response $res){
        $customerId = $req->params->id;
        $serviceProviderId = session('userId');
        $fav = new Favorite();
        $where = "UserId = {$serviceProviderId} AND TargetUserId = {$customerId}";
        if(!$fav->where($where)->exists()){
            $fav->create([
                'UserId' => $serviceProviderId,
                'TargetUserId' => $customerId,
                'IsFavorite' => 0,
                'IsBlocked' => 1,
            ]);    
        }
        else{
            $fav->where($where)->update([
                'IsBlocked' => 1,
            ]);    
        }
        $res->status(200)->json(['message'=>'Block Customer Successfully.']);
    }

    // ----------UNBLOCK-CUSTOMER----------
    public function unblockCustomer(Request $req, Response $res){
        $customerId = $req->params->id;
        $serviceProviderId = session('userId');
        $fav = new Favorite();
        $where = "UserId = {$serviceProviderId} AND TargetUserId = {$customerId}";
        $fav->where($where)->update([
            'IsBlocked' => 0,
        ]);    
        $res->status(200)->json(['message'=>'Unblock Customer Successfully.']);
    }

}