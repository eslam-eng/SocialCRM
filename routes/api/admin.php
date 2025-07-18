<?php

use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\CurrencyController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:admin')->group(function () {
    Route::post('login', AdminAuthController::class);
    Route::resource('currencies', CurrencyController::class);
    Route::resource('segments', SegmentController::class);
});
