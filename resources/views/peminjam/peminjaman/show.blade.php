@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')

    <!-- Konten Utama -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('peminjam.dashboard') }}" class="hover:text-blue-600">Home</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="{{ route('peminjam.peminjaman.index') }}" class="hover:text-blue-600">Katalog Buku</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="font-medium text-gray-800">Detail Buku</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Tombol Kembali -->
        <a href="{{ route('peminjam.peminjaman.index') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 mb-6 transition">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Katalog
        </a>

        <!-- Bagian Utama Detail Buku -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-0">
                
                <!-- Kolom Kiri: Cover Buku (4/12) -->
                <div class="md:col-span-4 bg-gray-50 p-8 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-200">
                    <div class="relative w-64 h-96 shadow-xl rounded-lg overflow-hidden group">
                        <!-- Cover Image -->
                        @if($buku->foto_cover)
                            <img src="{{ asset('storage/' . $buku->foto_cover) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                <span>No Image</span>
                            </div>
                        @endif
                        
                        <!-- Badge Stok -->
                        <span class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-bold shadow-sm {{ $buku->stok > 0 ? 'bg-green-500' : 'bg-red-500' }} text-white">
                            {{ $buku->stok > 0 ? 'Tersedia' : 'Habis' }}
                        </span>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-500">Kode Buku</p>
                        <p class="font-mono font-medium text-gray-700">{{ $buku->kode_buku }}</p>
                    </div>
                </div>

                <!-- Kolom Kanan: Informasi Buku (8/12) -->
                <div class="md:col-span-8 p-8 flex flex-col">
                    
                    <!-- Header Info -->
                    <div class="mb-6 border-b border-gray-100 pb-4">
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded">{{ $buku->kategori_buku ?? 'Tanpa Kategori' }}</span>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $buku->judul }}</h1>
                        <p class="text-lg text-gray-600">oleh <span class="font-medium text-gray-900">{{ $buku->pengarang }}</span></p>
                    </div>

                    <!-- Grid Metadata -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 mb-6">
                        <div class="flex items-start">
                            <div class="shrink-0 w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Penerbit</p>
                                <p class="text-sm font-medium text-gray-900">{{ $buku->penerbit }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="shrink-0 w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Tahun Terbit</p>
                                <p class="text-sm font-medium text-gray-900">{{ $buku->tahun_terbit }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="shrink-0 w-8 h-8 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Halaman</p>
                                <p class="text-sm font-medium text-gray-900">{{ $buku->jumlah_halaman }} Halaman</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sinopsis -->
                    <div class="mb-auto">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Sinopsis</h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-4">
                            {{ $buku->deskripsi ?? 'Buku ini tidak memiliki deskripsi.' }}
                        </p>
                    </div>

                    <!-- Status & Aksi -->
                    <div class="mt-6 pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-center sm:text-left">
                            <p class="text-sm text-gray-500">Sisa Stok</p>
                            <p class="text-xl font-bold {{ $buku->stok > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $buku->stok }} Buku</p>
                        </div>
                        
                        <div class="flex gap-3 w-full sm:w-auto">
                            @if($buku->stok > 0)
                                <button onclick="confirmBorrow()" class="flex-1 sm:flex-none text-center bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 text-sm font-semibold flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    Ajukan Peminjaman
                                </button>
                            @else
                                <button disabled class="flex-1 sm:flex-none text-center bg-gray-400 text-white px-8 py-3 rounded-lg shadow-lg transition text-sm font-semibold flex items-center justify-center cursor-not-allowed">
                                    Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Script Javascript -->
    <script>
        function confirmBorrow() {
            Swal.fire({
                title: 'Ajukan Peminjaman?',
                text: "Anda akan diarahkan ke form peminjaman buku '{{ addslashes($buku->judul) }}'.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb', // blue-600
                cancelButtonColor: '#d1d5db', // gray-300
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('peminjam.peminjaman.create', $buku->id) }}";
                }
            })
        }
    </script>
@endsection