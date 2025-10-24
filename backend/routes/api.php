<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AduanController;

Route::get('/', function () {
    return response()->json(['message' => 'API is running']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Semua route yang butuh autentikasi
Route::middleware(['auth:sanctum'])->group(function () {
    // WARGA
    Route::get('/warga/aduan', [AduanController::class, 'getByWarga']);
    Route::post('/aduan', [AduanController::class, 'store']);
    
    // RT & ADMIN
    Route::get('/aduan', [AduanController::class, 'index']);
    Route::get('/aduan/{id}', [AduanController::class, 'show']);
    Route::post('/aduan/{id}/recommend', [AduanController::class, 'sendRecommendation']);
    
    // ADMIN ONLY
    Route::put('/aduan/{id}/status', [AduanController::class, 'updateStatus']);
    Route::get('/admin/recommendations', [AduanController::class, 'getRecommendations']);
    Route::post('/admin/recommendations/{id}/handle', [AduanController::class, 'handleRecommendation']);
});