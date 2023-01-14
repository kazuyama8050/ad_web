<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

/**
 * アフィリエイター
 */
use App\Http\Controllers\Api\Deliveler\LoginDelivelerController;
use App\Http\Controllers\Api\Category\FirstLevelCategoriesController;
use App\Http\Controllers\Api\Deliveler\RegisterApplyFormController;
use App\Http\Controllers\Api\Deliveler\CategoriesController as DelivelerCategoriesController;

/**
 * 広告主
 */

 /**
  * 管理者
  */
use App\Http\Controllers\Api\Admin\DelivelerNoRegisteredController;
use App\Http\Controllers\Api\Admin\AdminDelivelerController;

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
Route::post('/login-deliveler', [LoginDelivelerController::class, 'login']);
Route::get('/login-check-deliveler', [LoginDelivelerController::class, 'loginCheck']);
Route::get('/first-level-categories', [FirstLevelCategoriesController::class, 'get']);
Route::post('/register-deliveler-form', [RegisterApplyFormController::class, 'create']);
Route::get('/all-categories', [DelivelerCategoriesController::class, 'getAll']);

/**
 * 広告主
 */

 /**
  * 管理者
  */
Route::get('/deliveler-no-registered', [DelivelerNoRegisteredController::class, 'get']);
Route::post('approve-deliveler-form', [DelivelerNoRegisteredController::class, 'approve']);
Route::post('disapprove-deliveler-form', [DelivelerNoRegisteredController::class, 'disapprove']);
Route::get('all-deliveler', [AdminDelivelerController::class, 'getAll']);
