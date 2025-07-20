<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\EmailVerificationController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\GoogleAuthController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\SegmentController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest', 'throttle:login'], 'prefix' => 'auth'], function () {
    Route::post('login', AuthController::class);
    Route::post('register', RegisterController::class);
    Route::get('google', [GoogleAuthController::class, 'redirectToProvider']);
    Route::get('google/callback', [GoogleAuthController::class, 'authenticate']);
});

Route::prefix('auth')->middleware(['throttle:verification_code'])->group(function () {
    Route::post('reset/code', [ForgotPasswordController::class, 'sendVerificationCode']);
    Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword']);
});

Route::group(['middleware' => ['auth:sanctum','locale']], function () {
    // Email verification routes
    Route::prefix('email')->group(function () {
        Route::post('verify', [EmailVerificationController::class, 'verify']);
        Route::post('send-verification-code', [EmailVerificationController::class, 'resend'])->middleware('throttle:verification_code');
    });

    Route::group(['middleware' => 'verified'], function () {
        Route::resource('segments', SegmentController::class);
    });


});
