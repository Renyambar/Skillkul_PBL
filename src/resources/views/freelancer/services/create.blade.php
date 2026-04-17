@extends('layouts.app')
@section('title', 'Buka Jasa Baru')
@section('content')
<main class="bg-slate-50 min-h-screen py-10 px-6">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-extrabold text-slate-900 mb-8">Buka Jasa Baru</h2>
        
        <div class="bg-white p-8 lg:p-10 rounded-[2.5rem] shadow-[0_20px_40px_rgb(0,0,0,0.02)] border border-slate-100">
            <form action="{{ route('services.store') }}" method="POST" class="space-y-8">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Judul Layanan</label>
                    <input type="text" name="title" placeholder="Ciptakan judul yang menjual..." class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl px-5 py-4 text-sm transition-all outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Model Bisnis (Tipe Jasa)</label>
                        <select name="type" class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl px-5 py-4 text-sm transition-all outline-none appearance-none cursor-pointer">
                            <option value="non_project">Harga Pasti (Direct Checkout)</option>
                            <option value="project">Project Based (Nego via WA)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Estimasi Harga (Rp)</label>
                        <input type="number" name="price" placeholder="150000" class="w-full bg-emerald-50/50 border border-emerald-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 rounded-2xl px-5 py-4 font-bold text-emerald-900 transition-all outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Detail</label>
                    <textarea name="description" rows="6" class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl px-5 py-4 text-sm transition-all outline-none resize-none"></textarea>
                </div>

                <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold shadow-lg shadow-slate-900/20 hover:bg-indigo-600 hover:-translate-y-0.5 transition-all">
                    Publikasikan Jasa
                </button>
            </form>
        </div>
    </div>
</main>
@endsection
