<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Adds to orders table:
 *  - deadline        : Project deadline (used for 24hr reminder & auto-complete tracking)
 *  - revision_count  : Number of revisions already requested by client
 *  - revision_limit  : Maximum revisions allowed for this order (configurable per-order)
 *
 * Also fixes the status enum to include 'waiting_payment' which is referenced
 * in MidtransController but was missing from the original migration.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('deadline')->nullable()->after('order_notes');
            $table->unsignedTinyInteger('revision_count')->default(0)->after('deadline');
            $table->unsignedTinyInteger('revision_limit')->default(2)->after('revision_count');
        });

        // Fix status enum to include 'waiting_payment' which was missing
        // Update Enum status via raw statement since Doctrine DBAL doesn't support ENUM drops
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'waiting_payment', 'paid', 'in_progress', 'revision', 'delivered', 'completed', 'canceled') NOT NULL DEFAULT 'pending'");
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['deadline', 'revision_count', 'revision_limit']);
        });

        // Restore original enum
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'in_progress', 'delivered', 'completed', 'canceled') NOT NULL DEFAULT 'pending'");
        }
    }
};
