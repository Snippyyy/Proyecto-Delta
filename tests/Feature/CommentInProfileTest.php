<?php

use App\Models\Comment;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('User can post a comment in a profile', function () {
    $user = User::factory()->has(Product::factory()->count(3))->create();
    $user2 = User::factory()->create();
    Order::factory()->count(3)->create([
        'seller_id' => $user->id,
        'buyer_id' => $user2->id,
    ]);

    $this->assertDatabaseHas('orders', [
        'seller_id' => $user->id,
        'buyer_id' => $user2->id,
    ]);

    actingAs($user2);

    $response = post(route('comments.store', $user->id), [
        'comment' => 'This is a comment',
    ]);

    $response
        ->assertRedirect(route('users.show', ['user' => $user->name]))
        ->assertSessionHas('status', 'Comentario realizado correctamente');

    $this->assertDatabaseHas('comments', [
        'buyer_id' => $user2->id,
        'comment' => 'This is a comment',
    ]);
});

it('Posted comment is displayed in page', function () {

    $user = User::factory()->create();
    $user2 = User::factory()->create();

    $comments = Comment::factory()->createMany([
        [
            'user_id' => $user->id,
            'buyer_id' => $user2->id,
            'comment' => 'First comment',
        ],
        [
            'user_id' => $user->id,
            'buyer_id' => $user2->id,
            'comment' => 'Second comment',
        ],
        [
            'user_id' => $user->id,
            'buyer_id' => $user2->id,
            'comment' => 'Third comment',
        ],
    ]);

    $response = get(route('users.show', $user->name));

    foreach ($comments as $comment) {
        $response->assertSee($comment->comment);
    }
});

it('Form for making a comment is in user page', function () {
    $user = User::factory()->create();

    $response = get(route('users.show', $user->name));

    $response->assertStatus(200);
    $response->assertSee('form');
    $response->assertSee('textarea');
    $response->assertSee('Publicar Comentario');
});
