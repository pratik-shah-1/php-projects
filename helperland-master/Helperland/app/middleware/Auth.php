<?php

namespace app\middleware;

use core\Response;

class Auth{

    private $res = null;

    public function __construct(){
        $this->res = new Response();
    }

    // ----------ALREADY LOGGED----------
    public function alreadyLogged(){
        if(session('isLogged')){
            switch(session('userRole')){
                case 1:
                    $redirect_url = BASE_URL.'/customer/dashboard/';
                    break;
                case 2:
                    $redirect_url = BASE_URL.'/service-provider/dashboard/';
                    break;
                case 3:
                    $redirect_url = BASE_URL.'/admin/dashboard/';
                    break;
            }
            header("location:{$redirect_url}");
            exit();
        }
        else{
            return true;
        }
    }

    // ----------IS CUSTOMER----------
    public function isCustomer(){
        if(session('isLogged')){
            if(session('userRole')==1){
                return true;
            }
            else{
                $this->res->status(403)->json(['message'=>'You are not allowed to access this page']);
                exit();
            }
        }
        else if($_SERVER['REQUEST_METHOD']=='GET'){
            $this->openLoginForm();
        }
        else{
            $this->res->status(401)->json(['message'=>'You need to login!']);
            exit();
        }
    }

    // ----------IS SERVICE PROVIDER----------
    public function isServiceProvider(){
        if(session('isLogged')){
            if(session('userRole')==2){
                return true;
            }
            else{
                $this->res->status(403)->json(['message'=>'You are not allowed to access this page']);
                exit();
            }
        }
        else if($_SERVER['REQUEST_METHOD']!='GET'){
            $this->res->status(401)->json(['message'=>'You need to login!']);
            exit();
        }
        else{
            $this->openLoginForm();
        }
    }

    // ----------IS CUSTOMER----------
    public function isAdmin(){
        if(session('isLogged')){
            if(session('userRole')==3){
                return true;
            }
            else{
                $this->res->status(403)->json(['message'=>'You are not allowed to access this page']);
                exit();
            }
        }
        else if($_SERVER['REQUEST_METHOD']!='GET'){
            $this->res->status(401)->json(['message'=>'You need to login!']);
            exit();
        }
        else{
            $this->openLoginForm();
        }
    }

    // ----------IS LOGGED----------
    public function isLogged(){
        if(session('isLogged')){
            return true;
        }
        else{
            $this->res->status(403)->json(['message'=>'You are not allowed to access this page']);
            exit();
        }
    }

    // ----------OPEN LOGIN FORM----------
    public function openLoginForm(){
        flashSession('openLoginForm', true);
        $base_url = BASE_URL;
        header("location:{$base_url}");
        exit();
    }
                
}