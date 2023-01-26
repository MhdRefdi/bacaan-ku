<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Models\User as UserModel;

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

Route::group(['middleware' => 'api'], function () {
    // auth
    Route::group(['prefix' => 'oauth'], function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    });

    // for has login
    Route::group(['middleware' => 'auth:api'], function () {
        Route::apiResource('book', BookController::class);
    });

    // for customer
    // Route::group(['middleware' => 'role:' . UserModel::CUSTOMER_ROLE], function () {
    // });

    // for admin
    // Route::group(['middleware' => 'role:' . UserModel::ADMIN_ROLE], function () {
    // });
});
