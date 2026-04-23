@extends('layouts.app')

@section('title', 'Peminjaman Buku')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Peminjaman Buku</h1>

    <!-- Search & Filter -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <form method="GET" action="{{ route('peminjam.peminjaman.index') }}" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari judul buku, penulis, atau ISBN..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            </div>
            <select name="kategori" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                <option value="">Semua Kategori</option>
                @foreach($kategoris ?? [] as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition">
                Cari
            </button>
        </form>
    </div>

    <!-- Buku Tersedia -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">📚 Buku Tersedia</h2>
            <span class="text-sm text-gray-500">{{ $bukus->count() }} buku ditemukan</span>
        </div>
        
        @if($bukus->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($bukus as $buku)
                    <div class="border rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col">
                        
                        {{-- Cover Buku --}}
                        <div class="relative bg-gray-100 h-52 shrink-0">
                            @if($buku->foto_cover)
                                <img src="{{ asset('storage/' . $buku->foto_cover) }}" 
                                     alt="{{ $buku->judul }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                    <svg class="w-16 h-16 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <span class="text-xs">Tidak ada cover</span>
                                </div>
                            @endif

                            {{-- Badge Stok --}}
                            <span class="absolute top-2 right-2 px-2 py-1 rounded text-xs font-medium 
                                         {{ $buku->stok > 3 ? 'bg-green-500 text-white' : ($buku->stok > 0 ? 'bg-yellow-500 text-white' : 'bg-red-500 text-white') }}">
                                Stok: {{ $buku->stok }}
                            </span>
                        </div>

                        {{-- Info Buku --}}
                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="text-lg font-bold leading-tight mb-2 line-clamp-2" title="{{ $buku->judul }}">
                                {{ $buku->judul }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-1">✍️ Pengarang : {{ $buku->pengarang }}</p>
                            <p class="text-gray-600 text-sm mb-1">📖 ISBN: {{ $buku->kode_buku ?? '-' }}</p>
                            <p class="text-gray-600 text-sm mb-1">🏷️ {{ $buku->kategori->nama ?? 'Tanpa Kategori' }}</p>
                            <p class="text-gray-600 text-sm mb-3">📅 Tahun: {{ $buku->tahun_terbit ?? '-' }}</p>
                            
                            {{-- Info stok --}}
                            <div class="flex items-center justify-between mb-4 text-sm">
                                <span class="text-gray-500">Max pinjam: <strong>{{ $buku->max_pinjam ?? 14 }} hari</strong></span>
                            </div>

                            <div class="flex gap-2 mt-auto">
                                <a href="{{ route('peminjam.peminjaman.show', $buku) }}" 
                                   class="flex-1 text-center border-2 border-blue-500 text-blue-500 hover:bg-blue-50 px-3 py-2 rounded transition text-sm font-medium">
                                    Detail
                                </a>
                                <a href="{{ route('peminjam.peminjaman.create', $buku) }}" 
                                   class="flex-1 text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded transition text-sm font-medium">
                                    Pinjam
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($bukus->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $bukus->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-8">
                <p class="text-gray-400 text-5xl mb-3">📕</p>
                <p class="text-gray-500">Tidak ada buku yang tersedia saat ini</p>
            </div>
        @endif
    </div>

    <!-- Menu Riwayat -->
    <div class="mt-8">
        <a href="{{ route('peminjam.riwayat.index') }}" 
           class="block bg-linear-to-r from-slate-900 to-indigo-900 hover:from-indigo-900 hover:to-slate-700 p-6 rounded-xl shadow-lg text-white group transition-all transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">📋 Lihat Riwayat Peminjaman</h2>
                    <p class="text-purple-100">Cek status dan history peminjaman buku Anda</p>
                </div>
                <svg class="w-8 h-8 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </div>
        </a>
    </div>
</div>

<script>
function deleteConfirm(formId) {
    Swal.fire({
        title: 'Yakin ingin membatalkan?',
        text: 'Peminjaman yang dibatalkan tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Batalkan!',
        confirmButtonColor: '#dc2626',
        cancelButtonText: 'Tidak',
        cancelButtonColor: '#6b7280'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}

function showReasonAlert(reason) {
    Swal.fire({
        title: 'Alasan Penolakan',
        text: reason,
        icon: 'info',
        confirmButtonText: 'Tutup'
    });
}
</script>
@endsection