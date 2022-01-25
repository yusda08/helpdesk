<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('home', HomeController::class)->name('home');
    Route::get('logout', LogoutController::class)->name('logout');

    Route::prefix('pegawai')->controller(PegawaiController::class)->group(function () {
        Route::post('load-data', 'loadPegawai');
    });
});

