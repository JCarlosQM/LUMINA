<?php

use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResendOtpController;
use App\Http\Controllers\Auth\VerifyOtpController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/registro', [RegisterController::class, 'show'])->name('register');
    Route::post('/registro', [RegisterController::class, 'store'])->middleware('throttle:auth');

    Route::get('/entrar', [LoginController::class, 'show'])->name('login');
    Route::post('/entrar', [LoginController::class, 'store'])->middleware('throttle:auth');
});

Route::get('/verificar', [VerifyOtpController::class, 'show'])->name('verification.notice');
Route::post('/verificar', [VerifyOtpController::class, 'store'])->middleware('throttle:otp');
Route::post('/reenviar-codigo', ResendOtpController::class)->middleware('throttle:otp')->name('otp.resend');

Route::middleware('auth')->group(function () {
    Route::post('/salir', LogoutController::class)->name('logout');
    Route::get('/cuenta', AccountController::class)->middleware('verified')->name('account');
});
