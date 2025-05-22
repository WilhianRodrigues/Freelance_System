<?php

// routes/auth.php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Rota de login (GET)
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

// Rota de login (POST)
Route::post('login', [LoginController::class, 'login'])->name('login.post');

// Rota de logout (POST)
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Rota de registro (GET)
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Rota de registro (POST)
Route::post('register', [RegisterController::class, 'register'])->name('register.post');

// Rota de recuperação de senha (GET)
Route::view('forgot-password', 'auth.forgot-password')->name('password.request');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

