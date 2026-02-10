@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Dashboard Petugas</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
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
                    <h3 class="text-gray-500 text-sm">Loker Dipinjam</h3>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">{{ \App\Models\Loker::where('status', 'dipinjam')->count() }}</p>
                </div>
                <div class="text-4xl">⏳</div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm">Menunggu Approval</h3>
                    <p class="text-3xl font-bold text-red-600 mt-2">{{ \App\Models\Peminjaman::where('status', 'pending')->count() }}</p>
                </div>
                <div class="text-4xl">⏰</div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm">Total Pengembalian</h3>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ \App\Models\Pengembalian::count() }}</p>
                </div>
                <div class="text-4xl">✅</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-lg shadow-lg text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Kelola Peminjaman</h2>
                    <p class="mb-4">Approve/reject peminjaman loker</p>
                    <a href="{{ route('petugas.peminjaman.index') }}" 
                       class="inline-block bg-white text-blue-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Kelola Peminjaman →
                    </a>
                </div>
                <div class="text-6xl opacity-20">📋</div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-lg shadow-lg text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Data Pengembalian</h2>
                    <p class="mb-4">Lihat history pengembalian loker</p>
                    <a href="{{ route('petugas.pengembalian.index') }}" 
                       class="inline-block bg-white text-green-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Lihat Data →
                    </a>
                </div>
                <div class="text-6xl opacity-20">📊</div>
            </div>
        </div>
    </div>
</div>
@endsection