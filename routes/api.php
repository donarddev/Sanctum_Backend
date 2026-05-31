<?php

use App\Http\Controllers\Api\AskCatechismController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DailyReflectionController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\RosaryProgressController;
use App\Http\Controllers\Api\SaintController;
use App\Http\Controllers\Api\PeaceSessionController;
use App\Http\Controllers\Api\PrayerSessionController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/prayer-sessions', [PrayerSessionController::class, 'store']);
    Route::post('/peace-sessions', [PeaceSessionController::class, 'store']);
    Route::get('/dashboard-stats', [DashboardController::class, 'index']);
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/rosary-progress', [RosaryProgressController::class, 'index']);
    Route::post('/rosary-progress', [RosaryProgressController::class, 'store']);
    Route::get('/daily-reflection', [DailyReflectionController::class, 'index']);
    Route::post('/daily-reflection/read', [DailyReflectionController::class, 'read']);
    Route::get('/saint-of-the-day', [SaintController::class, 'index']);
    Route::post('/ask-catechism', [AskCatechismController::class, 'ask']);
});
