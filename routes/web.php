<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Profile\ResetCredentialsController;

Route::get('/lang/{locale}', function () {
    return redirect()->back();
})->middleware('switch.locale')->name('lang.switch');

Route::get('/',                                                         [HomeController::class , 'home'])->name("dashboard");
Route::get('/test' ,                                                    [ProfileController::class , 'subcategory']);

Route::get('/{slug}',                                          [CategoryController::class, 'show'])->name('category.show');

Route::get('/{categorySlug}/{subSlug}',                         [CategoryController::class, 'subShow'])->name('subcategory.show');

// Login ve Register sayfaları
Route::middleware("auth.page")->group(function () {
    Route::get("/register",                                           [RegisterController::class, "index"])->name("register-page");
    Route::post("/register"                                         , [RegisterController::class, "register"])->name("register");

    Route::get('/login'                                             , [LoginController::class, 'index'])->name('login-page');
    Route::post('/login'                                            , [LoginController::class, 'login'])->name('login');

    Route::get('/auth/google'                   ,                  [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback'      ,                      [GoogleAuthController::class, 'callback'])->name('google.callback');
});

// Qorunan Routeler
Route::middleware('auth.user')->group(function () {
    Route::Get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/reset' ,[ResetCredentialsController::class , 'updateCredentials'])->name("reset-credentials");
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
