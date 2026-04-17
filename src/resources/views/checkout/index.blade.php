@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-6 lg:px-12">
        <h1 class="text-3xl font-extrabold text-slate-900 mb-8">Penyelesaian Pesanan</h1>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <div class="lg:col-span-7 space-y-6">
                <div class="bg-white rounded-[2rem] border border-slate-100 p-8 shadow-sm">
                    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                        <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg></div>
                        <div>
                            <h3 class="font-bold text-lg text-slate-900">Aplikasi Web Tingkat Enterprise</h3>
                            <p class="text-xs text-slate-500">Oleh: Alex Chandra</p>
                        </div>
                    </div>

                    <form id="payment-form" action="{{ route('checkout.process', $order->id ?? 1) }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-slate-900 mb-2">Instruksi Khusus untuk Freelancer</label>
                            <textarea name="order_notes" rows="4" class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:border-indigo-500 rounded-2xl px-4 py-3 text-sm outline-none transition-all" required></textarea>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="bg-white rounded-[2.5rem] border border-slate-100 p-8 shadow-[0_20px_40px_rgb(0,0,0,0.04)] sticky top-28">
                    <h3 class="font-bold text-xl text-slate-900 mb-6">Ringkasan Tagihan</h3>
                    
                    <div class="space-y-4 mb-6 border-b border-slate-100 pb-6 text-sm">
                        <div class="flex justify-between text-slate-600"><span>Subtotal Layanan</span><span class="font-bold text-slate-900">Rp 1.000.000</span></div>
                        <div class="flex justify-between text-slate-600"><span>Biaya Layanan & Escrow</span><span class="font-bold text-slate-900">Rp 50.000</span></div>
                    </div>

                    <div class="flex justify-between items-center mb-8">
                        <span class="font-bold text-slate-500">Total Pembayaran</span>
                        <span class="font-black text-3xl text-slate-900">Rp 1.050.000</span>
                    </div>

                    <div class="bg-emerald-50 rounded-2xl p-4 border border-emerald-100 mb-6 flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <div>
                            <h4 class="text-sm font-bold text-emerald-900 mb-0.5">Transaksi Dilindungi Escrow</h4>
                            <p class="text-[10px] text-emerald-700 leading-relaxed">Dana Anda ditahan aman oleh SkillKul dan baru cair setelah Anda menyetujui hasil kerja.</p>
                        </div>
                    </div>

                    <button onclick="document.getElementById('payment-form').submit()" class="w-full bg-slate-900 hover:bg-indigo-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-500/20 transition-all flex justify-center items-center gap-2">
                        Pilih Metode Pembayaran <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    
                    <div class="mt-6 flex justify-center opacity-50 grayscale"><img src="https://midtrans.com/images/midtrans-logo-color.svg" class="h-5"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
