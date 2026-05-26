<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Payments table — tracks each Midtrans payment transaction per order.
 *
 * This is separate from the orders table to:
 *  1. Allow multiple payment attempts per order (e.g., failed then retried)
 *  2. Store raw Midtrans response as JSON for audit purposes
 *  3. Track payment method, timestamps, and status independently
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Foreign key to orders (UUID primary key)
            $table->uuid('order_id');
            $table->foreign('order_id')
                  ->references('id')
                  ->on('orders')
                  ->onDelete('cascade');

            // Midtrans identifiers
            $table->string('midtrans_transaction_id', 100)->nullable()->unique();
            $table->string('midtrans_order_id', 100)->nullable()->index();

            // Payment details
            $table->string('payment_method', 50)->nullable(); // e.g. 'qris', 'bca_va', 'gopay'
            $table->decimal('gross_amount', 15, 2);

            // Payment status mirrors Midtrans: pending, settlement, expire, cancel, deny
            $table->string('payment_status', 30)->default('pending');

            // Timestamp when payment was confirmed by Midtrans
            $table->timestamp('paid_at')->nullable();

            // Full raw Midtrans webhook payload stored for audit trail
            $table->json('raw_response')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
