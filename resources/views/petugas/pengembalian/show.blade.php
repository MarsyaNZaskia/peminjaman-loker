@extends('layouts.app')

@section('title', 'Detail Pengembalian')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Detail Pengembalian</h1>
        <a href="{{ route('petugas.pengembalian.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Info Peminjam -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Informasi Peminjam</h2>
            <div class="space-y-2">
                <div>
                    <p class="text-gray-600 text-sm">Nama Peminjam</p>
                    <p class="font-semibold">{{ $pengembalian->peminjaman->user->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Username</p>
                    <p class="font-semibold">{{ $pengembalian->peminjaman->user->username }}</p>
                </div>
                @if($pengembalian->peminjaman->user->kategori)
                    <div>
                        <p class="text-gray-600 text-sm">Kategori</p>
                        <p class="font-semibold">{{ $pengembalian->peminjaman->user->kategori->nama_kategori }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Info Loker -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Informasi Loker</h2>
            <div class="space-y-2">
                <div>
                    <p class="text-gray-600 text-sm">Nomor Loker</p>
                    <p class="font-semibold text-lg">{{ $pengembalian->peminjaman->loker->nomor_loker }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Lokasi</p>
                    <p class="font-semibold">{{ $pengembalian->peminjaman->loker->lokasi }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Ukuran</p>
                    <p class="font-semibold">{{ ucfirst($pengembalian->peminjaman->loker->ukuran) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Peminjaman -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="text-xl font-bold mb-4">Detail Peminjaman</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">Tanggal Pinjam</p>
                <p class="font-semibold">{{ $pengembalian->peminjaman->tanggal_pinjam->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Rencana Kembali</p>
                <p class="font-semibold">{{ $pengembalian->peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-gray-600 text-sm">Keperluan</p>
                <p class="font-semibold">{{ $pengembalian->peminjaman->keperluan }}</p>
            </div>
        </div>
    </div>

    <!-- Detail Pengembalian -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="text-xl font-bold mb-4">Detail Pengembalian</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">Tanggal Pengembalian Aktual</p>
                <p class="font-semibold">{{ $pengembalian->tgl_kembali_realisasi->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Keterlambatan</p>
                @php
                    $keterlambatan = $pengembalian->hitungKeterlambatan();
                @endphp
                @if($keterlambatan > 0)
                    <p class="font-semibold text-red-600">{{ $keterlambatan }} hari</p>
                @else
                    <p class="font-semibold text-green-600">Tepat Waktu</p>
                @endif
            </div>
            <div>
                <p class="text-gray-600 text-sm">Kondisi Barang</p>
                <p class="font-semibold">
                    @if($pengembalian->kondisi_barang === 'baik')
                        <span class="px-3 py-1 rounded bg-green-100 text-green-800">Baik</span>
                    @elseif($pengembalian->kondisi_barang === 'rusak_ringan')
                        <span class="px-3 py-1 rounded bg-yellow-100 text-yellow-800">Rusak Ringan</span>
                    @elseif($pengembalian->kondisi_barang === 'rusak_berat')
                        <span class="px-3 py-1 rounded bg-orange-100 text-orange-800">Rusak Berat</span>
                    @else
                        <span class="px-3 py-1 rounded bg-red-100 text-red-800">Hilang</span>
                    @endif
                </p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Jenis Denda</p>
                <p class="font-semibold">{{ ucfirst(str_replace('_', ' ', $pengembalian->jenis_denda)) }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Total Denda</p>
                @if($pengembalian->total_denda > 0)
                    <p class="font-semibold text-red-600 text-xl">Rp {{ number_format($pengembalian->total_denda, 0, ',', '.') }}</p>
                @else
                    <p class="font-semibold text-green-600">Tidak Ada Denda</p>
                @endif
            </div>
            <div>
                <p class="text-gray-600 text-sm">Dicatat Oleh</p>
                <p class="font-semibold">{{ $pengembalian->user->name }}</p>
            </div>
            @if($pengembalian->catatan)
                <div class="col-span-2">
                    <p class="text-gray-600 text-sm">Catatan</p>
                    <p class="font-semibold">{{ $pengembalian->catatan }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection