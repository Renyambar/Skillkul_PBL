<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('freelancer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->enum('type', ['direct_checkout', 'custom_invoice'])->default('direct_checkout');
            $table->enum('status', ['pending', 'waiting_payment', 'paid', 'in_progress', 'revision', 'delivered', 'completed', 'canceled'])->default('pending');
            $table->text('order_notes')->nullable();
            $table->string('client_gdrive_link')->nullable();
            $table->string('freelancer_result_link')->nullable();
            $table->decimal('total_price', 15, 2);
            $table->string('midtrans_snap_token')->nullable();
            $table->string('midtrans_transaction_id', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
