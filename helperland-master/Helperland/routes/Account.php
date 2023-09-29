<?php

use core\Route;

// ----------MIDDLEWARE----------
use app\middleware\Auth;
$isLogged = [new Auth(), 'isLogged'];

// ----------CONTROLLERS----------
use app\controllers\Account;
use app\controllers\MyDetails;
use app\controllers\MyAddress;

// ----------MY-ACCOUNT----------
Route::post('/signup', [new Account(), 'signup']);
Route::get('/user/verify/:id/:token', [new Account(), 'verifyUser']);
Route::post('/login', [new Account(), 'login']);
Route::post('/forgot-password', [new Account(), 'forgotPassword']);
Route::post('/verify-otp', [new Account(), 'verifyOtp']);
Route::patch('/set-new-password', [new Account(), 'setNewPassword']);
Route::patch('/change-password', $isLogged, [new Account(), 'changePassword']);
Route::get('/logout', [new Account(), 'logout']);

// ----------MY-DETAILS----------
Route::get('/user/details', $isLogged, [new MyDetails(), 'getDetails']);
Route::patch('/user/details', $isLogged, [new MyDetails(), 'updateDetails']);

// ----------MY-ADDRESS----------
Route::get('/user/address', $isLogged, [new MyAddress(), 'getAllAddress']);
Route::get('/user/address/:id', $isLogged, [new MyAddress(), 'getSingleAddress']); // id = addressId
Route::post('/user/address', $isLogged, [new MyAddress(), 'addAddress']);
Route::patch('/user/address/:id', $isLogged, [new MyAddress(), 'updateAddress']); // id = addressId
Route::delete('/user/address/:id', $isLogged, [new MyAddress(), 'deleteAddress']); // id = addressId
