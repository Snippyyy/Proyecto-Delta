<?php

use App\Livewire\DiscountCodes;
use App\Models\DiscountCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('Discount codes are displayed in general page', function (){

    $user = User::factory([
        'role' => 'admin'
    ])->create();

    actingAs($user);

    $discountCodes = DiscountCode::factory()->count(3)->create();
    $response = get(route('discount-code'));

    foreach ($discountCodes as $discountCode) {
        $response->assertSee($discountCode->code);
        $response->assertSee($discountCode->discount);
        $response->assertSee($discountCode->created_at->format('Y-m-d'));
        $response->assertSee($discountCode->valid_until->format('Y-m-d'));
    }
});

it('Discount code can be disabled', function () {

    $user = User::factory([
        'role' => 'admin'
    ])->create();


    actingAs($user);

    $discountCodes = DiscountCode::factory()->count(3)->create();
    \Livewire\Livewire::test(DiscountCodes::class)
        ->assertSee('Desactivar')
        ->call('toggleStatus', $discountCodes->first()->id)
        ->assertSee('Activar');
});

it('Discount code can be enabled', function () {

    $user = User::factory([
        'role' => 'admin'
    ])->create();


    actingAs($user);

    $discountCodes = DiscountCode::factory([
        'is_active' => false
    ])->count(3)->create();
    \Livewire\Livewire::test(DiscountCodes::class)
        ->assertSee('Activar')
        ->call('toggleStatus', $discountCodes->first()->id)
        ->assertSee('Desactivar');
});

it('Discount code can be deleted', function () {

    $user = User::factory([
        'role' => 'admin'
    ])->create();

    actingAs($user);

    $discountCode = DiscountCode::factory()->create();

    \Livewire\Livewire::test(DiscountCodes::class)
        ->call('deleteCode', $discountCode->id)
        ->assertDontSee($discountCode->code);
});

it('Discount code is displayed in Livewire Component', function () {
    $user = User::factory([
        'role' => 'admin'
    ])->create();


    actingAs($user);

    $discountCodes = DiscountCode::factory()->count(3)->create();
    $livewire = \Livewire\Livewire::test(DiscountCodes::class);

    foreach ($discountCodes as $discountCode) {
        $livewire->assertSee($discountCode->code);
        $livewire->assertSee($discountCode->discount);
        $livewire->assertSee($discountCode->created_at->format('Y-m-d'));
        $livewire->assertSee($discountCode->valid_until->format('Y-m-d'));
    }
});

it('Admin can create a discount code', function () {

    $user = User::factory([
        'role' => 'admin'
    ])->create();


    actingAs($user);

    post(route('discount-code.store'), [
        'code' => 'DISCOUNTCODE',
        'percentage' => 10,
        'valid_until' => now()->addDays(10)->format('Y-m-d')
    ])->assertRedirect(route('discount-code'));
});

it('A discount code will be disabled after valid_until date', function () {
    // Set the current date to a specific point in time
    $now = Carbon::now();
    Carbon::setTestNow($now);

    // Create a discount code that expires today
    $discountCode = DiscountCode::factory()->create([
        'valid_until' => $now,
        'is_active' => true,
    ]);

    expect($discountCode->is_active)->toBe(true);

    // Move the current date to the next day
    Carbon::setTestNow($now->addDay());

    // Esto funcionaria con un schedule de laravel
    $this->artisan('discounts:deactivate-expired');

    // Refresh the model and check if it is deactivated
    $discountCode->refresh();
    expect($discountCode->is_active)->toBe(0);

    // Reset the date and time
    Carbon::setTestNow(null);
});

