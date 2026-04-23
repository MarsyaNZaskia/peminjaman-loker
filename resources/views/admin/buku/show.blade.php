{{-- resources/views/admin/bukus/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">Detail Buku: {{ $buku->kode_buku }}</h1>
        <a href="{{ route('admin.buku.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Kembali
        </a>
        
    </div>

    <!-- Informasi Buku -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="text-xl font-bold mb-4">Informasi Buku</h2>
        <div class="grid grid-cols-2 gap-4">
            <!-- Cover -->
            @if($buku->foto_cover)
                <div class="col-span-2 mb-4">
                    <p class="text-gray-600 mb-2">Foto Cover</p>
                    <img src="{{ asset('storage/' . $buku->foto_cover) }}" alt="Cover Buku" class="w-32 h-48 object-cover rounded shadow">
                </div>
            @endif
            <div>
                <p class="text-gray-600">Kode Buku</p>
                <p class="font-semibold text-lg">{{ $buku->kode_buku }}</p>
            </div>
            <div>
                <p class="text-gray-600">Judul</p>
                <p class="font-semibold">{{ $buku->judul }}</p>
            </div>
            <div>
                <p class="text-gray-600">Pengarang</p>
                <p class="font-semibold">{{ $buku->pengarang }}</p>
            </div>
            <div>
                <p class="text-gray-600">Penerbit</p>
                <p class="font-semibold">{{ $buku->penerbit }}</p>
            </div>
            <div>
                <p class="text-gray-600">Tahun Terbit</p>
                <p class="font-semibold">{{ $buku->tahun_terbit }}</p>
            </div>
            <div>
                <p class="text-gray-600">Kategori Buku</p>
                <p class="font-semibold">{{ $buku->kategori_buku }}</p>
            </div>
            <div>
                <p class="text-gray-600">Jumlah Halaman</p>
                <p class="font-semibold">{{ $buku->jumlah_halaman }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-gray-600">Deskripsi</p>
                <p class="font-semibold">{{ $buku->deskripsi ?? '-' }}</p>
            </div>
        </div>

        <div class="mt-4 flex space-x-2">
            
        </div>
    </div>

    <!-- History Peminjaman -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">History Peminjaman</h2>
        
        @if($buku->peminjaman->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Peminjam</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pinjam</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Kembali</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Disetujui Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($buku->peminjaman as $pinjam)
                            <tr>
                                <td class="px-4 py-3">{{ $pinjam->user->name }}</td>
                                <td class="px-4 py-3">{{ $pinjam->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ $pinjam->tanggal_kembali ? $pinjam->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                                <td class="px-4 py-3">
                                    @if($pinjam->status === 'pending')
                                        <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-800">Pending</span>
                                    @elseif($pinjam->status === 'disetujui')
                                        <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Disetujui</span>
                                    @elseif($pinjam->status === 'ditolak')
                                        <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800">Ditolak</span>
                                    @else
                                        <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">Selesai</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $pinjam->petugas->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">Belum ada history peminjaman</p>
        @endif
    </div>
</div>
@endsection