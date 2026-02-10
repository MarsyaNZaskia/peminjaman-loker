{{-- resources/views/petugas/peminjaman/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Detail Peminjaman</h1>
        <a href="{{ route('petugas.peminjaman.index') }}" 
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
                    <p class="text-gray-600 text-sm">Nama</p>
                    <p class="font-semibold">{{ $peminjaman->user->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Username</p>
                    <p class="font-semibold">{{ $peminjaman->user->username }}</p>
                </div>
            </div>
        </div>

        <!-- Info Loker -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Informasi Loker</h2>
            <div class="space-y-2">
                <div>
                    <p class="text-gray-600 text-sm">Nomor Loker</p>
                    <p class="font-semibold text-lg">{{ $peminjaman->loker->nomor_loker }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Lokasi</p>
                    <p class="font-semibold">{{ $peminjaman->loker->lokasi }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Ukuran</p>
                    <p class="font-semibold">{{ ucfirst($peminjaman->loker->ukuran) }}</p>
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
                        <span class="px-3 py-1 rounded text-sm bg-yellow-100 text-yellow-800">Menunggu Persetujuan</span>
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
                <p class="text-gray-600 text-sm">Diproses Oleh</p>
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

    <!-- Aksi -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Aksi</h2>
        
        @if($peminjaman->status === 'pending')
            <div class="flex space-x-2">
                <form method="POST" action="{{ route('petugas.peminjaman.approve', $peminjaman) }}"
                      id="approveForm">
                    @csrf
                    <button type="button"
                            onclick="approveConfirm()"
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        ✓ Setujui
                    </button>
                </form>

                <button onclick="showRejectModal()"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                    ✗ Tolak
                </button>
            </div>

            <!-- Modal Tolak -->
            <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg max-w-md w-full">
                    <h3 class="text-xl font-bold mb-4">Tolak Peminjaman</h3>
                    <form method="POST" action="{{ route('petugas.peminjaman.reject', $peminjaman) }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Alasan Penolakan</label>
                            <textarea name="catatan_petugas" rows="4" 
                                      class="w-full px-3 py-2 border rounded-lg" 
                                      placeholder="Jelaskan alasan penolakan..."
                                      required></textarea>
                        </div>
                        <div class="flex space-x-2">
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                                Tolak
                            </button>
                            <button type="button" onclick="hideRejectModal()" 
                                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        @elseif($peminjaman->status === 'disetujui')
            <form method="GET" action="{{ route('petugas.peminjaman.return', $peminjaman) }}"
                  id="returnForm">
                <button type="button"
                        onclick="returnConfirm()"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Catat Pengembalian
                </button>
            </form>
        @else
            <p class="text-gray-500">Tidak ada aksi yang tersedia</p>
        @endif
    </div>
</div>

<script>
function approveConfirm() {
    Swal.fire({
        title: 'Setujui Peminjaman?',
        text: 'Peminjaman akan disetujui dan loker siap dipinjam',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Ya, Setujui',
        confirmButtonColor: '#22c55e',
        cancelButtonText: 'Batal',
        cancelButtonColor: '#6b7280'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('approveForm').submit();
        }
    });
}

function returnConfirm() {
    Swal.fire({
        title: 'Catat Pengembalian?',
        text: 'Lanjut ke halaman pencatatan pengembalian loker',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Lanjut',
        confirmButtonColor: '#3b82f6',
        cancelButtonText: 'Batal',
        cancelButtonColor: '#6b7280'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('returnForm').submit();
        }
    });
}

function showRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endsection