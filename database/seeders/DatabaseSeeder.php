<?php

namespace Database\Seeders;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        CartItem::factory([
            'updated_at' => now()->subMonths(3),
        ])->create();
        // User::factory(10)->create();
        Category::factory()->count(5)->create();
        User::factory()->count(10)->create();
    }
}
