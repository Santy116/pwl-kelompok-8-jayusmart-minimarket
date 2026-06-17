<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
                  ->constrained('branches')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();
            $table->string('invoice_number', 50)->unique();
            $table->dateTime('transaction_date');
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('change_amount', 15, 2)->default(0);
            $table->enum('payment_method', ['cash', 'transfer', 'qris'])->default('cash');
            $table->enum('status', ['paid', 'cancelled'])->default('paid');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};