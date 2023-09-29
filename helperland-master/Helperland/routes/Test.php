<?php

use core\Route;
use core\Database;

Route::get('/test/page', function($req, $res){
    $res->render('/test');
});

Route::get('/test/api', function($req, $res){
    $res->json(getallheaders());
});

Route::post('/test/set-token', function($req, $res){
    $res->json(['message'=>'API Work Done']);
});