<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Ruta Principal
Route::get('index', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('index');

//Ruta Productos
Route::get('/product',[ProductController::class,'index'])->name('product.index');

//Rutas Categorias
Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('category.show');
Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('category.update');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
