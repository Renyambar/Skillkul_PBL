@extends('layouts.app')
@section('title', 'Verifikasi Mahasiswa')
@section('content')
<div class="min-h-screen bg-brand-light dark:bg-brand-darkbg relative overflow-hidden flex items-center mt-16 transition-colors duration-300">
    <!-- Brand aesthetic background elements -->
    <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] rounded-full bg-indigo-300/20 dark:bg-indigo-900/20 blur-[100px] mix-blend-multiply dark:mix-blend-lighten pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-5%] w-[400px] h-[400px] rounded-full bg-brand-primary/10 dark:bg-indigo-500/10 blur-[100px] mix-blend-multiply dark:mix-blend-lighten pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 py-12 grid lg:grid-cols-12 gap-16 relative z-10 w-full">
        <div class="lg:col-span-5 flex flex-col justify-center">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800/50 text-brand-primary dark:text-indigo-400 text-xs font-black tracking-widest uppercase mb-6 backdrop-blur-md w-max shadow-sm">
                <span class="w-2 h-2 rounded-full bg-brand-primary dark:bg-indigo-400 animate-pulse"></span> Pendaftaran Mahasiswa
            </span>
            <h1 class="text-4xl lg:text-5xl font-extrabold text-brand-primary dark:text-white leading-[1.15] tracking-tight mb-6">
                Langkah Terakhir:<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-primary to-indigo-500 dark:from-indigo-400 dark:to-purple-400">Verifikasi Akademik.</span>
            </h1>
            <p class="text-gray-600 dark:text-gray-400 text-base font-medium leading-relaxed mb-8">Validasi status kemahasiswaan Anda untuk membuka fitur eksklusif: perlindungan Escrow 100%, akses ke proyek klien, dan mode anti-overwork (Mode Ujian).</p>
            
            <div class="space-y-4">
                <div class="flex items-center gap-4 bg-white/80 dark:bg-brand-darksurface/80 p-5 rounded-2xl border border-white dark:border-gray-800 backdrop-blur-md shadow-sm transition-colors">
                    <div class="bg-brand-primary dark:bg-indigo-600 text-white p-3 rounded-xl shadow-inner"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
                    <div><h4 class="font-black text-brand-primary dark:text-white text-sm">Lencana Terverifikasi</h4><p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Tingkatkan konversi klien hingga 3x lipat.</p></div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7">
            <div class="bg-white/90 dark:bg-brand-darksurface/90 backdrop-blur-xl p-8 lg:p-10 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-brand-darkborder transition-colors">
                <form action="{{ route('onboarding.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-extrabold text-brand-secondary dark:text-gray-400 uppercase tracking-widest mb-2">Nama Universitas</label>
                        <input type="text" name="university_name" placeholder="Contoh: Universitas Gadjah Mada" class="w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 focus:bg-white dark:focus:bg-brand-darksurface focus:border-brand-primary dark:focus:border-indigo-500 focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-900/50 rounded-2xl px-5 py-4 text-sm font-medium text-gray-900 dark:text-white transition-all outline-none">
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] font-extrabold text-brand-secondary dark:text-gray-400 uppercase tracking-widest mb-2">Program Studi (Opsional)</label>
                            <input type="text" name="major" placeholder="Contoh: Teknik Informatika" class="w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 focus:bg-white dark:focus:bg-brand-darksurface focus:border-brand-primary dark:focus:border-indigo-500 focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-900/50 rounded-2xl px-5 py-4 text-sm font-medium text-gray-900 dark:text-white transition-all outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] font-extrabold text-brand-secondary dark:text-gray-400 uppercase tracking-widest mb-2">Target Lulus (Tahun)</label>
                            <input type="number" name="graduation_year" placeholder="Contoh: 2026" class="w-full bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 focus:bg-white dark:focus:bg-brand-darksurface focus:border-brand-primary dark:focus:border-indigo-500 focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-900/50 rounded-2xl px-5 py-4 text-sm font-medium text-gray-900 dark:text-white transition-all outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-extrabold text-brand-secondary dark:text-gray-400 uppercase tracking-widest mb-2">Kartu Tanda Mahasiswa (KTM)</label>
                        <div class="relative group border-2 border-dashed border-indigo-200 dark:border-gray-700 hover:border-brand-primary dark:hover:border-indigo-500 bg-indigo-50/50 dark:bg-gray-800/30 hover:bg-brand-light/50 dark:hover:bg-gray-800/50 rounded-[2rem] p-10 text-center transition-all cursor-pointer">
                            <input type="file" name="ktm_file" class="w-full h-full opacity-0 absolute inset-0 cursor-pointer z-10" accept="image/*,.pdf">
                            <div class="bg-white dark:bg-gray-800 text-brand-primary dark:text-indigo-400 w-14 h-14 rounded-2xl shadow-sm border border-indigo-50 dark:border-gray-700 flex items-center justify-center mx-auto mb-4 group-hover:-translate-y-1 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            </div>
                            <h4 class="text-sm font-black text-brand-primary dark:text-white mb-1">Seret & Lepas file KTM di sini</h4>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 mt-1">Mendukung format JPG, PNG, PDF (Maks. 5MB)</p>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-brand-primary dark:bg-indigo-600 text-white py-4 rounded-2xl font-black shadow-lg shadow-indigo-900/10 dark:shadow-indigo-900/20 hover:bg-brand-dark dark:hover:bg-indigo-700 hover:-translate-y-0.5 transition-all focus:outline-none focus:ring-4 focus:ring-indigo-100 dark:focus:ring-indigo-900 flex justify-center items-center gap-2">
                        Verifikasi Akun Saya <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
