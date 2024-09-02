<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sueperAdmin = User::create([
            'name' => 'رحماني جمال',
            'email' => 'rd@tamra.com',
            'password' => Hash::make('123456789'),
        ]);

        $sueperAdmin->addRole(1);

        $sueperAdmin = User::create([
            'name' => 'ياسر السلامة',
            'email' => 'ys@example.com',
            'password' => Hash::make('123456789'),
        ]);

        

        $sueperAdmin->addRole(1);

        $sueperAdmin = User::create([
            'name' => 'عبد الكريم السلامة',
            'email' => 'as@example.com',
            'password' => Hash::make('123456789'),
        ]);

        $sueperAdmin->addRole(1);

        $vendor = User::create([
            'name' => 'محمد العربي',
            'email' => 'ma@example.com',
            'password' => Hash::make('123456789'),
        ]);

        $vendor->addRole(3);

        $client = User::create([
            'name' => 'عبد الرحمان العربي',
            'email' => 'aba@example.com',
            'password' => Hash::make('123456789'),
        ]);

        $client->addRole(4);

    }
}
