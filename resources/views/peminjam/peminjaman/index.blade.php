@extends('layouts.app')

@section('title', 'Peminjaman Buku')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-2 space-y-6">

    {{-- SEARCH --}}
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <form method="GET"
              action="{{ route('peminjam.peminjaman.index') }}"
              class="grid grid-cols-1 md:grid-cols-12 gap-3">

            <div class="md:col-span-10">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari judul buku, penulis, atau ISBN..."
                       class="w-full px-4 py-2.5 rounded-xl text-sm
                              border border-gray-200
                              focus:ring-2 focus:ring-blue-400/30
                              focus:border-blue-400
                              outline-none transition">
            </div>

            <div class="md:col-span-2">
                <button class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2.5 rounded-xl text-sm font-medium transition">
                    Cari
                </button>
            </div>

        </form>
    </div>

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">📚 Buku Tersedia</h2>
        <span class="text-sm text-gray-500">
            {{ $bukus->count() }} buku ditemukan
        </span>
    </div>

    {{-- GRID --}}
    @if($bukus->count() > 0)

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

            @foreach($bukus as $buku)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100
                            hover:shadow-md hover:-translate-y-0.5 transition duration-200 flex flex-col">

                    {{-- COVER --}}
                    <div class="relative h-56 bg-gray-50">
                        @if($buku->foto_cover)
                            <img src="{{ asset('storage/' . $buku->foto_cover) }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                📖
                                <span class="text-xs mt-1">No Cover</span>
                            </div>
                        @endif

                        {{-- STOK --}}
                        <div class="absolute top-3 right-3">
                            <span class="px-2.5 py-1 text-xs rounded-full font-medium
                                {{ $buku->stok > 3
                                    ? 'bg-green-100 text-green-700'
                                    : ($buku->stok > 0
                                        ? 'bg-yellow-100 text-yellow-700'
                                        : 'bg-red-100 text-red-700') }}">
                                Stok {{ $buku->stok }}
                            </span>
                        </div>
                    </div>

                    {{-- CONTENT --}}
                    <div class="p-4 flex flex-col flex-1">

                        <h3 class="font-semibold text-gray-800 text-lg line-clamp-2 mb-2">
                            {{ $buku->judul }}
                        </h3>

                        <div class="text-sm text-gray-600 space-y-1 mb-4">
                            <p>✍️ {{ $buku->pengarang }}</p>
                            <p>📖 {{ $buku->kode_buku ?? '-' }}</p>
                            <p>🏷️ {{ $buku->kategori_buku ?? 'Tanpa Kategori' }}</p>
                            <p>📅 {{ $buku->tahun_terbit ?? '-' }}</p>
                        </div>

                        <div class="text-xs text-gray-500 mb-4">
                            Max pinjam:
                            <span class="font-semibold text-gray-700">
                                {{ $buku->max_pinjam ?? 14 }} hari
                            </span>
                        </div>

                        {{-- BUTTON --}}
                        <div class="flex gap-2 mt-auto">

                            <a href="{{ route('peminjam.peminjaman.show', $buku) }}"
                               class="flex-1 text-center border border-blue-400 text-blue-500
                                      hover:bg-blue-50 px-3 py-2 rounded-xl text-sm font-medium transition">
                                Detail
                            </a>

                            <a href="{{ route('peminjam.peminjaman.create', $buku) }}"
                               class="flex-1 text-center bg-blue-500 hover:bg-blue-600 text-white
                                      px-3 py-2 rounded-xl text-sm font-medium transition">
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
        <div class="text-center py-14 bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="text-5xl mb-2">📕</div>
            <p class="text-gray-500">Tidak ada buku yang tersedia</p>
        </div>

    @endif

    {{-- RIWAYAT --}}
    <a href="{{ route('peminjam.riwayat.index') }}"
       class="block bg-gradient-to-r from-slate-900 to-indigo-900
              hover:from-indigo-900 hover:to-slate-700
              p-6 rounded-2xl text-white group transition">

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