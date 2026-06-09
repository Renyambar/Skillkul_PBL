@php $layout = auth()->user()->role === 'freelancer' ? 'layouts.freelancer' : 'layouts.client'; @endphp
@extends($layout)
@section('title', 'Profil Saya - SkillKul')
@section('content')
    <!-- Main Container -->
    <div class="max-w-6xl mx-auto px-6 md:px-16 py-12 transition-colors duration-300">

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-800/50 text-green-700 dark:text-green-400 rounded-lg animate-fade-in transition-colors">
            {{ session('success') }}
        </div>
        @endif

        <!-- Page Header -->
        <div class="mb-12">
            <h1 class="text-4xl font-extrabold text-[#0c1c81] dark:text-white mb-2">Profil Saya</h1>
            <p class="text-gray-600 dark:text-gray-400 text-lg">Kelola informasi akun dan preferensi Anda</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">

            <!-- Sidebar Navigation -->
            <div class="md:col-span-1">
                <div class="bg-white dark:bg-brand-darksurface rounded-2xl shadow-sm border border-gray-100 dark:border-brand-darkborder p-6 sticky top-24 transition-colors duration-300">
                    <nav class="space-y-3">
                        <a href="#profile-info" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#0c1c81] dark:text-indigo-400 font-semibold bg-blue-50 dark:bg-indigo-900/30 border-l-4 border-[#0c1c81] dark:border-indigo-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Informasi Dasar
                        </a>
                        <a href="#exam-mode" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 dark:text-gray-400 font-semibold hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-[#0c1c81] dark:hover:text-indigo-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Mode Ujian
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 dark:text-gray-400 font-semibold hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-[#0c1c81] dark:hover:text-indigo-400 transition-colors">
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
                <div id="profile-info" class="bg-white dark:bg-brand-darksurface rounded-2xl shadow-sm border border-gray-100 dark:border-brand-darkborder p-8 transition-colors duration-300">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Informasi Dasar</h2>

                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Profile Avatar -->
                        <div class="flex flex-col items-center justify-center">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ Storage::url(auth()->user()->profile_photo_path) }}" alt="{{ auth()->user()->name }}" class="w-32 h-32 rounded-full object-cover shadow-lg mb-4 border-4 border-[#0c1c81] dark:border-indigo-600">
                            @else
                                <div class="w-32 h-32 bg-gradient-to-br from-[#0c1c81] to-indigo-500 rounded-full flex items-center justify-center text-white text-5xl font-bold shadow-lg mb-4">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                @if(auth()->user()->role === 'freelancer')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 transition-colors">Pekerja Lepas</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 transition-colors">Klien</span>
                                @endif
                            </p>
                        </div>

                        <!-- Profile Details -->
                        <div class="space-y-4">
                            <div class="border-b border-gray-200 dark:border-gray-800 pb-4 transition-colors">
                                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Email</p>
                                <p class="text-gray-900 dark:text-white font-medium">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="border-b border-gray-200 dark:border-gray-800 pb-4 transition-colors">
                                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Nomor WhatsApp</p>
                                <p class="text-gray-900 dark:text-white font-medium">{{ auth()->user()->phone_number }}</p>
                            </div>
                            <div class="pb-4">
                                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Bio</p>
                                <p class="text-gray-900 dark:text-white font-medium">{{ auth()->user()->profile_description ?? 'Belum ada deskripsi' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Button -->
                    <div class="mt-8 flex gap-4">
                        <a href="{{ route('profile.edit') }}" class="px-6 py-3 bg-[#0c1c81] dark:bg-indigo-600 text-white font-semibold rounded-lg hover:bg-blue-900 dark:hover:bg-indigo-700 transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Profil
                        </a>
                    </div>
                </div>

                <!-- Mode Ujian Card -->
                <div id="exam-mode" class="bg-white dark:bg-brand-darksurface rounded-2xl shadow-sm border border-gray-100 dark:border-brand-darkborder p-8 transition-colors duration-300">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Mode Ujian</h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Nonaktifkan pesanan saat UAS/UTS agar fokus belajar</p>
                        </div>

                        <!-- Toggle Switch -->
                        <button
                            id="exam-mode-toggle"
                            type="button"
                            data-active="{{ auth()->user()->exam_mode ? 'true' : 'false' }}"
                            class="relative inline-flex h-10 w-20 items-center rounded-full transition-all duration-300 {{ auth()->user()->exam_mode ? 'bg-green-500 shadow-lg shadow-green-500/30' : 'bg-gray-300 dark:bg-gray-700' }} focus:outline-none focus:ring-2 focus:ring-[#0c1c81] dark:focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                        >
                            <span class="inline-block h-8 w-8 transform rounded-full bg-white shadow-lg transition-transform duration-300 {{ auth()->user()->exam_mode ? 'translate-x-11' : 'translate-x-1' }}"></span>
                        </button>
                    </div>

                    <!-- Status Info -->
                    <div id="exam-status" class="p-5 border-l-4 rounded-lg transition-all duration-300 {{ auth()->user()->exam_mode ? 'border-green-500 bg-green-50 dark:bg-green-900/10' : 'border-gray-400 dark:border-gray-600 bg-gray-50 dark:bg-gray-800/30' }}">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 {{ auth()->user()->exam_mode ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ auth()->user()->exam_mode ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' }}">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p id="exam-status-text" class="font-bold text-lg {{ auth()->user()->exam_mode ? 'text-green-700 dark:text-green-400' : 'text-gray-700 dark:text-gray-300' }}">
                                    {{ auth()->user()->exam_mode ? '✓ Mode Ujian Aktif' : 'Mode Ujian Tidak Aktif' }}
                                </p>
                                <p id="exam-status-desc" class="text-sm {{ auth()->user()->exam_mode ? 'text-green-600 dark:text-green-500' : 'text-gray-600 dark:text-gray-400' }} mt-1">
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
                    <div class="mt-6 p-4 bg-blue-50 dark:bg-indigo-900/20 border-l-4 border-blue-500 dark:border-indigo-500 rounded-lg transition-colors">
                        <p class="text-sm text-blue-800 dark:text-indigo-300">
                            <strong>💡 Info:</strong> Ketika Mode Ujian aktif, tombol "Pesan Jasa" akan disembunyikan dari profil Anda di lokapasar. Klien tidak bisa membuat pesanan baru.
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </div>

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
                    toggleBtn.classList.toggle('dark:bg-gray-700');
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

                    // Refresh page setelah 500ms
                    setTimeout(() => location.reload(), 500);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    </script>
@endsection
