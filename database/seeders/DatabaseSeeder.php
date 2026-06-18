<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            BranchSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            StockSeeder::class,
            TransactionSeeder::class,
            StockMovementSeeder::class,
        ]);
    }
}
