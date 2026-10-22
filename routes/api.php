<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\FcmTokenController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('products', [ProductController::class, 'index']);
    Route::get('my-products', [ProductController::class, 'myProducts']);
    Route::post('products', [ProductController::class, 'store']);
    Route::post('orders', [OrderController::class, 'store']);

    // Reviews
    Route::get('products/{product}/reviews', [ReviewController::class, 'index']);
    Route::post('products/{product}/reviews', [ReviewController::class, 'store']);

    // Complaints
    Route::post('complaints', [ComplaintController::class, 'store']);
    Route::get('my-complaints', [ComplaintController::class, 'myComplaints']);

    // FCM token registration
    Route::post('fcm-token', [FcmTokenController::class, 'store']);
});

