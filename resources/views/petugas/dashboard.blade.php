@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-linear-to-r from-pink-100 to-purple-100 p-8 rounded-2xl shadow-lg border border-pink-200">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-pink-800 mb-2">Halo, {{ auth()->user()->name }}!</h1>
                    <p class="text-pink-600 text-lg">Kelola peminjaman dan pengembalian loker dengan mudah</p>
                </div>
                <div class="text-6xl animate-bounce">👋</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-linear-to-br from-pink-50 to-pink-100 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-pink-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-pink-600 text-sm font-medium">Total Buku</h3>
                    <p class="text-3xl font-bold mt-2 text-pink-800">{{ \App\Models\Buku::count() }}</p>
                </div>
                <div class="text-4xl">🔐</div>
            </div>
        </div>
        <div class="bg-linear-to-br from-yellow-50 to-yellow-100 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-yellow-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-yellow-600 text-sm font-medium">Buku Dipinjam</h3>
                    <p class="text-3xl font-bold text-yellow-700 mt-2">{{ \App\Models\Buku::where('status', 'dipinjam')->count() }}</p>
                </div>
                <div class="text-4xl">⏳</div>
            </div>
        </div>
        <div class="bg-linear-to-br from-orange-50 to-orange-100 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-orange-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-orange-600 text-sm font-medium">Menunggu Approval</h3>
                    <p class="text-3xl font-bold text-orange-700 mt-2">{{ \App\Models\Peminjaman::where('status', 'pending')->count() }}</p>
                </div>
                <div class="text-4xl">⏰</div>
            </div>
        </div>
        <div class="bg-linear-to-br from-green-50 to-green-100 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-green-600 text-sm font-medium">Total Pengembalian</h3>
                    <p class="text-3xl font-bold text-green-700 mt-2">{{ \App\Models\Pengembalian::count() }}</p>
                </div>
                <div class="text-4xl">✅</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-linear-to-r from-pink-400 to-pink-500 p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold mb-2">Kelola Peminjaman</h2>
                        <p class="mb-4 text-pink-100">Approve atau reject peminjaman loker</p>
                        <a href="{{ route('petugas.peminjaman.index') }}" 
                           class="inline-flex items-center bg-white text-pink-600 px-6 py-2.5 rounded-full font-semibold hover:bg-pink-50 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <span>Kelola Peminjaman</span>
                            <span class="ml-2">→</span>
                        </a>
                    </div>
                    <div class="text-5xl opacity-20">📋</div>
                </div>
            </div>
        </div>

        <div class="bg-linear-to-r from-purple-400 to-purple-500 p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold mb-2">Data Pengembalian</h2>
                        <p class="mb-4 text-purple-100">Lihat history pengembalian loker</p>
                        <a href="{{ route('petugas.pengembalian.index') }}" 
                           class="inline-flex items-center bg-white text-purple-600 px-6 py-2.5 rounded-full font-semibold hover:bg-purple-50 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <span>Lihat Data</span>
                            <span class="ml-2">→</span>
                        </a>
                    </div>
                    <div class="text-5xl opacity-20">📊</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection