<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id', 'name');

        $products = [
            ['Sembako', 'PRD001', 'Beras Ramos 5kg', 'pcs', 62000, 68000],
            ['Sembako', 'PRD002', 'Minyak Goreng 2L', 'pcs', 31000, 35000],
            ['Sembako', 'PRD003', 'Gula Pasir 1kg', 'pcs', 14000, 17000],
            ['Sembako', 'PRD004', 'Telur Ayam 1kg', 'kg', 26000, 30000],

            ['Minuman', 'PRD005', 'Air Mineral 600ml', 'pcs', 2500, 4000],
            ['Minuman', 'PRD006', 'Teh Botol 350ml', 'pcs', 4000, 6000],
            ['Minuman', 'PRD007', 'Susu UHT 1L', 'pcs', 16500, 20000],

            ['Makanan Ringan', 'PRD008', 'Keripik Kentang', 'pcs', 8000, 12000],
            ['Makanan Ringan', 'PRD009', 'Biskuit Coklat', 'pcs', 7000, 10000],
            ['Makanan Ringan', 'PRD010', 'Roti Tawar', 'pcs', 12000, 16000],

            ['Kebersihan', 'PRD011', 'Sabun Cuci Piring', 'pcs', 9000, 13000],
            ['Kebersihan', 'PRD012', 'Deterjen Bubuk 1kg', 'pcs', 18000, 23000],
            ['Kebersihan', 'PRD013', 'Pembersih Lantai', 'pcs', 15000, 19000],

            ['Perawatan Diri', 'PRD014', 'Sabun Mandi', 'pcs', 5000, 8000],
            ['Perawatan Diri', 'PRD015', 'Shampoo 170ml', 'pcs', 16000, 21000],
        ];

        foreach ($products as [$categoryName, $code, $name, $unit, $purchasePrice, $sellingPrice]) {
            Product::updateOrCreate(
                ['code' => $code],
                [
                    'category_id' => $categories[$categoryName],
                    'name' => $name,
                    'unit' => $unit,
                    'purchase_price' => $purchasePrice,
                    'selling_price' => $sellingPrice,
                    'description' => "Produk {$name} untuk kebutuhan minimarket.",
                ]
            );
        }
    }
}
