<?php

use App\Http\Controllers\Api\PlanSubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/subscriptions/{id}', [PlanSubscriptionController::class, 'show']);
Route::post('/subscriptions/{id}/cancel', [PlanSubscriptionController::class, 'cancel']);
