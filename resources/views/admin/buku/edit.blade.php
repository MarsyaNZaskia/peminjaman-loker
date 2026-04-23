{{-- resources/views/admin/bukus/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Edit Buku: {{ $buku->kode_buku }}</h1>

    <div class="bg-white p-6 rounded-lg shadow">
        <form method="POST" action="{{ route('admin.buku.update', $buku) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Kode Buku</label>
                <input type="text" name="kode_buku" value="{{ old('kode_buku', $buku->kode_buku) }}" 
                       class="w-full px-3 py-2 border rounded-lg @error('kode_buku') border-red-500 @enderror" 
                       required>
                @error('kode_buku')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Judul</label>
                <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" 
                       class="w-full px-3 py-2 border rounded-lg @error('judul') border-red-500 @enderror" 
                       required>
                @error('judul')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Pengarang</label>
                <input type="text" name="pengarang" value="{{ old('pengarang', $buku->pengarang) }}" 
                       class="w-full px-3 py-2 border rounded-lg @error('pengarang') border-red-500 @enderror" 
                       required>
                @error('pengarang')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Penerbit</label>
                <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" 
                       class="w-full px-3 py-2 border rounded-lg @error('penerbit') border-red-500 @enderror" 
                       required>
                @error('penerbit')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Tahun terbit</label>
                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" 
                       class="w-full px-3 py-2 border rounded-lg @error('tahun_terbit') border-red-500 @enderror" 
                       required>
                @error('tahun_terbit')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Kategori buku</label>
                <input type="text" name="kategori_buku" value="{{ old('kategori_buku', $buku->kategori_buku) }}" 
                       class="w-full px-3 py-2 border rounded-lg @error('kategori_buku') border-red-500 @enderror" 
                       required>
                @error('kategori_buku')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Jumlah Halaman</label>
                <input type="number" name="jumlah_halaman" value="{{ old('jumlah_halaman', $buku->jumlah_halaman) }}" 
                       class="w-full px-3 py-2 border rounded-lg @error('jumlah_halaman') border-red-500 @enderror" 
                       required>
                @error('jumlah_halaman')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Stok</label>
                <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}" 
                       class="w-full px-3 py-2 border rounded-lg @error('stok') border-red-500 @enderror" 
                       required>
                @error('stok')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Status</label>
                <select name="status" 
                        class="w-full px-3 py-2 border rounded-lg @error('status') border-red-500 @enderror" 
                        required>
                    <option value="tersedia" {{ old('status', $buku->status) === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipinjam" {{ old('status', $buku->status) === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="rusak" {{ old('status', $buku->status) === 'rusak' ? 'selected' : '' }}>Rusak</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Foto Cover</label>
                @if($buku->foto_cover)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $buku->foto_cover) }}" alt="Cover Buku" class="w-32 rounded shadow">
                    </div>
                @endif
                <input type="file" name="foto_cover"
                       class="w-full px-3 py-2 border rounded-lg @error('foto_cover') border-red-500 @enderror" >
                @error('foto_cover')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah cover.</p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" rows="3" 
                          class="w-full px-3 py-2 border rounded-lg @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-2">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Update
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