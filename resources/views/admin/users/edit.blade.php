{{-- resources/views/admin/users/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Edit User</h1>

    <div class="bg-white p-6 rounded-lg shadow">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                       class="w-full px-3 py-2 border rounded-lg @error('name') border-red-500 @enderror" 
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" 
                       class="w-full px-3 py-2 border rounded-lg @error('username') border-red-500 @enderror" 
                       required>
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Password Baru (Kosongkan jika tidak diubah)</label>
                <input type="password" name="password" 
                       class="w-full px-3 py-2 border rounded-lg @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Role</label>
                <select name="role" 
                        class="w-full px-3 py-2 border rounded-lg @error('role') border-red-500 @enderror" 
                        required>
                    <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="peminjam" {{ old('role', $user->role) == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
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
            <option value="{{ $kat->id }}" {{ old('kategori_id', $user->kategori_id) == $kat->id ? 'selected' : '' }}>
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
                    Update
                </button>
                <a href="{{ route('admin.users.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection