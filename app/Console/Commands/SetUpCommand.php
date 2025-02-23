<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetUpCommand extends Command
{
    protected $signature = 'set:up';

    protected $description = 'Este comando ejecuta las migraciones con los seeders y crea un admin personalizado';

    public function handle(): void
    {
        Artisan::call('migrate:fresh', ['--seed' => true]);

        $this->info('Creacion de admin personalizado...');
        $this->call('admin:creation');
    }
}
