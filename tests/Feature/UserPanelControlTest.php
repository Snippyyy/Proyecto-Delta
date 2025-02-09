<?php

use App\Models\SellerCart;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Stripe\Stripe;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('User can see his orders in my orders view', function () {

    $user = User::factory()->create();
    $user2 = User::factory()->has(Product::factory()->count(2))->create();
    $totalPrice = $user2->products->sum('price');

    $order = Order::factory()->create([
        'buyer_id' => $user->id,
        'seller_id' => $user2->id,
        'status' => 'paid',
        'total_price' => $totalPrice,
    ]);

    actingAs($user);
    get(route('my-orders'))
        ->assertOk()
        ->assertSee($order->id)
        ->assertSee($order->status)
        ->assertSee(number_format($order->total_price / 100, 2, ',', '.'))
        ->assertSee($order->created_at->format('d/m/Y'));
});

it('User can see his order in my orders show view with data products and links', function () {

    $user = User::factory()->create();
    $user2 = User::factory()->has(Product::factory()->count(2))->create();
    $totalPrice = $user2->products->sum('price');

    $order = Order::factory()->create([
        'buyer_id' => $user->id,
        'seller_id' => $user2->id,
        'status' => 'paid',
        'total_price' => $totalPrice,
    ]);

    $orderItems = $order->orderItems()->createMany([
        [
            'order_id' => $order->id,
            'product_id' => $user2->products->first()->id,
        ],
        [
            'order_id' => $order->id,
            'product_id' => $user2->products->last()->id,
        ],
    ]);

    actingAs($user);
    $response = get(route('my-orders.show', $order));

    $response->assertOk()
        ->assertSee($order->seller_user->name)
        ->assertSee(number_format($order->total_price / 100, 2, ',', '.'))
        ->assertSee(__($order->status))
        ->assertSee($order->created_at->format('d/m/Y'))
        ->assertSee($order->buyer_user->name);

    foreach ($orderItems as $item) {
        $response->assertSee($item->product->name)
            ->assertSee(number_format($item->product->price / 100, 2, ',', '.'))
            ->assertSeeHtml('<a href="' . route('product.show', $item->product->id));
    }

    if ($order->shipment_number) {
        $response->assertSee($order->shipment_number);
    } else {
        $response->assertSee('Numero de seguimiento no disponible');
    }

    $response->assertSee(route('my-orders'));
});

it('User can see his solds in my sold view with data and links', function () {


    $user = User::factory()->create();
    $user2 = User::factory()->has(Product::factory()->count(2))->create();
    $totalPrice = $user2->products->sum('price');

    $order = Order::factory()->create([
        'buyer_id' => $user->id,
        'seller_id' => $user2->id,
        'status' => 'paid',
        'total_price' => $totalPrice,
    ]);

    actingAs($user2);
    get(route('my-sold'))
        ->assertOk()
        ->assertSee($order->id)
        ->assertSee($order->status)
        ->assertSee(number_format($order->total_price / 100, 2, ',', '.'))
        ->assertSee($order->created_at->format('d/m/Y'));

});

it('User can see his order in my sold show view with data products and links', function () {

    $user = User::factory()->create();
    $user2 = User::factory()->has(Product::factory()->count(2))->create();
    $totalPrice = $user2->products->sum('price');

    $order = Order::factory()->create([
        'buyer_id' => $user->id,
        'seller_id' => $user2->id,
        'status' => 'paid',
        'total_price' => $totalPrice,
    ]);

    $orderItems = $order->orderItems()->createMany([
        [
            'order_id' => $order->id,
            'product_id' => $user2->products->first()->id,
        ],
        [
            'order_id' => $order->id,
            'product_id' => $user2->products->last()->id,
        ],
    ]);

    actingAs($user2);
    $response = get(route('my-sold.show', $order));

    $response->assertOk()
        ->assertSee($order->seller_user->name)
        ->assertSee(number_format($order->total_price / 100, 2, ',', '.'))
        ->assertSee(__($order->status))
        ->assertSee($order->created_at->format('d/m/Y'))
        ->assertSee($order->buyer_user->name);

    foreach ($orderItems as $item) {
        $response->assertSee($item->product->name)
            ->assertSee($item->product->price)
            ->assertSeeHtml('<a href="' . route('product.show', $item->product->id));
    }

    if ($order->shipment_number) {
        $response->assertSee($order->shipment_number);
    } else {
        $response->assertSee('Numero de seguimiento no disponible');
    }

    $response->assertSee(route('my-sold'));
});


it('User can add a shipment number to a sold', function () {

    $user = User::factory()->create();
    $user2 = User::factory()->has(Product::factory()->count(2))->create();
    $totalPrice = $user2->products->sum('price');

    $order = Order::factory()->create([
        'buyer_id' => $user->id,
        'seller_id' => $user2->id,
        'status' => 'paid',
        'total_price' => $totalPrice,
        'shipment_number' => null,
    ]);

    $order->orderItems()->createMany([
        [
            'order_id' => $order->id,
            'product_id' => $user2->products->first()->id,
        ],
        [
            'order_id' => $order->id,
            'product_id' => $user2->products->last()->id,
        ],
    ]);


    actingAs($user2);

    get(route('my-sold.show', $order))
        ->assertOk()
        ->assertDontSee('123456')
        ->assertSeeHtml('<button type="submit" class="ml-5 border border-black p-2 hover:bg-black hover:text-white focus:scale-50 active:scale-110">Establecer</button>');

    $response = post(route('shipment', $order), [
        'shipment_number' => '123456789',
    ]);

    $response->assertRedirect(route('my-sold.show', $order));

    $order->refresh();
    expect($order->shipment_number)->toBe('123456789');
    get(route('my-sold.show', $order))
        ->assertOk()
        ->assertSee('123456')
        ->assertDontSeeHtml('<button type="submit" class="ml-5 border border-black p-2 hover:bg-black hover:text-white focus:scale-50 active:scale-110">Establecer</button>')
        ->assertSeeHtml('<button type="submit" class="ml-5 border border-black p-2 hover:bg-black hover:text-white focus:scale-50 active:scale-110">Editar</button>');
});


