{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Dashboard Admin</h1>

    <!-- Statistik Loker -->
    <div class="mb-8">
        <h2 class="text-xl font-bold mb-4">📦 Statistik Loker</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Total Loker</h3>
                        <p class="text-3xl font-bold mt-2">{{ \App\Models\Loker::count() }}</p>
                    </div>
                    <div class="text-4xl">🔐</div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Loker Tersedia</h3>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ \App\Models\Loker::where('status', 'tersedia')->count() }}</p>
                    </div>
                    <div class="text-4xl">✅</div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Loker Dipinjam</h3>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">{{ \App\Models\Loker::where('status', 'dipinjam')->count() }}</p>
                    </div>
                    <div class="text-4xl">⏳</div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Loker Rusak</h3>
                        <p class="text-3xl font-bold text-red-600 mt-2">{{ \App\Models\Loker::where('status', 'rusak')->count() }}</p>
                    </div>
                    <div class="text-4xl">⚠️</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik User -->
    <div class="mb-8">
        <h2 class="text-xl font-bold mb-4">👥 Statistik User</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Total Petugas</h3>
                        <p class="text-3xl font-bold text-blue-600 mt-2">{{ \App\Models\User::where('role', 'petugas')->count() }}</p>
                    </div>
                    <div class="text-4xl">👮</div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Total Peminjam</h3>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ \App\Models\User::where('role', 'peminjam')->count() }}</p>
                    </div>
                    <div class="text-4xl">👨‍🎓</div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Total User</h3>
                        <p class="text-3xl font-bold mt-2">{{ \App\Models\User::where('role', '!=', 'admin')->count() }}</p>
                    </div>
                    <div class="text-4xl">👥</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Peminjaman -->
    <div class="mb-8">
        <h2 class="text-xl font-bold mb-4">📊 Statistik Peminjaman</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Total Peminjaman</h3>
                        <p class="text-3xl font-bold mt-2">{{ \App\Models\Peminjaman::count() }}</p>
                    </div>
                    <div class="text-4xl">📝</div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Menunggu Approval</h3>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">{{ \App\Models\Peminjaman::where('status', 'pending')->count() }}</p>
                    </div>
                    <div class="text-4xl">⏰</div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Sedang Dipinjam</h3>
                        <p class="text-3xl font-bold text-blue-600 mt-2">{{ \App\Models\Peminjaman::where('status', 'disetujui')->count() }}</p>
                    </div>
                    <div class="text-4xl">🔓</div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm">Selesai</h3>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ \App\Models\Peminjaman::where('status', 'selesai')->count() }}</p>
                    </div>
                    <div class="text-4xl">✔️</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-lg shadow-lg text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Kelola Loker</h2>
                    <p class="mb-4">Tambah, edit, atau hapus data loker</p>
                    <a href="{{ route('admin.lokers.index') }}" 
                       class="inline-block bg-white text-blue-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Kelola Loker →
                    </a>
                </div>
                <div class="text-6xl opacity-20">🔐</div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-lg shadow-lg text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Kelola User</h2>
                    <p class="mb-4">Kelola akun petugas dan peminjam</p>
                    <a href="{{ route('admin.users.index') }}" 
                       class="inline-block bg-white text-green-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Kelola User →
                    </a>
                </div>
                <div class="text-6xl opacity-20">👥</div>
            </div>
        </div>
    </div>
</div>
@endsection