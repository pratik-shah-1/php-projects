<?php

use core\Route;

// ----------MIDDLEWARE----------
use app\middleware\Auth;
$isCustomer = [new Auth(), 'isCustomer'];

// ----------BOOKNOW CONTROLLERS----------
use app\controllers\BookNow;

// ----------SERVICE-BOOKING-ACTION-ROUTES----------
Route::post('/book-service/check-postal-code', $isCustomer, [new BookNow(), 'checkPostalCode']);
Route::get('/book-service/customer/favorite-sp', $isCustomer, [new BookNow(), 'getFavoriteServiceProvider']);
Route::post('/book-service', $isCustomer, [new BookNow(), 'bookService']);