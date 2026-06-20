<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'view dashboard',
            'manage branches',
            'manage products',
            'manage stocks',
            'manage stock movements',
            'manage transactions',
            'view invoices',
            'view transaction reports',
            'view stock reports',
            'manage users',
            'manage profile',
            'print reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $owner = Role::firstOrCreate([
            'name' => 'owner',
            'guard_name' => 'web',
        ]);

        $manager = Role::firstOrCreate([
            'name' => 'manager',
            'guard_name' => 'web',
        ]);

        $supervisor = Role::firstOrCreate([
            'name' => 'supervisor',
            'guard_name' => 'web',
        ]);

        $cashier = Role::firstOrCreate([
            'name' => 'cashier',
            'guard_name' => 'web',
        ]);

        $warehouse = Role::firstOrCreate([
            'name' => 'warehouse',
            'guard_name' => 'web',
        ]);

        $owner->syncPermissions($permissions);

        $manager->syncPermissions([
            'view dashboard',
            'manage products',
            'manage stocks',
            'manage stock movements',
            'view transaction reports',
            'view stock reports',
            'manage users',
            'manage profile',
            'print reports',
        ]);

        $supervisor->syncPermissions([
            'view dashboard',
            'manage stocks',
            'manage transactions',
            'view invoices',
            'view transaction reports',
            'view stock reports',
            'manage profile',
            'print reports',
        ]);

        $cashier->syncPermissions([
            'view dashboard',
            'manage transactions',
            'view invoices',
            'manage profile',
        ]);

        $warehouse->syncPermissions([
            'view dashboard',
            'manage products',
            'manage stocks',
            'manage stock movements',
            'view stock reports',
            'manage profile',
            'print reports',
        ]);
    }
}