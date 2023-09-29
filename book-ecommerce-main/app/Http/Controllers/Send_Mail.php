<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
class Send_Mail extends Controller{

	public function basic_email() {
    	Mail::send('mail', ['name'=>"Pratik Jadav"], function($message) {
	        $message->to('pratikjadav29@gmail.com', '')->subject('MyBooks OTP');
	        $message->from('typee29@gmail.com','MyBooks');
	    });
	    echo "Basic Email Sent. Check your inbox.";
   }

}
