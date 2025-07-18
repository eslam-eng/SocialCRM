<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\SegmentController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest', 'prefix' => 'auth'], function () {
    Route::post('login', AuthController::class);
    Route::post('register', AuthController::class);
});

Route::prefix('auth')->group(function () {
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetCode']);
    Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('segments', SegmentController::class);

});
