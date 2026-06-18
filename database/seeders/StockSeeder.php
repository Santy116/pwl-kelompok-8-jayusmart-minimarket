<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $branches = Branch::orderBy('id')->get();
        $products = Product::orderBy('id')->get();

        foreach ($branches as $branchIndex => $branch) {
            foreach ($products as $productIndex => $product) {
                Stock::updateOrCreate(
                    [
                        'branch_id' => $branch->id,
                        'product_id' => $product->id,
                    ],
                    [
                        'quantity' => 80 + ($branchIndex * 10) + ($productIndex % 5),
                        'minimum_stock' => 20,
                    ]
                );
            }
        }
    }
}
