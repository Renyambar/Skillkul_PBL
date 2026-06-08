@extends('layouts.client')
@section('title', 'Profil Pekerja Lepas - SkillKul')
@section('content')
<div class="max-w-5xl mx-auto px-6 lg:px-8 py-10">
    {{-- Profile Header --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mb-6">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
            <img src="https://i.pravatar.cc/150?img=33" alt="Avatar" class="w-24 h-24 rounded-full object-cover border-4 border-indigo-100 shadow-lg">
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-2xl font-extrabold text-brand-dark">Alex Chandra</h1>
                <p class="text-gray-500 text-sm mb-2">Mahasiswa Ilmu Komputer • Universitas Indonesia</p>
                <div class="flex flex-wrap justify-center md:justify-start gap-3 mb-3">
                    <span class="bg-green-100 text-green-700 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider">✓ Terverifikasi</span>
                    <span class="flex items-center gap-1 text-sm text-yellow-500 font-bold">★ 4.9 <span class="text-gray-400 font-normal text-xs">(128 ulasan)</span></span>
                </div>
                <p class="text-sm text-gray-600 leading-relaxed max-w-lg">Full-stack developer dengan spesialisasi React, Next.js, dan Laravel. Fokus pada performa tinggi dan kode bersih. Skor Lighthouse selalu 90+.</p>
            </div>
            <a href="https://wa.me/6281234567890" class="bg-green-500 text-white px-5 py-3 rounded-xl text-sm font-bold hover:bg-green-600 transition-all flex items-center gap-2 shadow-lg shrink-0">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                Hubungi via WA
            </a>
        </div>
    </div>

    {{-- Skills --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
        <h3 class="font-bold text-brand-dark mb-4">Keahlian</h3>
        <div class="flex flex-wrap gap-2">
            <span class="bg-indigo-50 text-brand-primary text-xs font-bold px-3 py-1.5 rounded-lg">React.js</span>
            <span class="bg-indigo-50 text-brand-primary text-xs font-bold px-3 py-1.5 rounded-lg">Next.js</span>
            <span class="bg-indigo-50 text-brand-primary text-xs font-bold px-3 py-1.5 rounded-lg">Laravel</span>
            <span class="bg-indigo-50 text-brand-primary text-xs font-bold px-3 py-1.5 rounded-lg">PostgreSQL</span>
            <span class="bg-indigo-50 text-brand-primary text-xs font-bold px-3 py-1.5 rounded-lg">Tailwind CSS</span>
            <span class="bg-indigo-50 text-brand-primary text-xs font-bold px-3 py-1.5 rounded-lg">REST API</span>
        </div>
    </div>

    {{-- Services by this freelancer --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
        <h3 class="font-bold text-brand-dark mb-4">Layanan yang Ditawarkan</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('jasa.detail', 1) }}" class="group flex gap-4 p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">
                <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=200&q=80" class="w-20 h-16 rounded-lg object-cover">
                <div>
                    <h4 class="font-bold text-sm text-gray-900 group-hover:text-brand-primary transition-colors line-clamp-1">Pembuatan Landing Page</h4>
                    <p class="text-xs text-gray-500 mt-0.5">IDR 1,500,000</p>
                    <span class="text-[10px] bg-green-100 text-green-700 font-bold px-2 py-0.5 rounded mt-1 inline-block">Harga Pas</span>
                </div>
            </a>
            <a href="{{ route('jasa.detail', 3) }}" class="group flex gap-4 p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">
                <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=200&q=80" class="w-20 h-16 rounded-lg object-cover">
                <div>
                    <h4 class="font-bold text-sm text-gray-900 group-hover:text-brand-primary transition-colors line-clamp-1">Aplikasi Web Enterprise</h4>
                    <p class="text-xs text-gray-500 mt-0.5">Mulai IDR 1,000,000</p>
                    <span class="text-[10px] bg-orange-100 text-orange-700 font-bold px-2 py-0.5 rounded mt-1 inline-block">Bisa Nego</span>
                </div>
            </a>
        </div>
    </div>

    {{-- Reviews --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-brand-dark mb-4">Ulasan dari Klien</h3>
        <div class="space-y-4">
            <div class="border border-gray-100 rounded-xl p-4">
                <div class="flex gap-1 text-yellow-400 mb-2 text-sm">★★★★★</div>
                <p class="text-sm text-gray-600 leading-relaxed mb-3">"Alex sangat responsif dan hasil kerjanya melampaui ekspektasi. Landing page yang dibuatnya memiliki performa sangat tinggi."</p>
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 bg-brand-primary rounded-full flex items-center justify-center text-white text-[9px] font-bold">BS</div>
                    <span class="text-xs text-gray-500 font-medium">Budi Santoso • 5 hari lalu</span>
                </div>
            </div>
            <div class="border border-gray-100 rounded-xl p-4">
                <div class="flex gap-1 text-yellow-400 mb-2 text-sm">★★★★★</div>
                <p class="text-sm text-gray-600 leading-relaxed mb-3">"Kualitas kode sangat bersih dan well-documented. Sangat recommended untuk proyek web development."</p>
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 bg-green-600 rounded-full flex items-center justify-center text-white text-[9px] font-bold">SA</div>
                    <span class="text-xs text-gray-500 font-medium">Siti Aisyah • 1 minggu lalu</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
