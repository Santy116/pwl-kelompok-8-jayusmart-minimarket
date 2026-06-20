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
                'description' => 'Produk minuman kemasan dan minuman ringan.',
            ],
            [
                'name' => 'Makanan Ringan',
                'description' => 'Produk snack, roti, dan camilan.',
            ],
            [
                'name' => 'Kebersihan',
                'description' => 'Produk kebersihan rumah tangga.',
            ],
            [
                'name' => 'Perawatan Diri',
                'description' => 'Produk perawatan tubuh dan kebutuhan pribadi.',
            ],
            [
                'name' => 'Bumbu Dapur',
                'description' => 'Produk bumbu masak dan pelengkap dapur.',
            ],
            [
                'name' => 'Produk Instan',
                'description' => 'Produk makanan dan minuman instan.',
            ],
            [
                'name' => 'Perlengkapan Rumah',
                'description' => 'Produk perlengkapan sederhana untuk rumah tangga.',
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