<?php

namespace App\Services;

use App\Models\Escrow;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * EscrowService — Dana Escrow Management
 *
 * Bertanggung jawab atas seluruh lifecycle escrow:
 *   1. holdFunds()          : Tahan dana saat payment settlement
 *   2. releaseToFreelancer() : Lepas dana ke freelancer (manual accept)
 *   3. autoRelease()         : Lepas dana ke freelancer (auto complete 48 jam)
 *   4. refundToClient()      : Kembalikan dana ke client (deadline miss / cancel)
 *
 * PENTING:
 * - Semua method harus dipanggil di dalam DB::transaction() dari caller.
 * - Platform fee: 8% (PLATFORM_FEE_PERCENT di .env, default 8)
 * - Freelancer menerima: 92% dari amount
 *
 * Security:
 * - holdFunds() cek idempotency: skip jika escrow sudah ada (double webhook protection)
 * - releaseToFreelancer() dan refundToClient() cek status === 'held' sebelum proses
 * - Semua operasi menggunakan lockForUpdate() pada escrow record
 */
class EscrowService
{
    public function __construct(
        protected WalletService $walletService,
    ) {}

    /**
     * Platform fee percentage (default 8%).
     * Dapat dikonfigurasi via PLATFORM_FEE_PERCENT di .env
     */
    protected function platformFeePercent(): float
    {
        return (float) config('skillkul.platform_fee_percent', 8);
    }

    /**
     * Tahan dana escrow setelah payment berhasil (Midtrans settlement).
     *
     * Idempotent: jika escrow sudah ada untuk order ini, tidak membuat yang baru.
     * Ini mencegah double-escrow jika Midtrans mengirim webhook dua kali.
     *
     * @param  Order   $order   Order yang sudah dibayar
     * @param  Payment $payment Record payment dari Midtrans
     * @return Escrow           Escrow yang dibuat atau yang sudah ada
     */
    public function holdFunds(Order $order, Payment $payment): Escrow
    {
        // Idempotency check: jika escrow sudah ada, kembalikan yang lama
        $existing = Escrow::where('order_id', $order->id)->first();
        if ($existing) {
            Log::info('[Escrow] Escrow sudah ada untuk order ini — skip hold.', [
                'order_id'  => $order->id,
                'escrow_id' => $existing->id,
                'status'    => $existing->status,
            ]);
            return $existing;
        }

        $feePercent      = $this->platformFeePercent();
        $amount          = (float) $payment->gross_amount;
        $platformFee     = round($amount * ($feePercent / 100), 2);
        $freelancerAmt   = round($amount - $platformFee, 2);

        $escrow = Escrow::create([
            'order_id'            => $order->id,
            'amount'              => $amount,
            'platform_fee'        => $platformFee,
            'freelancer_amount'   => $freelancerAmt,
            'status'              => 'held',
            'held_at'             => now(),
            'released_to_user_id' => null,
            'release_type'        => null,
        ]);

        Log::info('[Escrow] Dana berhasil ditahan (held).', [
            'order_id'          => $order->id,
            'escrow_id'         => $escrow->id,
            'amount'            => $amount,
            'platform_fee'      => $platformFee,
            'freelancer_amount' => $freelancerAmt,
        ]);

        return $escrow;
    }

