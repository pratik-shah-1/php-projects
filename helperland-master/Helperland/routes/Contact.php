<?php

use core\Route;

// ----------CONTROLLERS----------
use app\controllers\Contact;


Route::post('/contact', [new Contact(), 'submit']);
