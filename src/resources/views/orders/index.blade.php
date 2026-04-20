@extends('layouts.client')
@section('title', 'Pesanan Saya - SkillKul')
@section('content')
@php
    // Status config sesuai enum di database schema
    $statusConfig = [
        'pending'     => ['label' => 'Menunggu Pembayaran', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
        'paid'        => ['label' => 'Dibayar', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
        'in_progress' => ['label' => 'Dalam Proses', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
        'delivered'   => ['label' => 'Terkirim', 'bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
        'completed'   => ['label' => 'Selesai', 'bg' => 'bg-green-100', 'text' => 'text-green-700'],
        'canceled'    => ['label' => 'Dibatalkan', 'bg' => 'bg-red-100', 'text' => 'text-red-700'],
    ];
    // Dummy data untuk demo UI
    $orders = [
        (object) ['id' => 'ORD-2401', 'title' => 'Pembuatan Landing Page', 'freelancer' => 'Alex Chandra', 'avatar' => 'https://i.pravatar.cc/150?img=33', 'status' => 'in_progress', 'type' => 'direct_checkout', 'total_price' => 1500000],
        (object) ['id' => 'ORD-2402', 'title' => 'Proofreading Jurnal Ilmiah', 'freelancer' => 'Dr. Elena R.', 'avatar' => 'https://i.pravatar.cc/150?img=32', 'status' => 'completed', 'type' => 'direct_checkout', 'total_price' => 150000],
        (object) ['id' => 'ORD-2403', 'title' => 'Desain Poster Acara Kampus', 'freelancer' => 'Budi Santoso', 'avatar' => 'https://i.pravatar.cc/150?img=12', 'status' => 'delivered', 'type' => 'custom_invoice', 'total_price' => 75000],
        (object) ['id' => 'ORD-2404', 'title' => 'Website Portofolio Pribadi', 'freelancer' => 'Siti Aisyah', 'avatar' => 'https://i.pravatar.cc/150?img=47', 'status' => 'pending', 'type' => 'direct_checkout', 'total_price' => 2500000],
        (object) ['id' => 'ORD-2405', 'title' => 'Script Python Automation', 'freelancer' => 'Ricky A.', 'avatar' => 'https://i.pravatar.cc/150?img=14', 'status' => 'canceled', 'type' => 'direct_checkout', 'total_price' => 300000],
    ];
@endphp

<div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-brand-dark tracking-tight">Pesanan Saya</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau status pesanan dan hasil kerja freelancer.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="bg-indigo-50 text-brand-primary text-xs font-bold px-4 py-2 rounded-lg">{{ count($orders) }} Pesanan</span>
        </div>
    </div>

    {{-- Status Filter Tabs --}}
    <div class="flex flex-wrap gap-2 mb-6">
        <button class="px-4 py-2 text-xs font-bold rounded-lg bg-brand-primary text-white">Semua</button>
        <button class="px-4 py-2 text-xs font-bold rounded-lg bg-white text-gray-600 border border-gray-200 hover:bg-gray-50">Menunggu</button>
        <button class="px-4 py-2 text-xs font-bold rounded-lg bg-white text-gray-600 border border-gray-200 hover:bg-gray-50">Dalam Proses</button>
        <button class="px-4 py-2 text-xs font-bold rounded-lg bg-white text-gray-600 border border-gray-200 hover:bg-gray-50">Terkirim</button>
        <button class="px-4 py-2 text-xs font-bold rounded-lg bg-white text-gray-600 border border-gray-200 hover:bg-gray-50">Selesai</button>
        <button class="px-4 py-2 text-xs font-bold rounded-lg bg-white text-gray-600 border border-gray-200 hover:bg-gray-50">Dibatalkan</button>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-[10px] font-extrabold text-gray-500 uppercase tracking-widest border-b border-gray-100 bg-gray-50">
                        <th class="px-6 py-4">ID Pesanan</th>
                        <th class="px-6 py-4">Layanan</th>
                        <th class="px-6 py-4">Freelancer</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($orders as $i => $o)
                    @php $st = $statusConfig[$o->status]; @endphp
                    <tr class="hover:bg-gray-50/50 transition-colors {{ $o->status === 'canceled' ? 'bg-red-50/20' : '' }}">
                        <td class="px-6 py-5 font-mono text-xs text-gray-500">#{{ $o->id }}</td>
                        <td class="px-6 py-5 font-bold text-gray-900">{{ $o->title }}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <img src="{{ $o->avatar }}" class="w-6 h-6 rounded-full">
                                <span class="text-gray-600">{{ $o->freelancer }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            @if($o->type === 'custom_invoice')
                                <span class="bg-orange-100 text-orange-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider">Invoice</span>
                            @else
                                <span class="bg-indigo-100 text-indigo-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider">Langsung</span>
                            @endif
                        </td>
                        <td class="px-6 py-5"><span class="{{ $st['bg'] }} {{ $st['text'] }} text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider">{{ $st['label'] }}</span></td>
                        <td class="px-6 py-5 font-bold text-brand-primary">Rp {{ number_format($o->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-5 text-right"><a href="{{ route('pesanan.detail', $i + 1) }}" class="text-brand-primary font-bold text-xs hover:underline">Lihat Detail →</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
