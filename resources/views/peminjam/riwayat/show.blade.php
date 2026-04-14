@extends('layouts.app')

@section('title', 'Detail Riwayat')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-800">📄 Detail Riwayat Peminjaman</h1>
        <a href="{{ route('peminjam.riwayat.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Status Badge -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800">Status Peminjaman</h2>
            @if($peminjaman->status === 'disetujui')
                <span class="px-6 py-2 rounded-full bg-green-100 text-green-800 font-bold text-lg">
                    ✅ Disetujui
                </span>
            @elseif($peminjaman->status === 'ditolak')
                <span class="px-6 py-2 rounded-full bg-red-100 text-red-800 font-bold text-lg">
                    ❌ Ditolak
                </span>
            @elseif($peminjaman->status === 'selesai')
                <span class="px-6 py-2 rounded-full bg-blue-100 text-blue-800 font-bold text-lg">
                    🏁 Selesai
                </span>
            @endif
        </div>
    </div>

    <!-- Info Loker -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <span class="mr-2">🔐</span>
            Informasi Loker
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500 mb-1">Nomor Loker</p>
                <p class="text-lg font-bold text-gray-800">{{ $peminjaman->loker->nomor_loker }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500 mb-1">Lokasi</p>
                <p class="text-lg font-bold text-gray-800">{{ $peminjaman->loker->lokasi }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500 mb-1">Ukuran</p>
                <p class="text-lg font-bold text-gray-800">{{ ucfirst($peminjaman->loker->ukuran) }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500 mb-1">Status Loker</p>
                <p class="text-lg font-bold text-gray-800">{{ ucfirst($peminjaman->loker->status) }}</p>
            </div>
        </div>
    </div>

    <!-- Info Peminjaman -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <span class="mr-2">📋</span>
            Detail Peminjaman
        </h2>
        <div class="space-y-4">
            <div class="flex justify-between items-start border-b border-gray-200 pb-3">
                <div>
                    <p class="text-sm text-gray-500">Tanggal Pinjam</p>
                    <p class="font-semibold text-gray-800">{{ $peminjaman->tanggal_pinjam->format('d F Y') }}</p>
                </div>
            </div>
            <div class="flex justify-between items-start border-b border-gray-200 pb-3">
                <div>
                    <p class="text-sm text-gray-500">Tanggal Rencana Kembali</p>
                    <p class="font-semibold text-gray-800">{{ $peminjaman->tanggal_kembali_rencana->format('d F Y') }}</p>
                </div>
            </div>
            <div class="flex justify-between items-start border-b border-gray-200 pb-3">
                <div>
                    <p class="text-sm text-gray-500">Keperluan</p>
                    <p class="font-semibold text-gray-800">{{ $peminjaman->keperluan }}</p>
                </div>
            </div>
            <div class="flex justify-between items-start border-b border-gray-200 pb-3">
                <div>
                    <p class="text-sm text-gray-500">Diproses Oleh</p>
                    <p class="font-semibold text-gray-800">
                        {{ $peminjaman->petugas->name ?? '-' }}
                        @if($peminjaman->petugas)
                            <span class="text-xs text-gray-500">({{ ucfirst($peminjaman->petugas->role) }})</span>
                        @endif
                    </p>
                </div>
            </div>
            @if($peminjaman->catatan_petugas)
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <p class="text-sm text-gray-500 mb-1">Catatan Petugas</p>
                    <p class="font-semibold text-red-700">{{ $peminjaman->catatan_petugas }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Info Pengembalian (Jika Ada) -->
    @if($peminjaman->pengembalian)
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <span class="mr-2">✅</span>
                Informasi Pengembalian
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">Tanggal Pengembalian</p>
                    <p class="text-lg font-bold text-gray-800">
                        {{ $peminjaman->pengembalian->tgl_kembali_realisasi->format('d F Y') }}
                    </p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">Keterlambatan</p>
                    @php
                        $keterlambatan = $peminjaman->pengembalian->hitungKeterlambatan();
                        $isTerlambat = $keterlambatan > 0 || $peminjaman->pengembalian->jenis_denda === 'telat';
                        
                        // Jika jenis denda telat tapi perhitungan tanggal tidak mendeteksi, hitung dari denda
                        if (!$isTerlambat && $peminjaman->pengembalian->jenis_denda === 'telat' && $peminjaman->pengembalian->total_denda > 0) {
                            $keterlambatan = intval($peminjaman->pengembalian->total_denda / 5000); // DENDA_PER_HARI = 5000
                            $isTerlambat = true;
                        }
                    @endphp
                    @if($isTerlambat)
                        <p class="text-lg font-bold text-red-600">
                            Terlambat {{ $keterlambatan }} hari
                            @if($peminjaman->pengembalian->jenis_denda === 'telat')
                                <span class="text-sm block text-red-500">Denda: Rp {{ number_format($peminjaman->pengembalian->total_denda, 0, ',', '.') }}</span>
                            @endif
                        </p>
                    @else
                        <p class="text-lg font-bold text-green-600">Tepat Waktu ✅</p>
                    @endif
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">Kondisi Loker</p>
                    <p class="text-lg font-bold text-gray-800">
                        {{ ucfirst(str_replace('_', ' ', $peminjaman->pengembalian->kondisi_barang)) }}
                    </p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">Total Denda</p>
                    @if($peminjaman->pengembalian->total_denda > 0)
                        <p class="text-lg font-bold text-red-600">
                            Rp {{ number_format($peminjaman->pengembalian->total_denda, 0, ',', '.') }}
                        </p>
                    @else
                        <p class="text-lg font-bold text-green-600">Rp 0</p>
                    @endif
                </div>
                @if($peminjaman->pengembalian->catatan)
                    <div class="md:col-span-2 bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Catatan Pengembalian</p>
                        <p class="text-sm text-gray-800">{{ $peminjaman->pengembalian->catatan }}</p>
                    </div>
                @endif
                <div class="md:col-span-2 bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">Dicatat Oleh</p>
                    <p class="font-semibold text-gray-800">{{ $peminjaman->pengembalian->user->name }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Timeline -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">📅 Timeline</h2>
        <div class="space-y-4">
            <div class="flex items-start">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <span class="text-xl">📝</span>
                </div>
                <div class="ml-4">
                    <p class="font-semibold text-gray-800">Peminjaman Diajukan</p>
                    <p class="text-sm text-gray-500">{{ $peminjaman->created_at->format('d F Y') }}</p>
                </div>
            </div>

            @if($peminjaman->status !== 'pending')
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full {{ $peminjaman->status === 'ditolak' ? 'bg-red-100' : 'bg-green-100' }} flex items-center justify-center">
                        <span class="text-xl">{{ $peminjaman->status === 'ditolak' ? '❌' : '✅' }}</span>
                    </div>
                    <div class="ml-4">
                        <p class="font-semibold text-gray-800">{{ $peminjaman->status === 'ditolak' ? 'Peminjaman Ditolak' : 'Peminjaman Disetujui' }}</p>
                        <p class="text-sm text-gray-500">{{ $peminjaman->updated_at->format('d F Y') }}</p>
                        <p class="text-xs text-gray-400">Oleh: {{ $peminjaman->petugas->name ?? '-' }}</p>
                    </div>
                </div>
            @endif

            @if($peminjaman->pengembalian)
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                        <span class="text-xl">🏁</span>
                    </div>
                    <div class="ml-4">
                        <p class="font-semibold text-gray-800">Loker Dikembalikan</p>
                        <p class="text-sm text-gray-500">{{ $peminjaman->pengembalian->created_at->format('d F Y') }}</p>
                        <p class="text-xs text-gray-400">Dicatat oleh: {{ $peminjaman->pengembalian->user->name }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection