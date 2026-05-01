<?php

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\PlannerController;
use Illuminate\Support\Facades\Route;

// 1. Guest Routes
Route::get('/', [HomepageController::class, 'index'])->name('homepage');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/register', [RegisterController::class, 'index'])->name('register');

Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// 2. Planner Routes (Teammate's Work)
Route::get('/course-planner', [PlannerController::class, 'course'])->name('course.planner');
Route::get('/section-planner', [PlannerController::class, 'section'])->name('section.planner');

// 3. Protected Routes (Requires Login)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard main page
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Calculator Route (New)
    Route::get('/calculator/cgpa', [DashboardController::class, 'cgpaCalculator'])->name('calculator.cgpa');
    
    // To-do list (Add, Toggle, Delete)
    Route::post('/tasks', [DashboardController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}/toggle', [DashboardController::class, 'toggle'])->name('tasks.toggle');
    Route::delete('/tasks/{task}', [DashboardController::class, 'destroy'])->name('tasks.destroy');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});