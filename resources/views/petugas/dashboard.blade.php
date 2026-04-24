@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-slate-900/50 backdrop-blur-xl p-8 rounded-3xl border border-white/10 shadow-2xl relative overflow-hidden group">
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl group-hover:bg-indigo-500/20 transition-all duration-700"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-black text-white mb-2 tracking-tight">Halo, <span class="text-indigo-400">{{ auth()->user()->name }}</span>!</h1>
                    <p class="text-slate-400 text-lg">Siap untuk mengelola sirkulasi buku hari ini?</p>
                </div>
                <div class="text-6xl drop-shadow-2xl">👮</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-slate-900/50 backdrop-blur-xl p-6 rounded-3xl border border-white/10 shadow-xl hover:bg-white/[0.08] transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Total Buku</h3>
                    <p class="text-3xl font-black mt-2 text-white">{{ \App\Models\Buku::count() }}</p>
                </div>
                <div class="text-3xl opacity-20 group-hover:opacity-100 transition-opacity">📚</div>
            </div>
        </div>
        <div class="bg-slate-900/50 backdrop-blur-xl p-6 rounded-3xl border border-white/10 shadow-xl hover:bg-white/[0.08] transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Buku Dipinjam</h3>
                    <p class="text-3xl font-black text-amber-400 mt-2">{{ \App\Models\Buku::where('status', 'dipinjam')->count() }}</p>
                </div>
                <div class="text-3xl opacity-20 group-hover:opacity-100 transition-opacity">⏳</div>
            </div>
        </div>
        <div class="bg-slate-900/50 backdrop-blur-xl p-6 rounded-3xl border border-white/10 shadow-xl hover:bg-white/[0.08] transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Pending</h3>
                    <p class="text-3xl font-black text-rose-400 mt-2">{{ \App\Models\Peminjaman::where('status', 'pending')->count() }}</p>
                </div>
                <div class="text-3xl opacity-20 group-hover:opacity-100 transition-opacity">⏰</div>
            </div>
        </div>
        <div class="bg-slate-900/50 backdrop-blur-xl p-6 rounded-3xl border border-white/10 shadow-xl hover:bg-white/[0.08] transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Pengembalian</h3>
                    <p class="text-3xl font-black text-emerald-400 mt-2">{{ \App\Models\Pengembalian::count() }}</p>
                </div>
                <div class="text-3xl opacity-20 group-hover:opacity-100 transition-opacity">✅</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-slate-900/50 backdrop-blur-xl p-8 rounded-3xl border border-white/10 shadow-2xl relative overflow-hidden group hover:scale-[1.02] transition-all duration-500">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-500/5 rounded-full blur-3xl group-hover:bg-indigo-500/10 transition-all duration-500"></div>
            <div class="relative z-10 flex flex-col h-full">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-2xl">📋</div>
                    <h2 class="text-2xl font-black text-white">Kelola Peminjaman</h2>
                </div>
                <p class="text-slate-400 mb-8 leading-relaxed">
                    Setujui atau tolak permintaan peminjaman buku dari siswa dengan cepat dan efisien.
                </p>
                <a href="{{ route('petugas.peminjaman.index') }}" 
                   class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-2xl font-bold transition-all shadow-lg shadow-indigo-500/20 active:scale-95 mt-auto">
                    <span>Masuk ke Modul</span>
                    <span class="ml-2">→</span>
                </a>
            </div>
        </div>

        <div class="bg-slate-900/50 backdrop-blur-xl p-8 rounded-3xl border border-white/10 shadow-2xl relative overflow-hidden group hover:scale-[1.02] transition-all duration-500">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-emerald-500/5 rounded-full blur-3xl group-hover:bg-emerald-500/10 transition-all duration-500"></div>
            <div class="relative z-10 flex flex-col h-full">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-2xl">🏁</div>
                    <h2 class="text-2xl font-black text-white">Data Pengembalian</h2>
                </div>
                <p class="text-slate-400 mb-8 leading-relaxed">
                    Pantau histori pengembalian buku, periksa kondisi barang, dan kelola data denda jika ada.
                </p>
                <a href="{{ route('petugas.pengembalian.index') }}" 
                   class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-2xl font-bold transition-all shadow-lg shadow-emerald-500/20 active:scale-95 mt-auto">
                    <span>Buka Histori</span>
                    <span class="ml-2">→</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection