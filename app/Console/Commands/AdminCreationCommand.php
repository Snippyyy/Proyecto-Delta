<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;

class AdminCreationCommand extends Command
{
    protected $signature = 'admin:creation';

    protected $description = 'Este comando esta creado para el testeo de la aplicación si es necesario durante la entrevista del proyecto';

    public function handle(): void
    {
        Artisan::call('db:seed', ['--class' => 'RoleSetterSeeder']);

        $name = $this->ask('Por favor, ingrese el nombre del administrador');
        $email = $this->ask('Por favor, ingrese el email del administrador');
        $password = $this->secret('Por favor, ingrese la contraseña del administrador');

        if (User::where('email', $email)->exists()) {
            $this->error('El email ya está en uso');
            return;
        }

        $user = User::factory([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ])->create();

        $user->assignRole('admin');

        $this->info('Usuario administrador creado exitosamente');
    }
}
