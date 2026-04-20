@extends('layouts.freelancer')
@section('title', 'Layanan Saya - SkillKul')
@section('content')
<div class="p-8 lg:p-10">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-brand-dark tracking-tight mb-1">Manajemen Layanan Saya</h1>
            <p class="text-sm text-gray-500">Kelola semua jasa yang Anda tawarkan di marketplace SkillKul.</p>
        </div>
        <a href="{{ route('freelancer.jasa.create') }}" class="inline-flex items-center gap-2 bg-brand-primary hover:bg-brand-dark text-white text-sm font-bold px-6 py-3 rounded-xl transition-all shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Buka Jasa Baru
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Total Jasa</p>
            <h3 class="text-2xl font-extrabold text-brand-dark">4</h3>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Jasa Aktif</p>
            <h3 class="text-2xl font-extrabold text-green-600">3</h3>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Non-Aktif</p>
            <h3 class="text-2xl font-extrabold text-gray-400">1</h3>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Total Pesanan</p>
            <h3 class="text-2xl font-extrabold text-brand-primary">27</h3>
        </div>
    </div>

    {{-- Tabel Jasa --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest border-b border-gray-100 bg-gray-50">
                        <th class="px-6 py-4">Judul Jasa</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Pesanan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=80&q=80" class="w-10 h-10 rounded-lg object-cover">
                                <div>
                                    <p class="font-bold text-gray-900">Pembuatan Landing Page</p>
                                    <p class="text-[10px] text-gray-400">Programming & Tech</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5"><span class="bg-green-100 text-green-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase">Non-Project</span></td>
                        <td class="px-6 py-5 font-bold text-brand-primary">Rp 1.500.000</td>
                        <td class="px-6 py-5 text-gray-600">12 pesanan</td>
                        <td class="px-6 py-5">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-500"></div>
                                <span class="ml-2 text-xs font-semibold text-green-600">Aktif</span>
                            </label>
                        </td>
                        <td class="px-6 py-5 text-right space-x-2">
                            <button class="text-brand-primary font-bold text-xs hover:underline">Edit</button>
                            <button class="text-red-500 font-bold text-xs hover:underline">Hapus</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1586281380349-632531db7ed4?auto=format&fit=crop&w=80&q=80" class="w-10 h-10 rounded-lg object-cover">
                                <div>
                                    <p class="font-bold text-gray-900">Proofreading Jurnal Ilmiah</p>
                                    <p class="text-[10px] text-gray-400">Penulisan</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5"><span class="bg-green-100 text-green-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase">Non-Project</span></td>
                        <td class="px-6 py-5 font-bold text-brand-primary">Rp 50.000</td>
                        <td class="px-6 py-5 text-gray-600">8 pesanan</td>
                        <td class="px-6 py-5">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-500"></div>
                                <span class="ml-2 text-xs font-semibold text-green-600">Aktif</span>
                            </label>
                        </td>
                        <td class="px-6 py-5 text-right space-x-2">
                            <button class="text-brand-primary font-bold text-xs hover:underline">Edit</button>
                            <button class="text-red-500 font-bold text-xs hover:underline">Hapus</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?auto=format&fit=crop&w=80&q=80" class="w-10 h-10 rounded-lg object-cover">
                                <div>
                                    <p class="font-bold text-gray-900">Desain Poster & Branding</p>
                                    <p class="text-[10px] text-gray-400">Design & Creative</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5"><span class="bg-orange-100 text-orange-700 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase">Project</span></td>
                        <td class="px-6 py-5 font-bold text-brand-primary">Rp 75.000</td>
                        <td class="px-6 py-5 text-gray-600">5 pesanan</td>
                        <td class="px-6 py-5">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-500"></div>
                                <span class="ml-2 text-xs font-semibold text-green-600">Aktif</span>
                            </label>
                        </td>
                        <td class="px-6 py-5 text-right space-x-2">
                            <button class="text-brand-primary font-bold text-xs hover:underline">Edit</button>
                            <button class="text-red-500 font-bold text-xs hover:underline">Hapus</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors bg-gray-50/30">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=80&q=80" class="w-10 h-10 rounded-lg object-cover opacity-50">
                                <div>
                                    <p class="font-bold text-gray-400">Analisis Data Excel</p>
                                    <p class="text-[10px] text-gray-300">Matematika/Statistik</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5"><span class="bg-gray-100 text-gray-500 text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase">Non-Project</span></td>
                        <td class="px-6 py-5 font-bold text-gray-400">Rp 200.000</td>
                        <td class="px-6 py-5 text-gray-400">2 pesanan</td>
                        <td class="px-6 py-5">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-500"></div>
                                <span class="ml-2 text-xs font-semibold text-gray-400">Non-aktif</span>
                            </label>
                        </td>
                        <td class="px-6 py-5 text-right space-x-2">
                            <button class="text-brand-primary font-bold text-xs hover:underline">Edit</button>
                            <button class="text-red-500 font-bold text-xs hover:underline">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
