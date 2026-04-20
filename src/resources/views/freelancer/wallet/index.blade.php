@extends('layouts.freelancer')
@section('title', 'Dompet - SkillKul')
@section('content')
<div class="p-8 lg:p-10">
    <h1 class="text-2xl font-extrabold text-brand-dark tracking-tight mb-8">Pendapatan & Dompet</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-brand-primary to-[#2a0e88] rounded-2xl p-6 text-white shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>
            <p class="text-indigo-200 text-[10px] font-extrabold uppercase tracking-widest mb-2">SALDO TERSEDIA</p>
            <h2 class="text-3xl font-extrabold mb-4">Rp 2.890.000</h2>
            <button class="bg-brand-accent text-brand-dark px-6 py-2.5 rounded-xl text-xs font-bold hover:bg-green-300 transition-colors shadow-lg">Tarik ke Bank</button>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">TOTAL PENDAPATAN</p>
            <h3 class="text-2xl font-extrabold text-brand-dark mb-1">Rp 12.450.000</h3>
            <p class="text-xs text-gray-500">Sejak bergabung</p>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">SEDANG DITAHAN (ESCROW)</p>
            <h3 class="text-2xl font-extrabold text-orange-500 mb-1">Rp 1.250.000</h3>
            <p class="text-xs text-gray-500">Dari 2 pesanan aktif</p>
        </div>
    </div>

    {{-- Transaction History --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-extrabold text-brand-dark text-lg mb-6">Riwayat Transaksi</h3>
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest border-b border-gray-100">
                    <th class="pb-3">Tanggal</th>
                    <th class="pb-3">Keterangan</th>
                    <th class="pb-3">Tipe</th>
                    <th class="pb-3 text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <tr>
                    <td class="py-4 text-gray-500 text-xs">19 Apr 2024</td>
                    <td class="py-4 font-semibold text-gray-900">Pembayaran - Tutoring Data Science</td>
                    <td class="py-4"><span class="bg-green-100 text-green-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase">Masuk</span></td>
                    <td class="py-4 text-right font-bold text-green-600">+ Rp 500.000</td>
                </tr>
                <tr>
                    <td class="py-4 text-gray-500 text-xs">17 Apr 2024</td>
                    <td class="py-4 font-semibold text-gray-900">Penarikan ke BCA ****4821</td>
                    <td class="py-4"><span class="bg-red-100 text-red-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase">Keluar</span></td>
                    <td class="py-4 text-right font-bold text-red-500">- Rp 2.000.000</td>
                </tr>
                <tr>
                    <td class="py-4 text-gray-500 text-xs">15 Apr 2024</td>
                    <td class="py-4 font-semibold text-gray-900">Pembayaran - Re-desain Logo</td>
                    <td class="py-4"><span class="bg-green-100 text-green-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase">Masuk</span></td>
                    <td class="py-4 text-right font-bold text-green-600">+ Rp 1.500.000</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
