<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory(10)->create();
        Vehicle::factory(15)->create();
        Reservation::factory(20)->create();
        $this->call(RoleSeeder::class);
    }
}
