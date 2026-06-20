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
                $baseQuantity = 60 + ($branchIndex * 15) + ($productIndex % 20);

                $quantity = match (true) {
                    $productIndex % 17 === 0 => 8,
                    $productIndex % 13 === 0 => 15,
                    $productIndex % 9 === 0 => 25,
                    default => $baseQuantity,
                };

                Stock::updateOrCreate(
                    [
                        'branch_id' => $branch->id,
                        'product_id' => $product->id,
                    ],
                    [
                        'quantity' => $quantity,
                        'minimum_stock' => 20,
                    ]
                );
            }
        }
    }
}