<?php

use DavidGut\SimpleAuth\Http\Controllers\LoginController;
use DavidGut\SimpleAuth\Http\Controllers\LogoutController;
use DavidGut\SimpleAuth\Http\Controllers\MagicLinkController;
use DavidGut\SimpleAuth\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;

Route::get('/signup', [SignupController::class, 'create'])->name('signup');
Route::post('/signup', [SignupController::class, 'store']);

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::get('/login/{method}', [LoginController::class, 'show'])->name('login.show');
Route::post('/login/{method}', [LoginController::class, 'store'])->name('login.store');

Route::post('/logout', LogoutController::class)->name('logout');

Route::get('/magic-link/{user}/{hash}', MagicLinkController::class)
    ->middleware('signed')
    ->name('magic_link');
