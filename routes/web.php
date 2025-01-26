<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemsCartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerCartController;
use App\Http\Controllers\UserProductsController;
use App\Http\Controllers\WelcomePageController;
use Illuminate\Support\Facades\Route;

//Middleware
use App\Http\Middleware\EnsureGuestHasCartTokenMiddleware;
use App\Http\Middleware\PendingProductMiddleware;


Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/', WelcomePageController::class)->name('index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//AreaPersonal
Route::get('my-products', UserProductsController::class)->name('my-products')->middleware(['auth', 'verified']);

//Ruta Productos
Route::get('/products/create',[ProductController::class,'create'])->name('product.create')->middleware(['auth', 'verified']);
Route::post('/products',[ProductController::class,'store'])->name('product.store')->middleware(['auth', 'verified']);
Route::get('/products/{product}',[ProductController::class,'show'])->name('product.show')->middleware(PendingProductMiddleware::class . ':product');
Route::patch('/products/{product}/post',[ProductController::class,'post'])->name('product.post');
Route::get('/products/{product}/edit',[ProductController::class,'edit'])->name('product.edit')->middleware(['auth', 'verified']);
Route::patch('/products/{product}',[ProductController::class,'update'])->name('product.update')->middleware(['auth', 'verified']);
Route::delete('/products/{product}',[ProductController::class,'destroy'])->name('product.delete')->middleware(['auth', 'verified']);

//Rutas Carrito
Route::middleware(EnsureGuestHasCartTokenMiddleware::class)->group(function () {
    Route::get('/cart', [SellerCartController::class, 'index'])->name('cart.index');
    Route::post('/products/{product}', [ItemsCartController::class, 'store'])->name('cart.store');
    Route::get('/cart/{cart}', [ItemsCartController::class, 'show'])->name('cart.show');
    Route::delete('/cart/{cart}/{product}', [ItemsCartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/{cart}/checkout', [SellerCartController::class, 'checkout'])->name('cart.checkout')->middleware(['auth', 'verified']);
});


//Rutas Categorias
Route::get('/categories', [CategoryController::class, 'index'])->name('categories')->middleware(['auth', 'verified']);
Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create')->middleware(['auth', 'verified']);
Route::post('/categories', [CategoryController::class, 'store'])->name('category.store')->middleware(['auth', 'verified']);;
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('category.destroy')->middleware(['auth', 'verified']);;
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('category.show');
Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('category.update')->middleware(['auth', 'verified']);;
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit')->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
