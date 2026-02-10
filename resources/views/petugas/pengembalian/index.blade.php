@extends('layouts.app')

@section('title', 'Data Pengembalian')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Data Pengembalian</h1>
    </div>

    @if (session('success'))
        <div data-alert class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative">
            <span class="block sm:inline">{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="absolute top-0 right-0 px-4 py-3">
                <span class="text-2xl">&times;</span>
            </button>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peminjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Loker</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Kembali</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kondisi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Denda</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pengembalian as $item)
                    <tr>
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $item->peminjaman->user->name }}</td>
                        <td class="px-6 py-4 font-semibold">{{ $item->peminjaman->loker->nomor_loker }}</td>
                        <td class="px-6 py-4">{{ $item->tgl_kembali_realisasi->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            @if($item->kondisi_barang === 'baik')
                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Baik</span>
                            @elseif($item->kondisi_barang === 'rusak_ringan')
                                <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Rusak Ringan</span>
                            @elseif($item->kondisi_barang === 'rusak_berat')
                                <span class="px-2 py-1 rounded text-xs bg-orange-100 text-orange-800">Rusak Berat</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800">Hilang</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($item->total_denda > 0)
                                <span class="text-red-600 font-semibold">Rp {{ number_format($item->total_denda, 0, ',', '.') }}</span>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('petugas.pengembalian.show', $item) }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Belum ada data pengembalian
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection