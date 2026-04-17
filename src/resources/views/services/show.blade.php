@extends('layouts.app')
@section('title', 'Detail Jasa')
@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 grid grid-cols-1 lg:grid-cols-12 gap-12">
        
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white p-8 lg:p-10 rounded-[2.5rem] shadow-[0_2px_20px_rgb(0,0,0,0.02)] border border-slate-100">
                <div class="flex items-center gap-3 mb-6">
                    <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide uppercase">Pengembangan Web</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight mb-8">Aplikasi Web Tingkat Enterprise Kustom dengan Arsitektur Terukur</h1>
                
                <div class="aspect-[16/9] bg-slate-100 rounded-3xl overflow-hidden mb-8 border border-slate-100">
                    <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c" class="w-full h-full object-cover">
                </div>

                <div class="prose prose-slate max-w-none">
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Tentang Layanan Ini</h3>
                    <p class="text-slate-600 leading-relaxed">Saya berspesialisasi dalam membangun aplikasi web yang kompleks dan berperforma tinggi. Kami berfokus pada kode yang bersih, keamanan yang tangguh, dan performa optimal (skor Lighthouse 90+).</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 relative">
            <div class="sticky top-28 bg-white rounded-[2rem] border border-slate-100 shadow-[0_20px_40px_rgb(0,0,0,0.04)] p-8 overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none"></div>

                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Estimasi Investasi</p>
                <h2 class="text-4xl font-extrabold text-slate-900 mb-6">Rp 1.000.000</h2>

                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 mb-8 space-y-3">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="text-sm font-medium text-slate-700">Perlindungan Escrow 100%</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-sm font-medium text-slate-700">Pengerjaan ~14 Hari</span>
                    </div>
                </div>

                <a href="https://wa.me/081234" class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-sm font-bold rounded-2xl text-white bg-[#25D366] hover:bg-[#1EBE57] shadow-lg shadow-green-500/30 transition-all overflow-hidden">
                    <div class="absolute inset-0 w-full h-full bg-white/20 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-500"></div>
                    <span class="relative flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        Konsultasi via WhatsApp
                    </span>
                </a>
                <p class="text-center text-[10px] text-slate-400 mt-4 font-medium">Link Custom Invoice akan dikirim ke Anda setelah harga disepakati.</p>
            </div>
        </div>
    </div>
</div>
@endsection
