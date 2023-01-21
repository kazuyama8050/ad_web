<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

/**
 * アフィリエイター
 */
use App\Http\Controllers\Api\User\LoginUserController;
use App\Http\Controllers\Api\Category\FirstLevelCategoriesController;
use App\Http\Controllers\Api\User\RegisterApplyFormController;
use App\Http\Controllers\Api\User\CategoriesController as UserCategoriesController;
use App\Http\Controllers\Api\User\TemplateController as UserTemplateController;

/**
 * 広告主
 */

 /**
  * 管理者
  */
use App\Http\Controllers\Api\Admin\UserNoRegisteredController;
use App\Http\Controllers\Api\Admin\AdminUserController;

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

//テンプレート
Route::post('/user-template-create', [UserTemplateController::class, 'create']);

/**
 * 広告主
 */

 /**
  * 管理者
  */
Route::get('/user-no-registered', [UserNoRegisteredController::class, 'get']);
Route::post('approve-user-form', [UserNoRegisteredController::class, 'approve']);
Route::post('disapprove-user-form', [UserNoRegisteredController::class, 'disapprove']);
Route::get('all-user', [AdminUserController::class, 'getAll']);
