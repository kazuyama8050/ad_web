<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

/**
 * middleware
 */
use App\Http\Middleware\AdminAuthenticate;
use App\Http\Middleware\UserAuthenticate;
use App\Http\Middleware\AdvertiserAuthenticate;

/**
 * アフィリエイター
 */
use App\Http\Controllers\Api\User\LoginUserController;
use App\Http\Controllers\Api\Category\FirstLevelCategoriesController;
use App\Http\Controllers\Api\User\RegisterApplyFormController;
use App\Http\Controllers\Api\User\CategoriesController as UserCategoriesController;


/**
 * 広告主
 */
use App\Http\Controllers\Api\Advertiser\AdvertiserRegisterApplyFormController;
use App\Http\Controllers\Api\Advertiser\LoginAdvertiserController;
use App\Http\Controllers\Api\Advertiser\TemplateController as AdvertiserTemplateController;
use App\Http\Controllers\Api\Advertiser\CategoryController as AdvertiserCategoryController;
use App\Http\Controllers\Api\Advertiser\AdvertisementController as AdvertiserAdvertisementController;

 /**
  * 管理者
  */
use App\Http\Controllers\Api\Admin\LoginAdminController;
use App\Http\Controllers\Api\Admin\UserNoRegisteredController;
use App\Http\Controllers\Api\Admin\AdminUserController;


use App\Http\Controllers\Api\LogoutController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', [TaskController::class, 'getTest']);
/**
 * アフィリエイター
 */
Route::post('/login-user', [LoginUserController::class, 'login']);
Route::get('/login-check-user', [LoginUserController::class, 'loginCheck']);
Route::get('/first-level-categories', [FirstLevelCategoriesController::class, 'get']);
Route::post('/register-user-form', [RegisterApplyFormController::class, 'create']);
Route::get('/all-categories', [UserCategoriesController::class, 'getAll']);

Route::middleware([UserAuthenticate::class])->group(function () {

});


/**
 * 広告主
 */
Route::post('/register-advertiser-form', [AdvertiserRegisterApplyFormController::class, 'create']);
Route::post('/login-advertiser', [LoginAdvertiserController::class, 'login']);
Route::middleware([AdvertiserAuthenticate::class])->group(function () {
    //テンプレート
    Route::post('/advertiser-template', [AdvertiserTemplateController::class, 'create']);
    Route::get('/advertiser-template-list', [AdvertiserTemplateController::class, 'getByAdvertiserId']);
    Route::get('/advertiser-template/{templateId}', [AdvertiserTemplateController::class, 'getById']);
    Route::delete('/advertiser-template/{templateId}', [AdvertiserTemplateController::class, 'deleteByTemplateId']);

    //カテゴリ
    Route::get('/advertise-category-all', [AdvertiserCategoryController::class, 'getAll']);

    //広告
    Route::post('/advertiser-advertise', [AdvertiserAdvertisementController::class, 'create']);
});

 /**
  * 管理者
  */
Route::post('/login-admin', [LoginAdminController::class, 'login']);
Route::middleware([AdminAuthenticate::class])->group(function () {
    Route::get('/user-no-registered', [UserNoRegisteredController::class, 'get']);
    Route::post('approve-user-form', [UserNoRegisteredController::class, 'approve']);
    Route::post('disapprove-user-form', [UserNoRegisteredController::class, 'disapprove']);
    Route::get('all-user', [AdminUserController::class, 'getAll']);
});






Route::get('logout/{target}', [LogoutController::class, 'logout']);
