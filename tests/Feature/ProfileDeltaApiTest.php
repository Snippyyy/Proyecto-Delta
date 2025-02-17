<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
uses(RefreshDatabase::class);

it('allows to view a profile', function () {
    $user = User::factory()->create();

    actingAs($user);

    $response = get(route('api.users.show', $user->name));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'province',
                'address',
                'postal_code',
                'phone_number',
                'products',
                'comments'
            ]
        ]);
});

it('allows anyone to list users', function () {
    User::factory()->count(3)->create();

    $response = get(route('api.users.index'));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'name',
                    'email',
                    'province',
                    'address',
                    'postal_code',
                ]
            ]
        ]);
});
