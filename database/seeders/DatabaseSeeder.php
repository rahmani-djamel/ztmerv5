<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Unit;
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
        $this->call([
            RolesAndPermissionsSeeder::class,
            UsersTableSeeder::class,
            StatesTableSeeder::class,
            CitiesTableSeeder::class,
            UnitSeeder::class,
            PackageSeeder::class,
        ]);
    }
}
