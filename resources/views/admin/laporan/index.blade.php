@extends('layouts.app')

@section('title', 'Cetak Laporan')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-2 space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
            Download laporan berdasarkan filter data
        </h1>
    </div>

    {{-- GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- PEMINJAMAN --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-3 mb-5">
                <div class="text-3xl">📋</div>
                <h2 class="text-lg font-semibold text-gray-800">Laporan Peminjaman</h2>
            </div>

            <form method="POST" action="{{ route('admin.laporan.peminjaman') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="text-sm text-gray-600">Status</label>
                    <select name="status"
                            class="w-full mt-1 px-3 py-2 border rounded-xl text-sm">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Tanggal Dari</label>
                    <input type="date" name="tanggal_dari"
                           class="w-full mt-1 px-3 py-2 border rounded-xl text-sm">
                </div>

                <div>
                    <label class="text-sm text-gray-600">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai"
                           class="w-full mt-1 px-3 py-2 border rounded-xl text-sm">
                </div>

                <button class="w-full mt-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
                    Download Excel
                </button>
            </form>
        </div>

        {{-- PENGEMBALIAN --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-3 mb-5">
                <div class="text-3xl">✅</div>
                <h2 class="text-lg font-semibold text-gray-800">Laporan Pengembalian</h2>
            </div>

            <form method="POST" action="{{ route('admin.laporan.pengembalian') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="text-sm text-gray-600">Tanggal Dari</label>
                    <input type="date" name="tanggal_dari"
                           class="w-full mt-1 px-3 py-2 border rounded-xl text-sm">
                </div>

                <div>
                    <label class="text-sm text-gray-600">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai"
                           class="w-full mt-1 px-3 py-2 border rounded-xl text-sm">
                </div>

                <p class="text-xs text-gray-400">
                    Kosongkan jika ingin export semua data
                </p>

                <button class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
                    Download Excel
                </button>
            </form>
        </div>

        {{-- BUKU --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-3 mb-5">
                <div class="text-3xl">📚</div>
                <h2 class="text-lg font-semibold text-gray-800">Laporan Data Buku</h2>
            </div>

            <form method="POST" action="{{ route('admin.laporan.buku') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="text-sm text-gray-600">Status Buku</label>
                    <select name="status"
                            class="w-full mt-1 px-3 py-2 border rounded-xl text-sm">
                        <option value="">Semua Status</option>
                        <option value="tersedia">Tersedia</option>
                        <option value="dipinjam">Dipinjam</option>
                        <option value="rusak">Rusak</option>
                    </select>
                </div>

                <p class="text-xs text-gray-400">
                    Export data buku berdasarkan status
                </p>

                <button class="w-full mt-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition">
                    Download Excel
                </button>
            </form>
        </div>

    </div>

    {{-- INFO --}}
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4">
        <p class="text-sm text-blue-800">
            💡 <strong>Tips:</strong> File Excel akan otomatis ter-download setelah proses export selesai.
        </p>
    </div>

</div>
@endsection