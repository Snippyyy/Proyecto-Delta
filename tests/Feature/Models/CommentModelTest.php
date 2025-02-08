<?php

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('user realitionship', function () {
    $comment = Comment::factory()->create();
    $this->assertInstanceOf(User::class, $comment->user);
});

it('buyer realitionship', function () {
    $comment = Comment::factory()->create();
    $this->assertInstanceOf(User::class, $comment->buyer);
});
