<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CategoryShowController;
use App\Http\Controllers\Api\V1\DiscountCodeController;
use App\Http\Controllers\Api\V1\LoginUserController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\WelcomePageController;
use App\Http\Middleware\Api\V1\AdminAccessMiddleware;
use App\Http\Middleware\Api\V1\EnsureUserIsProductOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginUserController::class)->name('api.login');

//Productos
Route::get('/products', WelcomePageController::class)->name('api.welcome');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('api.product.show');

//Categorias
Route::get('/categories/{category}', CategoryShowController::class)->name('api.category.show');

//Users
Route::get('/users', [UserController::class, 'index'])->name('api.users.index');
Route::get('/users/{user:name}', [UserController::class, 'show'])->name('api.users.show');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products/create', [ProductController::class, 'store'])->name('api.product.store');
    Route::patch('/products/{product}/update', [ProductController::class, 'update'])->name('api.product.update')->middleware(EnsureUserIsProductOwner::class);
    Route::delete('/products/{product}/delete', [ProductController::class, 'destroy'])->name('api.product.delete')->middleware(EnsureUserIsProductOwner::class);
    Route::patch('/products/{product}/post', [ProductController::class, 'post'])->name('api.product.post')->middleware(EnsureUserIsProductOwner::class);

    //Admin

    Route::middleware(AdminAccessMiddleware::class)->group(function () {
        Route::get('/categories', [CategoryController::class, 'index'])->name('api.categories.index');
        Route::post('/categories/create', [CategoryController::class, 'store'])->name('api.categories.store');
        Route::delete('/categories/{category}/delete', [CategoryController::class, 'destroy'])->name('api.categories.delete');
        Route::patch('/categories/{category}/update', [CategoryController::class, 'update'])->name('api.categories.update');

        Route::get('/discount-codes', [DiscountCodeController::class, 'index'])->name('api.discount-codes.index');
        Route::get('/discount-codes/{discountCode}', [DiscountCodeController::class, 'show'])->name('api.discount-codes.show');
        Route::post('/discount-codes/create', [DiscountCodeController::class, 'store'])->name('api.discount-codes.store');
        Route::delete('/discount-codes/{discountCode}/delete', [DiscountCodeController::class, 'destroy'])->name('api.discount-codes.delete');
        Route::patch('/discount-codes/{discountCode}/activate', [DiscountCodeController::class, 'activate'])->name('activate');
        Route::patch('/discount-codes/{discountCode}/deactivate', [DiscountCodeController::class, 'deactivate'])->name('deactivate');
    });
});
