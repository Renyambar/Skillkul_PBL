@extends('layouts.public')
@section('title', 'Pasar Jasa SkillKul')
@section('content')
{{-- Hero Search --}}
<section class="relative bg-brand-primary py-20 px-6 overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/10 rounded-full blur-[100px]"></div>
    <div class="max-w-4xl mx-auto relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-8 tracking-tight">Apa yang kamu cari,<br>Mahasiswa?</h1>

        {{-- Search Form --}}
        <form method="GET" action="{{ route('katalog') }}" class="mb-6">
            <div class="bg-white/10 backdrop-blur-md p-2 rounded-2xl flex items-center shadow-2xl">
                <div class="pl-4 text-white/70"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari jasa programming, desain, atau proofreading..." class="w-full bg-transparent py-4 px-4 text-white placeholder-white/50 outline-none font-medium">
                <button type="submit" class="bg-brand-secondary hover:bg-brand-accent hover:text-brand-dark text-white px-8 py-3.5 rounded-xl font-bold transition-colors shadow-lg whitespace-nowrap">Temukan</button>
            </div>

            {{-- Filter Dropdown --}}
            <div class="flex flex-wrap justify-center gap-3 mt-6">
                <a href="{{ route('katalog') }}" class="px-5 py-2 rounded-full {{ !request('type') ? 'bg-white text-brand-primary' : 'border border-white/20 bg-white/5 text-white hover:bg-white/20' }} text-sm font-semibold transition-colors">
                    🔍 Semua Tipe
                </a>
                <a href="{{ route('katalog', ['type' => 'non_project', 'search' => request('search')]) }}" class="px-5 py-2 rounded-full {{ request('type') == 'non_project' ? 'bg-white text-green-700' : 'border border-white/20 bg-white/5 text-white hover:bg-white/20' }} text-sm font-semibold transition-colors flex items-center gap-1.5">
                    💰 Non-Project (Harga Pas)
                </a>
                <a href="{{ route('katalog', ['type' => 'project', 'search' => request('search')]) }}" class="px-5 py-2 rounded-full {{ request('type') == 'project' ? 'bg-white text-orange-700' : 'border border-white/20 bg-white/5 text-white hover:bg-white/20' }} text-sm font-semibold transition-colors flex items-center gap-1.5">
                    🤝 Project (Bisa Nego)
                </a>
            </div>
        </form>

        {{-- Category Pills --}}
        <div class="flex flex-wrap justify-center gap-3">
            <a href="#" class="px-5 py-2 rounded-full border border-white/20 bg-white/5 text-white text-sm font-semibold hover:bg-white/20 transition-colors flex items-center gap-1.5">
                <span class="text-xs">🖥</span> Pemrograman
            </a>
            <a href="#" class="px-5 py-2 rounded-full border border-white/20 bg-white/5 text-white text-sm font-semibold hover:bg-white/20 transition-colors flex items-center gap-1.5">
                <span class="text-xs">🎨</span> Desain
            </a>
            <a href="#" class="px-5 py-2 rounded-full border border-white/20 bg-white/5 text-white text-sm font-semibold hover:bg-white/20 transition-colors flex items-center gap-1.5">
                <span class="text-xs">✏️</span> Penulisan
            </a>
            <a href="#" class="px-5 py-2 rounded-full border border-white/20 bg-white/5 text-white text-sm font-semibold hover:bg-white/20 transition-colors flex items-center gap-1.5">
                <span class="text-xs">📊</span> Matematika/Statistik
            </a>
            <a href="#" class="px-5 py-2 rounded-full border border-white/20 bg-white/5 text-white text-sm font-semibold hover:bg-white/20 transition-colors flex items-center gap-1.5">
                <span class="text-xs">🎬</span> Video Editing
            </a>
        </div>
    </div>
</section>

