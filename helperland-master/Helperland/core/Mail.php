<?php

namespace core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use core\Response;

class Mail{

    public static function send($receiver, $subject, $body, $recipients=false){

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            // $mail->SMTPDebug  = 1; // FOR SHOWING THE ERRORS
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_ADDRESS;
            $mail->Password   = EMAIL_PASSWORD;
            $mail->SMTPSecure = SMTP_SECURE;
            $mail->Port       = EMAIL_PORT;
            $mail->From       = EMAIL_ADDRESS;
            $mail->FromName   = 'Helperland';
            $mail->addAddress($receiver);
            // FOR SENDING A EMAIL TO MULTIPLE USERS... 
            if($recipients!=false && count($recipients)>0){
                foreach($recipients as $email){
                    if($email!=$receiver){
                        $mail->AddCC($email);
                    }
                }                
            }
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->send();
            return true;
        }
        catch (Exception $e) {
            $res = new Response();
            $res->status(500)->json(['message'=>'Internal Server Error']);            
            exit();
        }

    }

}

