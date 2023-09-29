<?php

namespace app\controllers;

use core\Request;
use core\Response;
use core\Validation;

use app\models\User;


class MyDetails{

    const MALE_ID = 1;
    const FEMALE_ID = 2;

    // ----------GET-DETAILS----------
    public function getDetails(Request $req, Response $res){
        $userId = session('userId');
        $user = new User();
        $details = $user->where('UserId', '=', $userId)->read();
        if(count($details)>0){
            // REMOVE PASSWORD...
            unset($details[0]->Password);
            $res->status(200)->json($details[0]);
        }
        else{
            $res->status(404)->json(['message'=> 'No details available!']);
        }
    }

    // ----------UPDATE-DETAILS----------
    public function updateDetails(Request $req, Response $res){

        Validation::check($req->body, [
            'firstName' => ['text', 'min:3', 'max:20'],
            'lastName' => ['text', 'min:3', 'max:20'],
            'phone' => ['phone'],
            'language' => ['integer'],
            'dateOfBirth' => ['required'],
            'gender' => ['optional'],
            'avatar' => ['optional'],
        ]);

        $userId = session('userId');
        $user = new User();
        $where = "UserId != {$userId} AND Mobile = {$req->body->phone}";

        $gender = isset($req->body->gender)? $req->body->gender : 0;
        $avatar = isset($req->body->avatar)? $req->body->avatar : 'hat';

        if(!$user->where($where)->exists()){
            $user->where('UserId', '=', $userId)->update([
                'FirstName' => $req->body->firstName,
                'LastName' => $req->body->lastName,
                'Mobile' => $req->body->phone,
                'LanguageId' => $req->body->language,
                'DateOfBirth' => $req->body->dateOfBirth,
                'Gender' => $gender,
                'UserProfilePicture' => $avatar,
                'ModifiedDate'=> date('Y-m-d H:i:s')
            ]);    
            $res->status(200)->json(['message'=>'Profile updated successfully.']);
        }
        else{
            $res->status(409)->json(['message'=>'Email or Mobile already exists in Database!']);
        }

    }
}