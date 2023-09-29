<?php

use core\Route;

// ----------MIDDLEWARE----------
use app\middleware\Auth;
$isServiceProvider = [new Auth(), 'isServiceProvider'];

// ----------CONTROLLERS----------
use app\controllers\ServiceProvider;

Route::get('/service-provider/service/new', $isServiceProvider, [new ServiceProvider(), 'newServices']);
Route::get('/service-provider/service/upcoming', $isServiceProvider, [new ServiceProvider(), 'upcomingServices']);
Route::get('/service-provider/service/history', $isServiceProvider, [new ServiceProvider(), 'serviceHistory']);
Route::get('/service-provider/rating-and-review', $isServiceProvider, [new ServiceProvider(), 'myRating']);
Route::get('/service-provider/service/schedule', $isServiceProvider, [new ServiceProvider(), 'serviceSchedule']);

Route::patch('/service-provider/service/accept/:id', $isServiceProvider, [new ServiceProvider(), 'acceptService']);     // id = serviceId
Route::patch('/service-provider/service/reject/:id', $isServiceProvider, [new ServiceProvider(), 'rejectService']);     // id = serviceId
Route::patch('/service-provider/service/complete/:id', $isServiceProvider, [new ServiceProvider(), 'completeService']); // id = serviceId

Route::get('/service-provider/customer', $isServiceProvider, [new ServiceProvider(), 'myCustomer']);
Route::patch('/service-provider/customer/block/:id', $isServiceProvider, [new ServiceProvider(), 'blockCustomer']);     // id = customerId
Route::patch('/service-provider/customer/unblock/:id', $isServiceProvider, [new ServiceProvider(), 'unblockCustomer']); // id = customerId
