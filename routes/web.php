<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomePageController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/', WelcomePageController::class)->name('index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



//Ruta Productos
Route::get('/products',[ProductController::class,'index'])->name('product.index');
Route::get('/products/create',[ProductController::class,'create'])->name('product.create')->middleware(['auth', 'verified']);
Route::post('/products',[ProductController::class,'store'])->name('product.store')->middleware(['auth', 'verified']);
Route::get('/products/{product}',[ProductController::class,'show'])->name('product.show');
Route::get('/products/{product}/edit',[ProductController::class,'edit'])->name('product.edit')->middleware(['auth', 'verified']);
Route::patch('/products/{product}',[ProductController::class,'update'])->name('product.update')->middleware(['auth', 'verified']);
Route::delete('/products/{product}',[ProductController::class,'destroy'])->name('product.delete')->middleware(['auth', 'verified']);

//Rutas Categorias
Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
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
