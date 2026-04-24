{{-- resources/views/admin/pengembalian/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Pengembalian')

@section('content')
<div class="max-w-7xl mx-auto px-4">

    {{-- HEADER --}}
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Data pengembalian buku</h1>
            </div>

        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peminjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Buku</th>
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
                        <td class="px-6 py-4 font-semibold">
                            {{ $item->peminjaman->buku->kode_buku ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $item->tgl_kembali_realisasi->format('d/m/Y') }}
                        </td>

                        <td class="px-6 py-4">
                            @if($item->kondisi_barang === 'baik')
                                <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Baik</span>
                            @elseif($item->kondisi_barang === 'rusak')
                                <span class="px-2 py-1 rounded-full text-xs bg-orange-100 text-orange-800">Rusak</span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">Hilang</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            @if($item->total_denda > 0)
                                <span class="text-red-600 font-semibold">
                                    Rp {{ number_format($item->total_denda, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 flex space-x-2">
                            <a href="{{ route('admin.pengembalian.show', $item) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-2xl text-sm">
                                Detail
                            </a>

                            <a href="{{ route('admin.pengembalian.edit', $item) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-2xl text-sm">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.pengembalian.destroy', $item) }}"
                                  id="deleteForm-pengembalian-{{ $item->id }}">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        onclick="deleteConfirm('deleteForm-pengembalian-{{ $item->id }}')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-2xl text-sm">
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
        text: 'Data pengembalian akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endsection