{{-- Featured Services --}}
<section class="max-w-7xl mx-auto px-6 md:px-12 py-14">
    <div class="flex justify-between items-end mb-8">
        <div>
            <p class="text-xs font-extrabold text-brand-secondary tracking-widest uppercase mb-1">PILIHAN PREMIUM</p>
            <h2 class="text-2xl font-black text-brand-dark tracking-tight">Layanan Unggulan</h2>
        </div>
        <span class="text-sm text-gray-400 font-semibold">Menampilkan 6 jasa</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7 mb-14">
        {{-- Card 1: Non-Project --}}
        <a href="{{ route('jasa.detail', 1) }}" class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all block">
            <div class="relative h-44 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute top-3 left-3 bg-green-500 text-white text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider shadow">Harga Pas</div>
            </div>
            <div class="p-5">
                <h3 class="font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-brand-primary transition-colors">Jasa Pembuatan Landing Page Perusahaan</h3>
                <div class="flex items-center gap-2 mb-4">
                    <img src="https://i.pravatar.cc/150?img=33" class="w-6 h-6 rounded-full">
                    <span class="text-xs text-gray-500 font-medium">@alex_creative</span>
                    <span class="flex items-center gap-0.5 text-yellow-500 text-xs ml-auto">★ <span class="text-gray-600 font-bold">4.8</span></span>
                </div>
                <div class="flex justify-between items-center border-t border-gray-50 pt-3">
                    <p class="font-extrabold text-brand-primary">Rp 1.500.000</p>
                    <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-brand-primary group-hover:text-white text-gray-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>
            </div>
        </a>
        {{-- Card 2: Non-Project --}}
        <a href="{{ route('jasa.detail', 2) }}" class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all block">
            <div class="relative h-44 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1586281380349-632531db7ed4?auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute top-3 left-3 bg-green-500 text-white text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider shadow">Harga Pas</div>
            </div>
            <div class="p-5">
                <h3 class="font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-brand-primary transition-colors">Proofreading Jurnal Ilmiah</h3>
                <div class="flex items-center gap-2 mb-4">
                    <img src="https://i.pravatar.cc/150?img=47" class="w-6 h-6 rounded-full">
                    <span class="text-xs text-gray-500 font-medium">@sarah_edits</span>
                    <span class="flex items-center gap-0.5 text-yellow-500 text-xs ml-auto">★ <span class="text-gray-600 font-bold">4.9</span></span>
                </div>
                <div class="flex justify-between items-center border-t border-gray-50 pt-3">
                    <p class="font-extrabold text-brand-primary">Rp 50.000</p>
                    <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-brand-primary group-hover:text-white text-gray-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>
            </div>
        </a>
        {{-- Card 3: Project --}}
        <a href="{{ route('jasa.detail', 3) }}" class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all block">
            <div class="relative h-44 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute top-3 left-3 bg-orange-500 text-white text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider shadow">Bisa Nego</div>
            </div>
            <div class="p-5">
                <h3 class="font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-brand-primary transition-colors">Jasa Desain Poster Organisasi</h3>
                <div class="flex items-center gap-2 mb-4">
                    <img src="https://i.pravatar.cc/150?img=12" class="w-6 h-6 rounded-full">
                    <span class="text-xs text-gray-500 font-medium">@ricky_arts</span>
                    <span class="flex items-center gap-0.5 text-yellow-500 text-xs ml-auto">★ <span class="text-gray-600 font-bold">4.7</span></span>
                </div>
                <div class="flex justify-between items-center border-t border-gray-50 pt-3">
                    <p class="font-extrabold text-brand-primary">Rp 75.000</p>
                    <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-brand-primary group-hover:text-white text-gray-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>
            </div>
        </a>
        {{-- Card 4: Non-Project --}}
        <a href="{{ route('jasa.detail', 4) }}" class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all block">
            <div class="relative h-44 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute top-3 left-3 bg-green-500 text-white text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider shadow">Harga Pas</div>
            </div>
            <div class="p-5">
                <h3 class="font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-brand-primary transition-colors">Analisis Data Excel & Pivot Table</h3>
                <div class="flex items-center gap-2 mb-4">
                    <img src="https://i.pravatar.cc/150?img=14" class="w-6 h-6 rounded-full">
                    <span class="text-xs text-gray-500 font-medium">@data_wizard</span>
                    <span class="flex items-center gap-0.5 text-yellow-500 text-xs ml-auto">★ <span class="text-gray-600 font-bold">4.6</span></span>
                </div>
                <div class="flex justify-between items-center border-t border-gray-50 pt-3">
                    <p class="font-extrabold text-brand-primary">Rp 200.000</p>
                    <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-brand-primary group-hover:text-white text-gray-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>
            </div>
        </a>
        {{-- Card 5: Project --}}
        <a href="{{ route('jasa.detail', 5) }}" class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all block">
            <div class="relative h-44 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1611532736597-de2d4265fba3?auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute top-3 left-3 bg-orange-500 text-white text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider shadow">Bisa Nego</div>
            </div>
            <div class="p-5">
                <h3 class="font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-brand-primary transition-colors">Editing Video YouTube & Reels</h3>
                <div class="flex items-center gap-2 mb-4">
                    <img src="https://i.pravatar.cc/150?img=22" class="w-6 h-6 rounded-full">
                    <span class="text-xs text-gray-500 font-medium">@media_pro</span>
                    <span class="flex items-center gap-0.5 text-yellow-500 text-xs ml-auto">★ <span class="text-gray-600 font-bold">4.5</span></span>
                </div>
                <div class="flex justify-between items-center border-t border-gray-50 pt-3">
                    <p class="font-extrabold text-brand-primary">Rp 350.000</p>
                    <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-brand-primary group-hover:text-white text-gray-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>
            </div>
        </a>
        {{-- Card 6: Non-Project --}}
        <a href="{{ route('jasa.detail', 6) }}" class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all block">
            <div class="relative h-44 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute top-3 left-3 bg-green-500 text-white text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider shadow">Harga Pas</div>
            </div>
            <div class="p-5">
                <h3 class="font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-brand-primary transition-colors">Jasa Penerjemahan Inggris-Indonesia</h3>
                <div class="flex items-center gap-2 mb-4">
                    <img src="https://i.pravatar.cc/150?img=45" class="w-6 h-6 rounded-full">
                    <span class="text-xs text-gray-500 font-medium">@lingua_id</span>
                    <span class="flex items-center gap-0.5 text-yellow-500 text-xs ml-auto">★ <span class="text-gray-600 font-bold">4.9</span></span>
                </div>
                <div class="flex justify-between items-center border-t border-gray-50 pt-3">
                    <p class="font-extrabold text-brand-primary">Rp 30.000</p>
                    <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-brand-primary group-hover:text-white text-gray-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>
            </div>
        </a>
    </div>

    {{-- Escrow Trust Banner --}}
    <div class="bg-indigo-50 border border-indigo-100 rounded-3xl p-8 mb-8">
        <div class="flex items-start gap-5">
            <div class="w-14 h-14 bg-indigo-100 text-brand-primary rounded-2xl flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <div>
                <span class="inline-block bg-brand-primary/10 text-brand-primary text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-widest mb-3">Sistem Escrow SkillKul</span>
                <h3 class="text-xl font-extrabold text-brand-dark mb-2">Uangmu aman sampai tugas selesai!</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">Kami menahan dana Anda di sistem escrow yang aman. Pembayaran baru akan diteruskan ke freelancer hanya setelah Anda menyetujui hasil kerjanya.</p>
                <div class="flex gap-3">
                    <a href="{{ route('keamanan') }}" class="bg-brand-primary text-white px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-brand-dark transition-all">Pelajari Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Auto Portfolio Section --}}
    <div class="bg-brand-primary rounded-3xl p-8 md:p-10 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
        <div class="flex flex-col md:flex-row items-center gap-10 relative z-10">
            <div class="flex-1">
                <span class="inline-flex items-center gap-1.5 bg-white/10 text-white px-3 py-1 rounded-full text-[10px] font-extrabold tracking-widest uppercase mb-4 border border-white/10">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"></path></svg>
                    FITUR POWERED BY AI
                </span>
                <h3 class="text-2xl font-extrabold text-white mb-3">Pembuatan Portofolio Otomatis</h3>
                <p class="text-indigo-200 text-sm leading-relaxed mb-6">Selesaikan tugas, bangun masa depan. Setiap proyek yang selesai dan mendapat rating ≥ 4 bintang akan otomatis tercatat sebagai portofolio profesional yang terverifikasi.</p>
                <ul class="space-y-2 mb-6">
                    <li class="flex items-center gap-2 text-sm text-indigo-100"><span class="text-brand-accent">✦</span> Integrasi Ulasan Terverifikasi</li>
                    <li class="flex items-center gap-2 text-sm text-indigo-100"><span class="text-brand-accent">✦</span> Generate PDF Portofolio Otomatis</li>
                    <li class="flex items-center gap-2 text-sm text-indigo-100"><span class="text-brand-accent">✦</span> Ekspor ke LinkedIn/CV</li>
                </ul>
                <button class="bg-brand-accent text-brand-dark px-6 py-3 rounded-xl text-sm font-bold hover:bg-green-300 transition-colors shadow-lg">Aktifkan Auto-Portfolio</button>
            </div>
            <div class="w-full md:w-80 bg-white/10 rounded-2xl p-6 backdrop-blur-sm border border-white/10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-brand-secondary rounded-full flex items-center justify-center text-white text-xs font-bold">JD</div>
                    <div>
                        <p class="text-white text-sm font-bold">John Doe</p>
                        <p class="text-indigo-300 text-[10px]">Mahasiswa Ilmu Komputer</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="w-full h-3 bg-white/10 rounded"></div>
                    <div class="w-3/4 h-3 bg-white/10 rounded"></div>
                    <div class="w-1/2 h-3 bg-white/10 rounded"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
