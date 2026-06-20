<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Jayusmart Bandung',
                'city' => 'Bandung',
                'address' => 'Jl. Asia Afrika No. 10, Bandung',
                'phone' => '0221234567',
            ],
            [
                'name' => 'Jayusmart Jakarta',
                'city' => 'Jakarta',
                'address' => 'Jl. Jenderal Sudirman No. 15, Jakarta',
                'phone' => '0211234567',
            ],
            [
                'name' => 'Jayusmart Bogor',
                'city' => 'Bogor',
                'address' => 'Jl. Pajajaran No. 20, Bogor',
                'phone' => '0251123456',
            ],
            [
                'name' => 'Jayusmart Depok',
                'city' => 'Depok',
                'address' => 'Jl. Margonda Raya No. 25, Depok',
                'phone' => '0217654321',
            ],
            [
                'name' => 'Jayusmart Bekasi',
                'city' => 'Bekasi',
                'address' => 'Jl. Ahmad Yani No. 30, Bekasi',
                'phone' => '0218899001',
            ],
        ];

        foreach ($branches as $branch) {
            Branch::updateOrCreate(
                ['name' => $branch['name']],
                $branch
            );
        }
    }
}