<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Escrows Table
 *
 * Menyimpan dana yang ditahan platform saat client membayar.
 * Dana tidak dilepas ke freelancer sampai order status = completed.
 *
 * Setiap order hanya boleh memiliki SATU escrow record (UNIQUE order_id).
 * Ini mencegah double-escrow saat webhook diterima lebih dari sekali.
 *
 * Status Flow:
 *   held → released  (order completed: manual accept atau auto complete)
 *   held → refunded  (order cancelled: freelancer gagal deadline)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('escrows', function (Blueprint $table) {
            $table->id();

            // FK ke orders (UUID PK) — UNIQUE: satu escrow per order
            $table->uuid('order_id')->unique();
            $table->foreign('order_id')
                  ->references('id')
                  ->on('orders')
                  ->onDelete('cascade');

            // Breakdown finansial
            $table->decimal('amount', 15, 2)->comment('Gross amount dari payment (100%)');
            $table->decimal('platform_fee', 15, 2)->comment('8% fee platform');
            $table->decimal('freelancer_amount', 15, 2)->comment('92% untuk freelancer');

            // Status escrow
            $table->enum('status', ['held', 'released', 'refunded'])->default('held');

            // Timestamps spesifik per aksi
            $table->timestamp('held_at')->nullable()->comment('Kapan dana mulai ditahan');
            $table->timestamp('released_at')->nullable()->comment('Kapan dana dilepas ke freelancer');
            $table->timestamp('refunded_at')->nullable()->comment('Kapan dana dikembalikan ke client');

            // Penerima dana saat release/refund
            $table->foreignId('released_to_user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete()
                  ->comment('User ID penerima dana (freelancer atau client)');

            // Tipe pelepasan dana — untuk audit trail
            $table->enum('release_type', [
                'manual_accept',   // Client manual klik "Terima Hasil"
                'auto_complete',   // Auto setelah 48 jam delivered tanpa konfirmasi
                'refund_deadline', // Freelancer gagal deadline → refund ke client
                'refund_cancel',   // Order dibatalkan manual → refund ke client
            ])->nullable();

            $table->timestamps();

            // Index untuk query performa
            $table->index('status');
            $table->index('held_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('escrows');
    }
};
