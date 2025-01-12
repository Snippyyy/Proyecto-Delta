<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(
            [
                'name' => 'snippy',
                'email' => $email ='snippy@mail.com',
                'password' => bcrypt('1234'),
                'province' => 'Madrid',
                'address' => 'Calle Ejemplo, 123',
                'postal_code' => '28001',
                'phone_number' => '123456789',
                'avatar' => 'https://api.dicebear.com/5.x/avataaars/svg?seed=' . md5($email),
                'role' => 'admin',
            ]
        )->create();

        User::factory(
            [
                'name' => 'snippy2',
                'email' => $email ='snippy2@mail.com',
                'password' => bcrypt('1234'),
                'province' => 'Madrid',
                'address' => 'Calle Ejemplo, 123',
                'postal_code' => '28001',
                'phone_number' => '123456789',
                'avatar' => 'https://api.dicebear.com/5.x/avataaars/svg?seed=' . md5($email),
            ]
        )->create();

        User::factory()->count(10)->create();
    }
}
