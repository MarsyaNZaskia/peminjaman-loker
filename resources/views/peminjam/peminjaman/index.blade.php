@extends('layouts.app')

@section('title', 'Peminjaman Loker')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Peminjaman Loker</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Loker Tersedia -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="text-xl font-bold mb-4">Loker Tersedia</h2>
        
        @if($lokers->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($lokers as $loker)
                    <div class="border rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-bold">{{ $loker->nomor_loker }}</h3>
                            <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Tersedia</span>
                        </div>
                        <p class="text-gray-600 text-sm mb-1">📍 {{ $loker->lokasi }}</p>
                        <p class="text-gray-600 text-sm mb-3">📦 Ukuran: {{ ucfirst($loker->ukuran) }}</p>
                        <a href="{{ route('peminjam.peminjaman.create', $loker) }}" 
                           class="block text-center bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                            Ajukan Peminjaman
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">Tidak ada loker yang tersedia saat ini</p>
        @endif
    </div>

    <!-- Peminjaman Saya -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Riwayat Peminjaman Saya</h2>
        
        @if($myPeminjaman->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Loker</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pinjam</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keperluan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($myPeminjaman as $pinjam)
                            <tr>
                                <td class="px-4 py-3 font-semibold">{{ $pinjam->loker->nomor_loker }}</td>
                                <td class="px-4 py-3">{{ $pinjam->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    @if($pinjam->status === 'pending')
                                        <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Menunggu Persetujuan</span>
                                    @elseif($pinjam->status === 'disetujui')
                                        <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Disetujui</span>
                                    @elseif($pinjam->status === 'ditolak')
                                        <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800">Ditolak</span>
                                    @else
                                        <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">Selesai</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">{{ Str::limit($pinjam->keperluan, 30) }}</td>
                                <td class="px-4 py-3">
                                    @if($pinjam->status === 'pending')
                                        <form method="POST" action="{{ route('peminjam.peminjaman.destroy', $pinjam) }}"
                                              id="deleteForm-peminjaman-{{ $pinjam->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    onclick="deleteConfirm('deleteForm-peminjaman-{{ $pinjam->id }}')"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                                Batalkan
                                            </button>
                                        </form>
                                    @elseif($pinjam->status === 'ditolak')
                                        <button type="button"
                                                onclick="showReasonAlert('{{ $pinjam->catatan_petugas }}')"
                                                class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-sm">
                                            Lihat Alasan
                                        </button>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">Belum ada riwayat peminjaman</p>
        @endif
    </div>
</div>

<script>
function deleteConfirm(formId) {
    Swal.fire({
        title: 'Yakin ingin membatalkan?',
        text: 'Peminjaman yang dibatalkan tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Batalkan!',
        confirmButtonColor: '#dc2626',
        cancelButtonText: 'Tidak',
        cancelButtonColor: '#6b7280'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}

function showReasonAlert(reason) {
    Swal.fire({
        title: 'Alasan Penolakan',
        text: reason,
        icon: 'info',
        confirmButtonText: 'Tutup'
    });
}
</script>
@endsection