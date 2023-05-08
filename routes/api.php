<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\videoController;


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



Route::group([

    'middleware' => 'api',



], function ($router) {
    Route::post('create', [AuthController::class,'create']);

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);
    Route::post('checkOtp', [AuthController::class,'checkOtp']);
    Route::post('sendOtp', [AuthController::class,'sendOtp']);
    Route::post('resendOtp', [AuthController::class,'reSendOtp']);
    Route::post('resetPassword', [AuthController::class,'resetPassword']);

});

// for videos

Route::resource('video', videoController::class);
