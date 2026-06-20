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

            for ($transactionNumber = 1; $transactionNumber <= 15; $transactionNumber++) {
                $stocks = Stock::with('product')
                    ->where('branch_id', $branch->id)
                    ->where('quantity', '>', 25)
                    ->inRandomOrder()
                    ->limit(4)
                    ->get();

                if ($stocks->isEmpty()) {
                    continue;
                }

                $items = [];
                $totalAmount = 0;

                foreach ($stocks as $index => $stock) {
                    $quantity = ($index % 3) + 1;
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

                $paidAmount = $totalAmount + (5000 * (($counter % 4) + 1));
                $transactionDate = now()->subDays($counter % 30);

                $transaction = Transaction::updateOrCreate(
                    [
                        'invoice_number' => 'INV-SEED-'.str_pad((string) $counter, 5, '0', STR_PAD_LEFT),
                    ],
                    [
                        'branch_id' => $branch->id,
                        'user_id' => $cashier->id,
                        'transaction_date' => $transactionDate,
                        'total_amount' => $totalAmount,
                        'paid_amount' => $paidAmount,
                        'change_amount' => $paidAmount - $totalAmount,
                        'payment_method' => $counter % 2 === 0 ? 'qris' : 'cash',
                        'status' => 'paid',
                    ]
                );

                foreach ($items as $item) {
                    TransactionItem::updateOrCreate(
                        [
                            'transaction_id' => $transaction->id,
                            'product_id' => $item['product_id'],
                        ],
                        [
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                            'subtotal' => $item['subtotal'],
                        ]
                    );

                    if ($item['stock']->quantity >= $item['quantity']) {
                        $item['stock']->decrement('quantity', $item['quantity']);
                    }
                }

                $counter++;
            }
        }
    }
}