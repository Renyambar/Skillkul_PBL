@extends('layouts.public')
@section('title', 'Tentang Kami - SkillKul')
@section('content')
    {{-- Hero --}}
    <section class="bg-brand-primary dark:bg-brand-darksurface py-24 px-6 relative overflow-hidden transition-colors duration-300">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-purple-500/20 rounded-full blur-[100px]"></div>
        
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <span class="inline-block bg-white/10 dark:bg-indigo-900/50 text-white px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-6 border border-white/10 dark:border-indigo-800">Tentang Kami</span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight mb-6 leading-tight">Membangun Jembatan Antara<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-200 to-purple-200">Akademis & Industri</span></h1>
            <p class="text-indigo-200 dark:text-gray-300 text-lg max-w-2xl mx-auto leading-relaxed font-medium">SkillKul adalah platform eksklusif yang menghubungkan mahasiswa bertalenta dengan klien yang membutuhkan jasa profesional berkualitas tinggi.</p>
        </div>
    </section>

    {{-- Visi Misi --}}
    <section class="max-w-6xl mx-auto px-6 py-24">
        <div class="grid md:grid-cols-2 gap-12">
            <div class="bg-white dark:bg-brand-darksurface rounded-[2.5rem] p-10 md:p-12 shadow-sm border border-gray-100 dark:border-brand-darkborder hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-indigo-50 dark:bg-indigo-900/30 rounded-2xl flex items-center justify-center mb-8">
                    <svg class="w-8 h-8 text-brand-primary dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
                <h3 class="text-3xl font-extrabold text-brand-dark dark:text-white mb-6">Visi Kami</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-lg font-medium">Menjadi platform terdepan di Indonesia yang memberdayakan mahasiswa untuk membangun karier profesional dan portofolio nyata sejak masa perkuliahan, serta menjadi jembatan terpercaya antara dunia akademis dan industri.</p>
            </div>
            <div class="bg-white dark:bg-brand-darksurface rounded-[2.5rem] p-10 md:p-12 shadow-sm border border-gray-100 dark:border-brand-darkborder hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-green-50 dark:bg-green-900/30 rounded-2xl flex items-center justify-center mb-8">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                </div>
                <h3 class="text-3xl font-extrabold text-brand-dark dark:text-white mb-6">Misi Kami</h3>
                <ul class="text-gray-600 dark:text-gray-400 leading-relaxed space-y-4 text-lg font-medium">
                    <li class="flex items-start gap-3"><span class="text-brand-accent dark:text-green-400 font-bold mt-1">✓</span> Menyediakan pasar jasa mahasiswa yang aman dengan sistem escrow</li>
                    <li class="flex items-start gap-3"><span class="text-brand-accent dark:text-green-400 font-bold mt-1">✓</span> Memverifikasi identitas akademik untuk menjamin kualitas layanan</li>
                    <li class="flex items-start gap-3"><span class="text-brand-accent dark:text-green-400 font-bold mt-1">✓</span> Membantu mahasiswa membangun portofolio profesional secara otomatis</li>
                    <li class="flex items-start gap-3"><span class="text-brand-accent dark:text-green-400 font-bold mt-1">✓</span> Menciptakan lingkungan kerja yang adil dan transparan bagi semua pihak</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Cara Kerja --}}
    <section class="bg-gray-50 dark:bg-gray-800/30 py-24 px-6 border-t border-gray-100 dark:border-gray-800 transition-colors duration-300">
        <div class="max-w-4xl mx-auto text-center mb-20">
            <h2 class="text-4xl font-extrabold text-brand-dark dark:text-white tracking-tight mb-4">Cara Kerja SkillKul</h2>
            <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">Proses sederhana yang menghubungkan kebutuhan klien dengan keahlian mahasiswa</p>
        </div>
        <div class="max-w-5xl mx-auto grid md:grid-cols-3 gap-12">
            <div class="text-center group">
                <div class="w-20 h-20 bg-white dark:bg-gray-800 text-brand-primary dark:text-indigo-400 border border-gray-100 dark:border-gray-700 rounded-3xl flex items-center justify-center mx-auto mb-8 text-3xl font-extrabold shadow-lg shadow-gray-200/50 dark:shadow-none group-hover:scale-110 transition-transform duration-300">1</div>
                <h4 class="text-xl font-extrabold text-brand-dark dark:text-white mb-4">Klien Cari Jasa</h4>
                <p class="text-gray-500 dark:text-gray-400 leading-relaxed font-medium">Temukan jasa mahasiswa melalui Pasar Jasa SkillKul dengan filter kategori dan harga yang sesuai anggaran.</p>
            </div>
            <div class="text-center group">
                <div class="w-20 h-20 bg-white dark:bg-gray-800 text-brand-primary dark:text-indigo-400 border border-gray-100 dark:border-gray-700 rounded-3xl flex items-center justify-center mx-auto mb-8 text-3xl font-extrabold shadow-lg shadow-gray-200/50 dark:shadow-none group-hover:scale-110 transition-transform duration-300">2</div>
                <h4 class="text-xl font-extrabold text-brand-dark dark:text-white mb-4">Pesan & Bayar Aman</h4>
                <p class="text-gray-500 dark:text-gray-400 leading-relaxed font-medium">Dana Anda ditahan aman di sistem escrow terintegrasi Midtrans sampai pekerjaan diselesaikan dengan baik.</p>
            </div>
            <div class="text-center group">
                <div class="w-20 h-20 bg-white dark:bg-gray-800 text-brand-primary dark:text-indigo-400 border border-gray-100 dark:border-gray-700 rounded-3xl flex items-center justify-center mx-auto mb-8 text-3xl font-extrabold shadow-lg shadow-gray-200/50 dark:shadow-none group-hover:scale-110 transition-transform duration-300">3</div>
                <h4 class="text-xl font-extrabold text-brand-dark dark:text-white mb-4">Terima & Ulas</h4>
                <p class="text-gray-500 dark:text-gray-400 leading-relaxed font-medium">Konfirmasi hasil kerja, berikan ulasan positif, dan dana otomatis diteruskan ke akun pekerja lepas.</p>
            </div>
        </div>
    </section>
@endsection
