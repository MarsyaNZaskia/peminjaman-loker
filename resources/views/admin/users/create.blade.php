{{-- resources/views/admin/users/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Tambah User Baru</h1>

    <div class="bg-white p-6 rounded-lg shadow">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="w-full px-3 py-2 border rounded-lg @error('name') border-red-500 @enderror" 
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" 
                       class="w-full px-3 py-2 border rounded-lg @error('username') border-red-500 @enderror" 
                       required>
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Password</label>
                <input type="password" name="password" 
                       class="w-full px-3 py-2 border rounded-lg @error('password') border-red-500 @enderror" 
                       required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Role</label>
                <select name="role" 
                        class="w-full px-3 py-2 border rounded-lg @error('role') border-red-500 @enderror" 
                        required>
                    <option value="">Pilih Role</option>
                    <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="peminjam" {{ old('role') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
    <label class="block text-gray-700 mb-2">Kategori (Untuk Peminjam)</label>
    <select name="kategori_id" 
            class="w-full px-3 py-2 border rounded-lg @error('kategori_id') border-red-500 @enderror">
        <option value="">Pilih Kategori (Opsional)</option>
        @foreach(\App\Models\Kategori::all() as $kat)
            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                {{ $kat->nama_kategori }}
            </option>
        @endforeach
    </select>
    <p class="text-sm text-gray-500 mt-1">Kategori hanya untuk user dengan role Peminjam</p>
    @error('kategori_id')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

            <div class="flex space-x-2">
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Simpan
                </button>
                <a href="{{ route('admin.users.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@if (session('success'))
    <div data-alert class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative">
        <span class="block sm:inline">{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="absolute top-0 right-0 px-4 py-3">
            <span class="text-2xl">&times;</span>
        </button>
    </div>
@endif

@if (session('error'))
    <div data-alert class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative">
        <span class="block sm:inline">{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" class="absolute top-0 right-0 px-4 py-3">
            <span class="text-2xl">&times;</span>
        </button>
    </div>
@endif
@endsection