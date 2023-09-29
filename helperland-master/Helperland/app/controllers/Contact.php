<?php

namespace app\controllers;

use core\Request;
use core\Response;
use core\Validation;
use core\File;
use core\Mail;

use app\models\User;
use app\models\Contact as ContactModel;

class Contact{

    // ----------CONTACT SUBMIT----------
    public function submit(Request $req, Response $res){
        Validation::check($req->body, [
            'firstName' => ['text', 'min:3', 'max:10'],
            'lastName' => ['text', 'min:3', 'max:10'],
            'phone' => ['phone', 'length:10'],
            'email' => ['email'],
            'message' => ['text'],
            'subject' => ['text'],
        ]);
        // SAVE A UPLOADED FILE PATH...
        $filePath = null;
        if(isset($req->files->attachment)){
            if($req->files->attachment['error']==0){
                $filePath = File::upload($req->files->attachment, 'contact/');
            }	
        }
        $contact = new ContactModel();
        $contact->create([
            'Name' => $req->body->firstName.' '.$req->body->lastName,
            'Email' => $req->body->email,
            'PhoneNumber' => $req->body->phone,
            'Subject' => $req->body->subject,
            'Message' => $req->body->message,
            'UploadFileName' => $filePath,
            'CreatedOn' => date('Y-m-d H:i:s')
        ]);    

        if(RES_WITH_MAIL){
            // ----------SEND MAIL----------
            $emailReceiver = ADMIN_EMAIL;
            $emailSubject = 'User Feedback or Query';
            $emailData = ['$Name' => $req->body->firstName.' '.$req->body->lastName,
                          '$Email' => $req->body->email,
                          '$Phone' => $req->body->phone,
                          '$Subject' => $req->body->subject,
                          '$Message' => $req->body->message];
            $emailBody = $res->template('contact', $emailData);
            Mail::send($emailReceiver, $emailSubject, $emailBody);
            $res->status(200)->json(['message'=>"Form Submitted Successfully."]);
        }
        else{
            $res->status(200)->json(['message'=>"Form submitted successfully."]);
        }
    }    
}