<?php

use core\Route;

// ----------MIDDLWARE----------
use app\middleware\Auth;
$isAdmin = [new Auth(), 'isAdmin'];

// ----------CONTROLLERS----------
use app\controllers\Admin;

Route::get('/admin/user-management', $isAdmin, [new Admin(), 'userManagement']);
Route::get('/admin/service-requests', $isAdmin, [new Admin(), 'serviceRequests']);
Route::patch('/admin/user/active/:id', $isAdmin, [new Admin(), 'makeUserActive']); // id = userId
Route::patch('/admin/user/inactive/:id', $isAdmin, [new Admin(), 'makeUserInactive']); // id = userId
Route::patch('/admin/service/reschedule/:id', $isAdmin, [new Admin(), 'rescheduleService']); // id = ServiceId
Route::patch('/admin/service/cancel/:id', $isAdmin, [new Admin(), 'cancelService']); // id = ServiceId