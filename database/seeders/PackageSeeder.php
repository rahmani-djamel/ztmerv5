<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            ['name' => 'كرتون'],
            ['name' => 'علبه'],
            ['name' => 'كيس'],
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}
