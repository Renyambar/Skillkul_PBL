<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Profil Saya - SkillKul</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">

    <!-- Navigation -->
    <nav class="w-full bg-white flex justify-between items-center py-5 px-6 md:px-16 border-b border-gray-100 sticky top-0 shadow-sm">
        <div class="flex items-center">
            <a href="/" class="text-2xl font-bold text-[#0c1c81] tracking-tight">Skill<span class="text-indigo-500">Kul</span></a>
        </div>
        <div class="hidden md:flex space-x-10 text-sm font-medium text-gray-600">
            <a href="#" class="hover:text-[#0c1c81] transition-colors">Marketplace</a>
            <a href="#" class="hover:text-[#0c1c81] transition-colors">Tentang</a>
            <a href="#" class="hover:text-[#0c1c81] transition-colors">Bantuan</a>
        </div>
        <div class="flex space-x-3 items-center">
            <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-red-700 transition-all">Logout</button>
            </form>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="max-w-6xl mx-auto px-6 md:px-16 py-12">

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg animate-fade-in">
            {{ session('success') }}
        </div>
        @endif

        <!-- Page Header -->
        <div class="mb-12">
            <h1 class="text-4xl font-extrabold text-[#0c1c81] mb-2">Profil Saya</h1>
            <p class="text-gray-600 text-lg">Kelola informasi akun dan preferensi Anda</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">

            <!-- Sidebar Navigation -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-2xl shadow-md p-6 sticky top-24">
                    <nav class="space-y-3">
                        <a href="#profile-info" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#0c1c81] font-semibold bg-blue-50 border-l-4 border-[#0c1c81]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Informasi Dasar
                        </a>
                        <a href="#exam-mode" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 font-semibold hover:bg-gray-50 hover:text-[#0c1c81] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Mode Ujian
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 font-semibold hover:bg-gray-50 hover:text-[#0c1c81] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Edit Profil
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="md:col-span-2 space-y-8">

                <!-- Profile Info Card -->
                <div id="profile-info" class="bg-white rounded-2xl shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Dasar</h2>

                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Profile Avatar -->
                        <div class="flex flex-col items-center justify-center">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ Storage::url(auth()->user()->profile_photo_path) }}" alt="{{ auth()->user()->name }}" class="w-32 h-32 rounded-full object-cover shadow-lg mb-4 border-4 border-[#0c1c81]">
                            @else
                                <div class="w-32 h-32 bg-gradient-to-br from-[#0c1c81] to-indigo-500 rounded-full flex items-center justify-center text-white text-5xl font-bold shadow-lg mb-4">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <h3 class="text-xl font-bold text-gray-900">{{ auth()->user()->name }}</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                @if(auth()->user()->role === 'freelancer')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">Pekerja Lepas</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Klien</span>
                                @endif
                            </p>
                        </div>

                        <!-- Profile Details -->
                        <div class="space-y-4">
                            <div class="border-b border-gray-200 pb-4">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Email</p>
                                <p class="text-gray-900 font-medium">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="border-b border-gray-200 pb-4">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Nomor WhatsApp</p>
                                <p class="text-gray-900 font-medium">{{ auth()->user()->phone_number }}</p>
                            </div>
                            <div class="pb-4">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Bio</p>
                                <p class="text-gray-900 font-medium">{{ auth()->user()->profile_description ?? 'Belum ada deskripsi' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Button -->
                    <div class="mt-8 flex gap-4">
                        <a href="{{ route('profile.edit') }}" class="px-6 py-3 bg-[#0c1c81] text-white font-semibold rounded-lg hover:bg-blue-900 transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Profil
                        </a>
                    </div>
                </div>

                <!-- Mode Ujian Card -->
                <div id="exam-mode" class="bg-white rounded-2xl shadow-md p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Mode Ujian</h2>
                            <p class="text-gray-600 text-sm mt-1">Nonaktifkan pesanan saat UAS/UTS agar fokus belajar</p>
                        </div>

                        <!-- Toggle Switch -->
                        <button
                            id="exam-mode-toggle"
                            type="button"
                            data-active="{{ auth()->user()->exam_mode ? 'true' : 'false' }}"
                            class="relative inline-flex h-10 w-20 items-center rounded-full transition-all duration-300 {{ auth()->user()->exam_mode ? 'bg-green-500 shadow-lg shadow-green-500/30' : 'bg-gray-300' }} focus:outline-none focus:ring-2 focus:ring-[#0c1c81] focus:ring-offset-2"
                        >
                            <span class="inline-block h-8 w-8 transform rounded-full bg-white shadow-lg transition-transform duration-300 {{ auth()->user()->exam_mode ? 'translate-x-11' : 'translate-x-1' }}"></span>
                        </button>
                    </div>

                    <!-- Status Info -->
                    <div id="exam-status" class="p-5 border-l-4 rounded-lg transition-all duration-300 {{ auth()->user()->exam_mode ? 'border-green-500 bg-green-50' : 'border-gray-400 bg-gray-50' }}">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 {{ auth()->user()->exam_mode ? 'text-green-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ auth()->user()->exam_mode ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' }}">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p id="exam-status-text" class="font-bold text-lg {{ auth()->user()->exam_mode ? 'text-green-700' : 'text-gray-700' }}">
                                    {{ auth()->user()->exam_mode ? '✓ Mode Ujian Aktif' : 'Mode Ujian Tidak Aktif' }}
                                </p>
                                <p id="exam-status-desc" class="text-sm {{ auth()->user()->exam_mode ? 'text-green-600' : 'text-gray-600' }} mt-1">
                                    {{ auth()->user()->exam_mode
                                        ? 'Pesanan baru tidak akan ditampilkan. Pesanan yang ada tetap bisa dikerjakan.'
                                        : 'Anda siap menerima pesanan baru' }}
                                </p>
                                @if(auth()->user()->exam_mode && auth()->user()->exam_mode_started_at)
                                <p class="text-xs text-green-500 mt-2">
                                    ⏱️ Diaktifkan sejak {{ auth()->user()->exam_mode_started_at->format('d M Y H:i') }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                        <p class="text-sm text-blue-800">
                            <strong>💡 Info:</strong> Ketika Mode Ujian aktif, button "Pesan Jasa" akan disembunyikan dari profil Anda di marketplace. Klien tidak bisa membuat pesanan baru.
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 mt-16 py-8 px-6 md:px-16">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex flex-col items-center md:items-start gap-2">
                <a href="/" class="text-2xl font-bold text-[#0c1c81] tracking-tight">Skill<span class="text-indigo-500">Kul</span></a>
                <p class="text-xs text-gray-400 font-medium">&copy; 2024 SkillKul. The Academic Entrepreneur.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-x-10 gap-y-4 text-sm font-semibold text-gray-600">
                <a href="#" class="hover:text-[#0c1c81] transition">Terms of Service</a>
                <a href="#" class="hover:text-[#0c1c81] transition">Privacy Policy</a>
                <a href="#" class="hover:text-[#0c1c81] transition">Help Center</a>
            </div>
        </div>
    </footer>

    <!-- JavaScript untuk Toggle -->
    <script>
        const toggleBtn = document.getElementById('exam-mode-toggle');
        const statusDiv = document.getElementById('exam-status');
        const statusText = document.getElementById('exam-status-text');
        const statusDesc = document.getElementById('exam-status-desc');

        toggleBtn.addEventListener('click', async () => {
            try {
                const response = await fetch('{{ route("profile.toggleExamMode") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                });

                const data = await response.json();

                if (data.success) {
                    const isActive = data.exam_mode;

                    // Update toggle UI
                    toggleBtn.dataset.active = isActive;
                    toggleBtn.classList.toggle('bg-green-500');
                    toggleBtn.classList.toggle('bg-gray-300');
                    toggleBtn.classList.toggle('shadow-lg');
                    toggleBtn.classList.toggle('shadow-green-500/30');

                    const span = toggleBtn.querySelector('span');
                    if (isActive) {
                        span.classList.remove('translate-x-1');
                        span.classList.add('translate-x-11');
                    } else {
                        span.classList.remove('translate-x-11');
                        span.classList.add('translate-x-1');
                    }

                    // Update status info
                    if (isActive) {
                        statusDiv.classList.remove('border-gray-400', 'bg-gray-50');
                        statusDiv.classList.add('border-green-500', 'bg-green-50');

                        const svg = statusDiv.querySelector('svg');
                        svg.classList.remove('text-gray-600');
                        svg.classList.add('text-green-600');
                        svg.querySelector('path').setAttribute('d', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z');

                        statusText.textContent = '✓ Mode Ujian Aktif';
                        statusText.classList.remove('text-gray-700');
                        statusText.classList.add('text-green-700');

                        statusDesc.textContent = 'Pesanan baru tidak akan ditampilkan. Pesanan yang ada tetap bisa dikerjakan.';
                        statusDesc.classList.remove('text-gray-600');
                        statusDesc.classList.add('text-green-600');
                    } else {
                        statusDiv.classList.remove('border-green-500', 'bg-green-50');
                        statusDiv.classList.add('border-gray-400', 'bg-gray-50');

                        const svg = statusDiv.querySelector('svg');
                        svg.classList.remove('text-green-600');
                        svg.classList.add('text-gray-600');
                        svg.querySelector('path').setAttribute('d', 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z');

                        statusText.textContent = 'Mode Ujian Tidak Aktif';
                        statusText.classList.remove('text-green-700');
                        statusText.classList.add('text-gray-700');

                        statusDesc.textContent = 'Anda siap menerima pesanan baru';
                        statusDesc.classList.remove('text-green-600');
                        statusDesc.classList.add('text-gray-600');
                    }

                    // Show success message
                    alert(data.message);

                    // Refresh page setelah 500ms
                    setTimeout(() => location.reload(), 500);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    </script>

</body>

</html>
