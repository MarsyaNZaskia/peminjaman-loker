{{-- resources/views/admin/lokers/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Loker')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Edit Loker: {{ $loker->nomor_loker }}</h1>

    <div class="bg-white p-6 rounded-lg shadow">
        <form method="POST" action="{{ route('admin.lokers.update', $loker) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nomor Loker</label>
                <input type="text" name="nomor_loker" value="{{ old('nomor_loker', $loker->nomor_loker) }}" 
                       class="w-full px-3 py-2 border rounded-lg @error('nomor_loker') border-red-500 @enderror" 
                       required>
                @error('nomor_loker')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Lokasi</label>
                <input type="text" name="lokasi" value="{{ old('lokasi', $loker->lokasi) }}" 
                       class="w-full px-3 py-2 border rounded-lg @error('lokasi') border-red-500 @enderror" 
                       required>
                @error('lokasi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Ukuran</label>
                <select name="ukuran" 
                        class="w-full px-3 py-2 border rounded-lg @error('ukuran') border-red-500 @enderror" 
                        required>
                    <option value="kecil" {{ old('ukuran', $loker->ukuran) === 'kecil' ? 'selected' : '' }}>Kecil</option>
                    <option value="sedang" {{ old('ukuran', $loker->ukuran) === 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="besar" {{ old('ukuran', $loker->ukuran) === 'besar' ? 'selected' : '' }}>Besar</option>
                </select>
                @error('ukuran')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Status</label>
                <select name="status" 
                        class="w-full px-3 py-2 border rounded-lg @error('status') border-red-500 @enderror" 
                        required>
                    <option value="tersedia" {{ old('status', $loker->status) === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipinjam" {{ old('status', $loker->status) === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="rusak" {{ old('status', $loker->status) === 'rusak' ? 'selected' : '' }}>Rusak</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Keterangan</label>
                <textarea name="keterangan" rows="3" 
                          class="w-full px-3 py-2 border rounded-lg @error('keterangan') border-red-500 @enderror">{{ old('keterangan', $loker->keterangan) }}</textarea>
                @error('keterangan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-2">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Update
                </button>
                <a href="{{ route('admin.lokers.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection