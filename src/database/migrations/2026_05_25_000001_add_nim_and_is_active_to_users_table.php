<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds:
 *  - nim          : Student ID Number (unique, nullable)
 *  - is_active    : Proper account suspension flag (replaces email_verified_at hack)
 *
 * This migration replaces the old pattern of using `email_verified_at = null`
 * to represent a suspended account, which broke email verification semantics.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Student ID Number — unique across all users, nullable for clients
            $table->string('nim', 20)->nullable()->unique()->after('email');

            // Proper suspension flag — admin uses this to deactivate accounts
            $table->boolean('is_active')->default(true)->after('wallet_balance');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['nim']);
            $table->dropColumn(['nim', 'is_active']);
        });
    }
};
