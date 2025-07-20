<?php

use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\FeatureController;
use App\Http\Controllers\Api\PlanController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:admin')->group(function () {

    Route::post('login', AdminAuthController::class);

    Route::apiResource('features', FeatureController::class);
    Route::apiResource('plans', PlanController::class);

});
