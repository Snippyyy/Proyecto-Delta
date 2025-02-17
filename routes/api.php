<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\DiscountCodeController;
use App\Http\Controllers\Api\V1\LoginUserController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\WelcomePageController;
use App\Http\Middleware\Api\V1\AdminAccessMiddleware;
use App\Http\Middleware\Api\V1\EnsureUserIsProductOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', LoginUserController::class);

//Productos
Route::get('/products', WelcomePageController::class);
Route::get('/products/{product}', [ProductController::class, 'show']);

//Categorias
Route::get('/categories/{category}', [CategoryController::class, 'show']);

//Users
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user:name}', [UserController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products/create', [ProductController::class, 'store']);
    Route::patch('/products/{product}/update', [ProductController::class, 'update'])->middleware(EnsureUserIsProductOwner::class);
    Route::delete('/products/{product}/delete', [ProductController::class, 'destroy'])->middleware(EnsureUserIsProductOwner::class);
    Route::patch('/products/{product}/post', [ProductController::class, 'post'])->middleware(EnsureUserIsProductOwner::class);

    //Admin

    Route::middleware(AdminAccessMiddleware::class)->group(function () {
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::post('/categories/create', [CategoryController::class, 'store']);
        Route::delete('/categories/{category}/delete', [CategoryController::class, 'destroy']);
        Route::patch('/categories/{category}/update', [CategoryController::class, 'update']);

        Route::get('/discount-codes', [DiscountCodeController::class, 'index']);
        Route::post('/discount-codes/create', [DiscountCodeController::class, 'store']);
        Route::delete('/discount-codes/{discountCode}/delete', [DiscountCodeController::class, 'destroy']);
        Route::patch('/discount-codes/{discountCode}/activate', [DiscountCodeController::class, 'activate']);
        Route::patch('/discount-codes/{discountCode}/deactivate', [DiscountCodeController::class, 'deactivate']);
    });
});
