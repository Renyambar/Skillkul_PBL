@extends('layouts.client')
@section('title', 'Dasbor Klien - SkillKul')
@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
    {{-- Welcome --}}
    <div class="bg-brand-primary dark:bg-brand-dark rounded-[32px] p-8 md:p-12 mb-10 relative overflow-hidden shadow-2xl dark:shadow-none transition-colors duration-300">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-white/10 dark:bg-indigo-500/10 rounded-full blur-[80px]"></div>
        
        <div class="relative z-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-3 tracking-tight">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-indigo-200 dark:text-gray-400 text-base max-w-xl font-medium leading-relaxed">Kelola pesanan Anda, temukan jasa mahasiswa berkualitas, dan pantau semua transaksi dari satu tempat.</p>
        </div>
    </div>

    {{-- Quick Actions --}}
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Akses Cepat</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <a href="{{ route('katalog') }}" class="group bg-white dark:bg-brand-darksurface rounded-3xl p-8 border border-gray-100 dark:border-brand-darkborder shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="w-14 h-14 bg-indigo-50 dark:bg-indigo-900/30 text-brand-primary dark:text-indigo-400 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-brand-primary group-hover:text-white transition-colors">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <h3 class="font-bold text-gray-900 dark:text-white mb-2 text-lg">Cari Jasa</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Temukan talent mahasiswa terbaik di Pasar Jasa SkillKul</p>
        </a>
        <a href="{{ route('pesanan.klien') }}" class="group bg-white dark:bg-brand-darksurface rounded-3xl p-8 border border-gray-100 dark:border-brand-darkborder shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="w-14 h-14 bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-green-600 group-hover:text-white transition-colors">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
            <h3 class="font-bold text-gray-900 dark:text-white mb-2 text-lg">Pesanan Saya</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Pantau status pesanan dan hasil kerja freelancer</p>
        </a>
        <a href="{{ route('profile.edit') }}" class="group bg-white dark:bg-brand-darksurface rounded-3xl p-8 border border-gray-100 dark:border-brand-darkborder shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="w-14 h-14 bg-orange-50 dark:bg-orange-900/30 text-orange-500 dark:text-orange-400 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <h3 class="font-bold text-gray-900 dark:text-white mb-2 text-lg">Profil Saya</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Kelola informasi akun dan preferensi Anda</p>
        </a>
    </div>

    {{-- Escrow Info --}}
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-100 dark:border-green-800/50 rounded-3xl p-8 flex flex-col md:flex-row items-center gap-6 shadow-sm transition-colors duration-300">
        <div class="w-16 h-16 bg-white dark:bg-green-900/40 text-green-600 dark:text-green-400 rounded-2xl flex items-center justify-center shrink-0 shadow-sm border border-green-100 dark:border-green-800/50">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
        </div>
        <div>
            <h4 class="font-extrabold text-green-800 dark:text-green-300 mb-1.5 text-lg">Transaksi Anda dilindungi Escrow</h4>
            <p class="text-sm text-green-700 dark:text-green-400 font-medium leading-relaxed">Semua pembayaran ditahan aman oleh sistem SkillKul dan baru diteruskan ke pekerja lepas setelah Anda menyetujui hasil pekerjaannya. 100% aman.</p>
        </div>
    </div>
</div>
@endsection
