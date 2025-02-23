<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->state(['name' => 'Consolas'])->create();
        Category::factory()->state(['name' => 'Televisiones'])->create();
        Category::factory()->state(['name' => 'Peliculas'])->create();
        Category::factory()->state(['name' => 'Varios'])->create();
        Category::factory()->state(['name' => 'Juegos'])->create();
        Category::factory()->state(['name' => 'Accesorios'])->create();
    }
}
