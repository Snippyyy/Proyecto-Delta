<?php

use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProductsController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\UserSoldController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AuthUserOrderMiddleware;
use App\Http\Middleware\AuthUserSoldMiddleware;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('my-products', UserProductsController::class)->name('my-products');
    Route::get('orders', [UserOrderController::class, 'index'])->name('my-orders');
    Route::get('my-sold', [UserSoldController::class, 'index'])->name('my-sold');
});

Route::middleware(AuthUserOrderMiddleware::class)->group(function () {
    Route::get('orders/{order}', [UserOrderController::class, 'show'])->name('my-orders.show');
    Route::get('orders/{order}/download', PdfController::class)->name('my-orders.download');
});

Route::middleware(AuthUserSoldMiddleware::class)->group(function () {
    Route::get('my-sold/{order}', [UserSoldController::class, 'show'])->name('my-sold.show');
    Route::post('my-sold/{order}/shipment', [UserSoldController::class, 'shipment'])->name('shipment');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
