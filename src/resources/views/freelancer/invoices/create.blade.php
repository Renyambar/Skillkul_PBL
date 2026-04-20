@extends('layouts.freelancer')
@section('title', 'Buat Tagihan - SkillKul')
@section('content')
<div class="p-8 lg:p-10">
    {{-- Header --}}
    <div class="mb-8">
        <span class="inline-flex items-center gap-1.5 text-[10px] font-extrabold text-brand-primary tracking-widest uppercase mb-3">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            CUSTOM INVOICE
        </span>
        <h1 class="text-3xl font-extrabold text-brand-dark tracking-tight mb-2">Buat Tagihan Kustom</h1>
        <p class="text-gray-500 text-sm max-w-2xl">Setelah deal via WhatsApp, buat tagihan untuk klien agar dapat membayar melalui sistem pembayaran aman SkillKul.</p>
    </div>

    <div class="grid lg:grid-cols-12 gap-8">
        {{-- Form --}}
        <div class="lg:col-span-7 bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
            <form action="{{ route('freelancer.invoice.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Email Klien</label>
                    <input type="email" name="client_email" placeholder="contoh@email.com"
                        class="w-full bg-gray-50 border border-transparent focus:bg-white focus:border-brand-primary focus:ring-2 focus:ring-indigo-100 rounded-xl px-4 py-3.5 text-sm font-medium text-gray-900 transition-all outline-none">
                    <p class="text-[10px] text-gray-400 mt-2">Email harus terdaftar sebagai klien di SkillKul.</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Judul Pesanan / Scope of Work</label>
                    <input type="text" name="title" placeholder="Contoh: Pembuatan Website Portofolio"
                        class="w-full bg-gray-50 border border-transparent focus:bg-white focus:border-brand-primary focus:ring-2 focus:ring-indigo-100 rounded-xl px-4 py-3.5 text-sm font-medium text-gray-900 transition-all outline-none">
                </div>

                <div class="bg-green-50 border border-green-100 rounded-2xl p-6">
                    <label class="block text-sm font-bold text-gray-900 mb-3">Harga Kesepakatan (IDR)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-green-700">Rp</span>
                        <input type="number" name="total_price" placeholder="1000000" min="10000"
                            class="w-full bg-white border border-transparent rounded-xl pl-12 pr-4 py-3.5 text-base font-bold text-gray-900 shadow-sm focus:border-green-400 focus:ring-2 focus:ring-green-100 outline-none">
                    </div>
                    <p class="text-[10px] font-bold text-green-700 mt-3 flex items-center gap-1.5 opacity-80">ℹ️ Harga final yang telah disepakati via WhatsApp. Minimum Rp 10.000.</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Catatan / Deskripsi Pekerjaan</label>
                    <textarea name="order_notes" rows="4" placeholder="Jelaskan scope pekerjaan yang telah disepakati..."
                        class="w-full bg-gray-50 border border-transparent focus:bg-white focus:border-brand-primary focus:ring-2 focus:ring-indigo-100 rounded-xl px-5 py-4 text-sm font-medium text-gray-700 transition-all outline-none resize-none"></textarea>
                </div>

                <button type="submit" class="w-full bg-[#0b0c54] text-white py-4 rounded-xl font-bold shadow-lg hover:bg-brand-dark transition-all flex justify-center items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Generate Link Pembayaran
                </button>
            </form>
        </div>

        {{-- Right: Preview --}}
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-6">Pratinjau Tagihan</h3>
                <div class="border border-gray-100 rounded-xl p-6">
                    <div class="border-b border-gray-100 pb-4 mb-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-extrabold text-brand-dark">SkillKul Invoice</h4>
                                <p class="text-[10px] text-gray-400 mt-1">DRAFT—belum dikirim</p>
                            </div>
                            <span class="bg-yellow-100 text-yellow-700 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider">Draft</span>
                        </div>
                    </div>
                    <div class="space-y-3 text-sm mb-6">
                        <div class="flex justify-between"><span class="text-gray-500">Kepada</span><span class="font-medium text-gray-400">–</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Judul</span><span class="font-medium text-gray-400">–</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Tipe</span><span class="font-medium">Custom Invoice</span></div>
                    </div>
                    <div class="bg-[#0b0c54] text-white p-4 rounded-xl">
                        <p class="text-[10px] text-indigo-300 font-bold uppercase">Total Tagihan Escrow</p>
                        <h3 class="text-2xl font-black mt-1">Rp [...]</h3>
                    </div>
                </div>
            </div>

            {{-- Info --}}
            <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-5">
                <h4 class="text-sm font-bold text-brand-dark mb-2">Bagaimana Cara Kerjanya?</h4>
                <ol class="text-[11px] text-gray-600 leading-relaxed space-y-2 list-decimal list-inside">
                    <li>Anda membuat tagihan setelah deal harga via WA</li>
                    <li>Sistem mengirim link pembayaran ke email klien</li>
                    <li>Klien membayar via Midtrans, dana masuk escrow</li>
                    <li>Anda kerjakan, kirim hasil, klien konfirmasi</li>
                    <li>Dana cair ke dompet Anda</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
