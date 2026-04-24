@extends('layouts.app')

@section('title', 'Detail Pengembalian')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-4 rounded-2xl shadow-2xl mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-xl shadow-lg shadow-indigo-500/10">📜</div>
            <h1 class="text-xl font-black text-white tracking-tight">Detail <span class="text-indigo-400">Pengembalian</span></h1>
        </div>
        <a href="{{ route('petugas.pengembalian.index') }}" 
           class="px-4 py-2 bg-white/5 hover:bg-white/10 text-white border border-white/10 rounded-xl text-xs font-bold transition-all active:scale-95 uppercase tracking-wider">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Info Peminjam -->
        <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl">
            <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 ml-1">Informasi Peminjam</h2>
            <div class="space-y-4">
                <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Nama Peminjam</p>
                    <p class="font-bold text-white">{{ $pengembalian->peminjaman->user->name }}</p>
                </div>
                <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Username</p>
                    <p class="font-bold text-white">{{ $pengembalian->peminjaman->user->username }}</p>
                </div>
                @if($pengembalian->peminjaman->user->kategori)
                    <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Kategori</p>
                        <p class="font-bold text-indigo-400">{{ $pengembalian->peminjaman->user->kategori->nama_kategori }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Info Buku -->
        <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl">
            <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 ml-1">Informasi Buku</h2>
            <div class="space-y-4">
                <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Kode Buku</p>
                    <p class="font-black text-xl text-white tracking-tighter">{{ $pengembalian->peminjaman->buku->kode_buku }}</p>
                </div>
                <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Judul</p>
                    <p class="font-bold text-white">{{ $pengembalian->peminjaman->buku->judul }}</p>
                </div>
                <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Pengarang</p>
                    <p class="font-bold text-slate-400">{{ $pengembalian->peminjaman->buku->pengarang }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Peminjaman -->
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl mb-6">
        <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 ml-1">Detail Peminjaman</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Tanggal Pinjam</p>
                <p class="font-bold text-white">{{ $pengembalian->peminjaman->tanggal_pinjam->format('d M Y') }}</p>
            </div>
            <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Rencana Kembali</p>
                <p class="font-bold text-indigo-400">{{ $pengembalian->peminjaman->tanggal_kembali_rencana->format('d M Y') }}</p>
            </div>
            <div class="col-span-2 bg-white/5 p-4 rounded-xl border border-white/5">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Keperluan</p>
                <p class="font-medium text-slate-300">{{ $pengembalian->peminjaman->keperluan }}</p>
            </div>
        </div>
    </div>

    <!-- Detail Pengembalian -->
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-8 rounded-3xl shadow-2xl mb-6">
        <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-8 ml-1">Detail Pengembalian</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-6">
                <div class="bg-white/5 p-5 rounded-2xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Tanggal Pengembalian Aktual</p>
                    <p class="text-xl font-black text-white">{{ $pengembalian->tgl_kembali_realisasi->format('d M Y') }}</p>
                </div>
                <div class="bg-white/5 p-5 rounded-2xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3">Kondisi Buku Saat Kembali</p>
                    <p>
                        @if($pengembalian->kondisi_barang === 'baik')
                            <span class="px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Kondisi Baik</span>
                        @elseif($pengembalian->kondisi_barang === 'rusak')
                            <span class="px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20">Buku Rusak</span>
                        @else
                            <span class="px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-full bg-rose-500/10 text-rose-400 border border-rose-500/20">Buku Hilang</span>
                        @endif
                    </p>
                </div>
                <div class="bg-white/5 p-5 rounded-2xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Keterangan Waktu</p>
                    @php
                        $keterlambatan = $pengembalian->hitungKeterlambatan();
                    @endphp
                    @if($pengembalian->kondisi_barang === 'baik')
                        @if($keterlambatan > 0)
                            <p class="font-bold text-rose-400 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                                Terlambat ({{ $keterlambatan }} hari)
                            </p>
                        @else
                            <p class="font-bold text-emerald-400 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Tepat Waktu
                            </p>
                        @endif
                    @else
                        <p class="font-bold text-slate-500">-</p>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-indigo-500/10 p-6 rounded-3xl border border-indigo-500/20 shadow-xl shadow-indigo-500/5">
                    <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-2">Total Denda</p>
                    @if($pengembalian->total_denda > 0)
                        <p class="text-3xl font-black text-white tracking-tighter">Rp {{ number_format($pengembalian->total_denda, 0, ',', '.') }}</p>
                        <p class="text-[10px] font-bold text-rose-400 mt-2 uppercase tracking-widest">
                            @if($pengembalian->kondisi_barang === 'hilang') Denda Kehilangan @elseif($pengembalian->kondisi_barang === 'rusak') Denda Kerusakan @else Denda Keterlambatan @endif
                        </p>
                    @else
                        <p class="text-3xl font-black text-emerald-400 tracking-tighter">Rp 0</p>
                        <p class="text-[10px] font-bold text-emerald-500/50 mt-2 uppercase tracking-widest">Bebas Denda</p>
                    @endif
                </div>

                <div class="bg-white/5 p-5 rounded-2xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Dicatat Oleh</p>
                    <p class="font-bold text-white">{{ $pengembalian->user->name }}</p>
                </div>

                @if($pengembalian->catatan)
                    <div class="bg-white/5 p-5 rounded-2xl border border-white/5">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Catatan</p>
                        <p class="font-medium text-slate-300 leading-relaxed">{{ $pengembalian->catatan }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection