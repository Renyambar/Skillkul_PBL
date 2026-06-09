@extends('layouts.public')
@section('title', 'Pusat Keamanan - SkillKul')
@section('content')
    {{-- Hero --}}
    <section class="bg-gradient-to-br from-brand-dark to-brand-primary dark:from-brand-dark dark:to-indigo-900 py-24 px-6 relative overflow-hidden transition-colors duration-300">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="absolute top-0 right-1/3 w-96 h-96 bg-green-500/20 rounded-full blur-[100px]"></div>
        
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <div class="w-24 h-24 bg-white/10 dark:bg-green-900/40 rounded-full flex items-center justify-center mx-auto mb-8 border border-white/20 dark:border-green-500/30 backdrop-blur-md shadow-xl">
                <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight mb-6">Pusat Keamanan SkillKul</h1>
            <p class="text-indigo-200 text-lg max-w-2xl mx-auto leading-relaxed font-medium">Keamanan transaksi dan data Anda adalah prioritas utama kami. Pelajari bagaimana cara SkillKul melindungi setiap pihak yang terlibat.</p>
        </div>
    </section>

    {{-- Security Features --}}
    <section class="max-w-6xl mx-auto px-6 py-24">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-brand-darksurface rounded-[2.5rem] p-10 shadow-sm border border-gray-100 dark:border-brand-darkborder hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                <div class="w-16 h-16 bg-green-50 dark:bg-green-900/30 rounded-2xl flex items-center justify-center mb-8 border border-green-100 dark:border-green-900">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="text-2xl font-extrabold text-brand-dark dark:text-white mb-4">Sistem Rekening Bersama (Escrow)</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed font-medium">Dana klien ditahan dengan aman di rekening penampungan SkillKul. Pekerja lepas (freelancer) baru akan menerima dana setelah klien mengonfirmasi hasil pekerjaan sesuai kesepakatan.</p>
            </div>
            <div class="bg-white dark:bg-brand-darksurface rounded-[2.5rem] p-10 shadow-sm border border-gray-100 dark:border-brand-darkborder hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                <div class="w-16 h-16 bg-indigo-50 dark:bg-indigo-900/30 rounded-2xl flex items-center justify-center mb-8 border border-indigo-100 dark:border-indigo-900">
                    <svg class="w-8 h-8 text-brand-primary dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                </div>
                <h3 class="text-2xl font-extrabold text-brand-dark dark:text-white mb-4">Verifikasi KTM</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed font-medium">Setiap pekerja lepas (freelancer) wajib memverifikasi Kartu Tanda Mahasiswa (KTM) mereka sebelum dapat menawarkan layanan. Admin akan memvalidasi data identitas secara manual.</p>
            </div>
            <div class="bg-white dark:bg-brand-darksurface rounded-[2.5rem] p-10 shadow-sm border border-gray-100 dark:border-brand-darkborder hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                <div class="w-16 h-16 bg-orange-50 dark:bg-orange-900/30 rounded-2xl flex items-center justify-center mb-8 border border-orange-100 dark:border-orange-900">
                    <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"></path></svg>
                </div>
                <h3 class="text-2xl font-extrabold text-brand-dark dark:text-white mb-4">Proteksi Data</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed font-medium">Data pribadi, keuangan, dan dokumen KTM Anda dienkripsi dan disimpan sesuai dengan standar keamanan industri. Kami tidak akan pernah menjual data Anda kepada pihak ketiga.</p>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="bg-gray-50 dark:bg-brand-darkbg py-24 px-6 border-t border-gray-100 dark:border-brand-darkborder transition-colors duration-300">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-4xl font-extrabold text-brand-dark dark:text-white tracking-tight mb-16 text-center">Pertanyaan Umum</h2>
            <div class="space-y-6">
                <div class="bg-white dark:bg-brand-darksurface border border-gray-100 dark:border-brand-darkborder rounded-3xl p-8 shadow-sm">
                    <h4 class="text-xl font-extrabold text-brand-dark dark:text-white mb-3">Apakah dana saya aman jika pekerja lepas (freelancer) tidak mengerjakan pesanan?</h4>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed font-medium">Ya, sistem rekening bersama (escrow) memastikan dana Anda tidak akan diteruskan ke pekerja lepas (freelancer) jika pekerjaan belum diselesaikan. Anda dapat mengajukan pengembalian dana melalui admin.</p>
                </div>
                <div class="bg-white dark:bg-brand-darksurface border border-gray-100 dark:border-brand-darkborder rounded-3xl p-8 shadow-sm">
                    <h4 class="text-xl font-extrabold text-brand-dark dark:text-white mb-3">Bagaimana proses verifikasi mahasiswa?</h4>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed font-medium">Pekerja lepas (freelancer) wajib mengunggah foto KTM, NIM, nama universitas, dan jurusan. Admin akan memverifikasi data dalam 1-3 hari kerja sebelum akun pekerja lepas (freelancer) tersebut dapat menawarkan layanan.</p>
                </div>
                <div class="bg-white dark:bg-brand-darksurface border border-gray-100 dark:border-brand-darkborder rounded-3xl p-8 shadow-sm">
                    <h4 class="text-xl font-extrabold text-brand-dark dark:text-white mb-3">Bagaimana jika ada sengketa antara klien dan pekerja lepas (freelancer)?</h4>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed font-medium">Tim SkillKul akan menengahi sengketa dan membuat keputusan berdasarkan bukti komunikasi serta hasil pekerjaan. Dana di rekening bersama (escrow) dilindungi sepenuhnya selama proses mediasi berlangsung.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
