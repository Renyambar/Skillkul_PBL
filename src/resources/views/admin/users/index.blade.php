@extends('layouts.admin')
@section('title', 'Admin - Manajemen User')
@section('content')
<div class="p-8 lg:p-10">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-brand-dark tracking-tight">Manajemen User & Verifikasi</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola status freelancer dan verifikasi data mahasiswa.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="bg-indigo-50 text-brand-primary text-xs font-bold px-4 py-2 rounded-lg">Total: 12 Freelancer</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest border-b border-gray-100 bg-gray-50">
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Universitas</th>
                        <th class="px-6 py-4">Jurusan</th>
                        <th class="px-6 py-4">NIM</th>
                        <th class="px-6 py-4">Status KTM</th>
                        <th class="px-6 py-4">Status Akun</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <img src="https://i.pravatar.cc/150?img=33" class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="font-bold text-gray-900">Alex Chandra</p>
                                    <p class="text-[10px] text-gray-400">alex@email.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-gray-600">Universitas Indonesia</td>
                        <td class="px-6 py-5 text-gray-600">Ilmu Komputer</td>
                        <td class="px-6 py-5 font-mono text-xs text-gray-500">2024001</td>
                        <td class="px-6 py-5"><span class="bg-green-100 text-green-700 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider">Terverifikasi</span></td>
                        <td class="px-6 py-5"><span class="bg-green-100 text-green-700 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider">Aktif</span></td>
                        <td class="px-6 py-5 text-right">
                            <button class="bg-red-50 text-red-600 px-4 py-2 rounded-lg text-xs font-bold hover:bg-red-100 transition-colors">Nonaktifkan</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <img src="https://i.pravatar.cc/150?img=47" class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="font-bold text-gray-900">Siti Aisyah</p>
                                    <p class="text-[10px] text-gray-400">siti@email.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-gray-600">ITB</td>
                        <td class="px-6 py-5 text-gray-600">Desain Komunikasi Visual</td>
                        <td class="px-6 py-5 font-mono text-xs text-gray-500">2023045</td>
                        <td class="px-6 py-5"><span class="bg-yellow-100 text-yellow-700 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider">Menunggu</span></td>
                        <td class="px-6 py-5"><span class="bg-green-100 text-green-700 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider">Aktif</span></td>
                        <td class="px-6 py-5 text-right space-x-2">
                            <button class="bg-brand-primary text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-brand-dark transition-colors">Verifikasi</button>
                            <button class="bg-red-50 text-red-600 px-4 py-2 rounded-lg text-xs font-bold hover:bg-red-100 transition-colors">Tolak</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors bg-red-50/30">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <img src="https://i.pravatar.cc/150?img=12" class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="font-bold text-gray-900">Budi Santoso</p>
                                    <p class="text-[10px] text-gray-400">budi@email.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-gray-600">UGM</td>
                        <td class="px-6 py-5 text-gray-600">Teknik Informatika</td>
                        <td class="px-6 py-5 font-mono text-xs text-gray-500">2022112</td>
                        <td class="px-6 py-5"><span class="bg-green-100 text-green-700 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider">Terverifikasi</span></td>
                        <td class="px-6 py-5"><span class="bg-red-100 text-red-700 text-[10px] font-extrabold px-3 py-1 rounded-lg uppercase tracking-wider">Nonaktif</span></td>
                        <td class="px-6 py-5 text-right">
                            <button class="bg-green-50 text-green-600 px-4 py-2 rounded-lg text-xs font-bold hover:bg-green-100 transition-colors">Aktifkan</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
