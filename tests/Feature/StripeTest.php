<?php

use App\Models\SellerCart;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Stripe\Stripe;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('User can create a Stripe checkout session', function () {

$buyer = User::factory()->create();
$seller = User::factory()->has(Product::factory()->count(1))->create();
$product = $seller->products->first();

actingAs($buyer);

post(route('cart.store', $product))
->assertRedirect(route('product.show', $product))
->assertSessionHas('status', 'Producto añadido al carrito');


$cart = $buyer->sellerCarts->first();


// Enviar solicitud de checkout
$response = post(route('cart.checkout', $cart));

// Verificar que redirige a Stripe Checkout
$response->assertRedirectContains('https://checkout.stripe.com/');
});

it('User can successfully complete a checkout session', function () {

$buyer = User::factory()->create();
$seller = User::factory()->has(Product::factory()->count(1))->create();
$product = $seller->products->first();

// Actuar como comprador
actingAs($buyer);

post(route('cart.store', $product))->assertRedirect(route('product.show', $product));

// Obtener el carrito recién creado
$cart = SellerCart::where('user_id', $buyer->id)->first();
expect($cart)->not->toBeNull();

// Definir un session_id simulado
$sessionId = 'fake_session_id';

// Crear una orden con session_id asociado
$order = Order::factory()->create([
'status' => 'unpaid',
'total_price' => $cart->total_price,
'buyer_id' => $buyer->id,
'seller_id' => $seller->id,
'session_id' => $sessionId,
]);

// Depuración antes de llamar a success()
$storedOrder = Order::where('session_id', $sessionId)->first();
expect($storedOrder)->not->toBeNull()->and($storedOrder->status)->toBe('unpaid');

// Acceder a la URL de success con el session_id simulado
$response = get(route('cart.checkout.success', $cart) . '?session_id=' . $sessionId);

// Refrescar la orden para verificar cambios
$storedOrder->refresh();


// Verificar que la orden se marcó como pagada
expect($storedOrder->status)->toBe('paid');

// Verificar que la vista de éxito se carga correctamente
$response->assertStatus(200);
});


it('User can cancel a checkout session', function () {

$buyer = User::factory()->create();
$seller = User::factory()->has(Product::factory()->count(1))->create();
$product = $seller->products->first();

actingAs($buyer);

post(route('cart.store', $product))->assertRedirect(route('product.show', $product));

// Obtener el carrito recién creado
$cart = SellerCart::where('user_id', $buyer->id)->first();
expect($cart)->not->toBeNull();

// Definir un session_id simulado
$sessionId = 'fake_session_id';

// Crear una orden pendiente asociada a este session_id
$order = Order::factory()->create([
'status' => 'unpaid',
'total_price' => $cart->total_price,
'buyer_id' => $buyer->id,
'seller_id' => $seller->id,
'session_id' => $sessionId,
]);

// Verificar que la orden existe antes de cancelarla
expect(Order::where('session_id', $sessionId)->exists())->toBeTrue();

// Acceder a la URL de cancelación
$response = get(route('cart.checkout.cancel', $cart) . '?session_id=' . $sessionId);

// Verificar que la orden fue eliminada
$this->assertDatabaseMissing('orders', ['session_id' => $sessionId]);

// Verificar que la vista de cancelación se carga correctamente
$response->assertStatus(200);
});
