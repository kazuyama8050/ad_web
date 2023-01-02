<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\Category\GetFirstLevelCategoriesController;
use App\Http\Controllers\Api\Deliveler\RegisterApplyFormController;

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

Route::get('/first-level-categories', [GetFirstLevelCategoriesController::class, 'get']);
Route::post('register-deliveler-form', [RegisterApplyFormController::class, 'create']);