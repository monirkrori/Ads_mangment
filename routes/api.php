<?php

use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and assigned to the "api"
| middleware group. Enjoy building your API!
|
*/

// Authentication Routes

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json(['message' => 'Email verified successfully.']);
})->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'Verification link sent!']);
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');


// Public Routes
Route::get('ads', [AdController::class, 'index']);
Route::get('ads/{ad}', [AdController::class, 'show']);
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    // Ad Routes
    Route::post('ads', [AdController::class, 'store']);
    Route::put('ads/{ad}', [AdController::class, 'update']);
    Route::delete('ads/{ad}', [AdController::class, 'destroy']);
    Route::get('user/ads/{user}', [AdController::class, 'userAds']);
    Route::put('ads/{ad}/review/{status}', [AdController::class, 'review']);

    // Review Routes
    Route::post('ads/{ad}/reviews', [ReviewController::class, 'store']);
    Route::put('reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy']);

    //categories routes
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{category}', [CategoryController::class, 'update']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

    // User Routes
    Route::get('user/{user}', [UserController::class, 'show']);
    Route::get('user', [UserController::class, 'index']);
});
