{{-- resources/views/admin/pengembalian/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Pengembalian')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Edit Data Pengembalian</h1>

    <div class="bg-white p-6 rounded-lg shadow mb-4">
        <h2 class="text-lg font-bold mb-2">Info Peminjaman</h2>
        <p><strong>Peminjam:</strong> {{ $pengembalian->peminjaman->user->name }}</p>
        <p><strong>Loker:</strong> {{ $pengembalian->peminjaman->loker->nomor_loker }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <form method="POST" action="{{ route('admin.pengembalian.update', $pengembalian) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Tanggal Pengembalian Aktual</label>
                <input type="date" name="tgl_kembali_realisasi" 
                       value="{{ old('tgl_kembali_realisasi', $pengembalian->tgl_kembali_realisasi->format('Y-m-d')) }}" 
                       class="w-full px-3 py-2 border rounded-lg @error('tgl_kembali_realisasi') border-red-500 @enderror" 
                       required>
                @error('tgl_kembali_realisasi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Kondisi Barang</label>
                <select name="kondisi_barang" 
                        class="w-full px-3 py-2 border rounded-lg @error('kondisi_barang') border-red-500 @enderror" 
                        required>
                    <option value="baik" {{ old('kondisi_barang', $pengembalian->kondisi_barang) === 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="rusak_ringan" {{ old('kondisi_barang', $pengembalian->kondisi_barang) === 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="rusak_berat" {{ old('kondisi_barang', $pengembalian->kondisi_barang) === 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                    <option value="hilang" {{ old('kondisi_barang', $pengembalian->kondisi_barang) === 'hilang' ? 'selected' : '' }}>Hilang</option>
                </select>
                @error('kondisi_barang')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Jenis Denda</label>
                <select name="jenis_denda" 
                        class="w-full px-3 py-2 border rounded-lg @error('jenis_denda') border-red-500 @enderror" 
                        required>
                    <option value="tidak_ada" {{ old('jenis_denda', $pengembalian->jenis_denda) === 'tidak_ada' ? 'selected' : '' }}>Tidak Ada Denda</option>
                    <option value="telat" {{ old('jenis_denda', $pengembalian->jenis_denda) === 'telat' ? 'selected' : '' }}>Denda Keterlambatan</option>
                    <option value="rusak" {{ old('jenis_denda', $pengembalian->jenis_denda) === 'rusak' ? 'selected' : '' }}>Denda Kerusakan</option>
                    <option value="hilang" {{ old('jenis_denda', $pengembalian->jenis_denda) === 'hilang' ? 'selected' : '' }}>Denda Kehilangan</option>
                </select>
                @error('jenis_denda')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Total Denda (Rp)</label>
                <input type="number" name="total_denda" 
                       value="{{ old('total_denda', $pengembalian->total_denda) }}" 
                       min="0"
                       class="w-full px-3 py-2 border rounded-lg @error('total_denda') border-red-500 @enderror" 
                       required>
                @error('total_denda')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Catatan</label>
                <textarea name="catatan" rows="3" 
                          class="w-full px-3 py-2 border rounded-lg @error('catatan') border-red-500 @enderror">{{ old('catatan', $pengembalian->catatan) }}</textarea>
                @error('catatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-2">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Update
                </button>
                <a href="{{ route('admin.pengembalian.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection