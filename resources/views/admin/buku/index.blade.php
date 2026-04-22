@extends('layouts.app')

@section('title', 'Kelola Buku')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Kelola Buku</h1>
        <a href="{{ route('admin.buku.create') }}" 
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            + Tambah Buku
        </a>
    </div>

    <!-- Filter Status -->
    <div class="bg-white p-4 rounded-lg shadow mb-4">
        <div class="flex space-x-4">
            <a href="{{ route('admin.buku.index') }}" 
               class="px-4 py-2 rounded {{ !request('status') ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                Semua ({{ \App\Models\Buku::count() }})
            </a>
            <a href="{{ route('admin.buku.index', ['status' => 'tersedia']) }}" 
               class="px-4 py-2 rounded {{ request('status') === 'tersedia' ? 'bg-green-500 text-white' : 'bg-gray-200' }}">
                Tersedia ({{ \App\Models\Buku::where('status', 'tersedia')->count() }})
            </a>
            <a href="{{ route('admin.buku.index', ['status' => 'dipinjam']) }}" 
               class="px-4 py-2 rounded {{ request('status') === 'dipinjam' ? 'bg-yellow-500 text-white' : 'bg-gray-200' }}">
                Dipinjam ({{ \App\Models\Buku::where('status', 'dipinjam')->count() }})
            </a>
            <a href="{{ route('admin.buku.index', ['status' => 'rusak']) }}" 
               class="px-4 py-2 rounded {{ request('status') === 'rusak' ? 'bg-red-500 text-white' : 'bg-gray-200' }}">
                Rusak ({{ \App\Models\Buku::where('status', 'rusak')->count() }})
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Buku</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengarang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($bukus as $buku)
                    <tr>
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-semibold">{{ $buku->kode_buku }}</td>
                        <td class="px-6 py-4">{{ $buku->judul }}</td>
                        <td class="px-6 py-4">{{ $buku->pengarang }}</td>
                        <td class="px-6 py-4">{{ $buku->stok }}</td>
                        <td class="px-6 py-4">
                            @if($buku->status === 'tersedia')
                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Tersedia</span>
                            @elseif($buku->status === 'dipinjam')
                                <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Dipinjam</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800">Rusak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 flex space-x-2">
                            <a href="{{ route('admin.buku.show', $buku) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                Detail
                            </a>
                            <a href="{{ route('admin.buku.edit', $buku) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.buku.destroy', $buku) }}"
                                  id="deleteForm-buku-{{ $buku->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="deleteConfirm('deleteForm-buku-{{ $buku->id }}')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Belum ada buku
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
        text: 'Data buku akan dihapus permanen dan tidak bisa dikembalikan!',
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