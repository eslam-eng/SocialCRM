<?php

use App\Helpers\ApiResponse;
use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\FeatureController;
use App\Http\Controllers\Api\PlanController;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return ApiResponse::notFound(message: 'Endpoint not found');
})->middleware('throttle:throttle_fallback'); // 10 requests per minute

Route::middleware('auth:admin')->group(function () {

    Route::post('login', AdminAuthController::class);

    Route::apiResource('features', FeatureController::class);

    Route::apiResource('plans', PlanController::class);

});
