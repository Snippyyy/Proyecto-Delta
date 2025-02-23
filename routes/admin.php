<?php

use App\Http\Middleware\AdminAccessMiddleware;
use App\Http\Controllers\DiscountCodeController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;


Route::middleware(AdminAccessMiddleware::class)->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');

    Route::get('discount-code', [DiscountCodeController::class, 'index'])->name('discount-code');
    Route::get('discount-code/create', [DiscountCodeController::class, 'create'])->name('discount-code.create');
    Route::post('discount-code', [DiscountCodeController::class, 'store'])->name('discount-code.store');
});

