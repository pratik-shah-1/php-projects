<?php

use core\Route;

// ----------MIDDLEWARE----------
use app\middleware\Auth;
$alreadyLogged = [new Auth(), 'alreadyLogged'];
$isCustomer = [new Auth(), 'isCustomer'];
$isServiceProvider = [new Auth(), 'isServiceProvider'];
$isAdmin = [new Auth(), 'isAdmin'];

// ----------CONTROLLERS----------
use app\controllers\View;

// ----------STATIC-PAGES----------
Route::get('/', [new View(), 'home']);
Route::get('/faqs', [new View(), 'faqs']);
Route::get('/prices', [new View(), 'prices']);
Route::get('/contact', [new View(), 'contact']);
Route::get('/about', [new View(), 'about']);
Route::get('/guarantee', [new View(), 'guarantee']);

// ----------COMPONENTS----------
Route::get('/login', $alreadyLogged,[new View(), 'login']);
Route::get('/forgot-password', $alreadyLogged, [new View(), 'forgotPassword']);

// ----------CUSTOMER----------
Route::get('/book-now', $isCustomer, [new View(), 'bookNow']);
Route::get('/customer/signup', $alreadyLogged, [new View(), 'customerSignup']);
Route::get('/customer/dashboard', $isCustomer, [new View(), 'customerDashboard']);

// ----------SERVICE-PROVDER----------
Route::get('/service-provider/signup', $alreadyLogged, [new View(), 'serviceProviderSignup']);
Route::get('/service-provider/dashboard', $isServiceProvider, [new View(), 'serviceProviderDashboard']);

// ----------ADMIN----------
Route::get('/admin/dashboard', $isAdmin, [new View(), 'adminDashboard']);
