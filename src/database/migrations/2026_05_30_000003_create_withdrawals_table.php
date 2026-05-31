<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Withdrawals Table
 *
 * Menyimpan request penarikan saldo dari freelancer maupun client.
 *
 * Workflow:
 *   Client/Freelancer request → status: pending
 *   Admin review → status: approved | rejected
 *   Admin transfer manual → Admin klik complete → status: completed
 *   (Saldo baru berkurang saat status = completed via WalletService::debit())
 *
 * Security:
 * - Saldo TIDAK langsung dikurangi saat request.
 * - Saldo dikurangi HANYA saat admin mark as completed.
 * - Tidak boleh ada dua pending withdrawal dari user yang sama.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();

            // Pemohon (client atau freelancer)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Data rekening bank tujuan
            $table->string('bank_name', 100)->comment('Nama bank: BCA, BNI, Mandiri, dll');
            $table->string('account_number', 30)->comment('Nomor rekening tujuan');
            $table->string('account_holder', 100)->comment('Nama pemilik rekening');

            // Nominal penarikan
            $table->decimal('amount', 15, 2);

            // Status workflow
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])
                  ->default('pending');

            // Catatan admin (wajib diisi saat reject)
            $table->text('admin_note')->nullable();

            // Timestamps spesifik per aksi
            $table->timestamp('requested_at')->nullable()->comment('Waktu request dibuat');
            $table->timestamp('reviewed_at')->nullable()->comment('Waktu admin approve/reject');
            $table->timestamp('completed_at')->nullable()->comment('Waktu admin mark completed');

            // Admin yang menangani request
            $table->foreignId('reviewed_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete()
                  ->comment('Admin user ID yang mereview');

            $table->timestamps();

            // Index untuk query admin dashboard
            $table->index('status');
            $table->index(['user_id', 'status']);
            $table->index('requested_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
