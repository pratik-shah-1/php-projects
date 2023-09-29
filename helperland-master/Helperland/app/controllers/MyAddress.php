<?php

namespace app\controllers;

use core\Request;
use core\Response;
use core\Validation;

use app\models\User;
use app\models\UserAddress;
use app\services\Functions;

class MyAddress{

    // ----------GET SINGLE ADDRESS----------
    public function getSingleAddress(Request $req, Response $res){
        $addressId = $req->params->id;
        $userAddress = new UserAddress();
        $data = $userAddress->where('AddressId', '=', $addressId)->read();
        if(count($data)>0){
            $res->status(200)->json($data[0]);
        }
        else{
            $res->status(404)->json(['message'=>'No address available!']);
        }
    }

    // ----------GET ALL ADDRESS----------
    public function getAllAddress(Request $req, Response $res){
        $userId = session('userId');
        $userAddress = new UserAddress();
        $data = $userAddress->where('UserId', '=', $userId)->read();
        if(count($data)>0){
            $res->status(200)->json($data);
        }
        else{
            $res->status(200)->json([]);
        }
    }    

    // ----------ADD ADDRESS----------
    public function addAddress(Request $req, Response $res){

        Validation::check($req->body, [
            'streetName' => ['text'],
            'houseNumber' => ['string'],
            'postalCode' => ['postal-code'],
            'city' => ['text', 'min:3', 'max:20'],
            'phone' => ['phone']
        ]);

        $userId = session('userId');

        $user = new User();
        $fun = new Functions();
        $email = $fun->getUserEmailByUserId($userId);

        $userAddress = new UserAddress();
        $userAddress->create([
            'UserId' => $userId,
            'AddressLine1' => $req->body->streetName,
            'AddressLine2' => $req->body->houseNumber,
            'City' => $req->body->city,
            'PostalCode' => $req->body->postalCode,
            'Mobile' => $req->body->phone,
            'State' => 'Gujarat',
            'Email' => $email
        ]);

        $res->status(200)->json(['message'=>'Address added successfully.']);

    }

    // ----------UPDATE ADDRESS----------
    public function updateAddress(Request $req, Response $res){

        Validation::check($req->body, [
            'streetName' => ['text'],
            'houseNumber' => ['string'],
            'postalCode' => ['postal-code'],
            'city' => ['text', 'min:3', 'max:20'],
            'phone' => ['phone']
        ]);

        $userId = session('userId');
        $addressId = $req->params->id;
 
        $user = new User();
        $userAddress = new UserAddress(); 
        $fun = new Functions();
        $email = $fun->getUserEmailByUserId($userId);

        $userAddress->where('AddressId', '=', $addressId)->update([
            'AddressLine1' => $req->body->streetName,
            'AddressLine2' => $req->body->houseNumber,
            'City' => $req->body->city,
            'PostalCode' => $req->body->postalCode,
            'Mobile' => $req->body->phone,
            'State' => 'Gujarat',
            'Email' => $email
        ]);

        $res->status(200)->json(['message'=>'Address updated successfully.']);

    } 

    // ----------DELETE ADDRESS----------
    public function deleteAddress(Request $req, Response $res){
        $addressId = $req->params->id;
        $userAddress = new UserAddress();
        $userAddress->where('AddressId', '=', $addressId)->delete();
        $res->status(200)->json(['message'=>'Address deleted successfully.']);
    }

}