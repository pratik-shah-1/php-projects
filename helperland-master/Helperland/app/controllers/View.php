<?php

namespace app\controllers;

use core\Request;
use core\Response;

use app\models\User;
use app\models\UserAddress;


class View{

    // **********STATIC-PAGES**********

    // -----HOME-----
    public function home(Request $req, Response $res){
		$res->render('static-pages/home');	
	}

    // -----FAQs-----
    public function faqs(Request $req, Response $res){
		$res->render('static-pages/faqs');	
    }

    // -----PRICES-----
    public function prices(Request $req, Response $res){
		$res->render('static-pages/prices');	
	}

    // -----CONTACT-----
    public function contact(Request $req, Response $res){
        $res->render('static-pages/contact');	
    }

    // -----ABOUT-----
	public function about(Request $req, Response $res){
		$res->render('static-pages/about');	
	}

    // -----GUARANTEE-----
    public function guarantee(Request $req, Response $res){
        $res->render('static-pages/guarantee');
    }

    // **********CUSTOMER**********

    // -----BOOK-NOW-----
    public function bookNow(Request $req, Response $res){
        $res->render('book-now/index');
    }

    // -----CUSTOMER-SIGNUP-----
    public function customerSignup(Request $req, Response $res){
		$res->render('customer/signup');
	}

    // -----CUSTOMER-DASHBOARD-----
    public function customerDashboard(Request $req, Response $res){
        $res->render('customer/index');
    }

    // **********SERVICE-PROVIDER**********

    // -----SP-SIGNUP-----
    public function serviceProviderSignup(Request $req, Response $res){
        $res->render('service-provider/signup');
    }

    // -----SP-DASHBOARD-----
    public function serviceProviderDashboard(Request $req, Response $res){
        $res->render('service-provider/index');
    }

    // **********ADMIN**********

    public function adminDashboard(Request $req, Response $res){
        $res->render('admin/index');
    }


    // **********COMPONENTS**********

    // -----LOGIN-----
    public function login(Request $req, Response $res){
		flashSession('openLoginForm', true);
		$res->redirect('/');
	}

    // -----FORGOT PASSWORD-----
	public function forgotPassword(Request $req, Response $res){
		flashSession('openForgotPasswordForm', true);
		$res->redirect('/');
	}

    // **********NOT FOUND**********

    // -----PAGE-NOT-FOUND-----
	public function notFoundPage(Request $req, Response $res){
		$res->render('static-pages/page-not-found');
	}

    // -----PAGE-NOT-FOUND-JSON-----
	public function notFoundJson(Request $req, Response $res){
		$res->status(404)->json(['message'=>'No route availabe!']);
	}

}