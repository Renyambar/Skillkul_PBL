@extends('layouts.freelancer')
@section('title', 'Dasbor Pekerja Lepas - SkillKul')
@section('content')
    <div class="p-8 lg:p-10">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-brand-dark dark:text-white tracking-tight mb-2">Selamat Datang,
                    {{ Auth::user()->name }}.
                </h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Target akademik dan pertumbuhan profesional Anda selaras hari ini.</p>
            </div>
            {{-- Exam Mode Toggle --}}
            <form id="exam-toggle-form" action="{{ route('profile.toggleExamMode') }}" method="POST"
                class="bg-orange-50 dark:bg-orange-900/20 border border-orange-100 dark:border-orange-800/50 rounded-2xl px-6 py-4 flex items-center gap-5 shadow-sm hover:shadow-md transition-shadow cursor-pointer"
                role="button" tabindex="0">
                @csrf
                <div>
                    <h4 class="text-xs font-extrabold text-orange-800 dark:text-orange-400 flex items-center gap-1.5 tracking-wide">📚 MODE UJIAN</h4>
                    <p class="text-[10px] text-orange-600 dark:text-orange-300/80 mt-1 font-medium">Aktifkan fitur ini untuk berhenti menerima pesanan baru agar fokus.</p>
                </div>
                <input id="exam-toggle-checkbox" name="exam_mode_checkbox" type="checkbox" class="sr-only" {{ auth()->user()->is_exam_mode ? 'checked' : '' }}>
                <label for="exam-toggle-checkbox" id="exam-toggle-label"
                    class="w-14 h-8 {{ auth()->user()->is_exam_mode ? 'bg-brand-accent' : 'bg-gray-300 dark:bg-gray-600' }} rounded-full relative inline-block p-[3px] transition-colors duration-300 shadow-inner shrink-0 cursor-pointer">
                    <span id="exam-toggle-knob" class="absolute top-1 left-1 w-6 h-6 bg-white rounded-full shadow-md transition-transform duration-300 ease-in-out {{ auth()->user()->is_exam_mode ? 'translate-x-6' : '' }}"></span>
                </label>
            </form>
        </div>

        {{-- Stats Row --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white dark:bg-brand-darksurface rounded-3xl p-8 border border-gray-100 dark:border-brand-darkborder shadow-sm hover:shadow-lg transition-all duration-300">
                <p class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">TOTAL PENDAPATAN</p>
                <h3 class="text-3xl font-extrabold text-brand-dark dark:text-white">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                <p class="text-xs text-green-600 dark:text-green-400 font-bold mt-2 flex items-center gap-1">📈 Pencapaian Anda</p>
            </div>
            <div class="bg-white dark:bg-brand-darksurface rounded-3xl p-8 border border-gray-100 dark:border-brand-darkborder shadow-sm hover:shadow-lg transition-all duration-300">
                <p class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">PESANAN AKTIF</p>
                <h3 class="text-3xl font-extrabold text-brand-dark dark:text-white">{{ str_pad($pesananAktifCount, 2, '0', STR_PAD_LEFT) }}</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mt-2">Status: Sedang Dikerjakan / Revisi</p>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-brand-accent/20 dark:from-green-900/20 dark:to-brand-accent/10 rounded-3xl p-8 border border-brand-accent/30 dark:border-brand-accent/20 shadow-sm relative overflow-hidden group hover:shadow-lg transition-all duration-300">
                <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-brand-accent/20 dark:bg-brand-accent/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <p class="text-[10px] font-extrabold text-green-700 dark:text-green-400 uppercase tracking-widest mb-3">SALDO DOMPET</p>
                    <h3 class="text-3xl font-extrabold text-brand-dark dark:text-white">Rp{{ number_format($saldoDompet, 0, ',', '.') }}</h3>
                    <a href="{{ route('freelancer.dompet') }}"
                        class="mt-4 inline-flex items-center gap-2 bg-brand-accent hover:bg-green-400 dark:bg-brand-accent dark:hover:bg-green-500 text-brand-dark text-xs font-extrabold px-5 py-2.5 rounded-xl transition-all shadow-sm">
                        Tarik ke Bank
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Active Orders Table --}}
            <div class="lg:col-span-8 bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm overflow-hidden flex flex-col">
                <div class="p-8 border-b border-gray-50 dark:border-gray-800 flex justify-between items-center">
                    <h3 class="font-extrabold text-brand-dark dark:text-white text-xl tracking-tight">Pesanan Aktif</h3>
                    <a href="{{ route('freelancer.pesanan') }}"
                        class="text-xs font-bold text-brand-primary dark:text-indigo-400 hover:text-brand-dark dark:hover:text-indigo-300 transition-colors">Lihat Semua Riwayat</a>
                </div>
                <div class="p-8 flex-1 overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest border-b border-gray-100 dark:border-gray-800">
                                <th class="pb-4 px-2">Nama Layanan</th>
                                <th class="pb-4 px-2">Klien</th>
                                <th class="pb-4 px-2">Status</th>
                                <th class="pb-4 px-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                            @forelse($activeOrders as $order)
                            <tr class="group hover:bg-gray-50/50 dark:hover:bg-gray-800/20 transition-colors">
                                <td class="py-5 px-2 font-bold text-gray-900 dark:text-white">
                                    <a href="{{ route('pesanan.detail', $order->id) }}" class="hover:text-brand-primary dark:hover:text-indigo-400 transition-colors">
                                        {{ $order->service->title }}
                                    </a>
                                </td>
                                <td class="py-5 px-2 text-gray-600 dark:text-gray-400 font-medium">{{ $order->client->name }}</td>
                                <td class="py-5 px-2">
                                    @if($order->status === 'paid' || $order->status === 'in_progress')
                                        <span class="bg-yellow-100/80 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider">Dalam Proses</span>
                                    @elseif($order->status === 'revision')
                                        <span class="bg-orange-100/80 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider">Revisi</span>
                                    @elseif($order->status === 'delivered')
                                        <span class="bg-blue-100/80 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider">Terkirim</span>
                                    @endif
                                </td>
                                <td class="py-5 px-2 text-right">
                                    @if(in_array($order->status, ['paid', 'in_progress', 'revision']))
                                        <a href="{{ route('pesanan.detail', $order->id) }}" class="inline-block text-brand-primary dark:text-indigo-400 font-bold text-xs hover:bg-brand-primary hover:text-white dark:hover:bg-indigo-500 dark:hover:text-white border border-brand-primary/30 dark:border-indigo-500/50 px-4 py-2 rounded-xl transition-all">Kirim Pekerjaan</a>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500 text-[10px] uppercase font-bold tracking-wider">Menunggu Klien</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-gray-500 dark:text-gray-400 text-sm font-medium">Tidak ada pesanan aktif saat ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Auto-Portofolio Engine --}}
            <div class="lg:col-span-4 flex flex-col h-full">
                <div class="bg-brand-primary dark:bg-brand-dark rounded-3xl p-8 text-white shadow-xl relative overflow-hidden flex-1 flex flex-col justify-between border border-transparent dark:border-gray-800">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                    <div class="absolute -top-12 -right-12 w-40 h-40 bg-white/10 dark:bg-indigo-500/20 rounded-full blur-3xl"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-white/10 dark:bg-indigo-900/50 rounded-2xl flex items-center justify-center mb-6 backdrop-blur-sm border border-white/10">
                            <svg class="w-6 h-6 text-indigo-200 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h3 class="text-2xl font-extrabold mb-3 tracking-tight">Sistem Auto-Portofolio</h3>
                        <p class="text-indigo-200 dark:text-indigo-300 text-sm leading-relaxed mb-8 font-medium">Buat PDF portofolio profesional secara instan. Kami hanya mengurasi proyek dengan ulasan bintang 4 ke atas untuk memastikan karya terbaik Anda bersinar.</p>
                    </div>
                    <div class="space-y-4 relative z-10 mt-auto">
                        <div class="bg-white/10 dark:bg-gray-800/50 rounded-2xl p-4 flex items-center gap-3 border border-white/10 backdrop-blur-sm">
                            <div class="w-8 h-8 bg-green-400/20 text-green-400 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-sm font-bold tracking-wide">12 Proyek Memenuhi Syarat</span>
                        </div>
                        <button class="w-full bg-white dark:bg-brand-darksurface text-brand-dark dark:text-white font-extrabold py-4 px-4 rounded-2xl text-sm flex justify-center items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors shadow-lg group">
                            <svg class="w-5 h-5 text-brand-primary dark:text-indigo-400 group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Unduh Portofolio (PDF)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('exam-toggle-form');
            if (!form) return;

            const checkbox = document.getElementById('exam-toggle-checkbox');
            const label = document.getElementById('exam-toggle-label');
            if (!checkbox) return;

            checkbox.addEventListener('change', function () {
                const labelEl = document.getElementById('exam-toggle-label');
                const knobEl = document.getElementById('exam-toggle-knob');
                const isDark = document.documentElement.classList.contains('dark');
                
                if (checkbox.checked) {
                    if (labelEl) {
                        labelEl.classList.add('bg-brand-accent');
                        labelEl.classList.remove('bg-gray-300', 'dark:bg-gray-600');
                    }
                    if (knobEl) knobEl.classList.add('translate-x-6');
                } else {
                    if (labelEl) {
                        labelEl.classList.remove('bg-brand-accent');
                        if (isDark) {
                            labelEl.classList.add('dark:bg-gray-600');
                        } else {
                            labelEl.classList.add('bg-gray-300');
                        }
                    }
                    if (knobEl) knobEl.classList.remove('translate-x-6');
                }

                checkbox.disabled = true;
                setTimeout(function () {
                    form.submit();
                }, 300);
            });

            form.addEventListener('click', function (e) {
                if (e.target.closest('input') || e.target.closest('label')) return;
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            });

            form.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change'));
                }
            });
        });
    </script>
@endsection