<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/**
 * Authentication Route
 */
Route::controller(AuthController::class,)->group(function(){
    Route::get('/cms-admin/login', 'index')->name('login');
    Route::post('/cms-admin/auth', 'authenticate')->name('login.auth');
    Route::post('/logout', 'logout')->name('logout');
});

/**
 * Admin: Dashboard Route
 */
Route::controller(DashboardController::class)->group(function(){
    Route::get('/cms-admin/dashboard', 'index')->name('admin.dashboard');
});

