<?php

use App\Helpers\ApiResponse;
use App\Http\Controllers\Api\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Api\Admin\FeatureController;
use App\Http\Controllers\Api\Admin\PlanController;
use App\Http\Controllers\Api\Admin\TenantController;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return ApiResponse::notFound(message: 'Endpoint not found');
})->middleware('throttle:throttle_fallback'); // 10 requests per minute

Route::post('auth/login', AdminAuthController::class);

Route::group(['middleware' => ['auth:admin']], function () {
    Route::apiResource('features', FeatureController::class);
    Route::apiResource('plans', PlanController::class);
    Route::apiResource('users', PlanController::class);
    Route::apiResource('tenants', TenantController::class);
    Route::get('tenants-statics', [TenantController::class,'statics']);

});
