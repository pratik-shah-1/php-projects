<?php

namespace app\services;

use core\Database;

use app\models\User;
use app\models\Favorite;
use app\models\Service;
use app\models\ExtraService;
use app\models\Token;

class Functions{

    // ----------SET USER ROLE_NAME----------
    public function setUserRoleName($roleId){
		switch($roleId){
			case 1:
				return 'customer';
			case 2:
				return 'service-provider';
			case 3:
				return 'admin';
		}
	}

    // ----------GET TOKEN BY USERID----------
    public function getVerificationLinkByUserId($userId){
        $_token = bin2hex(random_bytes(16));
        $token = new Token();
        $token->create(['userId' => $userId, 'token' => $_token]);
        $link = BASE_URL."/user/verify/{$userId}/{$_token}";
        return $link;
    }
    
    // ----------GET EMAIL BY USERID----------
    public function getUserEmailByUserId($id){
        $user = new User();
        $data = $user->where('UserId', '=', $id)->read();
        if(count($data)>0){
            return $data[0]->Email;
        }
        else{
            return false;
        }
    }

    // ----------GET DETAILS BY USERID----------
    public function getUserDetailsByUserId($id){
        $user = new User();
        $data = $user->where('UserId', '=', $id)->read();
        if(count($data)>0){
            return $data[0];
        }
        else{
            return false;
        }
    }

    // ----------GET SP EMAILS BY POSTAL CODE----------
    public function getSPEmailsByPostalCode($postal_code){
        $db = new Database();
        $sql = "SELECT user.Email,
                       user.UserId
                FROM user
                LEFT JOIN useraddress AS address
                    ON user.UserId = address.UserId
                WHERE address.PostalCode = {$postal_code} AND user.RoleId = 2
                HAVING  ( 
                            SELECT COUNT(*) FROM favoriteandblocked WHERE 
                            ( UserId = 2 AND TargetUserId = user.UserId AND IsBlocked = 1) OR 
                            (TargetUserId = 2 AND UserId = user.UserId  AND IsBlocked = 1) 
                        )=0";
        $data = $db->query($sql);
    
        if(count($data)>0){
            $emails  = [];
            foreach($data as $i){
                $emails[] = $i->Email;
            }
            return $emails;
        }
        else{
            return false;
        }
    }

    // ----------GET CUSTOMER EMAIL BY SERVICE ID----------
    public function getCustomerEmailByServiceId($id){
        $serviceId = $id;
        $service = new Service();
        $data = $service->join('UserId', 'UserId', 'user')->where('servicerequest.ServiceRequestId', '=', $serviceId)->read();
        if(count($data)==1){
            return $data[0]->Email;
        }
        else{
            return null;
        }
    }

    // ----------GET SP EMAIL BY SERVICE ID----------
    public function getSPEmailByServiceId($id){
        $serviceId = $id;
        $service = new Service();
        $data = $service->join('ServiceProviderId', 'UserId', 'user')->where('servicerequest.ServiceRequestId', '=', $serviceId)->read();
        if(count($data)==1){
            return $data[0]->Email;
        }
        else{
            return null;
        }
    }

    // ----------GET SP EMAIL BY SERVICE ID----------
    public function getServiceDetailsByServiceId($id){
        $serviceId = $id;
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
                WHERE service.ServiceRequestId = {$serviceId}
                GROUP BY service.ServiceRequestId
                ORDER BY service.ServiceRequestId";
    
        $data = $db->query($sql);
    
        $data[0]->TotalCost = (int) $data[0]->TotalCost;
        $data[0]->ServiceDate = date('d/m/Y', strtotime($data[0]->ServiceStartDate));
        $data[0]->StartTime = date('H:i', strtotime($data[0]->ServiceStartDate));
        $data[0]->EndTime = date('H:i', strtotime("+".($data[0]->Duration*60)." minutes", strtotime($data[0]->ServiceStartDate)));
        $data[0]->Duration = date('H:i', mktime(0, $data[0]->Duration*60) );
        if($data[0]->ExtraService!=null){
            $data[0]->ExtraService = array_map('intval', explode(',', $data[0]->ExtraService));
            $temp = '';
            for($j=0; $j<count($data[0]->ExtraService); $j++){
                if($data[0]->ExtraService[$j]==1){
                    $temp .= 'Cabinets, ';
                }
                else if($data[0]->ExtraService[$j]==2){
                    $temp .= 'Fridge, ';
                }
                else if($data[0]->ExtraService[$j]==3){
                    $temp .= 'Oven, ';
                }
                else if($data[0]->ExtraService[$j]==4){
                    $temp .= 'Laundry Wash, ';
                }
                else if($data[0]->ExtraService[$j]==5){
                    $temp .= 'Interior Windows, ';
                }
            }
            $data[0]->ExtraService = rtrim($temp, ', ');
        }
        else{
            $data[0]->ExtraService = '';
        }

        return $data[0];
    }

    // ----------CHECK USER BLOCKED ANOTHER USER----------
    public function isUserBlockedByAnotherUser($id){
        $user1 = session('userId');
        $user2 = $id;
        $favorite = new Favorite();

        $where = " (UserId = {$user2} AND TargetUserId = {$user1} AND IsBlocked=1) OR 
                   (UserId = {$user1} AND TargetUserId = {$user2} AND IsBlocked=1)";
        $data = $favorite->where($where)->read();
        
        if(count($data)>0){
            return true;
        }
        else{
            return false;
        }
    }

}