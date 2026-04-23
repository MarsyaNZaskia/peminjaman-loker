@extends('layouts.app')

@section('title', 'Dashboard Peminjam')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-linear-to-r from-pink-100 to-purple-100 p-6 rounded-2xl shadow-lg border border-pink-200">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-pink-800 mb-2">Halo, {{ auth()->user()->name }}!</h1>
                    <p class="text-pink-600 text-base">Pinjam buku disini</p>
                </div>
                <div class="text-4xl animate-bounce">👋</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-linear-to-br from-green-50 to-green-100 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-green-200">
            <div class="text-center">
                <div class="text-4xl mb-4">✅</div>
                <h3 class="text-green-600 text-sm font-medium mb-2">Buku Tersedia</h3>
                <p class="text-3xl font-bold text-green-700">{{ \App\Models\Buku::where('status', 'tersedia')->count() }}</p>
            </div>
        </div>
        <div class="bg-linear-to-br from-blue-50 to-blue-100 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-blue-200">
            <div class="text-center">
                <div class="text-4xl mb-4">🔓</div>
                <h3 class="text-blue-600 text-sm font-medium mb-2">Peminjaman Aktif</h3>
                <p class="text-3xl font-bold text-blue-700">
                    {{ \App\Models\Peminjaman::where('user_id', Auth::id())->where('status', 'disetujui')->count() }}
                </p>
            </div>
        </div>
        <div class="bg-linear-to-br from-yellow-50 to-yellow-100 p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-yellow-200">
            <div class="text-center">
                <div class="text-4xl mb-4">⏰</div>
                <h3 class="text-yellow-600 text-sm font-medium mb-2">Menunggu Persetujuan</h3>
                <p class="text-3xl font-bold text-yellow-700">
                    {{ \App\Models\Peminjaman::where('user_id', Auth::id())->where('status', 'pending')->count() }}
                </p>
            </div>
        </div>
    </div>

    <div class="bg-linear-to-r from-pink-400 to-pink-500 p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
        <div class="relative z-10">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Peminjaman Buku</h2>
                    <p class="mb-4 text-pink-100">Ajukan peminjaman buku yang tersedia dengan mudah</p>
                    <a href="{{ route('peminjam.peminjaman.index') }}" 
                       class="inline-flex items-center bg-white text-pink-600 px-6 py-2.5 rounded-full font-semibold hover:bg-pink-50 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <span>Lihat Buku Tersedia</span>
                        <span class="ml-2">→</span>
                    </a>
                </div>
                <div class="text-5xl opacity-20">📚</div>
            </div>
        </div>
    </div>
</div>
@endsection