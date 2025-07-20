<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\SocialAuthController;
use App\Http\Controllers\Api\SegmentController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest','throttle:login'], 'prefix' => 'auth'], function () {
    Route::post('login', AuthController::class);
    Route::post('register', AuthController::class);
    Route::get('redirect/{provider}', [SocialAuthController::class, 'redirectToProvider']);
    Route::post('socialite/callback', [SocialAuthController::class, 'authenticate']);
});

Route::prefix('auth')->middleware(['throttle:password_reset'])->group(function () {
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetCode']);
    Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('segments', SegmentController::class);

});
