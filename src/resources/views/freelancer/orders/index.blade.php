@extends('layouts.freelancer')
@section('title', 'Pesanan Masuk - SkillKul')
@section('content')
@php
    $statusConfig = [
        'pending'     => ['label' => 'Menunggu Pembayaran', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
        'paid'        => ['label' => 'Dibayar', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
        'in_progress' => ['label' => 'Dalam Proses', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
        'delivered'   => ['label' => 'Terkirim', 'bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
        'completed'   => ['label' => 'Selesai', 'bg' => 'bg-green-100', 'text' => 'text-green-700'],
        'canceled'    => ['label' => 'Dibatalkan', 'bg' => 'bg-red-100', 'text' => 'text-red-700'],
    ];
    $orders = [
        (object) ['title' => 'Tutoring Data Science', 'client' => 'Michael Chen', 'type' => 'non_project', 'status' => 'in_progress', 'price' => 500000],
        (object) ['title' => 'Prototipe Web App', 'client' => 'Loomis Co.', 'type' => 'project', 'status' => 'delivered', 'price' => 3200000],
        (object) ['title' => 'Scripting Python Automation', 'client' => 'Sarah J.', 'type' => 'non_project', 'status' => 'in_progress', 'price' => 750000],
        (object) ['title' => 'Re-desain Logo Startup', 'client' => 'Andi W.', 'type' => 'project', 'status' => 'completed', 'price' => 1500000],
    ];
@endphp

<div class="p-8 lg:p-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-brand-dark tracking-tight mb-1">Pesanan Masuk</h1>
            <p class="text-sm text-gray-500">Kelola pesanan dari klien dan kirim hasil pekerjaan.</p>
        </div>
        <a href="{{ route('freelancer.invoice.create') }}" class="inline-flex items-center gap-2 bg-brand-primary hover:bg-brand-dark text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Buat Tagihan Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest border-b border-gray-100 bg-gray-50">
                        <th class="px-6 py-4">Nama Layanan</th>
                        <th class="px-6 py-4">Klien</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Nilai</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($orders as $o)
                    @php $st = $statusConfig[$o->status]; @endphp
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-5 font-semibold text-gray-900">{{ $o->title }}</td>
                        <td class="px-6 py-5 text-gray-600">{{ $o->client }}</td>
                        <td class="px-6 py-5">
                            @if($o->type === 'project')
                                <span class="bg-orange-100 text-orange-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase">Project</span>
                            @else
                                <span class="bg-green-100 text-green-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase">Non-Project</span>
                            @endif
                        </td>
                        <td class="px-6 py-5"><span class="{{ $st['bg'] }} {{ $st['text'] }} text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider">{{ $st['label'] }}</span></td>
                        <td class="px-6 py-5 font-bold text-brand-primary">Rp {{ number_format($o->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-5 text-right">
                            @if($o->status === 'in_progress')
                                {{-- Tombol Kirim Tugas dengan modal expand --}}
                                <div x-data="{ open: false }">
                                    <button @click="open = !open" class="bg-brand-primary text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-brand-dark transition-all">Kirim Tugas</button>
                                    <div x-show="open" x-transition class="mt-3 bg-indigo-50 rounded-xl p-4 border border-indigo-100 text-left">
                                        <label class="block text-[10px] font-extrabold text-brand-secondary uppercase tracking-widest mb-2">Link Hasil Kerja (Google Drive)</label>
                                        <input type="url" placeholder="https://drive.google.com/..." class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-brand-primary mb-2">
                                        <button class="w-full bg-green-600 text-white py-2 rounded-lg text-xs font-bold hover:bg-green-700 transition-all">Kirim Hasil</button>
                                    </div>
                                </div>
                            @elseif($o->status === 'delivered')
                                <span class="text-purple-600 text-xs font-bold">📦 Menunggu Review</span>
                            @elseif($o->status === 'completed')
                                <span class="text-green-600 text-xs font-bold">✓ Selesai</span>
                            @else
                                <span class="text-gray-400 text-xs font-medium">–</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
