<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sembako',
                'description' => 'Produk kebutuhan pokok harian.',
            ],
            [
                'name' => 'Minuman',
                'description' => 'Produk minuman kemasan.',
            ],
            [
                'name' => 'Makanan Ringan',
                'description' => 'Produk snack dan makanan ringan.',
            ],
            [
                'name' => 'Kebersihan',
                'description' => 'Produk kebersihan rumah tangga.',
            ],
            [
                'name' => 'Perawatan Diri',
                'description' => 'Produk perawatan tubuh dan kesehatan ringan.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
