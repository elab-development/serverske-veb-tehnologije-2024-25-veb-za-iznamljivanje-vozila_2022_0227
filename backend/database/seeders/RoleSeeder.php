<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        Permission::create(['name' => 'manage vehicles']);
        Permission::create(['name' => 'export reservations']);
        Permission::create(['name' => 'create reservation']);
        Permission::create(['name' => 'view own reservations']);

        $adminRole->givePermissionTo([
            'manage vehicles',
            'export reservations',
            'create reservation',
            'view own reservations'
        ]);

        $userRole->givePermissionTo([
            'create reservation',
            'view own reservations'
        ]);
    }
}
