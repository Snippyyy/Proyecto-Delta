<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserWithProductsSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->has(
                Product::factory([
                    'status' => 'published',
                ])
                    ->count(10)
            )->create();
    }
}
