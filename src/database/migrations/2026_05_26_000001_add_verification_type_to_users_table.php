<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds:
 *  - verification_type : Menentukan metode verifikasi identitas mahasiswa.
 *
 * Nilai enum:
 *  - 'college_email' : Freelancer mendaftar dengan email .ac.id (terverifikasi via email)
 *  - 'nim'           : Freelancer mendaftar dengan NIM + email pribadi
 *  - 'none'          : Client atau admin (tidak memerlukan verifikasi mahasiswa)
 *
 * Kolom ini dibutuhkan agar sistem dapat membedakan jalur registrasi freelancer
 * tanpa menambahkan tabel terpisah.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('verification_type', ['college_email', 'nim', 'none'])
                  ->default('none')
                  ->after('role')
                  ->comment('Metode verifikasi identitas: college_email, nim, atau none (client/admin)');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('verification_type');
        });
    }
};
