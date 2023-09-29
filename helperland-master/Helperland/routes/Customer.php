<?php

use core\Route;

// ----------MIDDLWARE----------
use app\middleware\Auth;
$isCustomer = [new Auth(), 'isCustomer'];

// ----------CONTROLLERS----------
use app\controllers\Customer;

Route::get('/customer/service/current', $isCustomer, [new Customer(), 'currentServices']);
Route::get('/customer/service/history', $isCustomer, [new Customer(), 'serviceHistory']);

Route::patch('/customer/service/cancel/:id', $isCustomer, [new Customer(), 'cancelService']);         // id = serviceId
Route::patch('/customer/service/reschedule/:id', $isCustomer, [new Customer(), 'rescheduleService']); // id = serviceId

Route::get('/customer/sp', $isCustomer, [new Customer(), 'myServiceProvider']);
Route::post('/customer/sp/rate/:id', $isCustomer, [new Customer(), 'rateServiceProvider']);                        // id = serviceId
Route::patch('/customer/sp/favorite/:id', $isCustomer, [new Customer(), 'addToFavorite']);        // id = serviceProviderId
Route::patch('/customer/sp/unfavorite/:id', $isCustomer, [new Customer(), 'removeFromFavorite']); // id = serviceProviderId
Route::patch('/customer/sp/block/:id', $isCustomer, [new Customer(), 'blockServiceProvider']);               // id = serviceProviderId
Route::patch('/customer/sp/unblock/:id', $isCustomer, [new Customer(), 'unblockServiceProvider']);           // id = serviceProviderId