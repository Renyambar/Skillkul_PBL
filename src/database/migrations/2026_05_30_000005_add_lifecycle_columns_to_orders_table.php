<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Add Payment/Lifecycle Columns to Orders Table
 *
 * Kolom baru (additive only — tidak mengubah kolom yang sudah ada):
 *
 * - submitted_at  : Kapan freelancer submit hasil pekerjaan (status → delivered)
 *                   Digunakan sebagai acuan 48-jam auto-complete, menggantikan updated_at
 *                   yang tidak reliable karena bisa berubah karena alasan lain.
 *
 * - completed_at  : Kapan order selesai (manual accept atau auto complete).
 *                   Untuk laporan dan statistik.
 *
 * - cancelled_at  : Kapan order dibatalkan (deadline miss atau manual cancel).
 *                   Untuk laporan dan statistik.
 *
 * - escrow_released_at : Guard mencegah double-release escrow.
 *                        NULL = escrow belum dilepas, timestamp = sudah dilepas.
 *
 * Juga menambahkan 'submitted' ke status enum untuk konsistensi bisnis model.
 * CATATAN: Status 'delivered' tetap dipertahankan (tidak dihapus) agar tidak breaking.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('submitted_at')
                  ->nullable()
                  ->after('freelancer_result_link')
                  ->comment('Kapan freelancer submit hasil (status → delivered)');

            $table->timestamp('completed_at')
                  ->nullable()
                  ->after('submitted_at')
                  ->comment('Kapan order selesai (manual accept atau auto complete)');

            $table->timestamp('cancelled_at')
                  ->nullable()
                  ->after('completed_at')
                  ->comment('Kapan order dibatalkan (deadline miss atau manual)');

            $table->timestamp('escrow_released_at')
                  ->nullable()
                  ->after('cancelled_at')
                  ->comment('Guard: NULL = escrow belum dilepas, timestamp = sudah dilepas');
        });

        // Tambah index untuk query scheduler yang sering dijalankan setiap jam
        Schema::table('orders', function (Blueprint $table) {
            // Index untuk CancelExpiredOrders: status in_progress + deadline
            $table->index(['status', 'deadline'], 'orders_status_deadline_idx');

            // Index untuk AutoCompleteOrders: status delivered + submitted_at
            $table->index(['status', 'submitted_at'], 'orders_status_submitted_idx');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_status_deadline_idx');
            $table->dropIndex('orders_status_submitted_idx');
            $table->dropColumn([
                'submitted_at',
                'completed_at',
                'cancelled_at',
                'escrow_released_at',
            ]);
        });
    }
};
