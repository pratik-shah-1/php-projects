<?php    

namespace app\controllers;

use core\Request;
use core\Response;
use core\Hash;
use core\Validation;
use core\Mail;

use app\models\User;
use app\models\Token;
use app\models\OTP;
use app\services\Functions;

class Account{

	// ----------SIGNUP----------
	public function signup(Request $req, Response $res){

		Validation::check($req->body, [
			'firstName' => ['text', 'min:3', 'max:20'],
			'lastName' => ['text', 'min:3', 'max:20'],
			'email' => ['email'],
			'phone' => ['phone'],
			'role' => ['required'],
			'password' => ['password'],
			'confirmPassword' => ['confirm-password'],
		]);

		$user = new User();

		$email = $req->body->email;
		$mobile = $req->body->phone;
		$where = "Email = '{$email}' OR Mobile = $mobile";

		if(!$user->where($where)->exists()){
			$role = (int) $req->body->role;
			if($role==1 || $role==2 || $role==3){
				$hash = Hash::create($req->body->password);	
				$userId = $user->create([
					'FirstName' => $req->body->firstName,
					'LastName' => $req->body->lastName,
					'Email' => $req->body->email,
					'Mobile' => $req->body->phone,
					'Password'=> $hash,
					'RoleId' => $role,
					'UserProfilePicture' => 'car',
					'CreatedDate' => date('Y-m-d H:i:s')
				]);

				if(RES_WITH_MAIL){
					// ----------SEND-MAIL (ONLY CUSTOMER)----------
					if($role==1){
						$fun = new Functions();
						$verificationLink = $fun->getVerificationLinkByUserId($userId);
						$emailReceiver = $req->body->email;
						$emailSubject = 'Verify Your Account';
						$emailData = ['$verificationLink'=>$verificationLink,
									  '$contactLink' => BASE_URL.'/contact'];
						$emailBody = $res->template('verify-account', $emailData);
						Mail::send($emailReceiver, $emailSubject, $emailBody);
						$res->status(201)->json(['message'=>'Account is created successfully. Verification link sent on your email!']);
					}
					else{
						$res->status(201)->json(['message'=>'Account is created successfully.']);
					}	
				}
				else{
					if($role==1){
						$user->where('UserId', '=', $userId)->update(['IsActive' => 1]);
					}
					$res->status(201)->json(['message'=>'Account is created successfully.']);
				}
			}
			else{
				$res->status(401)->json(['message'=>'Role id not matched!']);
			}
		}
		else{
			$res->status(409)->json(['message'=>'Email or Mobile already exists in database']);
		}		
	}

	// ----------VERIFY-USER----------
	public function verifyUser(Request $req, Response $res){

		$userId = $req->params->id;
		$_token = $req->params->token;

		$token = new Token();
		$user = new User();

		$data = $token->where('userId', '=', $userId)->read();
		if(count($data)>0){
			$dbToken = $data[0]->token;
			if($dbToken==$_token){
				$user->where('userId', '=', $userId)->update(['IsActive' => 1]);
				$token->where('userId', '=', $userId)->delete();
				flashSession('accountVerified', true);
				$res->redirect('/login');
			}			
		}	
		else{
			$res->status(404)->json(['message'=>'Token Verification failed!']);
		}
	}

	// ----------LOGIN----------
	public function login(Request $req, Response $res){

		Validation::check($req->body, [
			'email' => ['email'],
			'password' => ['password']
		]);

		$email = $req->body->email;
		$password = $req->body->password;

		// REMEMBER ME...
		if(isset($req->body->remember)){
			if($req->body->remember=='true'){
				cookie('email', $email);
				cookie('password', $password);
			}
		}

		$user = new User();
		$where = "Email = '{$email}'";

		if($user->where($where)->exists()){

			$result = $user->where($where)->read();
			if($result[0]->IsActive){
				// STORE DATA IN VARIABLE FOR SET IN SESSION...
				$userId = $result[0]->UserId;
				$userRole = $result[0]->RoleId;
				$userPassword = $result[0]->Password;
				$userName = $result[0]->FirstName.' '.$result[0]->LastName;

				if(cookie('loginAttempts')<5){
					if(Hash::verify($password, $userPassword)){
						$fun = new Functions();
						session('isLogged', true);
						session('userId', $userId);
						session('userRole', $userRole);
						session('userRoleName', $fun->setUserRoleName($userRole));
						session('userName', $userName);
						$res->status(200)->json(['role'=>$userRole, 'message'=>"Login successfully."]);
					}
					else{
						$attempts =  cookie('loginAttempts') + 1;
						// SET COOKIE FOR 5 MINUTES...
						cookie('loginAttempts', $attempts, time()+(5*60));
						$res->status(401)->json(['message'=>"Password is not matched."]);
					}	
				}
				else{
					$res->status(401)->json(['message'=>"Try after 5 minutes!"]);
				}
			}
			else{
				$res->status(401)->json(['message'=>"You need to active your account by admin"]);
			}
		}
		else{
			$res->status(404)->json(['message'=>"User not exists in database"]);
		}		
	}

