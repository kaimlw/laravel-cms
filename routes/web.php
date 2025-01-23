<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WebController;
use App\Http\Controllers\Main\MainController;
use Illuminate\Support\Facades\Route;

/**
 * Main Web Route
 */
Route::middleware('subdomain')->group(function(){
    Route::controller(MainController::class)->group(function(){
        Route::get('/', 'index')->name('main');
    });
});

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
     * Route untuk role super_admin
     */
    Route::middleware('role:super_admin')->group(function(){
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
    });

    /**
     * Route untuk role web_admin
     */
    Route::middleware('role:web_admin')->group(function(){            
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
    
        /**
         * Admin: Menu Route
         */
        Route::controller(MenuController::class)->group(function(){
            Route::get('/cms-admin/menu', 'index')->name('admin.menu');
            Route::post('/cms-admin/menu', 'store')->name('admin.menu.store');
            Route::put('/cms-admin/menu/{id}', 'update')->name('admin.menu.update');
            Route::delete('/cms-admin/menu/{id}', 'destroy')->name('admin.menu.destroy');
            Route::get('/cms-admin/menu/{id}', 'menu_get')->name('admin.menu.get');
        });
    
        /**
         * Admin: Media Route
         */
        Route::controller(MediaController::class)->group(function(){
            Route::get('/cms-admin/media', 'index')->name('admin.media');
            Route::post('/cms-admin/media', 'store')->name('admin.media.store');
            Route::delete('/cms-admin/media/{id}', 'destroy')->name('admin.media.delete');
            Route::get('/cms-admin/media/{id}', 'media_get')->name('admin.media.get');
            Route::post('/cms-admin/media/upload', 'upload_image')->name('admin.media.upload');
        });

        /**
         * Admin: Setting Route
         */
        Route::controller(SettingController::class)->group(function(){
            Route::get('/cms-admin/setting', 'index')->name('admin.setting');
            Route::put('/cms-admin/setting/{id}', 'update')->name('admin.setting.update');
            Route::put('/cms-admin/setting/{id}/banner-null', 'set_banner_post_null');
        });

        /**
         * Admin: Theme Route
         */
        Route::controller(ThemeController::class)->group(function(){
            Route::get('/cms-admin/theme', 'index')->name('admin.theme');
            
            Route::post('/cms-admin/theme/main-slide/{media_id}', 'store_main_slide')->name('admin.theme.store_main_slide');
            Route::post('/cms-admin/theme/main-slide', 'upload_main_slide')->name('admin.theme.upload_main_slide');
            
            Route::post('/cms-admin/theme/agenda-slide/{media_id}', 'store_agenda_slide')->name('admin.theme.store_agenda_slide');
            Route::post('/cms-admin/theme/agenda-slide', 'upload_agenda_slide')->name('admin.theme.upload_agenda_slide');
            
            Route::post('/cms-admin/theme/gallery-slide/{media_id}', 'store_gallery_slide')->name('admin.theme.store_gallery_slide');
            Route::post('/cms-admin/theme/gallery-slide', 'upload_gallery_slide')->name('admin.theme.upload_gallery_slide');
            
            Route::delete('/cms-admin/theme/slide/{id}', 'destroy_slide')->name('admin.theme.delete_slide');
        });
    });
});

