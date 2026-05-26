<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Perbaikan: Hapus kolom 'exam_mode' yang redundan dari tabel users.
 *
 * Latar belakang:
 * - Migrasi dasar (create_users_table) sudah membuat kolom 'is_exam_mode'
 * - Migrasi 2026_04_16_000001 menambahkan kolom 'exam_mode' yang berbeda
 * - Ini menyebabkan konflik di User model dan ProfileController
 * - Sumber kebenaran tunggal adalah 'is_exam_mode'
 *
 * Kolom 'exam_mode_started_at' dipertahankan karena berguna sebagai audit trail.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom 'exam_mode' yang redundan jika masih ada
            if (Schema::hasColumn('users', 'exam_mode')) {
                $table->dropColumn('exam_mode');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restore jika rollback diperlukan
            if (! Schema::hasColumn('users', 'exam_mode')) {
                $table->boolean('exam_mode')->default(false)->after('role');
            }
        });
    }
};
