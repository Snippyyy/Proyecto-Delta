<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('redirects guest user to index with error message', function () {

    $order = Order::factory()->create();


    get(route('my-orders.show', $order))
        ->assertRedirect(route('index'))
        ->assertSessionHas('error', 'No puedes ver este pedido');
});

it('redirects authenticated user who is not the buyer to index with error message', function () {
    $user = User::factory()->create();
    $order = Order::factory()->create();

    actingAs($user)
        ->get(route('my-orders.show', $order))
        ->assertRedirect(route('index'))
        ->assertSessionHas('error', 'No puedes ver este pedido');
});

it('allows authenticated user who is the buyer to access the order', function () {
    $user = User::factory()->create();
    $order = Order::factory()->create(['buyer_id' => $user->id]);

    actingAs($user)
        ->get(route('my-orders.show', $order))
        ->assertStatus(200);
});
