<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Management\ConcessionController;
use App\Http\Controllers\Management\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;




Route::middleware('auth')->group(function () {
    //dashboard
    Route::get('/', DashboardController::class)->name('dashboard');
    //concessions
    Route::prefix('concessions')->name('concessions.')->controller(ConcessionController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{concession}/edit', 'edit')->name('edit');
        Route::put('/{concession}/update', 'update')->name('update');
        Route::delete('/{concession}/destroy', 'destroy')->name('destroy');
    });
    //orders
    Route::prefix('orders')->name('orders.')->controller(OrderController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{order}/edit', 'edit')->name('edit');
        Route::put('/{order}/update', 'update')->name('update');
        Route::delete('/{order}/destroy', 'destroy')->name('destroy');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
