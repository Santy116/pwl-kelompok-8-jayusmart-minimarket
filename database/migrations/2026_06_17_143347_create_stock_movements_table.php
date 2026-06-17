<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
                  ->constrained('branches')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();
            $table->foreignId('transaction_id')
                  ->nullable()
                  ->constrained('transactions')
                  ->nullOnDelete()   // Transaksi dihapus → transaction_id jadi null
                  ->cascadeOnUpdate();
            $table->enum('type', ['in', 'out', 'adjustment']);
            $table->unsignedInteger('quantity');
            $table->dateTime('movement_date');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};