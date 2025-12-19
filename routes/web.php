<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\website\Home\HomeController;
use App\Http\Controllers\website\Auth\LoginController;
use App\Http\Controllers\Backend\Admin\AdminController;

use App\Http\Controllers\website\Auth\RegisterController;
use App\Http\Controllers\website\Auth\GoogleAuthController;
use App\Http\Controllers\website\Profile\ProfileController;
use App\Http\Controllers\Backend\Auth\ManagerLoginController;
use App\Http\Controllers\website\Category\CategoryController;
use App\Http\Controllers\Backend\Dashboard\DashboardController;
use App\Http\Controllers\Backend\Category\BackCategoryController;
use App\Http\Controllers\Backend\Subcategory\BackSubcategoryController;
use App\Http\Controllers\website\Profile\ResetCredentialsController;



Route::get('/', [HomeController::class, 'home']);


// Google OAuth routes (locale prefix olmadan)
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
// *****************************************************************************************



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

        // Category routes (en sonda - wildcard)
        Route::middleware('normalize.slug')->group(function () {

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

        Route::get('/manager/admin', [AdminController::class, 'index'])->name('admin.view');
        Route::post('/manager/admin', [AdminController::class, 'store'])->name('admin.store');
        Route::put('/manager/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/manager/admin/delete/{id}', [AdminController::class, 'destroy'])->name('admin.delete');


        Route::get('/manager/category'   ,[BackCategoryController::class ,'index'])->name('category.view');
        Route::post('/manager/category'  ,[BackCategoryController::class ,'store'])->name('category.store');
        Route::put('/manager/category/update/{id}'  , [BackCategoryController::class , 'update'])->name('category.update');


        Route::get('/manager/subcategory'   ,[BackSubcategoryController::class ,'index'])->name('subcategory.view');
        Route::post('/manager/subcategory', [BackSubcategoryController::class, 'store'])->name('subcategory.store');
        Route::put('/manager/subcategory/update/{id}', [BackSubcategoryController::class, 'update'])->name('subcategory.update');
        Route::delete('/manager/subcategory/delete/{id}', [BackSubcategoryController::class, 'destroy'])->name('subcategory.delete');


    });




