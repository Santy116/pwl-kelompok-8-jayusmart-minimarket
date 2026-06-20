<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $owner = User::updateOrCreate(
            ['email' => 'owner@jayusmart.test'],
            [
                'branch_id' => null,
                'name' => 'Bapak Jayusman',
                'password' => Hash::make('Owner@Jayusmart2026'),
            ]
        );

        $owner->syncRoles(['owner']);

        $branchPasswords = [
            'bandung' => [
                'manager' => 'ManagerBandung@2026',
                'supervisor' => 'SupervisorBandung@2026',
                'cashier' => 'CashierBandung@2026',
                'warehouse' => 'WarehouseBandung@2026',
            ],
            'jakarta' => [
                'manager' => 'ManagerJakarta@2026',
                'supervisor' => 'SupervisorJakarta@2026',
                'cashier' => 'CashierJakarta@2026',
                'warehouse' => 'WarehouseJakarta@2026',
            ],
            'bogor' => [
                'manager' => 'ManagerBogor@2026',
                'supervisor' => 'SupervisorBogor@2026',
                'cashier' => 'CashierBogor@2026',
                'warehouse' => 'WarehouseBogor@2026',
            ],
            'depok' => [
                'manager' => 'ManagerDepok@2026',
                'supervisor' => 'SupervisorDepok@2026',
                'cashier' => 'CashierDepok@2026',
                'warehouse' => 'WarehouseDepok@2026',
            ],
            'bekasi' => [
                'manager' => 'ManagerBekasi@2026',
                'supervisor' => 'SupervisorBekasi@2026',
                'cashier' => 'CashierBekasi@2026',
                'warehouse' => 'WarehouseBekasi@2026',
            ],
        ];

        $branches = Branch::orderBy('id')->get();

        foreach ($branches as $branch) {
            $slug = Str::slug($branch->city);

            $manager = User::updateOrCreate(
                ['email' => "manager.{$slug}@jayusmart.test"],
                [
                    'branch_id' => $branch->id,
                    'name' => "Manager {$branch->city}",
                    'password' => Hash::make($branchPasswords[$slug]['manager']),
                ]
            );

            $manager->syncRoles(['manager']);

            $supervisor = User::updateOrCreate(
                ['email' => "supervisor.{$slug}@jayusmart.test"],
                [
                    'branch_id' => $branch->id,
                    'name' => "Supervisor {$branch->city}",
                    'password' => Hash::make($branchPasswords[$slug]['supervisor']),
                ]
            );

            $supervisor->syncRoles(['supervisor']);

            $cashier = User::updateOrCreate(
                ['email' => "cashier.{$slug}@jayusmart.test"],
                [
                    'branch_id' => $branch->id,
                    'name' => "Cashier {$branch->city}",
                    'password' => Hash::make($branchPasswords[$slug]['cashier']),
                ]
            );

            $cashier->syncRoles(['cashier']);

            $warehouse = User::updateOrCreate(
                ['email' => "warehouse.{$slug}@jayusmart.test"],
                [
                    'branch_id' => $branch->id,
                    'name' => "Warehouse {$branch->city}",
                    'password' => Hash::make($branchPasswords[$slug]['warehouse']),
                ]
            );

            $warehouse->syncRoles(['warehouse']);
        }
    }
}