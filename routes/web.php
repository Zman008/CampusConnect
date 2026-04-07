<?php

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomepageController::class, 'index']) -> name('homepage');

Route::get('/login', [LoginController::class, 'index']) -> name('login');

Route::get('/register', [RegisterController::class, 'index']) -> name('register');

Route::post('/login', [LoginController::class, 'authenticate']) -> name('login.authenticate');

Route::post('/register', [RegisterController::class, 'store']) -> name('register.store');

Route::post('/logout', [LoginController::class, 'logout']) -> name('logout');