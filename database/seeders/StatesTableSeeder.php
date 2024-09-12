<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['name' => 'الرياض'],
            ['name' => 'مكة المكرمة'],
            ['name' => 'المدينة المنورة'],
            ['name' => 'القصيم'],
            ['name' => 'المنطقة الشرقية'],
            ['name' => 'عسير'],
            ['name' => 'تبوك'],
            ['name' => 'حائل'],
            ['name' => 'الحدود الشمالية'],
            ['name' => 'جازان'],
            ['name' => 'نجران'],
            ['name' => 'الباحة'],
            ['name' => 'الجوف'],
        ];

        foreach ($states as &$state) {
            $state['slug'] = Str::slug($state['name']) . '-' . Str::random(5);
        }

        

        DB::table('states')->insert($states);
    }
}
