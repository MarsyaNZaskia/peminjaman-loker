@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Tambah Kategori Baru</h1>

    <div class="bg-white p-6 rounded-lg shadow">
        <form method="POST" action="{{ route('admin.kategoris.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" 
                       placeholder="Contoh: Kelas 10" 
                       class="w-full px-3 py-2 border rounded-lg @error('nama_kategori') border-red-500 @enderror" 
                       required>
                @error('nama_kategori')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Keterangan (Opsional)</label>
                <textarea name="keterangan" rows="3" 
                          class="w-full px-3 py-2 border rounded-lg @error('keterangan') border-red-500 @enderror" 
                          placeholder="Keterangan tambahan...">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-2">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Simpan
                </button>
                <a href="{{ route('admin.kategoris.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection