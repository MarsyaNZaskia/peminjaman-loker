{{-- resources/views/admin/peminjaman/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Detail Peminjaman</h1>
        <div class="flex space-x-2">
            @if($peminjaman->status === 'pending')
    <form action="{{ route('admin.peminjaman.update', $peminjaman) }}" method="POST" class="inline">
        @csrf
        @method('PUT')

        <input type="hidden" name="status" value="disetujui">

        <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
            Setujui
        </button>
    </form>

    <form action="{{ route('admin.peminjaman.update', $peminjaman) }}" method="POST" class="inline">
        @csrf
        @method('PUT')

        <input type="hidden" name="status" value="ditolak">

        <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
            Tolak
        </button>
    </form>
@endif
            <a href="{{ route('admin.peminjaman.edit', $peminjaman) }}" 
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                Edit
            </a>
            <a href="{{ route('admin.peminjaman.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Info Peminjam -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Informasi Buku</h2>
            <div class="space-y-2">
                <div>
                    <p class="text-gray-600 text-sm">Nama</p>
                    <p class="font-semibold">{{ $peminjaman->user->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Username</p>
                    <p class="font-semibold">{{ $peminjaman->user->username }}</p>
                </div>
                @if($peminjaman->user->kategori)
                    <div>
                        <p class="text-gray-600 text-sm">Kategori</p>
                        <p class="font-semibold">{{ $peminjaman->user->kategori->nama_kategori }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Info Loker -->
        <div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Informasi Buku</h2>

    <div class="flex gap-4">
        <!-- Cover -->
        <div>
            <img src="{{ $peminjaman->buku?-> foto_cover 
                ? asset('storage/'.$peminjaman->buku->cover) 
                : 'https://via.placeholder.com/100x140?text=No+Image' }}"
                class="w-24 h-32 object-cover rounded shadow">
        </div>

        <!-- Info -->
        <div class="space-y-2">
            <div>
                <p class="text-gray-600 text-sm">Kode Buku</p>
                <p class="font-semibold text-lg">
                    {{ $peminjaman->buku?->kode_buku ?? '-' }}
                </p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Judul</p>
                <p class="font-semibold">
                    {{ $peminjaman->buku?-> judul ?? '-' }}
                </p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Stok</p>
                <p class="font-semibold">
                    {{ $peminjaman->buku?->stok ?? 0 }}
                </p>
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
                <p class="font-semibold">{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Rencana Kembali</p>
                <p class="font-semibold">{{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Status</p>
                <p>
                    @if($peminjaman->status === 'pending')
                        <span class="px-3 py-1 rounded text-sm bg-yellow-100 text-yellow-800">Pending</span>
                    @elseif($peminjaman->status === 'disetujui')
                        <span class="px-3 py-1 rounded text-sm bg-green-100 text-green-800">Disetujui</span>
                    @elseif($peminjaman->status === 'ditolak')
                        <span class="px-3 py-1 rounded text-sm bg-red-100 text-red-800">Ditolak</span>
                    @else
                        <span class="px-3 py-1 rounded text-sm bg-blue-100 text-blue-800">Selesai</span>
                    @endif
                </p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Disetujui Oleh</p>
                <p class="font-semibold">{{ $peminjaman->petugas->name ?? '-' }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-gray-600 text-sm">Keperluan</p>
                <p class="font-semibold">{{ $peminjaman->keperluan }}</p>
            </div>
            @if($peminjaman->catatan_petugas)
                <div class="col-span-2">
                    <p class="text-gray-600 text-sm">Catatan Petugas</p>
                    <p class="font-semibold text-red-600">{{ $peminjaman->catatan_petugas }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Info Pengembalian (jika ada) -->
    @if($peminjaman->pengembalian)
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Informasi Pengembalian</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 text-sm">Tanggal Kembali</p>
                    <p class="font-semibold">{{ $peminjaman->pengembalian->tgl_kembali_realisasi->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Keterlambatan</p>
                    @php
                        $keterlambatan = $peminjaman->pengembalian->hitungKeterlambatan();
                    @endphp
                    @if($keterlambatan > 0)
                        <p class="font-semibold text-red-600">{{ $keterlambatan }} hari</p>
                    @else
                        <p class="font-semibold text-green-600">Tepat Waktu</p>
                    @endif
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Kondisi Barang</p>
                    <p class="font-semibold">{{ ucfirst(str_replace('_', ' ', $peminjaman->pengembalian->kondisi_barang)) }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Denda</p>
                    @if($peminjaman->pengembalian->total_denda > 0)
                        <p class="font-semibold text-red-600">Rp {{ number_format($peminjaman->pengembalian->total_denda, 0, ',', '.') }}</p>
                    @else
                        <p class="font-semibold text-green-600">Tidak Ada Denda</p>
                    @endif
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.pengembalian.show', $peminjaman->pengembalian) }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Lihat Detail Pengembalian
                </a>
            </div>
        </div>
    @endif
</div>
@endsection