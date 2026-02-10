@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Kelola Kategori Siswa</h1>
        <a href="{{ route('admin.kategoris.create') }}" 
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            + Tambah Kategori
        </a>
    </div>

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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($kategoris as $kategori)
                    <tr>
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-semibold">{{ $kategori->nama_kategori }}</td>
                        <td class="px-6 py-4">{{ $kategori->keterangan ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">
                                {{ $kategori->users_count }} siswa
                            </span>
                        </td>
                        <td class="px-6 py-4 flex space-x-2">
                            <a href="{{ route('admin.kategoris.edit', $kategori) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.kategoris.destroy', $kategori) }}"
                                  id="deleteForm-kategori-{{ $kategori->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="deleteConfirm('deleteForm-kategori-{{ $kategori->id }}')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Belum ada kategori
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
        text: 'Data kategori akan dihapus permanen dan tidak bisa dikembalikan!',
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