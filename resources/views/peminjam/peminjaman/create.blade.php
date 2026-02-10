@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Ajukan Peminjaman Loker</h1>

    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="text-xl font-bold mb-4">Informasi Loker</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600">Nomor Loker</p>
                <p class="font-semibold text-lg">{{ $loker->nomor_loker }}</p>
            </div>
            <div>
                <p class="text-gray-600">Lokasi</p>
                <p class="font-semibold">{{ $loker->lokasi }}</p>
            </div>
            <div>
                <p class="text-gray-600">Ukuran</p>
                <p class="font-semibold">{{ ucfirst($loker->ukuran) }}</p>
            </div>
            <div>
                <p class="text-gray-600">Status</p>
                <span class="px-3 py-1 rounded text-sm bg-green-100 text-green-800">Tersedia</span>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Form Peminjaman</h2>
        
        <form method="POST" action="{{ route('peminjam.peminjaman.store') }}">
            @csrf
            <input type="hidden" name="loker_id" value="{{ $loker->id }}">

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Tanggal Mulai Pinjam</label>
                <input type="date" name="tanggal_pinjam" 
                       value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" 
                       min="{{ date('Y-m-d') }}"
                       class="w-full px-3 py-2 border rounded-lg @error('tanggal_pinjam') border-red-500 @enderror" 
                       required>
                @error('tanggal_pinjam')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Tanggal Rencana Kembali</label>
                <input type="date" name="tanggal_kembali_rencana" 
                    value="{{ old('tanggal_kembali_rencana') }}" 
                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                    class="w-full px-3 py-2 border rounded-lg @error('tanggal_kembali_rencana') border-red-500 @enderror" 
                    required>
                @error('tanggal_kembali_rencana')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                    <p class="text-sm text-gray-500 mt-1">Kapan Anda berencana mengembalikan loker?</p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Keperluan Peminjaman</label>
                <textarea name="keperluan" rows="4" 
                          class="w-full px-3 py-2 border rounded-lg @error('keperluan') border-red-500 @enderror" 
                          placeholder="Jelaskan keperluan Anda meminjam loker ini..."
                          required>{{ old('keperluan') }}</textarea>
                @error('keperluan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-2">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Ajukan Peminjaman
                </button>
                <a href="{{ route('peminjam.peminjaman.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection