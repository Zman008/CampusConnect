<?php

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController; // এটা নতুন যোগ হয়েছে
use Illuminate\Support\Facades\Route;

// ১. guest route(wil show without login)
Route::get('/', [HomepageController::class, 'index'])->name('homepage');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/register', [RegisterController::class, 'index'])->name('register');

Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// ২. protected route (will show after login)
Route::middleware(['auth'])->group(function () {
    
    // dashboard main page
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // to-do list (Add, Toggle, Delete)
    Route::post('/tasks', [DashboardController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}/toggle', [DashboardController::class, 'toggle'])->name('tasks.toggle');
    Route::delete('/tasks/{task}', [DashboardController::class, 'destroy'])->name('tasks.destroy');

    // logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});