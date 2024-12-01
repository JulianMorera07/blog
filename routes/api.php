<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Rutas para los posts, solo accesibles para usuarios autenticados
Route::post('/create-register', [AuthController::class, 'register']);
Route::post('/sign-in', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/{categoryId}', [PostController::class, 'index']);
});
