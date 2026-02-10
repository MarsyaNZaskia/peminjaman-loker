{{-- resources/views/admin/pengembalian/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Pengembalian')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Kelola Data Pengembalian</h1>

    @if (session('success'))
        <div data-alert class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative">
            <span class="block sm:inline">{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="absolute top-0 right-0 px-4 py-3">
                <span class="text-2xl">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div data-alert class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative">
            <span class="block sm:inline">{{ session('error') }}</span>
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
                        <td class="px-6 py-4 flex space-x-2">
                            <a href="{{ route('admin.pengembalian.show', $item) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                Detail
                            </a>
                            <a href="{{ route('admin.pengembalian.edit', $item) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.pengembalian.destroy', $item) }}"
                                  id="deleteForm-pengembalian-{{ $item->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="deleteConfirm('deleteForm-pengembalian-{{ $item->id }}')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    Hapus
                                </button>
                            </form>
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

<script>
function deleteConfirm(formId) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: 'Data pengembalian akan dihapus permanen dan tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        confirmButtonColor: '#dc2626',
        cancelButtonText: 'Batal',
        cancelButtonColor: '#6b7280'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endsection