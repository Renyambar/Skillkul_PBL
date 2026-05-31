<?php

use App\Console\Commands\AutoCompleteOrders;
use App\Console\Commands\CancelExpiredOrders;
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
 * Auto-complete pesanan yang sudah 'delivered' melebihi batas waktu (default 48 jam).
 * Menggunakan EscrowService untuk melepas dana ke wallet freelancer + ledger.
 * Dijalankan setiap jam untuk memastikan respons cepat.
 */
Schedule::command(AutoCompleteOrders::class)->hourly();

/**
 * Kirim pengingat deadline ke freelancer yang deadlinenya < 24 jam.
 * Mengirim DeadlineReminderNotification (database + mail).
 * Dijalankan setiap jam agar reminder tepat waktu.
 */
Schedule::command(SendDeadlineReminders::class)->hourly();

/**
 * Batalkan order yang melewati deadline tanpa freelancer submit hasil.
 * Merefund escrow ke client wallet + notifikasi kedua pihak.
 * Dijalankan setiap jam untuk respons cepat.
 */
Schedule::command(CancelExpiredOrders::class)->hourly();

