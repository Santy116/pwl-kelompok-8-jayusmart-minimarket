<?php

namespace Database\Seeders;

use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class StockMovementSeeder extends Seeder
{
    public function run(): void
    {
        $transactions = Transaction::with('transactionItems')->get();

        foreach ($transactions as $transaction) {
            foreach ($transaction->transactionItems as $item) {
                StockMovement::updateOrCreate(
                    [
                        'transaction_id' => $transaction->id,
                        'product_id' => $item->product_id,
                    ],
                    [
                        'branch_id' => $transaction->branch_id,
                        'user_id' => $transaction->user_id,
                        'type' => 'out',
                        'quantity' => $item->quantity,
                        'movement_date' => $transaction->transaction_date,
                        'description' => 'Stok keluar dari transaksi penjualan.',
                    ]
                );
            }
        }

        $stocks = Stock::with(['branch', 'product'])
            ->orderBy('branch_id')
            ->orderBy('product_id')
            ->get();

        foreach ($stocks as $index => $stock) {
            $warehouse = User::role('warehouse')
                ->where('branch_id', $stock->branch_id)
                ->first();

            if (! $warehouse) {
                continue;
            }

            $incomingQuantity = 20 + ($index % 15);

            $stock->increment('quantity', $incomingQuantity);

            StockMovement::updateOrCreate(
                [
                    'branch_id' => $stock->branch_id,
                    'product_id' => $stock->product_id,
                    'type' => 'in',
                    'description' => 'Stok masuk awal dari data dummy.',
                ],
                [
                    'user_id' => $warehouse->id,
                    'transaction_id' => null,
                    'quantity' => $incomingQuantity,
                    'movement_date' => now()->subDays($index % 20),
                ]
            );

            if ($index % 10 === 0) {
                StockMovement::updateOrCreate(
                    [
                        'branch_id' => $stock->branch_id,
                        'product_id' => $stock->product_id,
                        'type' => 'adjustment',
                        'description' => 'Adjustment stok dari pengecekan fisik.',
                    ],
                    [
                        'user_id' => $warehouse->id,
                        'transaction_id' => null,
                        'quantity' => $stock->quantity,
                        'movement_date' => now()->subDays($index % 10),
                    ]
                );
            }
        }
    }
}