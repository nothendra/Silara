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

//Route untuk Warga (Login via Sanctum)
Route::middleware(['auth:sanctum'])->group(function () {
    // lihat semua aduan milik warga login
    Route::get('/warga/aduan', [AduanController::class, 'getByWarga']);

    // buat aduan baru
    Route::post('/aduan', [AduanController::class, 'store']);

    // lihat detail aduan tertentu
    Route::get('/aduan/{id}', [AduanController::class, 'show']);
});


// Route untuk RT (Role: rt)
Route::middleware(['auth:sanctum', 'role:rt'])->group(function () {
    // lihat semua aduan (bisa filter status)
    Route::get('/aduan', [AduanController::class, 'index']);

    // ubah status aduan (dalam_proses / selesai)
    Route::put('/aduan/{id}/status', [AduanController::class, 'updateStatus']);
});
