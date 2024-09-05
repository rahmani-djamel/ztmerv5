<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['name' => 'كيلوغرام', 'symbole' => 'كجم', 'value' => 1.0],
            ['name' => 'جرام', 'symbole' => 'جم', 'value' => 0.001],
            ['name' => 'طن', 'symbole' => 'طن', 'value' => 1000.0],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
