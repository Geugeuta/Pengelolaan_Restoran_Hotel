<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HidanganController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'authenticate')->name('authenticate');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/', 'index')->name('index');
        Route::middleware(['auth'])->group(function () {
            Route::get('cart', [UserController::class, 'cart'])->name('cart');
            Route::get('add-to-cart/{id}', [UserController::class, 'addToCart'])->name('add.to.cart');
            Route::patch('update-cart', [UserController::class, 'update'])->name('update.cart');
            Route::delete('remove-from-cart', [UserController::class, 'remove'])->name('remove.from.cart');
        });
});

Route::middleware(['admin'])->group(function () {
    Route::prefix('dashboard')->group(function () {
            Route::controller(DashboardController::class)->group(function () {
                Route::get('/', 'index')->name('dashboard.index');
            });
        });
});
Route::middleware(['admin'])->group(function () {
    Route::controller(HidanganController::class)->group(function () {
        Route::get('/hidangan', 'index')->name('dashboard.hidangan');
        Route::post('/hidangan/store', 'store')->name('dashboard.hidangan.store');
        Route::get('/hidangan/edit/{id}', 'edit')->name('dashboard.hidangan.edit');
        Route::patch('/hidangan/update', 'update')->name('dashboard.hidangan.update');
        Route::delete('/hidangan/delete/{id}', 'delete')->name('dashboard.hidangan.delete');
    });
});
