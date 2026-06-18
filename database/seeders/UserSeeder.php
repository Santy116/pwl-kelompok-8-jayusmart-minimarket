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
                'password' => Hash::make('password'),
            ]
        );

        $owner->syncRoles(['owner']);

        $branches = Branch::orderBy('id')->get();

        foreach ($branches as $branch) {
            $slug = Str::slug($branch->city);

            $manager = User::updateOrCreate(
                ['email' => "manager.{$slug}@jayusmart.test"],
                [
                    'branch_id' => $branch->id,
                    'name' => "Manager {$branch->city}",
                    'password' => Hash::make('password'),
                ]
            );

            $manager->syncRoles(['manager']);

            $supervisor = User::updateOrCreate(
                ['email' => "supervisor.{$slug}@jayusmart.test"],
                [
                    'branch_id' => $branch->id,
                    'name' => "Supervisor {$branch->city}",
                    'password' => Hash::make('password'),
                ]
            );

            $supervisor->syncRoles(['supervisor']);

            $cashier = User::updateOrCreate(
                ['email' => "cashier.{$slug}@jayusmart.test"],
                [
                    'branch_id' => $branch->id,
                    'name' => "Cashier {$branch->city}",
                    'password' => Hash::make('password'),
                ]
            );

            $cashier->syncRoles(['cashier']);

            $warehouse = User::updateOrCreate(
                ['email' => "warehouse.{$slug}@jayusmart.test"],
                [
                    'branch_id' => $branch->id,
                    'name' => "Warehouse {$branch->city}",
                    'password' => Hash::make('password'),
                ]
            );

            $warehouse->syncRoles(['warehouse']);
        }
    }
}