	// ----------LOGOUT----------
	public function logout(Request $req, Response $res){
		// DESTORY THE SESSION...
		session_destroy();
		flashSession('logout', true);
		$res->redirect('/');
	}

	// ----------FORGOT-PASSWORD----------
	public function forgotPassword(Request $req, Response $res){

		Validation::check($req->body, [
			'email' => ['email']
		]);

		$email = $req->body->email;
		$user = new User();
		if($user->where('Email', '=', $email)->exists()){
			$otp = rand(1000, 9999);// GENERATE OTP...
			$obj = new OTP();
			if($obj->where('email', '=', $email)->exists()){
				$obj->where('email', '=', $email)->delete();
			}
			// STORE OTP IN DATABASE...
			$obj->create(['email'=> $email, 'otp' => $otp ]);

			if(RES_WITH_MAIL){
				// ---------SEND MAIL---------
				$emailReceiver = $email;
				$emailSubject = 'Forgot Password';
				$emailData = ['$otp'=>$otp];
				$emailBody = $res->template('/forgot-password', $emailData);
				Mail::send($emailReceiver, $emailSubject, $emailBody);
				$res->status(200)->json(['otp'=>'', 'message'=> 'OTP sent on your email address']);
			}
			else{
				// ----------WITHOUT MAIL----------
				$res->status(200)->json(['otp'=>$otp, 'message'=>'OTP sent on your email address']);
			}
		}
		else{
			$res->status(404)->json(['message'=>'User not exists in database.']);
		}		
	}

	// ----------VERIFY-OTP----------
	public function verifyOtp(Request $req, Response $res){

		Validation::check($req->body, [
			'otp' => ['integer', 'length:4'],
			'email' => ['email']
		]);

		$obj = new OTP();
		$email = $req->body->email;
		$result = $obj->where('email', '=', $email)->read();
		if($result[0]->otp == $req->body->otp){
			if($obj->where('email', '=', $email)->delete()){
				$res->status(200)->json(['message'=>'OTP matched.']);
			}
		}
		else{
			$res->status(401)->json(['message'=> 'OTP not matched!']);
		}		
	
	}

	// ----------SET-NEW-PASSWORD----------
	public function setNewPassword(Request $req, Response $res){

		Validation::check($req->body, [
			'password' => ['password'],
			'confirmPassword' => ['confirm-password'],
			'email' => ['email'],
		]);

		$user = new User();
		$hash = Hash::create($req->body->password);
		$email = $req->body->email;
		$user->where('Email','=', $email)->update([
			'Password' => $hash,
			'ModifiedDate' => date('Y-m-d H:i:s'),
		]);
		$res->status(200)->json(['message'=>'Password updated successfully.']);
	}    

	// ----------CHANGE-PASSWORD----------
	public function changePassword(Request $req, Response $res){
		Validation::check($req->body, [
			'oldPassword' => ['required'],
			'newPassword' => ['password'],
			'confirmPassword' => ['confirm-password']
		]);

		$userId = session('userId');

		$user = new User();
		$data = $user->where('UserId', '=', $userId)->read();

		// ALL PASSWORD...
		$dbPassword = $data[0]->Password;
		$oldPassword = $req->body->oldPassword;
		$newPassword = $req->body->newPassword;
		$confirmPassword = $req->body->confirmPassword;
		$hash = Hash::create($confirmPassword);

		if(Hash::verify($oldPassword, $dbPassword)){
			$user->where('UserId', '=', $userId)->update([
				'UserId' => $userId,
				'Password' => $hash,
				'ModifiedDate' => date('Y-m-d H:i:s'),
			]);	
			$res->status(200)->json(['message'=>'Password change successfully.']);
		}
		else{
			$res->status(401)->json(['message'=>'Old password is wrong!']);
		}
	}    

}
