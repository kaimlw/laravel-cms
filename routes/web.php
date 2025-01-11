<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WebController;
use Illuminate\Support\Facades\Route;

/**
 * Authentication Route
 */
Route::controller(AuthController::class,)->group(function(){
    Route::get('/cms-admin/login', 'index')->name('login');
    Route::post('/cms-admin/auth', 'authenticate')->name('login.auth');
    Route::post('/logout', 'logout')->name('logout');
});

// Route with Auth Middleware
Route::middleware('auth')->group(function(){
    /**
     * Admin: Dashboard Route
     */
    Route::controller(DashboardController::class)->group(function(){
        Route::get('/cms-admin', 'index')->name('admin.dashboard');
    });
    
    /**
     * Admin: User Route 
     */
    Route::controller(UserController::class)->group(function(){
        Route::get('/cms-admin/user', 'index')->name('admin.user');
        Route::post('/cms-admin/user', 'store')->name('admin.user.store');
        Route::put('/cms-admin/user/{id}', 'update')->name('admin.user.update');
        Route::delete('/cms-admin/user/{id}', 'destroy')->name('admin.user.destroy');
        Route::get('/cms-admin/user/{id}', 'user_get')->name('admin.user.get');
    });

    /**
     * Admin: Web Route
     */
    Route::controller(WebController::class)->group(function(){
        Route::get('/cms-admin/web', 'index')->name('admin.web');
        Route::post('/cms-admin/web', 'store')->name('admin.web.store');
        Route::put('/cms-admin/web/{id}', 'update')->name('admin.web.update');
        Route::delete('/cms-admin/web/{id}', 'destroy')->name('admin.web.destroy');
        Route::get('/cms-admin/web/{id}', 'web_get')->name('admin.web.get');
    });

    /**
     * Admin: Kategori Route
     */
    Route::controller(CategoryController::class)->group(function(){
        Route::get('/cms-admin/category', 'index')->name('admin.category');
        Route::post('/cms-admin/category', 'store')->name('admin.category.store');
        Route::put('/cms-admin/category/{id}', 'update')->name('admin.category.update');
        Route::delete('/cms-admin/category/{id}', 'destroy')->name('admin.category.destroy');
        Route::get('/cms-admin/category/{id}', 'category_get')->name('admin.category.get');
    });

    /**
     * Admin: Post Route
     */
    Route::controller(PostController::class)->group(function(){
        Route::get('/cms-admin/post', 'index')->name('admin.post');
        Route::post('/cms-admin/post', 'store')->name('admin.post.store');
        Route::get('/cms-admin/post/{id}', 'edit')->name('admin.post.edit');
        Route::put('/cms-admin/post/{id}', 'update')->name('admin.post.update');
        Route::put('/cms-admin/post/{id}/publish', 'publish')->name('admin.post.publish');
        Route::delete('/cms-admin/post/{id}', 'destroy')->name('admin.post.destroy');
    });
});

