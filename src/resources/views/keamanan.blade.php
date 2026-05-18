@extends('layouts.public')
@section('title', 'Pusat Keamanan - SkillKul')
@section('content')
    {{-- Hero --}}
    <section class="bg-[#1f2178] py-24 px-6 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <div class="w-20 h-20 bg-green-400/20 rounded-full flex items-center justify-center mx-auto mb-8 border border-green-400/30">
                <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-6">Pusat Keamanan SkillKul</h1>
            <p class="text-indigo-200 text-lg max-w-2xl mx-auto leading-relaxed">Keamanan transaksi dan data Anda adalah prioritas utama kami. Pelajari bagaimana SkillKul melindungi setiap pihak.</p>
        </div>
    </section>

    {{-- Security Features --}}
    <section class="max-w-6xl mx-auto px-6 py-20">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center mb-6 border border-green-100">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="text-xl font-extrabold text-brand-primary mb-3">Sistem Escrow</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Dana klien ditahan aman di rekening penampungan SkillKul. Freelancer hanya menerima dana setelah klien mengonfirmasi hasil pekerjaan sesuai kesepakatan.</p>
            </div>
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center mb-6 border border-indigo-100">
                    <svg class="w-7 h-7 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                </div>
                <h3 class="text-xl font-extrabold text-brand-primary mb-3">Verifikasi KTM</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Setiap freelancer wajib memverifikasi Kartu Tanda Mahasiswa (KTM) mereka sebelum dapat menawarkan layanan. Admin memvalidasi data identitas manual.</p>
            </div>
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center mb-6 border border-orange-100">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"></path></svg>
                </div>
                <h3 class="text-xl font-extrabold text-brand-primary mb-3">Proteksi Data</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Data pribadi, keuangan, dan dokumen KTM Anda dienkripsi dan disimpan sesuai standar keamanan industri. Kami tidak menjual data ke pihak ketiga.</p>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="bg-white py-20 px-6">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl font-extrabold text-brand-primary tracking-tight mb-12 text-center">Pertanyaan Umum</h2>
            <div class="space-y-6">
                <div class="border border-gray-100 rounded-2xl p-6">
                    <h4 class="font-bold text-brand-dark mb-2">Apakah uang saya aman jika freelancer tidak mengerjakan?</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">Ya, sistem escrow memastikan dana Anda tidak akan diteruskan ke freelancer jika pekerjaan belum diselesaikan. Anda dapat mengajukan refund melalui admin.</p>
                </div>
                <div class="border border-gray-100 rounded-2xl p-6">
                    <h4 class="font-bold text-brand-dark mb-2">Bagaimana proses verifikasi mahasiswa?</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">Freelancer wajib mengunggah foto KTM, NIM, universitas, dan jurusan. Admin akan memverifikasi data dalam 1-3 hari kerja sebelum akun freelancer dapat menawarkan jasa.</p>
                </div>
                <div class="border border-gray-100 rounded-2xl p-6">
                    <h4 class="font-bold text-brand-dark mb-2">Bagaimana jika ada sengketa antara klien dan freelancer?</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">Tim SkillKul akan menengahi sengketa dan membuat keputusan berdasarkan bukti komunikasi dan hasil kerja. Dana escrow dilindungi selama proses mediasi.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
