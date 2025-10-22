<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AduanController;

// Route Public
Route::get('/', function () {
    return response()->json(['message' => 'API is running']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Route untuk WARGA (role: warga)
Route::middleware(['auth:sanctum', 'role:warga'])->group(function () {
    // Lihat aduan milik sendiri
    Route::get('/warga/aduan', [AduanController::class, 'getByWarga']);
    // Buat aduan baru
    Route::post('/aduan', [AduanController::class, 'store']);
    // Lihat detail aduan sendiri
    Route::get('/aduan/{id}', [AduanController::class, 'show']);
});

// Route untuk RT (role: rt)
Route::middleware(['auth:sanctum', 'role:rt'])->group(function () {
    // Lihat semua aduan (bisa filter status)
    Route::get('/aduan', [AduanController::class, 'index']);
    // Ubah status aduan
    Route::put('/aduan/{id}/status', [AduanController::class, 'updateStatus']);
    // Lihat detail aduan tertentu
    Route::get('/aduan/{id}', [AduanController::class, 'show']);
});

// 🆕 Route untuk ADMIN (role: admin)
// Admin punya akses SEMUA fitur RT
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Lihat semua aduan
    Route::get('/aduan', [AduanController::class, 'index']);
    // Ubah status aduan
    Route::put('/aduan/{id}/status', [AduanController::class, 'updateStatus']);
    // Lihat detail aduan
    Route::get('/aduan/{id}', [AduanController::class, 'show']);
    
    // 🆕 Endpoint khusus admin (jika perlu)
    // Route::get('/admin/statistics', [AduanController::class, 'adminStatistics']);
});