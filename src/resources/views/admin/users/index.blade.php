@extends('layouts.admin')
@section('title', 'Admin - Manajemen User')

@section('content')
<div class="p-8 lg:p-10 relative min-h-screen transition-colors duration-300">

    {{-- ── Header ── --}}
    <div class="flex flex-wrap justify-between items-start gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-brand-dark dark:text-white tracking-tight">Manajemen User</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 font-medium">Monitor dan kelola seluruh akun pengguna SkillKul.</p>
        </div>
    </div>

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800/50 text-green-800 dark:text-green-300 text-sm font-semibold rounded-2xl px-5 py-4 shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        @if(str_contains(session('error'), 'Gagal Mengaktifkan'))
            {{-- Toast Notification di Bottom Right --}}
            <div id="error-toast" class="fixed bottom-6 right-6 z-50 max-w-sm bg-[#e53e3e] dark:bg-red-900 text-white rounded-2xl shadow-2xl p-4 pr-10 flex items-start gap-3 border border-red-500 dark:border-red-700 transition-all duration-300 hover:scale-[1.02] transform">
                <div class="text-xs leading-relaxed font-semibold">
                    **Gagal Mengaktifkan: Akun dengan status email NONAKTIF tidak dapat diaktifkan secara manual. Pengguna harus memverifikasi email mereka terlebih dahulu.
                </div>
                <button onclick="document.getElementById('error-toast').remove()" class="absolute top-3.5 right-3 text-white/70 hover:text-white shrink-0 text-[10px] font-bold cursor-pointer transition-colors bg-white/10 hover:bg-white/20 rounded-full w-6 h-6 flex items-center justify-center focus:outline-none">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @else
            <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800/50 text-red-800 dark:text-red-300 text-sm font-semibold rounded-2xl px-5 py-4 shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                {{ session('error') }}
            </div>
        @endif
    @endif

    {{-- ── Statistik Cards ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        {{-- Total User --}}
        <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-gray-500 dark:text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <p class="text-[11px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Total User</p>
            </div>
            <p class="text-4xl font-black text-brand-dark dark:text-white">{{ $stats['total'] }}</p>
        </div>
        {{-- Pekerja Lepas --}}
        <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-6 hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-brand-primary/5 rounded-full blur-xl"></div>
            <div class="flex items-center gap-3 mb-4 relative z-10">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-brand-primary dark:text-indigo-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <p class="text-[11px] font-extrabold text-brand-primary dark:text-indigo-400 uppercase tracking-widest">Pekerja Lepas</p>
            </div>
            <p class="text-4xl font-black text-brand-primary dark:text-indigo-400 relative z-10">{{ $stats['freelancer'] }}</p>
        </div>
        {{-- Klien --}}
        <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-6 hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-purple-500/5 rounded-full blur-xl"></div>
            <div class="flex items-center gap-3 mb-4 relative z-10">
                <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <p class="text-[11px] font-extrabold text-purple-500 dark:text-purple-400 uppercase tracking-widest">Klien</p>
            </div>
            <p class="text-4xl font-black text-purple-600 dark:text-purple-400 relative z-10">{{ $stats['client'] }}</p>
        </div>
        {{-- Admin --}}
        <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <p class="text-[11px] font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Admin</p>
            </div>
            <p class="text-4xl font-black text-gray-700 dark:text-gray-300">{{ $stats['admin'] }}</p>
        </div>
    </div>

    {{-- ── Filter & Search ── --}}
    <form method="GET" action="{{ route('admin.users.index') }}"
          class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm p-6 mb-8 flex flex-wrap gap-4 items-end">

        {{-- Filter Role --}}
        <div class="flex flex-col gap-2 min-w-[160px]">
            <label class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Role</label>
            <select name="role"
                    class="border border-gray-200 dark:border-gray-700 rounded-xl text-sm px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-500 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-medium appearance-none transition-colors">
                <option value="">Semua Role</option>
                <option value="client"     {{ request('role') === 'client'     ? 'selected' : '' }}>Klien</option>
                <option value="freelancer" {{ request('role') === 'freelancer' ? 'selected' : '' }}>Pekerja Lepas</option>
                <option value="admin"      {{ request('role') === 'admin'      ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        {{-- Search Name/Email --}}
        <div class="flex flex-col gap-2 flex-1 min-w-[200px]">
            <label class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Cari Nama / Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Contoh: budi, budi@email.com..."
                       class="w-full border border-gray-200 dark:border-gray-700 rounded-xl text-sm pl-10 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-primary dark:focus:ring-indigo-500 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500 font-medium transition-colors">
            </div>
        </div>

        {{-- Tombol Terapkan & Reset --}}
        <div class="flex items-center gap-3">
            <button type="submit"
                    class="bg-brand-primary dark:bg-indigo-600 text-white text-sm font-bold px-6 py-2.5 rounded-xl hover:bg-brand-dark dark:hover:bg-indigo-500 transition-colors shadow-sm shadow-indigo-200 dark:shadow-none">
                Terapkan Filter
            </button>
            @if(request()->hasAny(['role', 'search']))
                <a href="{{ route('admin.users.index') }}"
                   class="text-sm font-semibold text-gray-500 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors px-3 py-2 bg-gray-50 dark:bg-gray-800 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-xl">
                    Reset
                </a>
            @endif
        </div>
    </form>

    {{-- ── Tabel User ── --}}
    <div class="bg-white dark:bg-brand-darksurface rounded-3xl border border-gray-100 dark:border-brand-darkborder shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-widest border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30">
                        <th class="px-6 py-5 whitespace-nowrap">Nama</th>
                        <th class="px-6 py-5 whitespace-nowrap">No. Telp</th>
                        <th class="px-6 py-5 whitespace-nowrap">Role</th>
                        <th class="px-6 py-5 whitespace-nowrap">Status Email</th>
                        <th class="px-6 py-5 whitespace-nowrap">Bergabung</th>
                        <th class="px-6 py-5 text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors {{ is_null($user->email_verified_at) ? 'bg-red-50/30 dark:bg-red-900/10' : '' }}">

                        {{-- Avatar & Nama --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <img
                                    src="{{ $user->profile_photo_path
                                        ? asset('storage/' . $user->profile_photo_path)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=140c61&color=fff&size=64' }}"
                                    alt="{{ $user->name }}"
                                    class="w-10 h-10 rounded-full object-cover border-2 border-indigo-50 dark:border-indigo-900/30 shrink-0"
                                >
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white">{{ $user->name }}</p>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- No. Telp --}}
                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-xs font-mono font-medium">
                            {{ $user->phone_number ?? '—' }}
                        </td>

                        {{-- Role Badge --}}
                        <td class="px-6 py-4">
                            @php
                                $roleBadge = match($user->role) {
                                    'freelancer' => 'bg-indigo-50 dark:bg-indigo-900/30 text-brand-primary dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800/50',
                                    'admin'      => 'bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 border border-purple-100 dark:border-purple-800/50',
                                    default      => 'bg-gray-50 dark:bg-gray-800/50 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700/50',
                                };
                            @endphp
                            <span class="text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider {{ $roleBadge }} inline-block">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>

                        {{-- Status Email (aktif / nonaktif) --}}
                        <td class="px-6 py-4">
                            @if($user->email_verified_at)
                                <span class="bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border border-green-100 dark:border-green-800/50 text-[10px] font-extrabold px-3 py-1.5 rounded-lg uppercase tracking-wider inline-block">
                                    Aktif
                                </span>
                            @else
                                <span class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/50 text-red-600 dark:text-red-400 text-[10px] font-extrabold px-2.5 py-1.5 rounded-lg uppercase tracking-wider inline-flex items-center gap-1.5 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        {{-- Tanggal Bergabung --}}
                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-xs font-medium">
                            {{ $user->created_at->format('d M Y') }}
                        </td>

                        {{-- Aksi Toggle --}}
                        <td class="px-6 py-4 text-right">
                            @if($user->role !== 'admin')
                                <form method="POST"
                                      action="{{ route('admin.users.toggle', $user) }}"
                                      onsubmit="return confirm('Yakin ingin mengubah status akun {{ addslashes($user->name) }}?')"
                                      class="inline-block">
                                    @csrf
                                    @if($user->is_active)
                                        <button type="submit"
                                                class="bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 px-4 py-2 rounded-xl text-xs font-bold hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors border border-red-100 dark:border-red-800/30">
                                            Nonaktifkan
                                        </button>
                                    @else
                                        <button type="submit"
                                                class="bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 px-4 py-2 rounded-xl text-xs font-bold hover:bg-green-100 dark:hover:bg-green-900/40 transition-colors border border-green-100 dark:border-green-800/30">
                                            Aktifkan
                                        </button>
                                    @endif
                                </form>
                            @else
                                <span class="text-[10px] text-gray-300 dark:text-gray-600 font-bold uppercase inline-block px-4 py-2">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center text-gray-400 dark:text-gray-500">
                            <div class="w-16 h-16 bg-gray-50 dark:bg-gray-800/50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-gray-100 dark:border-gray-700">
                                <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <p class="font-bold text-gray-600 dark:text-gray-400">Tidak ada user ditemukan</p>
                            <p class="text-xs mt-1">Coba ubah filter atau kata kunci pencarian Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── Pagination ── --}}
        @if($users->hasPages())
        <div class="px-6 py-5 border-t border-gray-100 dark:border-gray-800 bg-gray-50/30 dark:bg-gray-900/10 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-gray-500 dark:text-gray-400 font-medium">
            <span>
                Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }}
                dari <strong class="text-brand-dark dark:text-white font-black">{{ $users->total() }}</strong> user
            </span>
            <div>
                {{ $users->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
