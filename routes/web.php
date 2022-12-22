<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get($_ENV['DELIVELER_ROOT_PATH'].'/{any}', function() {
    return view($_ENV['DELIVELER_ROOT_PATH'].'/app');
})->where('any', '.*');

// Route::get('/tasks', [Controller::class, 'getTest']);
