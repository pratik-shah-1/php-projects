<?php

use core\Route;

// ----------CONTROLLERS----------
use app\controllers\View;

// ----------LAST-METHOD----------
Route::get('/*', [new View(), 'notFoundPage']);
Route::post('/*', [new View(), 'notFoundJson']);
Route::put('/*', [new View(), 'notFoundJson']);
Route::delete('/*', [new View(), 'notFoundJson']);
Route::patch('/*', [new View(), 'notFoundJson']);