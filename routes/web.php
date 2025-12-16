<?php

use App\Http\Controllers\Backend\Auth\ManagerLoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\website\Home\HomeController;

use App\Http\Controllers\website\Auth\LoginController;
use App\Http\Controllers\website\Auth\RegisterController;
use App\Http\Controllers\website\Auth\GoogleAuthController;
use App\Http\Controllers\Backend\Dashboard\DashboardController;
use App\Http\Controllers\website\Profile\ProfileController;
use App\Http\Controllers\website\Category\CategoryController;
use App\Http\Controllers\website\Profile\ResetCredentialsController;

// Root URL - Locale olmadan direkt home (middleware locale'i ayarlar)

Route::get('/', [HomeController::class, 'home'])->middleware('setlocale');
Route::get('/test' , [HomeController::class , 'test']);

// Google OAuth routes (locale prefix olmadan)
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');




Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => 'az|en|ru'],
       'middleware' => ['switch.locale', 'normalize.slug']
], function () {

    Route::get('/', [HomeController::class, 'home'])->name('dashboard');

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






Route::prefix('admin')->group(function () {

    // 🔓 Backend login page
    Route::get('/auth', [ManagerLoginController::class, 'showLoginForm'])
        ->name('backend.login');

    // 🔓 Backend login submit
    Route::post('/auth', [ManagerLoginController::class, 'login'])
        ->name('backend.login.submit');

    // 🔒 Backend logout
    Route::post('/auth/logout', [ManagerLoginController::class, 'logout'])
        ->middleware('auth:admin')
        ->name('backend.logout');

    // 🔒 Backend dashboard
    Route::get('/panel', [DashboardController::class, 'index'])
        ->middleware([
            'auth:admin',
            'admin.permission:dashboard.view'
        ])
        ->name('backend.dashboard');

});

