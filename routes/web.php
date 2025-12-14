<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Profile\ResetCredentialsController;

Route::get('/', function () {
    return redirect('/' . session('locale', 'az'));
});

Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => 'az|en|ru'],
    'middleware' => 'switch.locale'
], function () {

    Route::get('/', [HomeController::class, 'home'])->name('dashboard');

    Route::middleware('auth.page')->group(function () {
        Route::get('/login', [LoginController::class, 'index'])->name('login-page');
        Route::post('/login', [LoginController::class, 'login'])->name('login');

        Route::get('/register', [RegisterController::class, 'index'])->name('register-page');
        Route::post('/register', [RegisterController::class, 'register'])->name('register');
    });

    Route::middleware('auth.user')->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('/profile/reset', [ResetCredentialsController::class, 'updateCredentials'])->name('reset-credentials');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
         Route::get('/auth/google'                   ,                  [GoogleAuthController::class, 'redirect'])->name('google.redirect');
         Route::get('/auth/google/callback'      ,                      [GoogleAuthController::class, 'callback'])->name('google.callback');
    });

     Route::get('/{categorySlug}/{subSlug}', [CategoryController::class, 'subShow'])
        ->name('subcategory.show');

    Route::get('/{slug}', [CategoryController::class, 'show'])
        ->name('category.show');
});