    /**
     * Lepas dana escrow ke wallet freelancer setelah client manual accept.
     *
     * Dipanggil oleh: OrderController::acceptOrder()
     *
     * @param  Order  $order       Order yang di-accept client
     * @param  string $releaseType 'manual_accept' atau 'auto_complete'
     */
    public function releaseToFreelancer(Order $order, string $releaseType = 'manual_accept'): void
    {
        $escrow = Escrow::where('order_id', $order->id)
                        ->lockForUpdate()
                        ->first();

        if (! $escrow) {
            Log::error('[Escrow] Tidak ada escrow ditemukan untuk order ini.', [
                'order_id'    => $order->id,
                'release_type' => $releaseType,
            ]);
            return;
        }

        // Guard: hanya proses jika masih 'held'
        if (! $escrow->isHeld()) {
            Log::warning('[Escrow] Escrow sudah diproses sebelumnya — skip release.', [
                'order_id'  => $order->id,
                'escrow_id' => $escrow->id,
                'status'    => $escrow->status,
            ]);
            return;
        }

        $freelancer = $order->freelancer;
        $amount     = (float) $escrow->freelancer_amount;

        // Update status escrow
        $escrow->update([
            'status'              => 'released',
            'released_at'         => now(),
            'released_to_user_id' => $freelancer->id,
            'release_type'        => $releaseType,
        ]);

        // Update orders.escrow_released_at sebagai guard tambahan
        $order->update(['escrow_released_at' => now()]);

        // Credit wallet freelancer melalui WalletService (dengan ledger)
        $this->walletService->credit(
            user: $freelancer,
            amount: $amount,
            category: 'escrow_release',
            description: "Dana order #{$order->id} diterima (fee platform " . $this->platformFeePercent() . "%)",
            order: $order,
            escrow: $escrow,
        );

        Log::info('[Escrow] Dana berhasil dilepas ke freelancer.', [
            'order_id'      => $order->id,
            'escrow_id'     => $escrow->id,
            'freelancer_id' => $freelancer->id,
            'amount'        => $amount,
            'release_type'  => $releaseType,
        ]);
    }

    /**
     * Auto-release escrow ke freelancer setelah 48 jam tanpa konfirmasi client.
     *
     * Dipanggil oleh: AutoCompleteOrders command
     */
    public function autoRelease(Order $order): void
    {
        $this->releaseToFreelancer($order, 'auto_complete');
    }

    /**
     * Refund dana escrow ke wallet client karena order dibatalkan.
     *
     * Dipanggil oleh: CancelExpiredOrders command (deadline miss)
     *
     * CATATAN: Refund ke client adalah FULL amount (bukan 92%),
     * karena kesalahan ada di freelancer (gagal deadline).
     *
     * @param  Order  $order  Order yang dibatalkan
     * @param  string $reason Alasan pembatalan ('refund_deadline' atau 'refund_cancel')
     */
    public function refundToClient(Order $order, string $reason = 'refund_deadline'): void
    {
        $escrow = Escrow::where('order_id', $order->id)
                        ->lockForUpdate()
                        ->first();

        if (! $escrow) {
            Log::error('[Escrow] Tidak ada escrow ditemukan untuk refund order ini.', [
                'order_id' => $order->id,
                'reason'   => $reason,
            ]);
            return;
        }

        // Guard: hanya proses jika masih 'held'
        if (! $escrow->isHeld()) {
            Log::warning('[Escrow] Escrow sudah diproses sebelumnya — skip refund.', [
                'order_id'  => $order->id,
                'escrow_id' => $escrow->id,
                'status'    => $escrow->status,
            ]);
            return;
        }

        $client     = $order->client;
        $fullAmount = (float) $escrow->amount; // FULL refund, bukan freelancer_amount

        // Update status escrow ke refunded
        $escrow->update([
            'status'              => 'refunded',
            'refunded_at'         => now(),
            'released_to_user_id' => $client->id,
            'release_type'        => $reason,
        ]);

        // Credit wallet client melalui WalletService (dengan ledger)
        $this->walletService->credit(
            user: $client,
            amount: $fullAmount,
            category: 'refund',
            description: "Refund order #{$order->id} — " . match($reason) {
                'refund_deadline' => 'freelancer gagal memenuhi deadline',
                'refund_cancel'   => 'order dibatalkan',
                default           => $reason,
            },
            order: $order,
            escrow: $escrow,
        );

        Log::info('[Escrow] Dana berhasil direfund ke client.', [
            'order_id'  => $order->id,
            'escrow_id' => $escrow->id,
            'client_id' => $client->id,
            'amount'    => $fullAmount,
            'reason'    => $reason,
        ]);
    }
}
