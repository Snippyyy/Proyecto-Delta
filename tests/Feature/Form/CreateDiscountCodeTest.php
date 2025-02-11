<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

beforeEach(function () {
    roleSeeder();
});

it('Code field is required', function () {
    $user = User::factory()->create()->assignRole('admin');

    actingAs($user);

    $response = post(route('discount-code.store'), [
        'percentage' => 10,
        'valid_until' => now()->addDays(10),
    ]);

    $response->assertSessionHasErrors('code');
});

it('Discount field is required', function () {
    $user = User::factory()->create()->assignRole('admin');

    actingAs($user);

    $response = post(route('discount-code.store'), [
        'code' => 'DISCOUNT10',
        'valid_until' => now()->addDays(10),
    ]);

    $response->assertSessionHasErrors('percentage');
});

it('Valid until field is required', function () {
    $user = User::factory()->create()->assignRole('admin');

    actingAs($user);

    $response = post(route('discount-code.store'), [
        'code' => 'DISCOUNT10',
        'percentage' => 10,
    ]);

    $response->assertSessionHasErrors('valid_until');
});

it('Valid until must be after today date', function () {
    $user = User::factory()->create()->assignRole('admin');

    actingAs($user);

    $response = post(route('discount-code.store'), [
        'code' => 'DISCOUNT10',
        'percentage' => 10,
        'valid_until' => now()->subDays(10),
    ]);

    $response->assertSessionHasErrors('valid_until');
});
