<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Order Revisions Table
 *
 * Menyimpan setiap catatan permintaan revisi dari client.
 * Dipisah dari tabel orders agar riwayat revisi bisa dilacak per-request.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_revisions', function (Blueprint $table) {
            $table->id();

            // Order yang diminta revisi
            $table->uuid('order_id');
            $table->foreign('order_id')
                  ->references('id')
                  ->on('orders')
                  ->onDelete('cascade');

            // Client yang meminta revisi
            $table->foreignId('requested_by')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Catatan revisi (wajib)
            $table->text('notes')->comment('Catatan detail apa yang perlu direvisi');

            // Link Google Drive opsional (untuk referensi / file materi tambahan)
            $table->string('drive_link', 500)->nullable()->comment('Link Google Drive opsional');

            // Nomor urut revisi untuk order ini (ke-1, ke-2, dst)
            $table->unsignedTinyInteger('revision_number')->default(1);

            $table->timestamps();

            // Index untuk query cepat
            $table->index('order_id');
            $table->index(['order_id', 'revision_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_revisions');
    }
};
