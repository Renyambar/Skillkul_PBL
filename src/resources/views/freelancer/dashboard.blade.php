@extends('layouts.freelancer')
@section('title', 'Dashboard Freelancer - SkillKul')
@section('content')
    <div class="p-8 lg:p-10">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-brand-dark tracking-tight mb-1">Selamat Datang,
                    {{ Auth::user()->name }}.
                </h1>
                <p class="text-gray-500 text-sm">Target akademik dan pertumbuhan profesional Anda selaras hari ini.</p>
            </div>
            {{-- Exam Mode Toggle --}}
            <form id="exam-toggle-form" action="{{ route('profile.toggleExamMode') }}" method="POST"
                class="bg-orange-50 border border-orange-100 rounded-2xl px-5 py-3 flex items-center gap-4 shadow-sm cursor-pointer"
                role="button" tabindex="0">
                @csrf
                <div>
                    <h4 class="text-xs font-bold text-orange-800 flex items-center gap-1.5">📚 MODE UJIAN</h4>
                    <p class="text-[10px] text-orange-600 mt-0.5">Aktifkan fitur ini untuk berhenti menerima pesanan baru
                        agar tetap fokus ujian.</p>
                </div>
                <input id="exam-toggle-checkbox" name="exam_mode_checkbox" type="checkbox" class="sr-only" {{ auth()->user()->is_exam_mode ? 'checked' : '' }}>
                <label for="exam-toggle-checkbox" id="exam-toggle-label"
                    class="w-12 h-7 {{ auth()->user()->is_exam_mode ? 'bg-brand-accent' : 'bg-gray-300' }} rounded-full relative inline-block p-[3px] transition-colors duration-200 shadow-inner shrink-0 cursor-pointer">
                    <span id="exam-toggle-knob" class="absolute top-1 left-1 w-5 h-5 bg-white rounded-full shadow transition-transform duration-200 {{ auth()->user()->is_exam_mode ? 'translate-x-5' : '' }}"></span>
                </label>
            </form>
        </div>

        {{-- Stats Row --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">TOTAL PENDAPATAN</p>
                <h3 class="text-2xl font-extrabold text-brand-dark">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                <p class="text-xs text-green-600 font-semibold mt-1 flex items-center gap-1">📈 Pencapaian Anda</p>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">PESANAN AKTIF</p>
                <h3 class="text-2xl font-extrabold text-brand-dark">{{ str_pad($pesananAktifCount, 2, '0', STR_PAD_LEFT) }}</h3>
                <p class="text-xs text-gray-500 mt-1">Status: Sedang Dikerjakan / Revisi</p>
            </div>
            <div class="bg-brand-accent/10 rounded-2xl p-6 border border-brand-accent/20 shadow-sm">
                <p class="text-[10px] font-extrabold text-gray-500 uppercase tracking-widest mb-2">SALDO DOMPET</p>
                <h3 class="text-2xl font-extrabold text-brand-dark">Rp {{ number_format($saldoDompet, 0, ',', '.') }}</h3>
                <a href="{{ route('freelancer.dompet') }}"
                    class="mt-3 inline-block bg-brand-accent text-brand-dark text-xs font-bold px-5 py-2 rounded-lg hover:bg-green-300 transition-colors">Tarik
                    ke Bank</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Active Orders Table --}}
            <div class="lg:col-span-8 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-extrabold text-brand-dark text-lg">Pesanan Aktif</h3>
                    <a href="{{ route('freelancer.pesanan') }}"
                        class="text-xs font-bold text-brand-primary hover:underline">Lihat Semua Riwayat</a>
                </div>
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr
                            class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest border-b border-gray-100">
                            <th class="pb-3">Nama Layanan</th>
                            <th class="pb-3">Klien</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($activeOrders as $order)
                        <tr>
                            <td class="py-4 font-semibold text-gray-900">
                                <a href="{{ route('pesanan.detail', $order->id) }}" class="hover:text-brand-primary transition-colors">
                                    {{ $order->service->title }}
                                </a>
                            </td>
                            <td class="py-4 text-gray-600">{{ $order->client->name }}</td>
                            <td class="py-4">
                                @if($order->status === 'paid' || $order->status === 'in_progress')
                                    <span class="bg-yellow-100 text-yellow-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider">Dalam Proses</span>
                                @elseif($order->status === 'revision')
                                    <span class="bg-orange-100 text-orange-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider">Revisi</span>
                                @elseif($order->status === 'delivered')
                                    <span class="bg-blue-100 text-blue-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider">Terkirim</span>
                                @endif
                            </td>
                            <td class="py-4 text-right">
                                @if(in_array($order->status, ['paid', 'in_progress', 'revision']))
                                    <a href="{{ route('pesanan.detail', $order->id) }}" class="text-brand-primary font-bold text-xs hover:underline border border-brand-primary px-3 py-1.5 rounded-lg">Kirim Pekerjaan</a>
                                @else
                                    <span class="text-gray-400 text-[10px] uppercase font-bold tracking-wider">Menunggu Klien</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-gray-500 text-sm">Tidak ada pesanan aktif saat ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Auto-Portfolio Engine --}}
            <div class="lg:col-span-4">
                <div
                    class="bg-gradient-to-br from-[#2a0e88] to-[#160655] rounded-2xl p-7 text-white shadow-xl relative overflow-hidden h-full flex flex-col justify-between">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
                    <div>
                        <!-- <span
                            class="inline-block bg-white/10 px-3 py-1 rounded-full text-[9px] font-extrabold tracking-widest uppercase mb-4 border border-white/10">Fitur
                            Utama</span> -->
                        <h3 class="text-xl font-extrabold mb-3">Sistem Auto-Portfolio</h3>
                        <p class="text-indigo-200 text-xs leading-relaxed mb-6">Buat PDF portofolio profesional secara
                            instan. Kami hanya mengurasi proyek dengan ulasan bintang 4 ke atas untuk memastikan karya
                            terbaik Anda bersinar.</p>
                    </div>
                    <div class="space-y-3">
                        <div class="bg-white/10 rounded-xl p-3 flex items-center gap-2 border border-white/10">
                            <span class="text-brand-accent text-sm">✓</span>
                            <span class="text-sm font-semibold">12 Proyek Memenuhi Syarat</span>
                        </div>
                        <button
                            class="w-full bg-white text-[#2a0e88] font-bold py-3 rounded-xl text-xs flex justify-center items-center gap-2 hover:bg-indigo-50 transition-colors shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Unduh Portofolio Anda (PDF)
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

            // When checkbox changes, animate then submit the form
            checkbox.addEventListener('change', function () {
                const labelEl = document.getElementById('exam-toggle-label');
                const knobEl = document.getElementById('exam-toggle-knob');
                if (checkbox.checked) {
                    if (labelEl) {
                        labelEl.classList.add('bg-brand-accent');
                        labelEl.classList.remove('bg-gray-300');
                    }
                    if (knobEl) knobEl.classList.add('translate-x-5');
                } else {
                    if (labelEl) {
                        labelEl.classList.remove('bg-brand-accent');
                        labelEl.classList.add('bg-gray-300');
                    }
                    if (knobEl) knobEl.classList.remove('translate-x-5');
                }

                // disable the checkbox briefly to avoid duplicate submits
                checkbox.disabled = true;
                // wait a short time so the animation is visible, then submit
                setTimeout(function () {
                    form.submit();
                }, 220);
            });

            // Clicking the card (form) toggles the checkbox, except when user clicks the checkbox/label directly
            form.addEventListener('click', function (e) {
                if (e.target.closest('input') || e.target.closest('label')) return;
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            });

            // Keyboard activation for accessibility
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