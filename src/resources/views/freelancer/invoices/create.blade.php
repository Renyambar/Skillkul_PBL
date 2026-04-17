@extends('layouts.app')
@section('title', 'Buat Custom Invoice')
@section('content')
<main class="bg-slate-50 min-h-screen py-10 px-6">
    <div class="max-w-5xl mx-auto">
        <h2 class="text-3xl font-extrabold text-slate-900 mb-8">Buat Tagihan (Invoice)</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-7 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <form action="{{ route('invoices.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Email Klien (Validasi Akun)</label>
                        <input type="email" name="client_email" class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:border-indigo-500 rounded-2xl px-4 py-3.5 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Harga Kesepakatan (Rp)</label>
                        <input type="number" name="total_price" class="w-full bg-emerald-50 border border-emerald-200 focus:bg-white focus:border-emerald-500 rounded-2xl px-4 py-3.5 font-bold text-lg outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Catatan Scope of Work</label>
                        <textarea name="order_notes" rows="4" class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:border-indigo-500 rounded-2xl px-4 py-3.5 text-sm outline-none transition-all resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold shadow-lg hover:bg-indigo-600 transition-all">Generate Link Pembayaran</button>
                </form>
            </div>
            
            <div class="lg:col-span-5">
                <div class="bg-slate-100 rounded-[2.5rem] p-8 border border-slate-200 border-dashed">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">Preview Tagihan</h3>
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="border-b border-slate-100 pb-4 mb-4">
                            <h4 class="font-extrabold text-slate-900">SkillKul Invoice</h4>
                            <p class="text-[10px] text-slate-500">DRAFT-001</p>
                        </div>
                        <div class="bg-slate-900 text-white p-4 rounded-xl mt-6">
                            <p class="text-[10px] text-indigo-300 font-bold uppercase">Total Tagihan Escrow</p>
                            <h3 class="text-2xl font-black mt-1">Rp [...]</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
