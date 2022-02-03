<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Complaint\ComplaintController;
use App\Http\Controllers\Complaint\ComplaintImageController;
use App\Http\Controllers\Complaint\RatingController;
use App\Http\Controllers\Feedback\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Reset\ResetController;
use App\Http\Controllers\User\MappingController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Utility\PegawaiController;
use App\Http\Controllers\Utility\UnitController;
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
        Route::get('reset', ResetController::class)->name('reset');

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
                Route::post('delete/{map_id}', 'destroy');
            });
        });

        Route::prefix('feedback')->controller(FeedbackController::class)->group(function () {
            Route::get('/', 'index')->name('feedback');
            Route::get('/history', 'history')->name('history');
            Route::post('/', 'store');
            Route::put('/{complaint_ticket:ticket_code}', 'updateStatus');
            Route::get('detail/{complaint_ticket:ticket_code}', 'detail')->name('feedback-detail');
        });

        Route::prefix('unit')->controller(UnitController::class)->group(function () {
            Route::get('load-unit', 'loadUnit');
        });
    });

    Route::prefix('feedback')->controller(FeedbackController::class)->group(function () {
        Route::post('/', 'store')->name('feedback');
    });

    Route::middleware(['pegawai'])->group(function () {
        Route::prefix('complaint')->controller(ComplaintController::class)->group(function () {
            Route::get('/', 'index')->name('complaint');
            Route::post('/', 'store');
            Route::post('store-image', 'storeImage')->name('store-image');
            Route::post('posting/{ticket}', 'posting');
            Route::post('delete', 'delete');
            Route::get('detail/{complaint_ticket:ticket_code}', 'detail')->name('feedback-detail');
        });
        Route::prefix('rating')->controller(RatingController::class)->group(function () {
            Route::post('/', 'store')->name('rating-star');
        });
    });

    Route::prefix('complaint-image')->controller(ComplaintImageController::class)->group(function () {
        Route::get('/', 'index')->name('complaint-images');
        Route::post('/', 'store');
        Route::post('delete/{images}', 'destroy');
        Route::get('load-image/{ticket_code}', 'loadComplaintImages');
    });

});

