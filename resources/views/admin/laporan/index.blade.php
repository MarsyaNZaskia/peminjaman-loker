@extends('layouts.app')

@section('title', 'Cetak Laporan')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">📊 Cetak Laporan Excel</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Laporan Peminjaman -->
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center mb-4">
                <div class="text-4xl mr-4">📋</div>
                <h2 class="text-xl font-bold">Laporan Peminjaman</h2>
            </div>
            
            <form method="POST" action="{{ route('admin.laporan.peminjaman') }}">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Filter Status</label>
                    <select name="status" class="w-full px-3 py-2 border rounded-lg text-sm">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Tanggal Dari</label>
                    <input type="date" name="tanggal_dari" class="w-full px-3 py-2 border rounded-lg text-sm">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai" class="w-full px-3 py-2 border rounded-lg text-sm">
                </div>

                <button type="submit" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                    📥 Download Excel
                </button>
            </form>
        </div>

        <!-- Laporan Pengembalian -->
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center mb-4">
                <div class="text-4xl mr-4">✅</div>
                <h2 class="text-xl font-bold">Laporan Pengembalian</h2>
            </div>
            
            <form method="POST" action="{{ route('admin.laporan.pengembalian') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Tanggal Dari</label>
                    <input type="date" name="tanggal_dari" class="w-full px-3 py-2 border rounded-lg text-sm">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai" class="w-full px-3 py-2 border rounded-lg text-sm">
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Kosongkan untuk export semua data</p>
                </div>

                <button type="submit" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mt-8">
                    📥 Download Excel
                </button>
            </form>
        </div>

        <!-- Laporan Loker -->
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center mb-4">
                <div class="text-4xl mr-4">🔐</div>
                <h2 class="text-xl font-bold">Laporan Data Loker</h2>
            </div>
            
            <form method="POST" action="{{ route('admin.laporan.loker') }}">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Filter Status</label>
                    <select name="status" class="w-full px-3 py-2 border rounded-lg text-sm">
                        <option value="">Semua Status</option>
                        <option value="tersedia">Tersedia</option>
                        <option value="dipinjam">Dipinjam</option>
                        <option value="rusak">Rusak</option>
                    </select>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Laporan data loker berdasarkan status</p>
                </div>

                <button type="submit" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mt-24">
                    📥 Download Excel
                </button>
            </form>
        </div>

    </div>

    <!-- Info -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <p class="text-sm text-blue-800">
            💡 <strong>Tips:</strong> File Excel akan otomatis ter-download setelah Anda klik tombol "Download Excel"
        </p>
    </div>
</div>
@endsection