<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * NotificationController
 *
 * Menangani halaman notifikasi in-app dan aksi mark-as-read.
 * Menggunakan Laravel built-in database notification system.
 */
class NotificationController extends Controller
{
    /**
     * Tampilkan semua notifikasi user (paginasi).
     */
    public function index(): View
    {
        $user          = auth()->user();
        $notifications = $user->notifications()->paginate(20);
        $unreadCount   = $user->unreadNotifications()->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Tandai satu notifikasi sebagai sudah dibaca.
     */
    public function markAsRead(string $id): RedirectResponse
    {
        $notification = auth()->user()
                             ->notifications()
                             ->where('id', $id)
                             ->first();

        if ($notification) {
            $notification->markAsRead();
        }

        // Redirect ke URL yang ada di data notifikasi jika tersedia
        $url = $notification?->data['url'] ?? route('dashboard');

        return redirect($url);
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca.
     */
    public function markAllRead(): RedirectResponse
    {
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->back()
            ->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }
}
