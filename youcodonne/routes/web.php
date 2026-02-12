<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FavoriController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('restaurants', RestaurantController::class);

    Route::resource('reservations', ReservationController::class)->except(['edit', 'update']);

    Route::get('/favoris', [FavoriController::class, 'index'])->name('favoris.index');
    Route::post('/favoris/{restaurant}/toggle', [FavoriController::class, 'toggle'])->name('favoris.toggle');

    Route::get('/payments/{reservation}/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/{reservation}', [PaymentController::class, 'store'])->name('payments.store');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});