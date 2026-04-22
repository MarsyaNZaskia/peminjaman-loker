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
                    <p class="text-gray-600 text-sm">Kode Buku</p>
                    <p class="font-semibold text-lg">{{ $pengembalian->peminjaman->buku->kode_buku }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Judul</p>
                    <p class="font-semibold">{{ $pengembalian->peminjaman->buku->judul }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Pengarang</p>
                    <p class="font-semibold">{{ $pengembalian->peminjaman->buku->pengarang }}</p>
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
                <p class="text-gray-600 text-sm">Kondisi Loker</p>
                <p class="font-semibold">
                    @if($pengembalian->kondisi_barang === 'baik')
                        <span class="px-3 py-1 rounded bg-green-100 text-green-800">Baik</span>
                    @elseif($pengembalian->kondisi_barang === 'rusak')
                        <span class="px-3 py-1 rounded bg-orange-100 text-orange-800">Rusak</span>
                    @else
                        <span class="px-3 py-1 rounded bg-red-100 text-red-800">Hilang</span>
                    @endif
                </p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Keterangan Waktu</p>
                @php
                    $keterlambatan = $pengembalian->hitungKeterlambatan();
                @endphp
                @if($pengembalian->kondisi_barang === 'baik')
                    @if($keterlambatan > 0)
                        <p class="font-semibold text-red-600">Terlambat ({{ $keterlambatan }} hari)</p>
                    @else
                        <p class="font-semibold text-green-600">Tepat Waktu</p>
                    @endif
                @else
                    <p class="font-semibold text-gray-600">-</p>
                @endif
            </div>
            <div>
                <p class="text-gray-600 text-sm">Total Denda</p>
                @php
                    $keterlambatan = $pengembalian->hitungKeterlambatan();
                @endphp
                @if($pengembalian->kondisi_barang === 'baik')
                    {{-- Kondisi Baik: Hanya ada denda jika terlambat --}}
                    @if($keterlambatan > 0)
                        <p class="font-semibold text-red-600 text-xl">Rp {{ number_format($pengembalian->total_denda, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 mt-1">(Denda Keterlambatan: {{ $keterlambatan }} hari × Rp 5.000)</p>
                    @else
                        <p class="font-semibold text-green-600">Rp 0</p>
                    @endif
                @elseif($pengembalian->kondisi_barang === 'hilang')
                    {{-- Kondisi Hilang: Selalu ada denda kehilangan --}}
                    <p class="font-semibold text-red-600 text-xl">Rp {{ number_format($pengembalian->total_denda, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1">(Denda Kehilangan)</p>
                @elseif($pengembalian->kondisi_barang === 'rusak')
                    {{-- Kondisi Rusak: Selalu ada denda kerusakan --}}
                    <p class="font-semibold text-red-600 text-xl">Rp {{ number_format($pengembalian->total_denda, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1">(Denda Kerusakan)</p>
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