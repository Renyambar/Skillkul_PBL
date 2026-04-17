@extends('layouts.app')
@section('title', 'Profil Mahasiswa')
@section('content')
<main class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-6 lg:px-12">
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-[0_20px_40px_rgb(0,0,0,0.02)] p-8 lg:p-12 mb-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-bl from-indigo-100 to-transparent opacity-60 rounded-bl-full pointer-events-none"></div>
            
            <div class="flex flex-col md:flex-row gap-8 items-center md:items-start relative z-10">
                <div class="w-32 h-32 rounded-[2rem] overflow-hidden shadow-lg shrink-0 rotate-3 hover:rotate-0 transition-transform">
                    <img src="https://i.pravatar.cc/150?img=33" class="w-full h-full object-cover">
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mb-2">Alex Chandra</h1>
                    <h2 class="text-sm font-bold text-indigo-600 mb-4 bg-indigo-50 px-3 py-1 rounded-lg inline-block">D4 Teknik Informatika • Polinema</h2>
                    <p class="text-sm text-slate-600 leading-relaxed mb-6 max-w-2xl">"Full-Stack Developer yang berfokus pada arsitektur kode bersih menggunakan Laravel 11 dan Tailwind CSS."</p>
                    
                    <div class="flex flex-wrap justify-center md:justify-start gap-3">
                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-100 px-3 py-1.5 rounded-xl text-xs font-bold flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Mahasiswa Terverifikasi
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="text-xl font-extrabold text-slate-900 mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            Auto-Portfolio
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-4 group">
                <div class="h-48 bg-slate-200 rounded-2xl overflow-hidden relative mb-4">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                </div>
                <div class="px-2 pb-2">
                    <h4 class="font-bold text-slate-900">Dashboard Analitik FinTech</h4>
                    <p class="text-xs text-slate-500 mt-1">Diselesaikan melalui SkillKul dengan Rating 5 Bintang</p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
