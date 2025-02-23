<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserWithProductsSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(10)->has(Comment::factory()->count(8))->has(Product::factory([
            'status' => 'published',
        ])->count(5))->create();
    }
}
