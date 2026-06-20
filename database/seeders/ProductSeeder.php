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
            // Sembako
            ['Sembako', 'PRD001', 'Beras Ramos 5kg', 'pcs', 62000, 68000],
            ['Sembako', 'PRD002', 'Beras Pandan Wangi 5kg', 'pcs', 68000, 75000],
            ['Sembako', 'PRD003', 'Minyak Goreng 2L', 'pcs', 31000, 35000],
            ['Sembako', 'PRD004', 'Gula Pasir 1kg', 'pcs', 14000, 17000],
            ['Sembako', 'PRD005', 'Telur Ayam 1kg', 'kg', 26000, 30000],
            ['Sembako', 'PRD006', 'Tepung Terigu 1kg', 'pcs', 10000, 13000],
            ['Sembako', 'PRD007', 'Garam Dapur 500g', 'pcs', 4000, 6000],
            ['Sembako', 'PRD008', 'Santan Instan 65ml', 'pcs', 3500, 5000],

            // Minuman
            ['Minuman', 'PRD009', 'Air Mineral 600ml', 'pcs', 2500, 4000],
            ['Minuman', 'PRD010', 'Air Mineral 1.5L', 'pcs', 4500, 7000],
            ['Minuman', 'PRD011', 'Teh Botol 350ml', 'pcs', 4000, 6000],
            ['Minuman', 'PRD012', 'Susu UHT 1L', 'pcs', 16500, 20000],
            ['Minuman', 'PRD013', 'Kopi Susu Botol 250ml', 'pcs', 6500, 9000],
            ['Minuman', 'PRD014', 'Minuman Isotonik 500ml', 'pcs', 5500, 8000],
            ['Minuman', 'PRD015', 'Jus Jeruk Kotak 250ml', 'pcs', 5000, 7500],
            ['Minuman', 'PRD016', 'Soda Kaleng 330ml', 'pcs', 6000, 9000],

            // Makanan Ringan
            ['Makanan Ringan', 'PRD017', 'Keripik Kentang', 'pcs', 8000, 12000],
            ['Makanan Ringan', 'PRD018', 'Biskuit Coklat', 'pcs', 7000, 10000],
            ['Makanan Ringan', 'PRD019', 'Roti Tawar', 'pcs', 12000, 16000],
            ['Makanan Ringan', 'PRD020', 'Wafer Coklat', 'pcs', 6500, 9500],
            ['Makanan Ringan', 'PRD021', 'Kacang Atom', 'pcs', 7500, 11000],
            ['Makanan Ringan', 'PRD022', 'Permen Mint', 'pcs', 3500, 5000],
            ['Makanan Ringan', 'PRD023', 'Coklat Batang', 'pcs', 9000, 13000],
            ['Makanan Ringan', 'PRD024', 'Snack Keju', 'pcs', 7000, 10000],

            // Kebersihan
            ['Kebersihan', 'PRD025', 'Sabun Cuci Piring', 'pcs', 9000, 13000],
            ['Kebersihan', 'PRD026', 'Deterjen Bubuk 1kg', 'pcs', 18000, 23000],
            ['Kebersihan', 'PRD027', 'Pembersih Lantai', 'pcs', 15000, 19000],
            ['Kebersihan', 'PRD028', 'Pewangi Pakaian 800ml', 'pcs', 14000, 18000],
            ['Kebersihan', 'PRD029', 'Tisu Gulung Isi 10', 'pcs', 28000, 34000],
            ['Kebersihan', 'PRD030', 'Tisu Wajah 250 Sheet', 'pcs', 12000, 16000],
            ['Kebersihan', 'PRD031', 'Sabun Colek 500g', 'pcs', 7000, 10000],
            ['Kebersihan', 'PRD032', 'Karbol 800ml', 'pcs', 13000, 17000],

            // Perawatan Diri
            ['Perawatan Diri', 'PRD033', 'Sabun Mandi', 'pcs', 5000, 8000],
            ['Perawatan Diri', 'PRD034', 'Shampoo 170ml', 'pcs', 16000, 21000],
            ['Perawatan Diri', 'PRD035', 'Pasta Gigi 190g', 'pcs', 12000, 16000],
            ['Perawatan Diri', 'PRD036', 'Sikat Gigi', 'pcs', 6000, 9000],
            ['Perawatan Diri', 'PRD037', 'Deodorant Roll On', 'pcs', 15000, 21000],
            ['Perawatan Diri', 'PRD038', 'Hand Sanitizer 100ml', 'pcs', 9000, 13000],
            ['Perawatan Diri', 'PRD039', 'Masker Medis Isi 10', 'pcs', 10000, 15000],
            ['Perawatan Diri', 'PRD040', 'Body Lotion 200ml', 'pcs', 18000, 25000],

            // Bumbu Dapur
            ['Bumbu Dapur', 'PRD041', 'Kecap Manis 600ml', 'pcs', 18000, 24000],
            ['Bumbu Dapur', 'PRD042', 'Saus Sambal 335ml', 'pcs', 11000, 15000],
            ['Bumbu Dapur', 'PRD043', 'Saus Tomat 335ml', 'pcs', 10000, 14000],
            ['Bumbu Dapur', 'PRD044', 'Merica Bubuk 50g', 'pcs', 6000, 9000],
            ['Bumbu Dapur', 'PRD045', 'Ketumbar Bubuk 50g', 'pcs', 5000, 8000],
            ['Bumbu Dapur', 'PRD046', 'Kaldu Ayam Sachet', 'pcs', 8000, 11000],
            ['Bumbu Dapur', 'PRD047', 'Bawang Goreng 100g', 'pcs', 12000, 17000],
            ['Bumbu Dapur', 'PRD048', 'Terasi Sachet', 'pcs', 3500, 5000],

            // Produk Instan
            ['Produk Instan', 'PRD049', 'Mie Instan Goreng', 'pcs', 2800, 4000],
            ['Produk Instan', 'PRD050', 'Mie Instan Kuah', 'pcs', 2800, 4000],
            ['Produk Instan', 'PRD051', 'Bubur Instan Ayam', 'pcs', 8000, 12000],
            ['Produk Instan', 'PRD052', 'Sereal Sachet', 'pcs', 6000, 9000],
            ['Produk Instan', 'PRD053', 'Kopi Sachet', 'pcs', 1200, 2000],
            ['Produk Instan', 'PRD054', 'Susu Bubuk Sachet', 'pcs', 2500, 4000],
            ['Produk Instan', 'PRD055', 'Minuman Coklat Sachet', 'pcs', 2000, 3500],
            ['Produk Instan', 'PRD056', 'Sup Krim Instan', 'pcs', 7000, 10000],

            // Perlengkapan Rumah
            ['Perlengkapan Rumah', 'PRD057', 'Baterai AA Isi 2', 'pcs', 12000, 17000],
            ['Perlengkapan Rumah', 'PRD058', 'Baterai AAA Isi 2', 'pcs', 12000, 17000],
            ['Perlengkapan Rumah', 'PRD059', 'Lampu LED 9 Watt', 'pcs', 18000, 25000],
            ['Perlengkapan Rumah', 'PRD060', 'Kantong Sampah Roll', 'pcs', 9000, 13000],
            ['Perlengkapan Rumah', 'PRD061', 'Spons Cuci Piring', 'pcs', 5000, 8000],
            ['Perlengkapan Rumah', 'PRD062', 'Lap Serbaguna', 'pcs', 7000, 10000],
            ['Perlengkapan Rumah', 'PRD063', 'Obat Nyamuk Bakar', 'pcs', 6000, 9000],
            ['Perlengkapan Rumah', 'PRD064', 'Korek Api Gas', 'pcs', 3000, 5000],
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
                    'description' => "Produk {$name} untuk kebutuhan minimarket Jayusmart.",
                ]
            );
        }
    }
}