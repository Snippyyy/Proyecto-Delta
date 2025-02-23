<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'comment' => $this->faker->sentence,
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'buyer_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
