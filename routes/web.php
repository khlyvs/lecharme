<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;





Route::get('/', function () {
    return view('website.home.home');

})->name("dashboard");

// Login ve Register sayfaları - sadece giriş yapmamış kullanıcılar için
Route::middleware("auth.page")->group(function () {
    Route::get("/register", [RegisterController::class, "index"])->name("register-page");
    Route::post("/registerto", [RegisterController::class, "register"])->name("register");

    Route::get('/login', [LoginController::class, 'index'])->name('login-page');
    Route::post('/loginto', [LoginController::class, 'login'])->name('login');
});

// Giriş yapmış kullanıcılar için korumalı route'lar
Route::middleware('auth.user')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});





