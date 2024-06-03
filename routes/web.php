<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Middleware\UserAuthenticate;
use App\Http\Middleware\UserAuthenticateRedirector;
use App\Http\Middleware\AdvertiserAuthenticate;
use App\Http\Middleware\AdvertiserAuthenticateRedirector;
use App\Http\Middleware\AdminAuthenticate;
use App\Http\Middleware\AdminAuthenticateRedirector;
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

/**
 * アフィリエイター
 */
Route::get($_ENV['USER_ROOT_PATH']."/login", function() {
    return view($_ENV['USER_ROOT_PATH'].'/app_no_header');
})->middleware(UserAuthenticateRedirector::class);

Route::get($_ENV['USER_ROOT_PATH'].'/register', function() {
    return view($_ENV['USER_ROOT_PATH'].'/app_no_header');
});

Route::get($_ENV['USER_ROOT_PATH'].'/{any}', function() {
    return view($_ENV['USER_ROOT_PATH'].'/app');
})->where('any', '.*')->middleware(UserAuthenticate::class);


/**
 * 広告主
 */
Route::get($_ENV['ADVERTISER_ROOT_PATH']."/login", function() {
    return view($_ENV['ADVERTISER_ROOT_PATH'].'/app_no_header');
})->middleware(AdvertiserAuthenticateRedirector::class);

Route::get($_ENV['ADVERTISER_ROOT_PATH'].'/register', function() {
    return view($_ENV['ADVERTISER_ROOT_PATH'].'/app_no_header');
});
Route::get($_ENV['ADVERTISER_ROOT_PATH'].'/{any}', function() {
    return view($_ENV['ADVERTISER_ROOT_PATH'].'/app');
})->where('any', '.*')->middleware(AdvertiserAuthenticate::class);


/**
 * 管理者
 */
Route::get($_ENV['ADMIN_ROOT_PATH']."/login", function() {
    return view($_ENV['ADMIN_ROOT_PATH'].'/app_no_header');
})->middleware(AdminAuthenticateRedirector::class);

Route::get($_ENV['ADMIN_ROOT_PATH'].'/{any}', function() {
    return view($_ENV['ADMIN_ROOT_PATH'].'/app');
})->where('any', '.*')->middleware(AdminAuthenticate::class);

