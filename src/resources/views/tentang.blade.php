@extends('layouts.public')
@section('title', 'Tentang Kami - SkillKul')
@section('content')
    {{-- Hero --}}
    <section class="bg-brand-primary py-24 px-6 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <span class="inline-block bg-white/10 text-white px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-6 border border-white/10">Tentang Kami</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-6">Membangun Jembatan Antara<br>Akademis & Industri</h1>
            <p class="text-indigo-200 text-lg max-w-2xl mx-auto leading-relaxed">SkillKul adalah platform eksklusif yang menghubungkan mahasiswa bertalenta dengan klien yang membutuhkan jasa profesional berkualitas tinggi.</p>
        </div>
    </section>

    {{-- Visi Misi --}}
    <section class="max-w-6xl mx-auto px-6 py-20">
        <div class="grid md:grid-cols-2 gap-16">
            <div class="bg-white rounded-3xl p-10 shadow-sm border border-gray-100">
                <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
                <h3 class="text-2xl font-extrabold text-brand-primary mb-4">Visi Kami</h3>
                <p class="text-gray-600 leading-relaxed">Menjadi platform terdepan di Indonesia yang memberdayakan mahasiswa untuk membangun karier profesional dan portofolio nyata sejak masa perkuliahan, serta menjadi jembatan terpercaya antara dunia akademis dan industri.</p>
            </div>
            <div class="bg-white rounded-3xl p-10 shadow-sm border border-gray-100">
                <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                </div>
                <h3 class="text-2xl font-extrabold text-brand-primary mb-4">Misi Kami</h3>
                <ul class="text-gray-600 leading-relaxed space-y-3">
                    <li class="flex items-start gap-2"><span class="text-brand-accent font-bold mt-0.5">✓</span> Menyediakan marketplace jasa mahasiswa yang aman dengan sistem escrow</li>
                    <li class="flex items-start gap-2"><span class="text-brand-accent font-bold mt-0.5">✓</span> Memverifikasi identitas akademik untuk menjamin kualitas layanan</li>
                    <li class="flex items-start gap-2"><span class="text-brand-accent font-bold mt-0.5">✓</span> Membantu mahasiswa membangun portofolio profesional secara otomatis</li>
                    <li class="flex items-start gap-2"><span class="text-brand-accent font-bold mt-0.5">✓</span> Menciptakan lingkungan kerja yang adil dan transparan bagi semua pihak</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Cara Kerja --}}
    <section class="bg-white py-20 px-6">
        <div class="max-w-4xl mx-auto text-center mb-16">
            <h2 class="text-3xl font-extrabold text-brand-primary tracking-tight mb-4">Cara Kerja SkillKul</h2>
            <p class="text-gray-500">Proses sederhana yang menghubungkan kebutuhan klien dengan keahlian mahasiswa</p>
        </div>
        <div class="max-w-5xl mx-auto grid md:grid-cols-3 gap-10">
            <div class="text-center">
                <div class="w-16 h-16 bg-brand-primary text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-extrabold shadow-lg shadow-indigo-900/20">1</div>
                <h4 class="text-lg font-bold text-brand-dark mb-2">Klien Cari Jasa</h4>
                <p class="text-sm text-gray-500 leading-relaxed">Temukan jasa mahasiswa melalui Pasar Jasa SkillKul dengan filter kategori dan harga.</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-brand-primary text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-extrabold shadow-lg shadow-indigo-900/20">2</div>
                <h4 class="text-lg font-bold text-brand-dark mb-2">Pesan & Bayar Aman</h4>
                <p class="text-sm text-gray-500 leading-relaxed">Dana Anda ditahan aman di sistem escrow SkillKul sampai pekerjaan selesai.</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-brand-primary text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-extrabold shadow-lg shadow-indigo-900/20">3</div>
                <h4 class="text-lg font-bold text-brand-dark mb-2">Terima & Review</h4>
                <p class="text-sm text-gray-500 leading-relaxed">Konfirmasi hasil kerja, berikan review, dan dana otomatis diteruskan ke freelancer.</p>
            </div>
        </div>
    </section>
@endsection
