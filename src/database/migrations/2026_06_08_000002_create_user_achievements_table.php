<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create User Achievements Table
 *
 * Menyimpan badge/pencapaian freelancer yang HANYA dihitung dari
 * project-based services (service.type = 'project').
 *
 * Badge yang tersedia:
 * - first_project      : Menyelesaikan proyek pertama
 * - five_projects      : Menyelesaikan 5 proyek
 * - ten_projects       : Menyelesaikan 10 proyek
 * - top_rated          : Rata-rata rating ≥ 4.5 (min 3 review)
 * - excellent_feedback : Mendapat rating sempurna (5★) minimal 3 kali
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->enum('badge_key', [
                'first_project',
                'five_projects',
                'ten_projects',
                'top_rated',
                'excellent_feedback',
            ])->comment('Identifier unik badge');

            $table->timestamp('earned_at')
                  ->useCurrent()
                  ->comment('Kapan badge ini pertama kali diraih');

            $table->timestamps();

            // Satu freelancer hanya bisa mendapat setiap badge sekali
            $table->unique(['user_id', 'badge_key'], 'user_achievements_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_achievements');
    }
};
