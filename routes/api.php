<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

/**
 * アフィリエイター
 */
use App\Http\Controllers\Api\Category\FirstLevelCategoriesController;
use App\Http\Controllers\Api\Deliveler\RegisterApplyFormController;

/**
 * 広告主
 */

 /**
  * 管理者
  */
use App\Http\Controllers\Api\Admin\DelivelerNoRegisteredController;

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
Route::get('/first-level-categories', [FirstLevelCategoriesController::class, 'get']);
Route::post('register-deliveler-form', [RegisterApplyFormController::class, 'create']);

/**
 * 広告主
 */

 /**
  * 管理者
  */
Route::get('/deliveler-no-registered', [DelivelerNoRegisteredController::class, 'get']);
Route::post('approve-deliveler-form', [DelivelerNoRegisteredController::class, 'approve']);
Route::post('disapprove-deliveler-form', [DelivelerNoRegisteredController::class, 'disapprove']);
