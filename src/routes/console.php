<?php

use App\Console\Commands\AutoCompleteOrders;
use App\Console\Commands\SendDeadlineReminders;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ──────────────────────────────────────────────────────────────
// Scheduled Jobs SkillKul
// ──────────────────────────────────────────────────────────────

/**
 * Auto-complete pesanan yang sudah 'delivered' lebih dari 48 jam.
 * Dijalankan setiap jam untuk memastikan respons cepat.
 * Dana 95% otomatis dilepas ke wallet freelancer.
 */
Schedule::command(AutoCompleteOrders::class)->hourly();

/**
 * Kirim pengingat deadline ke freelancer yang deadlinenya < 24 jam.
 * Dijalankan setiap jam agar reminder tepat waktu.
 */
Schedule::command(SendDeadlineReminders::class)->hourly();
