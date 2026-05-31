<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Wallet Transactions Table — Immutable Financial Ledger
 *
 * Setiap perubahan saldo wallet user HARUS tercatat di sini.
 * Tidak ada saldo yang berubah tanpa entry di tabel ini.
 *
 * Prinsip:
 * - Ledger ini bersifat IMMUTABLE: tidak ada update atau delete.
 * - balance_before dan balance_after adalah snapshot saat transaksi terjadi.
 * - Konsistensi: users.wallet_balance harus selalu = entry terbaru balance_after.
 *
 * Kategori transaksi:
 * - escrow_release : Dana escrow dilepas ke wallet freelancer (order completed)
 * - refund         : Dana escrow dikembalikan ke wallet client (order cancelled)
 * - withdrawal     : Dana dikeluarkan dari wallet (withdrawal approved + completed)
 * - withdrawal_reversal : Dana dikembalikan jika withdrawal direject setelah debit
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();

            // Pemilik wallet
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Referensi sumber transaksi (nullable — tidak semua punya semua FK)
            $table->uuid('order_id')->nullable();
            $table->foreign('order_id')
                  ->references('id')
                  ->on('orders')
                  ->nullOnDelete();

            $table->foreignId('escrow_id')
                  ->nullable()
                  ->constrained('escrows')
                  ->nullOnDelete();

            // FK ke withdrawals ditambahkan di migration 000003_add_withdrawal_fk
            // setelah tabel withdrawals dibuat (dependency order)
            $table->unsignedBigInteger('withdrawal_id')->nullable();

            // Tipe dan kategori
            $table->enum('type', ['credit', 'debit']);
            $table->enum('category', [
                'escrow_release',       // Freelancer menerima dana dari escrow
                'refund',               // Client menerima refund dari escrow
                'withdrawal',           // Saldo keluar karena withdrawal completed
                'withdrawal_reversal',  // Saldo kembali jika ada reversal
            ]);

            // Nominal dan snapshot saldo
            $table->decimal('amount', 15, 2);
            $table->decimal('balance_before', 15, 2)->comment('Saldo sebelum transaksi ini');
            $table->decimal('balance_after', 15, 2)->comment('Saldo sesudah transaksi ini');

            // Deskripsi human-readable untuk UI
            $table->string('description', 255);

            $table->timestamps();

            // Index untuk query riwayat dan audit
            $table->index('user_id');
            $table->index(['user_id', 'type']);
            $table->index(['user_id', 'category']);
            $table->index('order_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
