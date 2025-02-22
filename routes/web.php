<?php

use App\Http\Controllers\DiscountCodeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FavoriteItemsController;
use App\Http\Controllers\ItemsCartController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerCartController;
use App\Http\Controllers\StripeCheckoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProductsController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\UserSoldController;
use App\Http\Controllers\WelcomePageController;
use Illuminate\Support\Facades\Route;

//Middleware
use App\Http\Middleware\AdminAccessMiddleware;
use App\Http\Middleware\EnsureGuestHasCartTokenMiddleware;
use App\Http\Middleware\PendingProductMiddleware;
use App\Http\Middleware\CheckSoldItemsInCartMiddleware;
use App\Http\Middleware\AuthUserOrderMiddleware;
use App\Http\Middleware\AuthUserSoldMiddleware;
use App\Http\Middleware\CommentsMiddleware;
use App\Http\Middleware\CantPurchaseSoldItemsMiddleware;
use App\Http\Middleware\EnsureDiscountCodeIsActiveMiddleware;
use App\Http\Middleware\EnsureUserIsProductOwnerMiddleware;

Route::get('/', WelcomePageController::class)->name('index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//Ruta de codigos de descuento
Route::get('discount-code', [DiscountCodeController::class, 'index'])->name('discount-code')->middleware(AdminAccessMiddleware::class);
Route::get('discount-code/create', [DiscountCodeController::class, 'create'])->name('discount-code.create')->middleware(AdminAccessMiddleware::class);
Route::post('discount-code', [DiscountCodeController::class, 'store'])->name('discount-code.store')->middleware(AdminAccessMiddleware::class);

//Ruta de comentarios
Route::post('users/{user:name}/comment', [CommentsController::class, 'store'])->name('comments.store')->middleware(CommentsMiddleware::class);

//users
Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::get('users/{user:name}', [UserController::class, 'show'])->name('users.show');


//AreaPersonal
Route::get('my-products', UserProductsController::class)->name('my-products')->middleware(['auth', 'verified']);
Route::get('orders', [UserOrderController::class, 'index'])->name('my-orders')->middleware(['auth', 'verified']);
Route::get('orders/{order}', [UserOrderController::class, 'show'])->name('my-orders.show')->middleware(AuthUserOrderMiddleware::class);
Route::get('orders/{order}/download', PdfController::class)->name('my-orders.download')->middleware(AuthUserOrderMiddleware::class);
Route::get('my-sold', [UserSoldController::class, 'index'])->name('my-sold')->middleware(['auth', 'verified']);
Route::get('my-sold/{order}', [UserSoldController::class, 'show'])->name('my-sold.show')->middleware((AuthUserSoldMiddleware::class));
Route::post('my-sold/{order}/shipment', [UserSoldController::class, 'shipment'])->name('shipment')->middleware((AuthUserSoldMiddleware::class));


//Ruta Productos
Route::get('/products/create',[ProductController::class,'create'])->name('product.create')->middleware(['auth', 'verified']);
Route::post('/products',[ProductController::class,'store'])->name('product.store')->middleware(['auth', 'verified']);
Route::get('/products/{product}',[ProductController::class,'show'])->name('product.show')->middleware(PendingProductMiddleware::class . ':product');
Route::patch('/products/{product}/post',[ProductController::class,'post'])->name('product.post')->middleware([EnsureUserIsProductOwnerMiddleware::class, 'auth', 'verified']);
Route::get('/products/{product}/edit',[ProductController::class,'edit'])->name('product.edit')->middleware(['auth', 'verified', EnsureUserIsProductOwnerMiddleware::class]);
Route::patch('/products/{product}',[ProductController::class,'update'])->name('product.update')->middleware(['auth', 'verified', EnsureUserIsProductOwnerMiddleware::class]);
Route::delete('/products/{product}',[ProductController::class,'destroy'])->name('product.delete')->middleware(['auth', 'verified', EnsureUserIsProductOwnerMiddleware::class]);

//Ruta de favoritos
Route::get('favorites', FavoriteItemsController::class)->name('favorites')->middleware(['auth', 'verified']);

//Rutas Carrito
Route::middleware(EnsureGuestHasCartTokenMiddleware::class)->group(function () {
    Route::get('/cart', [SellerCartController::class, 'index'])->name('cart.index');
    Route::post('/products/{product}', [ItemsCartController::class, 'store'])->name('cart.store')->middleware(CantPurchaseSoldItemsMiddleware::class);
    Route::get('/cart/{cart}', [ItemsCartController::class, 'show'])->name('cart.show')->middleware(EnsureDiscountCodeIsActiveMiddleware::class);
    Route::patch('/cart/{cart}/discountapply', [SellerCartController::class, 'discount_apply'])->name('cart.discountapply')->middleware(['auth', 'verified']);
    Route::patch('cart/{cart}/remove-discount', [SellerCartController::class, 'remove_discount'])->name('cart.remove-discount')->middleware(['auth', 'verified']);
    Route::delete('/cart/{cart}/{product}', [ItemsCartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/{cart}/checkout', [StripeCheckoutController::class, 'session'])->name('cart.checkout')->middleware(['auth', 'verified'])->middleware(CheckSoldItemsInCartMiddleware::class)->middleware(EnsureDiscountCodeIsActiveMiddleware::class);
    Route::get('/cart/{cart}/success', [StripeCheckoutController::class, 'success'])->name('cart.checkout.success')->middleware(['auth', 'verified']);
    Route::get('/cart/{cart}/cancel', [StripeCheckoutController::class, 'cancel'])->name('cart.checkout.cancel')->middleware(['auth', 'verified']);
    Route::post('/webhook', [StripeCheckoutController::class, 'webhook'])->name('webhook');
});


//Rutas Categorias
Route::get('/categories', [CategoryController::class, 'index'])->name('categories')->middleware(AdminAccessMiddleware::class);
Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create')->middleware(AdminAccessMiddleware::class);
Route::post('/categories', [CategoryController::class, 'store'])->name('category.store')->middleware(AdminAccessMiddleware::class);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('category.destroy')->middleware(AdminAccessMiddleware::class);
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('category.show');
Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('category.update')->middleware(AdminAccessMiddleware::class);
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit')->middleware(AdminAccessMiddleware::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
