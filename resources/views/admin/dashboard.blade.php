@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    <!-- Welcome -->
    <div class="mb-6">
        <div class="bg-linear-to-r from-slate-800 to-slate-700 p-6 rounded-2xl shadow-lg text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold">Selamat Datang, Admin 👋</h1>
                    <p class="text-slate-300 text-sm">Kelola sistem perpustakaan dengan mudah</p>
                </div>
                <div class="text-3xl">📊</div>
            </div>
        </div>
    </div>

    <!-- Statistik Buku -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">📚 Statistik Buku</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div class="bg-white p-5 rounded-xl shadow hover:shadow-md transition">
                <p class="text-sm text-gray-500">Total Buku</p>
                <h3 class="text-2xl font-bold mt-2">{{ \App\Models\Buku::count() }}</h3>
            </div>

            <div class="bg-green-50 p-5 rounded-xl shadow">
                <p class="text-sm text-green-600">Tersedia</p>
                <h3 class="text-2xl font-bold text-green-700 mt-2">
                    {{ \App\Models\Buku::where('status', 'tersedia')->count() }}
                </h3>
            </div>

            <div class="bg-yellow-50 p-5 rounded-xl shadow">
                <p class="text-sm text-yellow-600">Dipinjam</p>
                <h3 class="text-2xl font-bold text-yellow-700 mt-2">
                    {{ \App\Models\Buku::where('status', 'dipinjam')->count() }}
                </h3>
            </div>

            <div class="bg-red-50 p-5 rounded-xl shadow">
                <p class="text-sm text-red-600">Rusak</p>
                <h3 class="text-2xl font-bold text-red-700 mt-2">
                    {{ \App\Models\Buku::where('status', 'rusak')->count() }}
                </h3>
            </div>

        </div>
    </div>

    <!-- Statistik User -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">👥 User</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="bg-white p-5 rounded-xl shadow">
                <p class="text-sm text-gray-500">Petugas</p>
                <h3 class="text-2xl font-bold mt-2">
                    {{ \App\Models\User::where('role', 'petugas')->count() }}
                </h3>
            </div>

            <div class="bg-white p-5 rounded-xl shadow">
                <p class="text-sm text-gray-500">Peminjam</p>
                <h3 class="text-2xl font-bold mt-2">
                    {{ \App\Models\User::where('role', 'peminjam')->count() }}
                </h3>
            </div>

            <div class="bg-white p-5 rounded-xl shadow">
                <p class="text-sm text-gray-500">Total User</p>
                <h3 class="text-2xl font-bold mt-2">
                    {{ \App\Models\User::where('role', '!=', 'admin')->count() }}
                </h3>
            </div>

        </div>
    </div>

    <!-- Statistik Peminjaman -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">📊 Peminjaman</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div class="bg-white p-5 rounded-xl shadow">
                <p class="text-sm text-gray-500">Total</p>
                <h3 class="text-2xl font-bold mt-2">
                    {{ \App\Models\Peminjaman::count() }}
                </h3>
            </div>

            <div class="bg-yellow-50 p-5 rounded-xl shadow">
                <p class="text-sm text-yellow-600">Pending</p>
                <h3 class="text-2xl font-bold text-yellow-700 mt-2">
                    {{ \App\Models\Peminjaman::where('status', 'pending')->count() }}
                </h3>
            </div>

            <div class="bg-blue-50 p-5 rounded-xl shadow">
                <p class="text-sm text-blue-600">Dipinjam</p>
                <h3 class="text-2xl font-bold text-blue-700 mt-2">
                    {{ \App\Models\Peminjaman::where('status', 'disetujui')->count() }}
                </h3>
            </div>

            <div class="bg-green-50 p-5 rounded-xl shadow">
                <p class="text-sm text-green-600">Selesai</p>
                <h3 class="text-2xl font-bold text-green-700 mt-2">
                    {{ \App\Models\Peminjaman::where('status', 'selesai')->count() }}
                </h3>
            </div>

        </div>
    </div>

    <!-- Quick Action -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <a href="{{ route('admin.buku.index') }}"
           class="bg-slate-800 text-white p-6 rounded-xl shadow hover:bg-slate-700 transition">
            <h3 class="text-lg font-semibold mb-2">📚 Kelola Buku</h3>
            <p class="text-sm text-slate-300">Tambah, edit, dan hapus buku</p>
        </a>

        <a href="{{ route('admin.users.index') }}"
           class="bg-indigo-600 text-white p-6 rounded-xl shadow hover:bg-indigo-500 transition">
            <h3 class="text-lg font-semibold mb-2">👥 Kelola User</h3>
            <p class="text-sm text-indigo-100">Manajemen pengguna sistem</p>
        </a>

    </div>

</div>
@endsection