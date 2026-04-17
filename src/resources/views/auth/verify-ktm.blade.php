@extends('layouts.app')
@section('title', 'Verifikasi Mahasiswa')
@section('content')
<div class="min-h-screen bg-slate-50 relative overflow-hidden flex items-center">
    <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] rounded-full bg-indigo-300/30 blur-[100px] mix-blend-multiply pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-5%] w-[400px] h-[400px] rounded-full bg-purple-300/30 blur-[100px] mix-blend-multiply pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 py-12 grid lg:grid-cols-12 gap-16 relative z-10 w-full">
        <div class="lg:col-span-5 flex flex-col justify-center">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-100/50 text-indigo-700 text-xs font-bold tracking-widest uppercase mb-6 border border-indigo-200 backdrop-blur-md w-max">
                <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span> Pendaftaran Mahasiswa
            </span>
            <h1 class="text-4xl lg:text-5xl font-extrabold text-slate-900 leading-[1.15] tracking-tight mb-6">
                Ubah Kemampuan Akademik Jadi <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Peluang Nyata.</span>
            </h1>
            <p class="text-slate-600 text-base leading-relaxed mb-8">Validasi status kemahasiswaan Anda untuk membuka fitur eksklusif: Escrow payment, portofolio AI, dan mode anti-overwork.</p>
            
            <div class="space-y-4">
                <div class="flex items-center gap-4 bg-white/60 p-4 rounded-2xl border border-white backdrop-blur-md shadow-sm">
                    <div class="bg-indigo-500 text-white p-2.5 rounded-xl"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
                    <div><h4 class="font-bold text-slate-900 text-sm">Lencana Terverifikasi</h4><p class="text-xs text-slate-500">Tingkatkan konversi klien hingga 3x lipat.</p></div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7">
            <div class="bg-white/80 backdrop-blur-xl p-8 lg:p-10 rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white">
                <form action="{{ route('verify.ktm.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">Nama Lengkap (Sesuai KTM)</label>
                            <input type="text" name="name" class="w-full bg-slate-50/50 border border-slate-200 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl px-4 py-3.5 text-sm transition-all outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">Nomor Induk Mahasiswa</label>
                            <input type="text" name="nim" class="w-full bg-slate-50/50 border border-slate-200 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl px-4 py-3.5 text-sm transition-all outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">Unggah Identitas (KTM)</label>
                        <div class="relative group border-2 border-dashed border-indigo-200 hover:border-indigo-500 bg-indigo-50/30 hover:bg-indigo-50/80 rounded-[2rem] p-10 text-center transition-all cursor-pointer">
                            <input type="file" name="ktm_file" class="w-full h-full opacity-0 absolute inset-0 cursor-pointer z-10">
                            <div class="bg-white text-indigo-600 w-14 h-14 rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-4 group-hover:-translate-y-1 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            </div>
                            <h4 class="text-sm font-bold text-slate-900">Seret & Lepas file KTM di sini</h4>
                            <p class="text-xs text-slate-500 mt-1">Mendukung format JPG, PNG, PDF (Maks. 5MB)</p>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold shadow-lg shadow-slate-900/20 hover:bg-slate-800 hover:-translate-y-0.5 transition-all">
                        Kirim & Verifikasi Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
