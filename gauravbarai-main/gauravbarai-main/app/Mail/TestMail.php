<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable{

    use Queueable, SerializesModels;
    public $data;

    public function __construct($email_data){
        $this->data = $email_data;
    }

    public function build(){
        return $this->view('general.mail');
    }
}
