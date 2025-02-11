<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSetterSeeder extends Seeder
{
    public function run()
    {
        // Limpiar caché de permisos y roles
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //  Permisos
        Permission::create(['name' => 'discount codes administration']);
        Permission::create(['name' => 'categories administration']);

        // Crear roles y asignar permisos
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo('discount codes administration');
        $adminRole->givePermissionTo('categories administration');
    }
}
