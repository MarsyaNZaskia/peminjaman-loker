{{-- resources/views/admin/peminjaman/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Peminjaman')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Edit Peminjaman</h1>

    <div class="bg-white p-6 rounded-lg shadow">
        <form method="POST" action="{{ route('admin.peminjaman.update', $peminjaman) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Peminjam</label>
                <select name="user_id" 
                        class="w-full px-3 py-2 border rounded-lg @error('user_id') border-red-500 @enderror" 
                        required>
                    <option value="">Pilih Peminjam</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $peminjaman->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->username }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Loker</label>
                <select name="loker_id" 
                        class="w-full px-3 py-2 border rounded-lg @error('loker_id') border-red-500 @enderror" 
                        required>
                    <option value="">Pilih Loker</option>
                    @foreach($lokers as $loker)
                        <option value="{{ $loker->id }}" {{ old('loker_id', $peminjaman->loker_id) == $loker->id ? 'selected' : '' }}>
                            {{ $loker->nomor_loker }} - {{ $loker->lokasi }} ({{ ucfirst($loker->status) }})
                        </option>
                    @endforeach
                </select>
                @error('loker_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Tanggal Mulai Pinjam</label>
                <input type="date" name="tanggal_pinjam" 
                       value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam->format('Y-m-d')) }}" 
                       class="w-full px-3 py-2 border rounded-lg @error('tanggal_pinjam') border-red-500 @enderror" 
                       required>
                @error('tanggal_pinjam')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Tanggal Rencana Kembali</label>
                <input type="date" name="tanggal_kembali_rencana" 
                       value="{{ old('tanggal_kembali_rencana', $peminjaman->tanggal_kembali_rencana->format('Y-m-d')) }}" 
                       class="w-full px-3 py-2 border rounded-lg @error('tanggal_kembali_rencana') border-red-500 @enderror" 
                       required>
                @error('tanggal_kembali_rencana')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Keperluan</label>
                <textarea name="keperluan" rows="3" 
                          class="w-full px-3 py-2 border rounded-lg @error('keperluan') border-red-500 @enderror" 
                          required>{{ old('keperluan', $peminjaman->keperluan) }}</textarea>
                @error('keperluan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Status</label>
                <select name="status" 
                        class="w-full px-3 py-2 border rounded-lg @error('status') border-red-500 @enderror" 
                        required>
                    <option value="pending" {{ old('status', $peminjaman->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="disetujui" {{ old('status', $peminjaman->status) === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ old('status', $peminjaman->status) === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="selesai" {{ old('status', $peminjaman->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Catatan Petugas (Opsional)</label>
                <textarea name="catatan_petugas" rows="2" 
                          class="w-full px-3 py-2 border rounded-lg @error('catatan_petugas') border-red-500 @enderror" 
                          placeholder="Catatan tambahan dari petugas...">{{ old('catatan_petugas', $peminjaman->catatan_petugas) }}</textarea>
                @error('catatan_petugas')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-2">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Update
                </button>
                <a href="{{ route('admin.peminjaman.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection