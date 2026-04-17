@extends('layouts.app')
@section('title', 'Detail Pesanan')
@section('content')
<main class="bg-slate-50 min-h-screen py-10 px-6 lg:px-12">
    <div class="max-w-5xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 flex items-center gap-3">
                Pesanan #ORD-982A1B 
                <span class="bg-indigo-100 text-indigo-700 text-xs px-3 py-1 rounded-lg font-bold uppercase tracking-wider">Terkirim</span>
            </h1>
        </div>

        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] p-8 md:p-10">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-16 h-16 bg-slate-100 rounded-2xl overflow-hidden shrink-0"><img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c" class="w-full h-full object-cover"></div>
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Aplikasi Web Tingkat Enterprise Kustom</h2>
                    <p class="text-sm text-slate-500">Freelancer: Alex Chandra</p>
                </div>
            </div>

            <div class="bg-emerald-50 rounded-[2rem] border border-emerald-100 p-8 mt-6 relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-emerald-200/50 rounded-full blur-3xl pointer-events-none"></div>
                <h2 class="text-xl font-extrabold text-emerald-900 mb-2 relative z-10">Freelancer Telah Mengirimkan Hasil!</h2>
                <p class="text-sm text-emerald-700 mb-6 relative z-10">Silakan tinjau file hasil pekerjaan. Jika sesuai, setujui pesanan untuk mencairkan dana Escrow.</p>
                
                <a href="{{ $order->freelancer_result_link }}" target="_blank" class="inline-flex items-center gap-2 bg-white text-emerald-800 px-5 py-3 rounded-xl text-sm font-bold shadow-sm border border-emerald-100 mb-6 hover:bg-emerald-100 transition-colors relative z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Download Hasil Kerja (G-Drive)
                </a>
                
                <button onclick="document.getElementById('reviewModal').classList.remove('hidden')" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-600/20 transition-all relative z-10">
                    Setujui Hasil & Cairkan Dana Escrow
                </button>
            </div>
        </div>
    </div>
</main>

<div id="reviewModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[100] flex items-center justify-center p-4 transition-all">
    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md p-8 relative">
        <button onclick="document.getElementById('reviewModal').classList.add('hidden')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <h3 class="text-2xl font-extrabold text-slate-900 mb-2">Penilaian Pesanan</h3>
        <p class="text-sm text-slate-500 mb-6">Penilaian Anda memicu pembuatan Auto-Portfolio untuk mahasiswa ini.</p>
        
        <form action="{{ route('orders.review', $order->id ?? 1) }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-bold text-slate-900 mb-2">Rating Bintang (1-5)</label>
                <input type="number" name="rating" min="1" max="5" value="5" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 focus:border-indigo-500 focus:bg-white outline-none transition-colors" required>
            </div>
            
            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-900 mb-2">Ulasan Konstruktif</label>
                <textarea name="comment" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 focus:border-indigo-500 focus:bg-white outline-none transition-colors resize-none" placeholder="Pekerjaannya luar biasa..."></textarea>
            </div>
            
            <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold shadow-lg hover:bg-indigo-600 transition-colors">Selesai & Kirim Ulasan</button>
        </form>
    </div>
</div>
@endsection
