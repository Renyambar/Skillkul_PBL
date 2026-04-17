@extends('layouts.app')
@section('title', 'Dasbor Freelancer')
@section('content')
<main class="bg-slate-50 min-h-screen py-10 px-6 lg:px-12">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-500">Halo, {{ auth()->user()->name }}</h2>
            <p class="text-slate-500 text-sm mt-1">Pantau aktivitas profesional Anda hari ini.</p>
        </div>
        
        <form action="{{ route('freelancer.exam_mode.toggle') }}" method="POST" class="bg-white border border-indigo-100 rounded-2xl p-4 flex items-center gap-6 shadow-[0_8px_30px_rgb(79,70,229,0.05)]">
            @csrf
            <div>
                <h4 class="text-sm font-bold text-indigo-900 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg> MODE UJIAN
                </h4>
                <p class="text-[10px] text-slate-500">Aktifkan untuk fokus belajar.</p>
            </div>
            <button type="submit" class="w-14 h-8 {{ auth()->user()->is_exam_mode ? 'bg-indigo-600' : 'bg-slate-200' }} rounded-full relative p-1 transition-colors shadow-inner">
                <div class="w-6 h-6 bg-white rounded-full shadow-sm {{ auth()->user()->is_exam_mode ? 'ml-auto' : '' }} transition-all"></div>
            </button>
        </form>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] p-8">
        <h3 class="font-bold text-lg text-slate-900 mb-6">Sedang Dikerjakan (In Progress)</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-xs font-bold text-slate-400 uppercase border-b border-slate-100">
                        <th class="pb-4">Proyek</th>
                        <th class="pb-4">Status</th>
                        <th class="pb-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-5 font-bold text-slate-800">Aplikasi Web Laravel</td>
                        <td class="py-5"><span class="bg-blue-50 text-blue-600 border border-blue-100 text-[10px] font-bold px-3 py-1 rounded-lg">IN PROGRESS</span></td>
                        <td class="py-5 text-right"><a href="#" class="bg-slate-900 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-indigo-600 transition-colors">Kirim Tugas</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
