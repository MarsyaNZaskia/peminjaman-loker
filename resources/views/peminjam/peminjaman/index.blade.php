@extends('layouts.app')

@section('title', 'Peminjaman Buku')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-2 space-y-6">

    {{-- SEARCH --}}
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl">
        <form method="GET"
              action="{{ route('peminjam.peminjaman.index') }}"
              class="grid grid-cols-1 md:grid-cols-12 gap-3">

            <div class="md:col-span-10">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari judul buku, penulis, atau ISBN..."
                       class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-sm text-white
                              focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500
                              outline-none transition placeholder-slate-500">
            </div>

            <div class="md:col-span-2">
                <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-500/20 transition-all active:scale-95">
                    Cari Buku
                </button>
            </div>

        </form>
    </div>

    {{-- HEADER --}}
    <div class="flex justify-between items-center px-2">
        <h2 class="text-xl font-bold text-white tracking-tight">📚 Koleksi <span class="text-indigo-400">Buku</span></h2>
        <span class="text-sm text-slate-500">
            {{ $bukus->count() }} hasil ditemukan
        </span>
    </div>

    {{-- GRID --}}
    @if($bukus->count() > 0)

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

            @foreach($bukus as $buku)
                <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden shadow-2xl
                            hover:border-white/20 hover:-translate-y-1 transition duration-300 flex flex-col group">

                    {{-- COVER --}}
                    <div class="relative h-64 bg-slate-800/50 overflow-hidden">
                        @if($buku->foto_cover)
                            <img src="{{ asset('storage/' . $buku->foto_cover) }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-700">
                                <span class="text-6xl">📖</span>
                                <span class="text-[10px] uppercase font-bold tracking-widest mt-2">No Cover</span>
                            </div>
                        @endif

                        {{-- STOK --}}
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full backdrop-blur-md border
                                {{ $buku->stok > 3
                                    ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30'
                                    : ($buku->stok > 0
                                        ? 'bg-amber-500/20 text-amber-300 border-amber-500/30'
                                        : 'bg-rose-500/20 text-rose-300 border-rose-500/30') }}">
                                {{ $buku->stok }} Unit
                            </span>
                        </div>
                    </div>

                    {{-- CONTENT --}}
                    <div class="p-6 flex flex-col flex-1">
                        <h3 class="font-bold text-white text-lg line-clamp-2 mb-3 leading-tight">
                            {{ $buku->judul }}
                        </h3>

                        <div class="text-sm text-slate-400 space-y-2 mb-5">
                            <p class="flex items-center gap-2"><span class="opacity-50 text-xs">Penulis</span> <span class="text-slate-300 font-medium">{{ $buku->pengarang }}</span></p>
                            <p class="flex items-center gap-2"><span class="opacity-50 text-xs">ISBN</span> <span class="text-slate-300 font-medium">{{ $buku->kode_buku ?? '-' }}</span></p>
                            <p class="flex items-center gap-2"><span class="opacity-50 text-xs">Kategori</span> <span class="text-slate-300 font-medium">{{ $buku->kategori_buku ?? 'Tanpa Kategori' }}</span></p>
                        </div>

                        <div class="flex items-center gap-2 mb-6">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Durasi Pinjam:</span>
                            <span class="text-xs font-bold text-indigo-400">{{ $buku->max_pinjam ?? 14 }} Hari</span>
                        </div>

                        {{-- BUTTON --}}
                        <div class="flex gap-3">
                            <a href="{{ route('peminjam.peminjaman.show', $buku) }}"
                               class="flex-1 text-center bg-white/5 border border-white/10 text-slate-300
                                      hover:bg-white/10 hover:text-white px-3 py-2.5 rounded-xl text-sm font-bold transition-all active:scale-95">
                                Detail
                            </a>

                            <a href="{{ route('peminjam.peminjaman.create', $buku) }}"
                               class="flex-1 text-center bg-indigo-600 hover:bg-indigo-700 text-white
                                      px-3 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-500/20 transition-all active:scale-95">
                                Pinjam
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>

        {{-- PAGINATION --}}
        @if($bukus->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $bukus->links() }}
            </div>
        @endif

    @else

        {{-- EMPTY --}}
        <div class="text-center py-20 bg-slate-900/50 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/10">
            <div class="text-6xl mb-4 opacity-50">📕</div>
            <p class="text-slate-400 font-medium">Maaf, tidak ada buku yang tersedia saat ini.</p>
        </div>

    @endif

    {{-- RIWAYAT --}}
    <a href="{{ route('peminjam.riwayat.index') }}"
       class="block bg-gradient-to-r from-slate-900 to-indigo-950
              border border-white/10 hover:border-indigo-500/50
              p-8 rounded-2xl text-white group transition-all shadow-2xl">

        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-xl font-bold">📋 Riwayat Peminjaman</h2>
                <p class="text-sm text-white/70 mt-1">
                    Cek status dan history peminjaman Anda
                </p>
            </div>

            <span class="group-hover:translate-x-2 transition text-xl">
                →
            </span>

        </div>

    </a>

</div>
@endsection