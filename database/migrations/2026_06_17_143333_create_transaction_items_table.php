<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')
                  ->constrained('transactions')
                  ->cascadeOnDelete()  // Transaksi dihapus → item ikut terhapus
                  ->cascadeOnUpdate();
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};