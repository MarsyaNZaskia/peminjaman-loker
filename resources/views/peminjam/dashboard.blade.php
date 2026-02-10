@extends('layouts.app')

@section('title', 'Dashboard Peminjam')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Dashboard Peminjam</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm">Loker Tersedia</h3>
            <p class="text-3xl font-bold text-green-600">{{ \App\Models\Loker::where('status', 'tersedia')->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm">Peminjaman Aktif</h3>
            <p class="text-3xl font-bold text-blue-600">
                {{ \App\Models\Peminjaman::where('user_id', Auth::id())->where('status', 'disetujui')->count() }}
            </p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm">Menunggu Persetujuan</h3>
            <p class="text-3xl font-bold text-yellow-600">
                {{ \App\Models\Peminjaman::where('user_id', Auth::id())->where('status', 'pending')->count() }}
            </p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Peminjaman Loker</h2>
            <a href="{{ route('peminjam.peminjaman.index') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Lihat Loker Tersedia
            </a>
        </div>
        <p class="text-gray-600">Ajukan peminjaman loker yang tersedia</p>
    </div>
</div>
@endsection