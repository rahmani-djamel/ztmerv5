<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Admin', 'display_name' => 'أدمين', 'description' => 'مدير النظام']);

        $role2 = Role::create(['name' => 'Manger', 'display_name' => 'إداري', 'description' => 'إداري']);

        $role3 = Role::create(['name' => 'User', 'display_name' => 'مشتري', 'description' => 'مشتري']);

        $role4 = Role::create(['name' => 'Vendor', 'display_name' => 'بائع', 'description' => 'بائع']);

        $permissions = [
            ['name' => 'dashboard', 'display_name' => 'الرئيسية', 'description' => 'الرئيسية'],
            ['name' => 'users', 'display_name' => 'المستخدمين', 'description' => 'المستخدمين'],
            ['name' => 'products', 'display_name' => 'المنتجات', 'description' => 'المنتجات'],
            ['name' => 'citis', 'display_name' => 'المدن', 'description' => 'المدن'],
            ['name' => 'categories', 'display_name' => 'الأصناف', 'description' => 'الأصناف'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $role1->givePermissions(['dashboard', 'users', 'products', 'citis', 'categories']);
    }
}
