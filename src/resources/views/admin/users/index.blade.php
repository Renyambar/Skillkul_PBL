@extends('layouts.admin')
@section('title', 'Admin - Manajemen User')

@section('content')
<div class="p-8 lg:p-10 relative min-h-screen">


    {{-- ── Header ── --}}
    <div class="flex flex-wrap justify-between items-start gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-brand-dark tracking-tight">Manajemen User</h1>
            <p class="text-sm text-gray-500 mt-1">Monitor dan kelola seluruh akun pengguna SkillKul.</p>
        </div>
    </div>

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 text-sm font-semibold rounded-xl px-5 py-4">
            ✓ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        @if(str_contains(session('error'), 'Gagal Mengaktifkan'))
            {{-- Toast Notification di Bottom Right --}}
            <div id="error-toast" class="fixed bottom-6 right-6 z-50 max-w-sm bg-[#e53e3e] text-white rounded-xl shadow-2xl p-4 pr-10 flex items-start gap-3 border border-red-500 transition-all duration-300 hover:scale-[1.02] transform">
                <div class="text-xs leading-relaxed font-semibold">
                    **Gagal Mengaktifkan: Akun dengan status email NONAKTIF tidak dapat diaktifkan secara manual. Pengguna harus memverifikasi email mereka terlebih dahulu.
                </div>
                <button onclick="document.getElementById('error-toast').remove()" class="absolute top-3.5 right-3 text-white/70 hover:text-white shrink-0 text-[10px] font-bold cursor-pointer transition-colors bg-white/10 hover:bg-white/20 rounded-full w-5 h-5 flex items-center justify-center focus:outline-none">
                    ✕
                </button>
            </div>
        @else
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 text-sm font-semibold rounded-xl px-5 py-4">
                ✗ {{ session('error') }}
            </div>
        @endif
    @endif

    {{-- ── Statistik Cards ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Total User --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Total User</p>
            <p class="text-3xl font-extrabold text-brand-dark">{{ $stats['total'] }}</p>
        </div>
        {{-- Pekerja Lepas --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-[10px] font-extrabold text-brand-primary uppercase tracking-widest mb-1">Pekerja Lepas</p>
            <p class="text-3xl font-extrabold text-brand-primary">{{ $stats['freelancer'] }}</p>
        </div>
        {{-- Klien --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-[10px] font-extrabold text-indigo-400 uppercase tracking-widest mb-1">Klien</p>
            <p class="text-3xl font-extrabold text-indigo-600">{{ $stats['client'] }}</p>
        </div>
        {{-- Admin --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Admin</p>
            <p class="text-3xl font-extrabold text-gray-700">{{ $stats['admin'] }}</p>
        </div>
    </div>

    {{-- ── Filter & Search ── --}}
    <form method="GET" action="{{ route('admin.users.index') }}"
          class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6 flex flex-wrap gap-3 items-end">

        {{-- Filter Role --}}
        <div class="flex flex-col gap-1 min-w-[160px]">
            <label class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Role</label>
            <select name="role"
                    class="border border-gray-200 rounded-xl text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary bg-gray-50">
                <option value="">Semua Role</option>
                <option value="client"     {{ request('role') === 'client'     ? 'selected' : '' }}>Klien</option>
                <option value="freelancer" {{ request('role') === 'freelancer' ? 'selected' : '' }}>Pekerja Lepas</option>
                <option value="admin"      {{ request('role') === 'admin'      ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        {{-- Search Name/Email --}}
        <div class="flex flex-col gap-1 flex-1 min-w-[200px]">
            <label class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Cari Nama / Email</label>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Contoh: budi, budi@email.com..."
                   class="border border-gray-200 rounded-xl text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary bg-gray-50">
        </div>

        {{-- Tombol Terapkan & Reset --}}
        <button type="submit"
                class="bg-brand-primary text-white text-sm font-bold px-5 py-2 rounded-xl hover:bg-brand-dark transition-colors">
            Terapkan Filter
        </button>
        @if(request()->hasAny(['role', 'search']))
            <a href="{{ route('admin.users.index') }}"
               class="text-sm font-semibold text-gray-500 hover:text-red-500 transition-colors px-2 py-2">
                Reset
            </a>
        @endif
    </form>

    {{-- ── Tabel User ── --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest border-b border-gray-100 bg-gray-50">
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">No. Telp</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Status Email</th>
                        <th class="px-6 py-4">Bergabung</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50/50 transition-colors {{ is_null($user->email_verified_at) ? 'bg-red-50/20' : '' }}">

                        {{-- Avatar & Nama --}}
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <img
                                    src="{{ $user->profile_photo_path
                                        ? asset('storage/' . $user->profile_photo_path)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=140c61&color=fff&size=64' }}"
                                    alt="{{ $user->name }}"
                                    class="w-9 h-9 rounded-full object-cover border-2 border-indigo-100 shrink-0"
                                >
                                <div>
                                    <p class="font-bold text-gray-900">{{ $user->name }}</p>
                                    <p class="text-[10px] text-gray-400">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- No. Telp --}}
                        <td class="px-6 py-5 text-gray-500 text-xs font-mono">
                            {{ $user->phone_number ?? '—' }}
                        </td>

                        {{-- Role Badge --}}
                        <td class="px-6 py-5">
                            @php
                                $roleBadge = match($user->role) {
                                    'freelancer' => 'bg-indigo-100 text-brand-primary',
                                    'admin'      => 'bg-purple-100 text-purple-700',
                                    default      => 'bg-gray-100 text-gray-600',
                                };
                            @endphp
                            <span class="text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider {{ $roleBadge }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>

                        {{-- Status Email (aktif / nonaktif) --}}
                        <td class="px-6 py-5">
                            @if($user->email_verified_at)
                                <span class="bg-green-100 text-green-700 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider">
                                    Aktif
                                </span>
                            @else
                                <span class="bg-red-50 border border-red-200 text-red-600 text-[10px] font-extrabold px-2.5 py-1 rounded-lg uppercase tracking-wider inline-flex items-center gap-1 shadow-sm">
                                    Nonaktif
                                    <svg class="w-3 h-3 text-red-500 fill-current shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            @endif
                        </td>

                        {{-- Tanggal Bergabung --}}
                        <td class="px-6 py-5 text-gray-500 text-xs">
                            {{ $user->created_at->format('d M Y') }}
                        </td>

                        {{-- Aksi Toggle --}}
                        <td class="px-6 py-5 text-right">
                            @if($user->role !== 'admin')
                                <form method="POST"
                                      action="{{ route('admin.users.toggle', $user) }}"
                                      onsubmit="return confirm('Yakin ingin mengubah status akun {{ addslashes($user->name) }}?')">
                                    @csrf
                                    @if($user->is_active)
                                        <button type="submit"
                                                class="bg-red-50 text-red-600 px-4 py-2 rounded-lg text-xs font-bold hover:bg-red-100 transition-colors">
                                            Nonaktifkan
                                        </button>
                                    @else
                                        <button type="submit"
                                                class="bg-green-50 text-green-600 px-4 py-2 rounded-lg text-xs font-bold hover:bg-green-100 transition-colors">
                                            Aktifkan
                                        </button>
                                    @endif
                                </form>
                            @else
                                <span class="text-[10px] text-gray-300 font-semibold uppercase">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="font-semibold text-sm">Tidak ada user yang cocok dengan filter.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── Pagination ── --}}
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
            <span>
                Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }}
                dari <strong class="text-brand-dark">{{ $users->total() }}</strong> user
            </span>
            <div>
                {{ $users->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
