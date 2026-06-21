<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class AuditLogSeeder extends Seeder
{
    public function run(): void
    {
        AuditLog::query()->delete();

        $this->seedTransactionLogs();
        $this->seedStockMovementLogs();
        $this->seedProductLogs();
    }

    private function seedTransactionLogs(): void
    {
        Transaction::with(['user', 'branch'])
            ->latest()
            ->take(50)
            ->get()
            ->each(function (Transaction $transaction): void {
                $user = $transaction->user ?? User::role('owner')->first();

                AuditLog::create([
                    'user_id' => $user?->id,
                    'branch_id' => $transaction->branch_id,
                    'role' => $user?->roles->pluck('name')->first() ?? 'cashier',
                    'action' => 'create',
                    'table_name' => 'transactions',
                    'record_id' => $transaction->id,
                    'old_values' => null,
                    'new_values' => [
                        'invoice_number' => $transaction->invoice_number,
                        'branch_id' => $transaction->branch_id,
                        'user_id' => $transaction->user_id,
                        'transaction_date' => $transaction->transaction_date,
                        'total_amount' => $transaction->total_amount,
                        'payment_method' => $transaction->payment_method,
                        'status' => $transaction->status,
                    ],
                    'ip_address' => '127.0.0.1',
                    'user_agent' => 'Seeder Dummy Data',
                    'created_at' => $transaction->created_at,
                    'updated_at' => $transaction->updated_at,
                ]);
            });
    }

    private function seedStockMovementLogs(): void
    {
        StockMovement::with(['user', 'branch', 'product'])
            ->latest()
            ->take(75)
            ->get()
            ->each(function (StockMovement $stockMovement): void {
                $user = $stockMovement->user ?? User::role('warehouse')->first();

                AuditLog::create([
                    'user_id' => $user?->id,
                    'branch_id' => $stockMovement->branch_id,
                    'role' => $user?->roles->pluck('name')->first() ?? 'warehouse',
                    'action' => 'create',
                    'table_name' => 'stock_movements',
                    'record_id' => $stockMovement->id,
                    'old_values' => null,
                    'new_values' => [
                        'branch_id' => $stockMovement->branch_id,
                        'product_id' => $stockMovement->product_id,
                        'user_id' => $stockMovement->user_id,
                        'transaction_id' => $stockMovement->transaction_id,
                        'type' => $stockMovement->type,
                        'quantity' => $stockMovement->quantity,
                        'movement_date' => $stockMovement->movement_date,
                        'description' => $stockMovement->description,
                    ],
                    'ip_address' => '127.0.0.1',
                    'user_agent' => 'Seeder Dummy Data',
                    'created_at' => $stockMovement->created_at,
                    'updated_at' => $stockMovement->updated_at,
                ]);
            });
    }

    private function seedProductLogs(): void
    {
        $owner = User::role('owner')->first();
        $manager = User::role('manager')->first();
        $warehouse = User::role('warehouse')->first();

        Product::latest()
            ->take(50)
            ->get()
            ->each(function (Product $product, int $index) use ($owner, $manager, $warehouse): void {
                $user = match ($index % 3) {
                    0 => $owner,
                    1 => $manager,
                    default => $warehouse,
                };

                $action = match ($index % 3) {
                    0 => 'create',
                    1 => 'update',
                    default => 'delete',
                };

                $oldValues = null;
                $newValues = [
                    'id' => $product->id,
                    'category_id' => $product->category_id,
                    'code' => $product->code,
                    'name' => $product->name,
                    'unit' => $product->unit,
                    'purchase_price' => $product->purchase_price,
                    'selling_price' => $product->selling_price,
                    'description' => $product->description,
                ];

                if ($action === 'update') {
                    $oldValues = [
                        ...$newValues,
                        'selling_price' => max(0, (int) $product->selling_price - 1000),
                    ];
                }

                if ($action === 'delete') {
                    $oldValues = $newValues;
                    $newValues = null;
                }

                AuditLog::create([
                    'user_id' => $user?->id,
                    'branch_id' => $user?->branch_id,
                    'role' => $user?->roles->pluck('name')->first() ?? 'owner',
                    'action' => $action,
                    'table_name' => 'products',
                    'record_id' => $product->id,
                    'old_values' => $oldValues,
                    'new_values' => $newValues,
                    'ip_address' => '127.0.0.1',
                    'user_agent' => 'Seeder Dummy Data',
                    'created_at' => now()->subDays(rand(1, 14)),
                    'updated_at' => now(),
                ]);
            });
    }
}