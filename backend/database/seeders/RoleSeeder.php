<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::query()->firstOrCreate(['name' => 'admin']);
        $userRole = Role::query()->firstOrCreate(['name' => 'user']);
        $admin = User::query()->first();
        if ($admin) {
            $admin->assignRole($adminRole);
        }
    }
}
