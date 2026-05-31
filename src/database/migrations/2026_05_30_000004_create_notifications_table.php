<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Notifications Table — Laravel Built-in Database Notifications
 *
 * Menggunakan struktur standar Laravel Notification (polymorphic).
 * Kompatibel dengan Notifiable trait yang sudah ada di User model.
 *
 * Equivalent dengan: php artisan notifications:table
 * Dibuat manual agar konsisten dengan numbering migration ini.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Polymorphic: notifiable_type = 'App\Models\User', notifiable_id = user.id
            $table->string('type');
            $table->morphs('notifiable');

            // Payload notifikasi dalam JSON
            $table->text('data');

            // NULL = belum dibaca, timestamp = sudah dibaca
            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            // Index untuk query notifikasi belum dibaca per user
            $table->index(['notifiable_type', 'notifiable_id', 'read_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
