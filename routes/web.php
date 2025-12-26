<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\website\Home\HomeController;
use App\Http\Controllers\website\Auth\LoginController;
use App\Http\Controllers\Backend\Admin\AdminController;

use App\Http\Controllers\website\Auth\RegisterController;
use App\Http\Controllers\website\Auth\GoogleAuthController;
use App\Http\Controllers\website\Profile\ProfileController;
use App\Http\Controllers\Backend\Auth\ManagerLoginController;
use App\Http\Controllers\Backend\Slider\BackSliderController;
use App\Http\Controllers\website\Category\CategoryController;
use App\Http\Controllers\Website\Favorite\FavoriteController;
use App\Http\Controllers\Backend\Dashboard\DashboardController;
use App\Http\Controllers\Backend\Product\BackProductController;
use App\Http\Controllers\Backend\Product\ProductAjaxController;
use App\Http\Controllers\Backend\Category\BackCategoryController;
use App\Http\Controllers\website\Profile\ResetCredentialsController;
use App\Http\Controllers\Backend\Subcategory\BackSubcategoryController;
use App\Http\Controllers\Website\ProductDetail\ProductDetailController;
use App\Http\Controllers\Website\Basket\BasketController;



Route::get('/', [HomeController::class, 'home']);

// Google OAuth routes (locale prefix olmadan)
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
// *****************************************************************************************


// Rate limit: max 30 requests per minute per IP
Route::post('/basket/add/{product}', [BasketController::class, 'add'])
    ->middleware('throttle:30,1')
    ->name('basket.add');

// Rate limit for favorites
Route::post('/favorite/{product}', [FavoriteController::class, 'addfavorite'])
    ->middleware('throttle:30,1')
    ->name('favorite.toggle');



    Route::group([
        'prefix' => '{locale}',
        'where' => ['locale' => 'az|en|ru'],
        'middleware' => ['switch.locale']
    ], function () {

        Route::get('/', [HomeController::class, 'home'])->name('dashboard');
        Route::get('/login',[LoginController::class , 'index'])->name('login');
        // Guest routes (sadece giriş yapmamış kullanıcılar)
        Route::middleware('auth.page')->group(function () {
            Route::get('/login', [LoginController::class, 'index'])->name('login-page');
            Route::post('/login', [LoginController::class, 'login'])->name('login');

            Route::get('/register', [RegisterController::class, 'index'])->name('register-page');
            Route::post('/register', [RegisterController::class, 'register'])->name('register');
        });

        // Authenticated routes (sadece giriş yapmış kullanıcılar)
        Route::middleware('auth.user')->group(function () {
            Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
            Route::post('/profile/reset', [ResetCredentialsController::class, 'updateCredentials'])->name('reset-credentials');
            Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        });


        Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite.view');






        // Category routes (en sonda - wildcard)
        Route::middleware('normalize.slug')->group(function () {

         Route::get('/product/{slug}', [ProductDetailController::class, 'index'])->where('slug', '[\pL\pN\-]+')->name('product.detail');
        Route::get('/{categorySlug}/{subSlug}', [CategoryController::class, 'subShow'])
            ->where([
                'categorySlug' => '[\pL\pN\-]+',
                'subSlug' => '[\pL\pN\-]+',
            ])
            ->name('subcategory.show');

        Route::get('/{slug}', [CategoryController::class, 'show'])
            ->where('slug', '[\pL\pN\-]+')
            ->name('category.show');
        });


    });


// *********************** Backend/******************************** */




    Route::get('/manager/auth', [ManagerLoginController::class, 'showLoginForm'])->name('backend.login');
    Route::post('/auth', [ManagerLoginController::class, 'login'])->name('backend.login.submit');



     Route::middleware('admin.permission')->group(function () {
        Route::get('/manager/dashboard' , [DashboardController::class , 'index'])->name('dashboard.view');
        Route::post('/auth/logout', [ManagerLoginController::class, 'logout'])->name('backend.logout');

        Route::prefix('manager')->group(function () {


        Route::get('/admin', [AdminController::class, 'index'])->name('admin.view');
        Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
        Route::put('/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/admin/delete/{id}', [AdminController::class, 'destroy'])->name('admin.delete');


        Route::get('/category'   ,[BackCategoryController::class ,'index'])->name('category.view');
        Route::post('/category'  ,[BackCategoryController::class ,'store'])->name('category.store');
        Route::put('/category/update/{id}'  , [BackCategoryController::class , 'update'])->name('category.update');


        Route::get('/subcategory'   ,[BackSubcategoryController::class ,'index'])->name('subcategory.view');
        Route::post('/subcategory', [BackSubcategoryController::class, 'store'])->name('subcategory.store');
        Route::put('/subcategory/update/{id}', [BackSubcategoryController::class, 'update'])->name('subcategory.update');
        Route::delete('/subcategory/delete/{id}', [BackSubcategoryController::class, 'destroy'])->name('subcategory.delete');

        Route::get('/slider' ,[BackSliderController::class , 'index'])->name('slider.view');
        Route::post('/slider' ,[BackSliderController::class , 'store'])->name('slider.store');
        Route::put('/slider/update/{id}', [BackSliderController::class, 'update'])->name('slider.update');
        Route::delete('/slider/delete/{id}', [BackSliderController::class, 'destroy'])->name('slider.delete');

        Route::get('/product' , [BackProductController::class   , 'index'])->name('product.view');
        Route::post('/product' , [BackProductController::class   , 'store'])->name('product.store');
        Route::put('/product/update/{product}' , [BackProductController::class   , 'update'])->name('product.update');
        Route::get('/product/{category}', [ProductAjaxController::class, 'subcategories'])->name('admin.subcategories.byCategory');

        });






    });



