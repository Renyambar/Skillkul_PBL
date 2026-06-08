<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Revamp Portfolios Table — Additive Only
 *
 * Menambahkan kolom-kolom baru untuk mendukung:
 * - Visibility control per-project (is_portfolio)
 * - Featured projects (is_featured, max 3)
 * - Data lengkap portfolio (role, durasi, cloud link, rating, testimonial)
 * - Urutan tampil (sort_order)
 *
 * TIDAK menghapus kolom lama agar backward-compatible.
 * Record existing akan memiliki is_portfolio = false (hidden) secara default.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            // ─── Deskripsi & Konteks ──────────────────────────────
            $table->text('project_description')
                  ->nullable()
                  ->after('project_title')
                  ->comment('Deskripsi proyek — auto-filled dari service.description');

            $table->string('project_category', 100)
                  ->nullable()
                  ->after('project_description')
                  ->comment('Nama kategori — auto-filled dari service.category.name');

            $table->string('freelancer_role', 100)
                  ->nullable()
                  ->after('project_category')
                  ->comment('Role freelancer dalam proyek — diisi manual');

            // ─── Durasi & Waktu ───────────────────────────────────
            $table->unsignedSmallInteger('project_duration_days')
                  ->nullable()
                  ->after('freelancer_role')
                  ->comment('Durasi pengerjaan dalam hari — hitung dari created_at → completed_at');

            // ─── Link Hasil Kerja ─────────────────────────────────
            $table->string('cloud_link', 500)
                  ->nullable()
                  ->after('project_duration_days')
                  ->comment('Link hasil kerja — auto-fill dari orders.freelancer_result_link');

            // ─── Rating & Testimonial Client ──────────────────────
            $table->tinyInteger('client_rating')
                  ->unsigned()
                  ->nullable()
                  ->after('cloud_link')
                  ->comment('Rating dari client (1-5) — dari reviews.rating');

            $table->text('client_testimonial')
                  ->nullable()
                  ->after('client_rating')
                  ->comment('Komentar client — dari reviews.comment');

            // ─── Visibility & Featured Control ───────────────────
            $table->boolean('is_portfolio')
                  ->default(false)
                  ->after('client_testimonial')
                  ->comment('true = tampil di portfolio publik freelancer');

            $table->boolean('is_featured')
                  ->default(false)
                  ->after('is_portfolio')
                  ->comment('true = tampil paling atas (max 3 per freelancer)');

            // ─── Sort Order ───────────────────────────────────────
            $table->unsignedSmallInteger('sort_order')
                  ->default(0)
                  ->after('is_featured')
                  ->comment('Urutan tampil pada halaman portfolio');
        });

        // Index untuk query portfolio publik
        Schema::table('portfolios', function (Blueprint $table) {
            $table->index(['freelancer_id', 'is_portfolio', 'is_featured'], 'portfolios_public_idx');
            $table->index(['freelancer_id', 'is_featured'], 'portfolios_featured_idx');
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropIndex('portfolios_public_idx');
            $table->dropIndex('portfolios_featured_idx');
            $table->dropColumn([
                'project_description',
                'project_category',
                'freelancer_role',
                'project_duration_days',
                'cloud_link',
                'client_rating',
                'client_testimonial',
                'is_portfolio',
                'is_featured',
                'sort_order',
            ]);
        });
    }
};
