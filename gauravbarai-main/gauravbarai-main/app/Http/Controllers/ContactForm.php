<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class ContactForm extends Controller{


    public function send_mail(Request $req){
        $data = ['name'=>$req->name, 'email'=>$req->email, 'msg'=>$req->message];
        // // View is Basically for Which data we have to pass in mail that 
        Mail::send('general.mail', $data, function($message) use ($data){
            $message->from('desaipriya606@gmail.com', 'Portfolio');
            $message->to('gauravbarai9@gmail.com');            
            $message->subject($data['name'].' via Portfolio');
        });
        // \Mail::to('gauravbarai9@gmail.com')->send(new \App\Mail\TestMail($data));
        return true;
    }

}
