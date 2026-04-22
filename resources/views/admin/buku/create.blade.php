{{-- resources/views/admin/lokers/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Tambah Buku Baru</h1>

    <div class="bg-white p-6 rounded-lg shadow">
        <form method="POST" action="{{ route('admin.buku.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Kode Buku</label>
                <input type="text" name="kode_buku" value="{{ old('kode_buku') }}" 
                       placeholder="Contoh: Bk1091 " 
                       class="w-full px-3 py-2 border rounded-lg @error('kode_buku') border-red-500 @enderror" 
                       required>
                @error('kode_buku')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Judul</label>
                <input type="text" name="judul" value="{{ old('judul') }}" 
                       placeholder="Contoh: Filosofi Teras" 
                       class="w-full px-3 py-2 border rounded-lg @error('judul') border-red-500 @enderror" 
                       required>
                @error('judul')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Pengarang</label>
                <input type="text" name="pengarang" value="{{ old('pengarang') }}" 
                       placeholder="Contoh: Henry Manampiring" 
                       class="w-full px-3 py-2 border rounded-lg @error('pengarang') border-red-500 @enderror" 
                       required>
                @error('pengarang')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Penerbit</label>
                <input type="text" name="penerbit" value="{{ old('penerbit') }}" 
                       placeholder="Contoh: Erlangga" 
                       class="w-full px-3 py-2 border rounded-lg @error('penerbit') border-red-500 @enderror" 
                       >
                @error('penerbit')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Tahun terbit</label>
                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" 
                       placeholder="Contoh: 2020" 
                       class="w-full px-3 py-2 border rounded-lg @error('tahun_terbit') border-red-500 @enderror" 
                       >
                @error('tahun_terbit')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Kategori buku</label>
                <input type="text" name="kategori_buku" value="{{ old('kategori_buku') }}" 
                       placeholder="Contoh: Lantai 1" 
                       class="w-full px-3 py-2 border rounded-lg @error('kategori_buku') border-red-500 @enderror" 
                       >
                @error('kategori_buku')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Jumlah Halaman</label>
                <input type="number" name="jumlah_halaman" value="{{ old('jumlah_halaman') }}" 
                       placeholder="Contoh: Lantai 1" 
                       class="w-full px-3 py-2 border rounded-lg @error('jumlah_halaman') border-red-500 @enderror" 
                       required>
                @error('jumlah_halaman')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Stok</label>
                <input type="int" name="stok" value="{{ old('stok') }}" 
                       placeholder="" 
                       class="w-full px-3 py-2 border rounded-lg @error('stok') border-red-500 @enderror" 
                       required>
                @error('stok')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Foto Cover</label>
                <input type="file" name="cover" value="{{ old('foto_cover') }}" 
                       placeholder="" 
                       class="w-full px-3 py-2 border rounded-lg @error('foto_cover') border-red-500 @enderror" >
                @error('foto_cover')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" rows="3" 
                          class="w-full px-3 py-2 border rounded-lg @error('deskripsi') border-red-500 @enderror" 
                          placeholder="Deskripsi Buku">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-2">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Simpan
                </button>
                <a href="{{ route('admin.buku.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection