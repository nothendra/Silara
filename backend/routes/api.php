<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AduanController;



Route::get('/', function () {
    return response()->json(['message' => 'API is running']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/aduan', [AduanController::class, 'index'])
        ->middleware('role:rt');
});

// aduan route
Route::get('/aduan', [AduanController::class, 'index']);
Route::post('/aduan', [AduanController::class, 'store']);