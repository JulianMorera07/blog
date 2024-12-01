<?php

use Illuminate\Support\Facades\Route;

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Ruta para la vista de login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/', function () {
    return view('auth.login');
});

