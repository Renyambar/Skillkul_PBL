<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SkillKul - Jembatan Akademis & Industri</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            dark: '#1a0f4c',
                            purple: '#5D3FD3',
                            lightPurple: '#F2F0FF',
                            gray: '#FAFAFA',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom smooth scrolling */
        html { scroll-behavior: smooth; }
        
        /* Glassmorphism effect for floating card */
        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-brand-gray">

    <nav class="w-full bg-white flex justify-between items-center py-5 px-6 md:px-16 border-b border-gray-100 z-50 sticky top-0 shadow-sm">
        <div class="flex items-center">
            <a href="/" class="text-2xl font-bold text-brand-dark tracking-tight">Skill<span class="text-brand-purple">Kul</span></a>
        </div>
        <div class="hidden md:flex space-x-10 text-sm font-medium text-gray-600">
            <a href="#" class="text-brand-dark border-b-2 border-brand-purple pb-1 font-semibold">Marketplace</a>
            <a href="#" class="hover:text-brand-purple pb-1 transition-colors">Tentang</a>
            <a href="#" class="hover:text-brand-purple pb-1 transition-colors">Keamanan</a>
        </div>
        <div class="flex space-x-3 items-center">
            @auth
                <a href="{{ url('/dashboard') }}" class="bg-brand-dark text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-[#120a3a] transition-all shadow-md hover:shadow-lg">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-black transition-colors px-4 py-2">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-brand-dark text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-[#120a3a] transition-all shadow-md hover:shadow-lg">Register</a>
                @endif
            @endauth
        </div>
    </nav>

    <section class="max-w-7xl mx-auto px-6 md:px-16 py-20 md:py-32 grid md:grid-cols-2 gap-16 items-center">
        <div class="space-y-8">
            <span class="inline-flex items-center bg-brand-lightPurple text-brand-purple px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider border border-purple-100">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                The Curated Scholastic Atelier
            </span>
            <h1 class="text-5xl md:text-6xl font-extrabold text-brand-dark leading-tight tracking-tighter">
                Menjembatani Dunia <span class="text-brand-purple">Akademis</span> & Industri
            </h1>
            <p class="text-gray-600 md:text-xl max-w-xl leading-relaxed">
                Platform kurasi untuk mahasiswa bertalenta dalam membangun portofolio profesional dan karier wirausaha sejak masa kuliah.
            </p>
            <div class="flex flex-wrap gap-5 pt-4">
                <a href="#" class="bg-brand-dark text-white px-8 py-4 rounded-xl text-base font-semibold flex items-center gap-2.5 hover:bg-[#120a3a] transition-all shadow-lg shadow-indigo-900/20 hover:-translate-y-0.5">
                    Mulai Jelajahi Jasa
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
                <a href="#" class="bg-white text-gray-800 px-8 py-4 rounded-xl text-base font-semibold hover:bg-gray-50 transition-all border border-gray-200 shadow-sm hover:shadow-md">
                    Daftar Jadi Freelancer
                </a>
            </div>
        </div>
        <div class="relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-brand-purple to-indigo-500 rounded-3xl blur opacity-25 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
            <div class="rounded-3xl overflow-hidden shadow-2xl relative border-4 border-white group-hover:scale-[1.01] transition-transform duration-500">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Students collaborating" class="w-full h-auto object-cover transform scale-100 group-hover:scale-105 transition-transform duration-700"/>
            </div>
            <div class="absolute -bottom-10 -left-10 glass p-5 rounded-2xl shadow-2xl border border-white/50 max-w-[240px] transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center gap-3 mb-2">
                    <div class="bg-green-100 text-green-600 p-1.5 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="font-bold text-lg text-brand-dark">Verified Talent</span>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed font-medium">Hanya mahasiswa berprestasi dengan portofolio terkurasi dan terverifikasi.</p>
            </div>
        </div>
    </section>

    <section id="fitur" class="max-w-7xl mx-auto px-6 md:px-16 py-24 md:py-32">
        <div class="text-center mb-20 space-y-4">
            <span class="text-brand-purple font-bold text-sm uppercase tracking-widest">Inovasi Kami</span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-brand-dark tracking-tight">Fitur Utama untuk Masa Depanmu</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-autoLeading-relaxed">Teknologi digital yang dirancang khusus untuk memperkuat ekosistem pendidikan dan profesional mahasiswa.</p>
        </div>

        <div class="grid md:grid-cols-5 gap-8">
            <div class="md:col-span-3 bg-brand-dark rounded-3xl p-10 md:p-14 text-white relative overflow-hidden shadow-xl shadow-indigo-950/20 group">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/diagmonds-light.png')] opacity-10"></div>
                <span class="inline-block bg-white/10 px-4 py-1.5 rounded-lg text-xs font-semibold tracking-wide mb-8 border border-white/10">INNOVATOR'S TOOL</span>
                <h3 class="text-3xl md:text-4xl font-bold mb-6 tracking-tight">Auto-Portfolio Generator</h3>
                <p class="text-indigo-200 text-base max-w-lg leading-relaxed mb-16 relative z-10">
                    Teknologi AI canggih yang secara otomatis merangkum proyek kuliah, kompetensi, dan sertifikasi menjadi portofolio profesional yang siap kerja dan menarik bagi rekruter.
                </p>
                
                <div class="flex gap-4 absolute bottom-0 right-10 transform translate-y-1/3 group-hover:translate-y-1/4 transition-transform duration-500 opacity-60">
                    <div class="w-36 h-48 border-2 border-white/20 rounded-t-2xl bg-white/5 flex flex-col p-4 gap-2">
                        <div class="w-full h-4 bg-white/20 rounded-sm"></div>
                        <div class="w-2/3 h-3 bg-white/10 rounded-sm"></div>
                    </div>
                    <div class="w-36 h-60 border-2 border-white/20 rounded-t-2xl bg-white/5 flex flex-col p-4 gap-2">
                        <div class="w-full h-4 bg-white/20 rounded-sm"></div>
                        <div class="w-1/2 h-3 bg-white/10 rounded-sm"></div>
                        <div class="w-full h-24 bg-white/5 rounded-md mt-4 border border-white/10"></div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2 bg-white border border-gray-100 rounded-3xl p-10 md:p-12 shadow-lg shadow-gray-100/50 flex flex-col justify-between group hover:border-brand-purple/20 transition-all duration-300">
                <div>
                    <div class="w-14 h-14 bg-brand-lightPurple text-brand-purple rounded-2xl flex items-center justify-center mb-8 border border-purple-100 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-brand-dark mb-4 tracking-tight">Mode Ujian</h3>
                    <p class="text-base text-gray-600 leading-relaxed mb-8">Fitur anti-overwork. Nonaktifkan pesanan sementara saat minggu UAS/UTS agar fokus studimu tetap terjaga.</p>
                </div>
                <div class="bg-brand-gray rounded-2xl p-5 flex justify-between items-center border border-gray-100">
                    <span class="text-sm font-semibold text-brand-dark">Status Akademik (Sibuk)</span>
                    <button class="w-12 h-7 bg-brand-dark rounded-full relative p-1 group">
                        <div class="absolute inset-0 bg-brand-purple rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="w-5 h-5 bg-white rounded-full ml-auto relative z-10 shadow-sm"></div>
                    </button>
                </div>
            </div>

            <div class="md:col-span-5 bg-white border border-gray-100 rounded-3xl p-10 md:p-16 shadow-lg shadow-gray-100/50 grid md:grid-cols-2 gap-12 items-center mt-4 hover:border-green-200 transition-all duration-300">
                <div class="space-y-6">
                    <span class="inline-flex items-center bg-green-50 text-green-700 px-4 py-1.5 rounded-lg text-xs font-bold border border-green-100">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                        SAFE & SECURE PAYMENT
                    </span>
                    <h3 class="text-3xl font-bold text-brand-dark tracking-tight">Pembayaran Escrow Midtrans</h3>
                    <p class="text-gray-600 text-base leading-relaxed max-w-lg">
                        Dana Anda dijamin aman 100%. Kami menjaga dana di sistem penampungan (escrow) terpercaya dan hanya melepaskannya ke mahasiswa setelah tugas dikonfirmasi selesai dan memenuhi standar kualitas.
                    </p>
                    <div class="flex items-center gap-3 text-sm text-gray-500 font-medium pt-2">
                        <img src="https://midtrans.com/images/midtrans-logo-color.svg" alt="Midtrans Logo" class="h-6 opacity-80">
                        <span class="border-l border-gray-200 h-5"></span>
                        <span>Powered by Midtrans Secure Architecture</span>
                    </div>
                </div>
                <div class="bg-brand-gray rounded-2xl p-8 border-2 border-gray-200 border-dashed relative group hover:border-green-300 hover:bg-green-50/50 transition-all">
                    <div class="flex justify-between items-center border-b border-gray-200 pb-5 mb-5 group-hover:border-green-200">
                        <span class="text-sm font-medium text-gray-600">Total Pembayaran Proyek</span>
                        <span class="text-2xl font-extrabold text-brand-dark tracking-tight">Rp 2.500.000</span>
                    </div>
                    <div class="space-y-5">
                        <div class="flex items-center gap-4 group-hover:scale-[1.02] transition-transform">
                            <div class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center border border-green-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-base font-semibold text-green-700">Dana Tertahan di Escrow (Aman)</span>
                        </div>
                        <div class="flex items-center gap-4 opacity-40 group-hover:opacity-60 transition-opacity">
                            <div class="w-6 h-6 rounded-full border-2 border-gray-400 border-dotted flex items-center justify-center"></div>
                            <span class="text-base font-medium text-gray-600">Pelepasan Dana ke Freelancer</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-gray-100 py-12 px-6 md:px-16 mt-16">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex flex-col items-center md:items-start gap-2">
                <a href="/" class="text-2xl font-bold text-brand-dark tracking-tight">Skill<span class="text-brand-purple">Kul</span></a>
                <p class="text-xs text-gray-400 font-medium">&copy; 2024 SkillKul Global. The Curated Scholastic Atelier.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-x-10 gap-y-4 text-sm font-semibold text-gray-600">
                <a href="#" class="hover:text-brand-purple transition">Terms of Service</a>
                <a href="#" class="hover:text-brand-purple transition">Privacy Policy</a>
                <a href="#" class="hover:text-brand-purple transition">Escrow Safety</a>
                <a href="#" class="hover:text-brand-purple transition">Help Center</a>
            </div>
        </div>
    </footer>

</body>
</html>