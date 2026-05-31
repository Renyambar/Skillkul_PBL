<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add Foreign Key: wallet_transactions.withdrawal_id → withdrawals.id
 *
 * Dipisah dari migration 000002 karena tabel withdrawals (000003) harus
 * dibuat lebih dulu. Migration ini dijalankan setelah keduanya ada.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->foreign('withdrawal_id')
                  ->references('id')
                  ->on('withdrawals')
                  ->nullOnDelete();

            // Index untuk query riwayat withdrawal per transaksi
            $table->index('withdrawal_id', 'wt_withdrawal_id_idx');
        });
    }

    public function down(): void
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->dropForeign(['withdrawal_id']);
            $table->dropIndex('wt_withdrawal_id_idx');
        });
    }
};
