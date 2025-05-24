<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WebController;
use App\Http\Controllers\Main\MainController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\WebPageDefaultController;
use App\Http\Controllers\Admin\WebCategoryDefaultController;

/**
 * Main Web Route
 */
Route::middleware('subdomain')->group(function(){
    Route::controller(MainController::class)->group(function(){
        Route::get('/', 'index')->name('main');
        Route::get('/page/{slug}', 'show_page')->name('main.page');
        Route::get('/post/{slug}', 'show_post')->name('main.post');
        Route::get('/category/{slug}', 'show_category')->name('main.category');
        Route::get('/search', 'show_search')->name('main.search');
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

        Route::controller(WebPageDefaultController::class)->group(function(){
            Route::get('/cms-admin/default/page', 'index')->name('admin.default.page');
            Route::post('/cms-admin/default/page', 'store')->name('admin.default.page.store');
            Route::put('/cms-admin/default/page/{id}', 'update')->name('admin.default.page.update');
            Route::delete('/cms-admin/default/page/{id}', 'destroy')->name('admin.default.page.destroy');
            Route::get('/cms-admin/default/page/{id}', 'page_get')->name('admin.default.page.get');
        });

        Route::controller(WebCategoryDefaultController::class)->group(function(){
            Route::get('/cms-admin/default/category', 'index')->name('admin.default.category');
            Route::post('/cms-admin/default/category', 'store')->name('admin.default.category.store');
            Route::put('/cms-admin/default/category/{id}', 'update')->name('admin.default.category.update');
            Route::delete('/cms-admin/default/category/{id}', 'destroy')->name('admin.default.category.destroy');
            Route::get('/cms-admin/default/category/{id}', 'category_get')->name('admin.default.category.get');
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
            Route::post('/cms-admin/post/{id}/banner', 'set_banner_upload')->name('admin.post.set_banner_upload');
            Route::post('/cms-admin/post/{id}/banner-media', 'set_banner_media')->name('admin.post.set_banner_media');
            Route::delete('/cms-admin/post/{id}/banner', 'delete_banner')->name('admin.post.delete_banner');
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
            Route::post('/cms-admin/media/load', 'media_load')->name('admin.media.load');
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
            
            Route::post('/cms-admin/theme/partnership-slide/{media_id}', 'store_partnership_slide')->name('admin.theme.store_partnership_slide');
            Route::post('/cms-admin/theme/partnership-slide', 'upload_partnership_slide')->name('admin.theme.upload_partnership_slide');
            
            Route::delete('/cms-admin/theme/slide/{id}', 'destroy_slide')->name('admin.theme.delete_slide');
        });
    });
});

