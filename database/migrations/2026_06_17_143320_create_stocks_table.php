<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
                  ->constrained('branches')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('minimum_stock')->default(0);
            $table->timestamps();

            // Satu produk hanya boleh punya satu data stok per cabang
            $table->unique(['branch_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};