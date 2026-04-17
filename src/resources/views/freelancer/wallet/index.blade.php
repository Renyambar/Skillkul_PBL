@extends('layouts.app')
@section('title', 'Dompet Escrow')
@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-6">
        <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-8">Pusat Keuangan</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-gradient-to-br from-slate-900 to-indigo-950 rounded-[2rem] p-8 text-white shadow-2xl shadow-indigo-900/20 relative overflow-hidden flex flex-col justify-between h-56">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-500/30 rounded-full blur-3xl"></div>
                
                <div class="relative z-10 flex justify-between items-center">
                    <p class="text-xs font-bold text-indigo-200 uppercase tracking-widest">Saldo Tersedia</p>
                    <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                </div>
                
                <div class="relative z-10 flex justify-between items-end">
                    <h2 class="text-4xl font-black">Rp 2.890.000</h2>
                    <button class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white px-5 py-2.5 rounded-xl font-bold text-sm transition-all">Tarik Dana</button>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-8 flex flex-col justify-center">
                <div class="flex items-center gap-2 text-yellow-600 mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <p class="text-xs font-bold uppercase tracking-widest">Dana Tertahan Escrow</p>
                </div>
                <h3 class="text-3xl font-extrabold text-slate-900 mb-2">Rp 1.500.000</h3>
                <p class="text-xs text-slate-500 leading-relaxed border-t border-slate-50 pt-3 mt-2">Dana aman. Otomatis cair ke Saldo Tersedia ketika klien mengonfirmasi pesanan "Selesai".</p>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 md:p-8 border-b border-slate-50">
                <h3 class="font-bold text-slate-900 text-lg">Riwayat Mutasi</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <tbody class="text-sm divide-y divide-slate-50">
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="py-5 px-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg></div>
                                    <div>
                                        <p class="font-bold text-slate-900">Pencairan Escrow</p>
                                        <p class="text-xs text-slate-500">Klien: Budi Santoso</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-8 text-right">
                                <span class="font-black text-green-600 text-base">+ Rp 1.000.000</span>
                                <p class="text-[10px] text-slate-400 mt-1">15 Apr 2026</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
