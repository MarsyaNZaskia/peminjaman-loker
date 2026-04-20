@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-pink-100 to-purple-100 p-6 rounded-2xl shadow-lg border border-pink-200">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-pink-800 mb-2">Selamat Datang, Admin!</h1>
                    <p class="text-pink-600 text-base">Pantau dan kelola sistem peminjaman loker dengan mudah</p>
                </div>
                <div class="text-4xl animate-bounce">👋</div>
            </div>
        </div>
    </div>

    <!-- Statistik Loker -->
    <div class="mb-10">
        <h2 class="text-2xl font-bold mb-6 text-pink-800 flex items-center">
            <span class="text-3xl mr-3">📦</span>
            Informasi Loker
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-gradient-to-br from-pink-50 to-pink-100 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-pink-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-pink-600 text-sm font-medium">Total Loker</h3>
                        <p class="text-3xl font-bold mt-2 text-pink-800">{{ \App\Models\Loker::count() }}</p>
                    </div>
                    <div class="text-4xl">🔐</div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-green-600 text-sm font-medium">Loker Tersedia</h3>
                        <p class="text-3xl font-bold text-green-700 mt-2">{{ \App\Models\Loker::where('status', 'tersedia')->count() }}</p>
                    </div>
                    <div class="text-4xl">✅</div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-yellow-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-yellow-600 text-sm font-medium">Loker Dipinjam</h3>
                        <p class="text-3xl font-bold text-yellow-700 mt-2">{{ \App\Models\Loker::where('status', 'dipinjam')->count() }}</p>
                    </div>
                    <div class="text-4xl">⏳</div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-red-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-red-600 text-sm font-medium">Loker Rusak</h3>
                        <p class="text-3xl font-bold text-red-700 mt-2">{{ \App\Models\Loker::where('status', 'rusak')->count() }}</p>
                    </div>
                    <div class="text-4xl">⚠️</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik User -->
    <div class="mb-10">
        <h2 class="text-2xl font-bold mb-6 text-pink-800 flex items-center">
            <span class="text-3xl mr-3">👥</span>
            Informasi User
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-blue-600 text-sm font-medium">Total Petugas</h3>
                        <p class="text-3xl font-bold text-blue-700 mt-2">{{ \App\Models\User::where('role', 'petugas')->count() }}</p>
                    </div>
                    <div class="text-4xl">👮‍♀️</div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-green-600 text-sm font-medium">Total Peminjam</h3>
                        <p class="text-3xl font-bold text-green-700 mt-2">{{ \App\Models\User::where('role', 'peminjam')->count() }}</p>
                    </div>
                    <div class="text-4xl">👨‍🎓</div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-purple-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-purple-600 text-sm font-medium">Total User</h3>
                        <p class="text-3xl font-bold text-purple-700 mt-2">{{ \App\Models\User::where('role', '!=', 'admin')->count() }}</p>
                    </div>
                    <div class="text-4xl">👥</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Peminjaman -->
    <div class="mb-10">
        <h2 class="text-2xl font-bold mb-6 text-pink-800 flex items-center">
            <span class="text-3xl mr-3">📊</span>
            Informasi Peminjaman
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-indigo-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-indigo-600 text-sm font-medium">Total Peminjaman</h3>
                        <p class="text-3xl font-bold text-indigo-700 mt-2">{{ \App\Models\Peminjaman::count() }}</p>
                    </div>
                    <div class="text-4xl">📝</div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-yellow-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-yellow-600 text-sm font-medium">Menunggu Approval</h3>
                        <p class="text-3xl font-bold text-yellow-700 mt-2">{{ \App\Models\Peminjaman::where('status', 'pending')->count() }}</p>
                    </div>
                    <div class="text-4xl">⏰</div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-blue-600 text-sm font-medium">Sedang Dipinjam</h3>
                        <p class="text-3xl font-bold text-blue-700 mt-2">{{ \App\Models\Peminjaman::where('status', 'disetujui')->count() }}</p>
                    </div>
                    <div class="text-4xl">🔓</div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-green-600 text-sm font-medium">Selesai</h3>
                        <p class="text-3xl font-bold text-green-700 mt-2">{{ \App\Models\Peminjaman::where('status', 'selesai')->count() }}</p>
                    </div>
                    <div class="text-4xl">✔️</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gradient-to-r from-pink-400 to-pink-500 p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold mb-2">Kelola Loker</h2>
                        <p class="mb-4 text-pink-100">Tambah, edit, atau hapus data loker dengan mudah</p>
                        <a href="{{ route('admin.lokers.index') }}" 
                           class="inline-flex items-center bg-white text-pink-600 px-6 py-2.5 rounded-full font-semibold hover:bg-pink-50 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <span>Kelola Loker</span>
                            <span class="ml-2">→</span>
                        </a>
                    </div>
                    <div class="text-5xl opacity-20">🔐</div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-400 to-purple-500 p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold mb-2">Kelola User</h2>
                        <p class="mb-4 text-purple-100">Kelola akun petugas dan peminjam dengan cepat</p>
                        <a href="{{ route('admin.users.index') }}" 
                           class="inline-flex items-center bg-white text-purple-600 px-6 py-2.5 rounded-full font-semibold hover:bg-purple-50 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <span>Kelola User</span>
                            <span class="ml-2">→</span>
                        </a>
                    </div>
                    <div class="text-5xl opacity-20">👥</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection