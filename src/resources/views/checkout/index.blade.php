@extends('layouts.client')
@section('title', 'Checkout & Pembayaran - SkillKul')
@section('content')
<div class="max-w-6xl mx-auto px-6 lg:px-12 py-10">
    <span class="inline-flex items-center gap-1.5 text-[10px] font-extrabold text-brand-primary tracking-widest uppercase mb-4">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        CHECKOUT AMAN
    </span>
    <h1 class="text-2xl md:text-3xl font-extrabold text-brand-dark tracking-tight mb-8">Proyek Kustom: Pengembangan Web – Penawaran Khusus</h1>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        {{-- Left: Order Details --}}
        <div class="lg:col-span-7 space-y-6">
            {{-- Deliverables Card --}}
            <div class="bg-[#080c35] rounded-2xl p-8 text-white">
                <div class="space-y-4 mb-6">
                    <div class="flex items-center gap-3 bg-white/5 rounded-xl p-4 border border-white/10">
                        <div class="w-5 h-5 rounded bg-brand-primary flex items-center justify-center shrink-0"><svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div>
                        <div>
                            <p class="text-sm font-bold">Front-End</p>
                            <p class="text-[10px] text-indigo-300">Est. 5 halaman UI/UX responsif custom design</p>
                        </div>
                        <svg class="w-4 h-4 text-indigo-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div class="flex items-center gap-3 bg-white/5 rounded-xl p-4 border border-white/10">
                        <div class="w-5 h-5 rounded bg-white/10 flex items-center justify-center shrink-0"><span class="text-xs text-indigo-300">☐</span></div>
                        <div>
                            <p class="text-sm font-bold">Back-End</p>
                            <p class="text-[10px] text-indigo-300">API, Database, Authentication</p>
                        </div>
                        <svg class="w-4 h-4 text-indigo-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div class="flex items-center gap-3 bg-white/5 rounded-xl p-4 border border-white/10">
                        <div class="w-5 h-5 rounded bg-white/10 flex items-center justify-center shrink-0"><span class="text-xs text-indigo-300">☐</span></div>
                        <div>
                            <p class="text-sm font-bold">BotTrinity</p>
                            <p class="text-[10px] text-indigo-300">Miku Zero Point</p>
                        </div>
                        <div class="ml-auto text-[10px] text-indigo-300 bg-white/5 px-2 py-1 rounded flex items-center gap-1">✓</div>
                    </div>
                </div>
                <div class="h-1 bg-brand-primary rounded-full w-3/4 mb-2"></div>
            </div>

            {{-- Project Info --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-8 h-8 bg-brand-primary rounded-lg flex items-center justify-center text-white"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg></div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-900">Portal Akademik Entrepreneur</h4>
                        <span class="text-[10px] font-extrabold text-brand-primary tracking-wider uppercase">BERBASIS PROYEK</span>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Aplikasi web full-stack dengan integrasi pembayaran aman dan dashboard mahasiswa.</p>
            </div>

            {{-- Payment Method --}}
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-900">Metode Pembayaran</h3>
                    <span class="text-[10px] text-gray-400 font-semibold flex items-center gap-1">DIDUKUNG OLEH <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/Midtrans_Logo.svg/320px-Midtrans_Logo.svg.png" class="h-3 opacity-60"></span>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <button class="bg-white rounded-xl p-4 border-2 border-brand-primary text-center shadow-sm">
                        <div class="w-10 h-10 mx-auto mb-2 bg-indigo-50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-brand-primary">QRIS</span>
                    </button>
                    <button class="bg-white rounded-xl p-4 border border-gray-100 text-center hover:border-gray-300 transition-colors">
                        <div class="w-10 h-10 mx-auto mb-2 bg-gray-50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-600">Transfer Bank</span>
                    </button>
                    <button class="bg-white rounded-xl p-4 border border-gray-100 text-center hover:border-gray-300 transition-colors">
                        <div class="w-10 h-10 mx-auto mb-2 bg-gray-50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-600">E-Wallet</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Right: Summary --}}
        <div class="lg:col-span-5">
            <div class="sticky top-24 bg-white rounded-2xl border border-gray-100 p-8 shadow-xl">
                <h3 class="font-extrabold text-lg text-brand-dark mb-6">Ringkasan Pesanan</h3>
                <div class="space-y-3 mb-6 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span class="font-bold">IDR 1,200,000</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Biaya Admin (5%)</span><span class="font-bold">IDR 60,000</span></div>
                    <div class="border-t border-gray-100 pt-3 flex justify-between">
                        <span class="font-extrabold text-brand-dark">Total</span>
                        <span class="font-extrabold text-xl text-brand-primary">IDR 1,260,000</span>
                    </div>
                </div>

                <div class="bg-green-50 border border-green-100 rounded-xl p-4 mb-6 flex items-start gap-3">
                    <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center shrink-0 mt-0.5"><svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div>
                    <div>
                        <h4 class="text-sm font-bold text-green-800">Jaminan Escrow</h4>
                        <p class="text-[10px] text-green-700 leading-relaxed">Seluruh biaya di tahan Escrow SkillKul. Freelancer baru akan menerima pembayaran setelah Anda menyetujui hasil kerja.</p>
                    </div>
                </div>

                <form action="{{ route('checkout.process', 1) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-xl shadow-lg transition-all flex justify-center items-center gap-2">
                        Bayar Sekarang <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>

                <p class="text-center text-[10px] text-gray-400 mt-4 uppercase tracking-wider font-semibold">Pembayaran aman via Midtrans ID 120..41°</p>

                <div class="mt-6 pt-4 border-t border-gray-100 flex items-center gap-2 text-gray-400 text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span>Penjual Akademik Terverifikasi</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
