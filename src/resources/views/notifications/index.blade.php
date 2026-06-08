@extends(auth()->check() && auth()->user()->role === 'freelancer' ? 'layouts.freelancer' : 'layouts.client')
@section('title', 'Notifikasi - SkillKul')
@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Notifikasi</h1>
            @if($unreadCount > 0)
                <p class="text-sm text-indigo-600 font-medium mt-0.5">{{ $unreadCount }} belum dibaca</p>
            @else
                <p class="text-sm text-gray-500 mt-0.5">Semua sudah dibaca</p>
            @endif
        </div>
        @if($unreadCount > 0)
            <form action="{{ route('notifikasi.readAll') }}" method="POST">
                @csrf
                <button type="submit"
                    class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold hover:underline">
                    Tandai semua dibaca
                </button>
            </form>
        @endif
    </div>

    @if($notifications->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <h4 class="text-base font-bold text-gray-900 mb-1">Tidak ada notifikasi</h4>
            <p class="text-sm text-gray-500">Notifikasi transaksi dan order akan muncul di sini.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($notifications as $notif)
            @php
                $data = $notif->data;
                $isUnread = is_null($notif->read_at);
                $iconMap = [
                    'payment_success'      => ['🎉', 'bg-green-50 text-green-600'],
                    'payment_failed'       => ['❌', 'bg-red-50 text-red-600'],
                    'escrow_held'          => ['🔒', 'bg-indigo-50 text-indigo-600'],
                    'freelancer_submit'    => ['📦', 'bg-blue-50 text-blue-600'],
                    'order_completed'      => ['✅', 'bg-green-50 text-green-600'],
                    'auto_complete'        => ['⏰', 'bg-purple-50 text-purple-600'],
                    'deadline_reminder'    => ['⏰', 'bg-yellow-50 text-yellow-600'],
                    'deadline_missed'      => ['⚠️', 'bg-red-50 text-red-600'],
                    'refund_generated'     => ['💰', 'bg-emerald-50 text-emerald-600'],
                    'withdrawal_requested' => ['💸', 'bg-orange-50 text-orange-600'],
                    'withdrawal_approved'  => ['✅', 'bg-blue-50 text-blue-600'],
                    'withdrawal_rejected'  => ['❌', 'bg-red-50 text-red-600'],
                    'withdrawal_completed' => ['🎉', 'bg-green-50 text-green-600'],
                ];
                $icon = $iconMap[$data['type'] ?? ''] ?? ['🔔', 'bg-gray-50 text-gray-600'];
            @endphp
            <div class="bg-white rounded-2xl border {{ $isUnread ? 'border-indigo-200 shadow-md' : 'border-gray-100 shadow-sm' }} p-4 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-4">
                    {{-- Icon --}}
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg flex-shrink-0 {{ $icon[1] }}">
                        {{ $icon[0] }}
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="text-sm font-bold text-gray-900 {{ $isUnread ? '' : 'font-semibold' }}">
                                    {{ $data['title'] ?? 'Notifikasi' }}
                                    @if($isUnread)
                                        <span class="ml-1.5 inline-block w-2 h-2 bg-indigo-500 rounded-full"></span>
                                    @endif
                                </p>
                                <p class="text-sm text-gray-600 mt-0.5 leading-relaxed">{{ $data['message'] ?? '' }}</p>
                            </div>
                            <span class="text-xs text-gray-400 whitespace-nowrap flex-shrink-0">
                                {{ $notif->created_at->diffForHumans() }}
                            </span>
                        </div>

                        {{-- Action --}}
                        @if(!empty($data['url']))
                        <div class="mt-2">
                            <form action="{{ route('notifikasi.read', $notif->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold hover:underline">
                                    Lihat Detail →
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($notifications->hasPages())
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
        @endif
    @endif
</div>
@endsection
