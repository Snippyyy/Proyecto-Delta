<?php

use App\Http\Controllers\CategoryShowController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FavoriteItemsController;
use App\Http\Controllers\ItemsCartController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerCartController;
use App\Http\Controllers\StripeCheckoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomePageController;
use Illuminate\Support\Facades\Route;

// Middleware
use App\Http\Middleware\EnsureGuestHasCartTokenMiddleware;
use App\Http\Middleware\PendingProductMiddleware;
use App\Http\Middleware\CheckSoldItemsInCartMiddleware;
use App\Http\Middleware\CommentsMiddleware;
use App\Http\Middleware\CantPurchaseSoldItemsMiddleware;
use App\Http\Middleware\EnsureDiscountCodeIsActiveMiddleware;
use App\Http\Middleware\EnsureUserIsProductOwnerMiddleware;

Route::get('/', WelcomePageController::class)->name('index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(CommentsMiddleware::class)->group(function () {
    Route::post('users/{user:name}/comment', [CommentsController::class, 'store'])->name('comments.store');
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('{user:name}', [UserController::class, 'show'])->name('users.show');
});

Route::post('/switch-language', LanguageController::class)->name('switch.language');

Route::prefix('products')->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/', [ProductController::class, 'store'])->name('product.store');
        Route::patch('{product:slug}/post', [ProductController::class, 'post'])->name('product.post')->middleware(EnsureUserIsProductOwnerMiddleware::class);
        Route::get('{product:slug}/edit', [ProductController::class, 'edit'])->name('product.edit')->middleware(EnsureUserIsProductOwnerMiddleware::class);
        Route::patch('{product:slug}', [ProductController::class, 'update'])->name('product.update')->middleware(EnsureUserIsProductOwnerMiddleware::class);
        Route::delete('{product:slug}', [ProductController::class, 'destroy'])->name('product.delete')->middleware(EnsureUserIsProductOwnerMiddleware::class);
    });
    Route::get('{product:slug}', [ProductController::class, 'show'])->name('product.show')->middleware(PendingProductMiddleware::class . ':product');
});

Route::get('favorites', FavoriteItemsController::class)->name('favorites')->middleware(['auth', 'verified']);

Route::middleware(EnsureGuestHasCartTokenMiddleware::class)->group(function () {
    Route::get('/cart', [SellerCartController::class, 'index'])->name('cart.index');
    Route::post('/products/{product}', [ItemsCartController::class, 'store'])->name('cart.store')->middleware(CantPurchaseSoldItemsMiddleware::class);
    Route::get('/cart/{cart}', [ItemsCartController::class, 'show'])->name('cart.show')->middleware(EnsureDiscountCodeIsActiveMiddleware::class);
    Route::patch('/cart/{cart}/discountapply', [SellerCartController::class, 'discount_apply'])->name('cart.discountapply')->middleware(['auth', 'verified']);
    Route::patch('cart/{cart}/remove-discount', [SellerCartController::class, 'remove_discount'])->name('cart.remove-discount')->middleware(['auth', 'verified']);
    Route::delete('/cart/{cart}/{product}', [ItemsCartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/{cart}/checkout', [StripeCheckoutController::class, 'session'])->name('cart.checkout')->middleware(['auth', 'verified', CheckSoldItemsInCartMiddleware::class, EnsureDiscountCodeIsActiveMiddleware::class]);
    Route::get('/cart/{cart}/success', [StripeCheckoutController::class, 'success'])->name('cart.checkout.success')->middleware(['auth', 'verified']);
    Route::get('/cart/{cart}/cancel', [StripeCheckoutController::class, 'cancel'])->name('cart.checkout.cancel')->middleware(['auth', 'verified']);
    Route::post('/webhook', [StripeCheckoutController::class, 'webhook'])->name('webhook');
});

Route::prefix('categories')->group(function () {
    Route::get('{category}', CategoryShowController::class)->name('category.show');
});




require __DIR__.'/auth.php';
