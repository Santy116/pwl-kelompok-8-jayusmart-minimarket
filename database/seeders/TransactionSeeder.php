<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $branches = Branch::orderBy('id')->get();
        $counter = 1;

        foreach ($branches as $branch) {
            $cashier = User::role('cashier')
                ->where('branch_id', $branch->id)
                ->first();

            if (! $cashier) {
                continue;
            }

            for ($transactionNumber = 1; $transactionNumber <= 2; $transactionNumber++) {
                $stocks = Stock::with('product')
                    ->where('branch_id', $branch->id)
                    ->where('quantity', '>', 10)
                    ->limit(3)
                    ->get();

                if ($stocks->isEmpty()) {
                    continue;
                }

                $items = [];
                $totalAmount = 0;

                foreach ($stocks as $index => $stock) {
                    $quantity = $index + 1;
                    $price = $stock->product->selling_price;
                    $subtotal = $quantity * $price;

                    $items[] = [
                        'stock' => $stock,
                        'product_id' => $stock->product_id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'subtotal' => $subtotal,
                    ];

                    $totalAmount += $subtotal;
                }

                $paidAmount = $totalAmount + 10000;

                $transaction = Transaction::create([
                    'branch_id' => $branch->id,
                    'user_id' => $cashier->id,
                    'invoice_number' => 'INV-SEED-'.str_pad((string) $counter, 5, '0', STR_PAD_LEFT),
                    'transaction_date' => now()->subDays($counter),
                    'total_amount' => $totalAmount,
                    'paid_amount' => $paidAmount,
                    'change_amount' => $paidAmount - $totalAmount,
                    'payment_method' => $counter % 2 === 0 ? 'qris' : 'cash',
                    'status' => 'paid',
                ]);

                foreach ($items as $item) {
                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    $item['stock']->decrement('quantity', $item['quantity']);
                }

                $counter++;
            }
        }
    }
}
