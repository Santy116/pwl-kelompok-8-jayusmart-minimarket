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
                StockMovement::create([
                    'branch_id' => $transaction->branch_id,
                    'product_id' => $item->product_id,
                    'user_id' => $transaction->user_id,
                    'transaction_id' => $transaction->id,
                    'type' => 'out',
                    'quantity' => $item->quantity,
                    'movement_date' => $transaction->transaction_date,
                    'description' => 'Stok keluar dari transaksi penjualan.',
                ]);
            }
        }

        $stocks = Stock::with(['branch', 'product'])
            ->limit(10)
            ->get();

        foreach ($stocks as $stock) {
            $warehouse = User::role('warehouse')
                ->where('branch_id', $stock->branch_id)
                ->first();

            if (! $warehouse) {
                continue;
            }

            $stock->increment('quantity', 20);

            StockMovement::create([
                'branch_id' => $stock->branch_id,
                'product_id' => $stock->product_id,
                'user_id' => $warehouse->id,
                'transaction_id' => null,
                'type' => 'in',
                'quantity' => 20,
                'movement_date' => now(),
                'description' => 'Stok masuk awal dari data dummy.',
            ]);
        }
    }
}
