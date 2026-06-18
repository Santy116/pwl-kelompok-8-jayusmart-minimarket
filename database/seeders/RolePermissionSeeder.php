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
            'manage transactions',
            'view transaction reports',
            'view stock reports',
            'manage users',
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
            'view transaction reports',
            'view stock reports',
            'manage users',
            'print reports',
        ]);

        $supervisor->syncPermissions([
            'view dashboard',
            'manage transactions',
            'manage stocks',
            'view transaction reports',
            'view stock reports',
            'print reports',
        ]);

        $cashier->syncPermissions([
            'view dashboard',
            'manage transactions',
        ]);

        $warehouse->syncPermissions([
            'view dashboard',
            'manage products',
            'manage stocks',
            'view stock reports',
            'print reports',
        ]);
    }
}
