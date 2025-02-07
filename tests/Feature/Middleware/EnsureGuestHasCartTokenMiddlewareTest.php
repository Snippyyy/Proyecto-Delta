<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cookie;
use function Pest\Laravel\get;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('assigns a guest cart token if not authenticated and no token exists', function () {
    // Ensure no user is authenticated
    auth()->logout();

    // Ensure no guest cart token exists
    Cookie::queue(Cookie::forget('guest_cart_token'));

    get(route('cart.index'))
        ->assertCookie('guest_cart_token');
});

it('does not assign a guest cart token if authenticated', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('cart.index'))
        ->assertCookieMissing('guest_cart_token');
});

it('does not assign a new guest cart token if one already exists', function () {
    auth()->logout();

    get(route('cart.index'))
        ->assertCookie('guest_cart_token');

    $existingToken = Cookie::get('guest_cart_token');

    get(route('cart.index'))
        ->assertCookie('guest_cart_token', $existingToken);
});
