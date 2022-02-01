<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ComplaintImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MappingController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'store']);
});

Route::middleware(['logged'])->group(function () {
    Route::post('logout', LogoutController::class)->name('logout');
    Route::prefix('pegawai')->controller(PegawaiController::class)->group(function () {
        Route::get('api-pegawai/{nip}', 'getApiPegawai');
        Route::post('load-data', 'loadPegawai');
        Route::post('reset-account', 'resetAccount');
    });

    Route::middleware(['administrator'])->group(function () {
        Route::get('home', HomeController::class)->name('home');

        Route::middleware(['admin'])->group(function () {
            Route::prefix('user')->controller(UserController::class)->group(function () {
                Route::get('/', 'index')->name('user');
                Route::post('/', 'store');
                Route::post('reset-password/{id}', 'resetPassword');
                Route::post('update-status/{user}', 'updateStatus');
                Route::post('delete/{id}', 'destroy');
            });
            Route::prefix('mapping')->controller(MappingController::class)->group(function () {
                Route::get('/', 'index')->name('mapping');
                Route::post('/', 'store');
            });
        });

        Route::prefix('unit')->controller(UnitController::class)->group(function () {
            Route::get('load-unit', 'loadUnit');
        });

    });

//    Route::middleware(['subadmin'])->group(function () {
//        Route::get('home', HomeController::class)->name('home');
//    });

    Route::middleware(['pegawai'])->group(function () {
        Route::prefix('complaint')->controller(ComplaintController::class)->group(function () {
            Route::get('/', 'index')->name('complaint');
            Route::post('/', 'store');
            Route::post('store-image', 'storeImage')->name('store-image');
            Route::post('posting/{ticket}', 'posting');
            Route::post('delete', 'delete');
        });
    });

    Route::prefix('complaint-image')->controller(ComplaintImageController::class)->group(function () {
        Route::get('/', 'index')->name('complaint-images');
        Route::post('/', 'store');
        Route::post('delete/{images}', 'destroy');
        Route::get('load-image/{ticket_code}', 'loadComplaintImages');
    });

});

