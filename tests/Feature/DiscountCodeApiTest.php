<?php

use App\Models\DiscountCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\artisan;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\patch;
use function Pest\Laravel\delete;

uses(RefreshDatabase::class);

beforeEach(function () {
    artisan('db:seed --class=RoleSetterSeeder');
    $user = User::factory()->create();
    $user->assignRole('admin');
    $this->actingAs($user);
});

it('lists all discount codes', function () {
    DiscountCode::factory()->count(3)->create();

    $response = get(route('api.discount-codes.index'));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'code',
                    'discount',
                    'status',
                    'valid_until'
                ]
            ]
        ]);
});

it('creates a discount code', function () {
    $response = post(route('api.discount-codes.store'), [
        'code' => 'TESTCODE',
        'percentage' => 10,
        'valid_until' => '9999-12-31',
        'is_active' => '1'
    ]);

    $response->assertStatus(200)
        ->assertJson(['message' => 'Código de descuento creado']);

    $this->assertDatabaseHas('discount_codes', [
        'code' => 'TESTCODE',
        'percentage' => 10,
        'is_active' => true
    ]);
});

it('shows a discount code', function () {
    $discountCode = DiscountCode::factory()->create();

    $response = get(route('api.discount-codes.show', $discountCode));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'discount',
                'status',
                'valid_until'
            ]
        ]);
});

it('deletes a discount code', function () {
    $discountCode = DiscountCode::factory()->create();

    $response = delete(route('api.discount-codes.delete', $discountCode));

    $response->assertStatus(200)
        ->assertJson(['message' => 'Código de descuento eliminado']);

    $this->assertDatabaseMissing('discount_codes', ['id' => $discountCode->id]);
});

it('activates a discount code', function () {
    $discountCode = DiscountCode::factory()->create(['is_active' => false]);

    $response = patch(route('activate', $discountCode));

    $response->assertStatus(200)
        ->assertJson(['message' => 'Código de descuento activado']);

    $this->assertDatabaseHas('discount_codes', [
        'id' => $discountCode->id,
        'is_active' => true
    ]);
});

it('deactivates a discount code', function () {
    $discountCode = DiscountCode::factory()->create(['is_active' => true]);

    $response = patch(route('deactivate', $discountCode));

    $response->assertStatus(200)
        ->assertJson(['message' => 'Código de descuento desactivado']);

    $this->assertDatabaseHas('discount_codes', [
        'id' => $discountCode->id,
        'is_active' => false
    ]);
});
