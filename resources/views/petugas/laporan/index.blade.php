@extends('layouts.app')

@section('title', 'Cetak Laporan')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-2 space-y-6">
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-8 rounded-2xl shadow-2xl mb-6">
        <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">
            Download Laporan <span class="text-indigo-400">Petugas</span>
        </h1>
        <p class="text-slate-400 mt-2">Export data ke format Excel berdasarkan filter yang Anda tentukan.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Laporan Peminjaman -->
        <div class="bg-slate-900/50 backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/10 flex flex-col">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-xl">📋</div>
                <h2 class="text-lg font-bold text-white">Laporan Peminjaman</h2>
            </div>
            
            <form method="POST" action="{{ route('petugas.laporan.peminjaman') }}">
                @csrf
                
                <div class="mb-4">
                    <label class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5 block">Filter Status</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-sm text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition appearance-none">
                        <option value="" class="bg-slate-900">Semua Status</option>
                        <option value="pending" class="bg-slate-900">Pending</option>
                        <option value="disetujui" class="bg-slate-900">Disetujui</option>
                        <option value="ditolak" class="bg-slate-900">Ditolak</option>
                        <option value="selesai" class="bg-slate-900">Selesai</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5 block">Dari</label>
                        <input type="date" name="tanggal_dari" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-sm text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition">
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5 block">Sampai</label>
                        <input type="date" name="tanggal_sampai" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-sm text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition">
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg shadow-indigo-500/20 transition-all active:scale-95 flex items-center justify-center gap-2">
                    <span>📥</span> Download Excel
                </button>
            </form>
        </div>

        <!-- Laporan Pengembalian -->
        <div class="bg-slate-900/50 backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/10 flex flex-col">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-xl">✅</div>
                <h2 class="text-lg font-bold text-white">Laporan Pengembalian</h2>
            </div>
            
            <form method="POST" action="{{ route('petugas.laporan.pengembalian') }}">
                @csrf

                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5 block">Dari</label>
                        <input type="date" name="tanggal_dari" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-sm text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition">
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5 block">Sampai</label>
                        <input type="date" name="tanggal_sampai" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-sm text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition">
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-xs text-slate-500 italic">* Kosongkan filter tanggal untuk mengunduh seluruh data.</p>
                </div>

                <button type="submit" 
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg shadow-emerald-500/20 transition-all active:scale-95 flex items-center justify-center gap-2 mt-auto">
                    <span>📥</span> Download Excel
                </button>
            </form>
        </div>

        <!-- Laporan Buku -->
        <div class="bg-slate-900/50 backdrop-blur-xl p-6 rounded-2xl shadow-2xl border border-white/10 flex flex-col">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center text-xl">📚</div>
                <h2 class="text-lg font-bold text-white">Laporan Data Buku</h2>
            </div>
            
            <form method="POST" action="{{ route('petugas.laporan.buku') }}">
                @csrf
                
                <div class="mb-4">
                    <label class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5 block">Filter Status</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-sm text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition appearance-none">
                        <option value="" class="bg-slate-900">Semua Status</option>
                        <option value="tersedia" class="bg-slate-900">Tersedia</option>
                        <option value="dipinjam" class="bg-slate-900">Dipinjam</option>
                        <option value="rusak" class="bg-slate-900">Rusak</option>
                    </select>
                </div>

                <div class="mb-4">
                    <p class="text-xs text-slate-500 italic">Laporan data buku berdasarkan ketersediaan.</p>
                </div>

                <button type="submit" 
                        class="w-full bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg shadow-amber-500/20 transition-all active:scale-95 flex items-center justify-center gap-2 mt-auto">
                    <span>📥</span> Download Excel
                </button>
            </form>
        </div>

    </div>

    <!-- Info -->
    <div class="bg-indigo-500/10 border border-indigo-500/20 rounded-2xl p-5 flex items-start gap-4">
        <span class="text-2xl">💡</span>
        <div>
            <p class="text-indigo-400 font-bold mb-1 text-sm">Informasi</p>
            <p class="text-sm text-indigo-300/80 leading-relaxed">
                File Excel akan otomatis terunduh setelah server memproses data Anda. Pastikan filter sudah sesuai sebelum menekan tombol download.
            </p>
        </div>
    </div>
</div>
@endsection