@extends('layouts.app')
@section('title', 'Pasar Jasa')
@section('content')
<section class="relative bg-slate-900 py-24 px-6 overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/20 rounded-full blur-[100px]"></div>
    
    <div class="max-w-3xl mx-auto relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6 tracking-tight">Eksplorasi Talenta <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">Akademik</span></h1>
        
        <div class="bg-white/10 backdrop-blur-md p-2 rounded-2xl flex items-center shadow-2xl border border-white/20 focus-within:border-indigo-400 transition-colors">
            <div class="pl-4 text-indigo-200"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></div>
            <input type="text" placeholder="Cari jasa pembuatan web, desain UI/UX..." class="w-full bg-transparent py-3 px-4 text-white placeholder-indigo-200/70 outline-none">
            <button class="bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-3 rounded-xl font-bold transition-colors">Cari</button>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-6 md:px-12 py-16 bg-slate-50 min-h-screen">
    <div class="flex justify-between items-end mb-10">
        <div>
            <p class="text-xs font-bold text-indigo-500 tracking-widest uppercase mb-1">Pilihan Premium</p>
            <h2 class="text-2xl font-black text-slate-900">Layanan Unggulan</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <a href="#" class="group bg-white rounded-[2rem] p-4 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(79,70,229,0.1)] hover:-translate-y-1 transition-all block">
            <div class="relative h-48 rounded-2xl overflow-hidden mb-4">
                <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute top-3 left-3 bg-white/90 backdrop-blur text-indigo-700 text-[10px] font-bold px-3 py-1.5 rounded-lg uppercase tracking-wide border border-white/50 shadow-sm">
                    Bisa Nego
                </div>
            </div>
            <div class="px-2">
                <h3 class="font-bold text-slate-900 mb-3 line-clamp-2 group-hover:text-indigo-600 transition-colors">Jasa Pembuatan Landing Page Perusahaan</h3>
                <div class="flex items-center gap-3 mb-4">
                    <img src="https://i.pravatar.cc/150?img=33" class="w-6 h-6 rounded-full border border-slate-200">
                    <span class="text-xs text-slate-500 font-medium">Alex Chandra</span>
                </div>
                <div class="border-t border-slate-100 pt-4 flex justify-between items-center">
                    <p class="font-black text-slate-900 text-lg">Rp 1.500.000</p>
                    <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </div>
            </div>
        </a>
    </div>
</section>
@endsection
