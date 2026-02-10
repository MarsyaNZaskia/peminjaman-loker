@extends('layouts.app')

@section('title', 'Kelola Peminjaman')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Kelola Peminjaman</h1>
        <a href="{{ route('admin.peminjaman.create') }}" 
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            + Tambah Peminjaman
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

    <!-- Filter Status -->
    <div class="bg-white p-4 rounded-lg shadow mb-4">
        <div class="flex space-x-4">
            <a href="{{ route('admin.peminjaman.index') }}" 
               class="px-4 py-2 rounded {{ !request('status') ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                Semua ({{ \App\Models\Peminjaman::count() }})
            </a>
            <a href="{{ route('admin.peminjaman.index', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded {{ request('status') === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-200' }}">
                Pending ({{ \App\Models\Peminjaman::where('status', 'pending')->count() }})
            </a>
            <a href="{{ route('admin.peminjaman.index', ['status' => 'disetujui']) }}" 
               class="px-4 py-2 rounded {{ request('status') === 'disetujui' ? 'bg-green-500 text-white' : 'bg-gray-200' }}">
                Disetujui ({{ \App\Models\Peminjaman::where('status', 'disetujui')->count() }})
            </a>
            <a href="{{ route('admin.peminjaman.index', ['status' => 'selesai']) }}" 
               class="px-4 py-2 rounded {{ request('status') === 'selesai' ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                Selesai ({{ \App\Models\Peminjaman::where('status', 'selesai')->count() }})
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peminjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Loker</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pinjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($peminjaman as $item)
                    <tr>
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $item->user->name }}</td>
                        <td class="px-6 py-4 font-semibold">{{ $item->loker->nomor_loker }}</td>
                        <td class="px-6 py-4">{{ $item->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            @if($item->status === 'pending')
                                <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($item->status === 'disetujui')
                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Disetujui</span>
                            @elseif($item->status === 'ditolak')
                                <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800">Ditolak</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">Selesai</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 flex space-x-2">
                            <a href="{{ route('admin.peminjaman.show', $item) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                Detail
                            </a>
                            <a href="{{ route('admin.peminjaman.edit', $item) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.peminjaman.destroy', $item) }}"
                                  id="deleteForm-peminjaman-{{ $item->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="deleteConfirm('deleteForm-peminjaman-{{ $item->id }}')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Belum ada data peminjaman
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
        text: 'Data peminjaman akan dihapus permanen dan tidak bisa dikembalikan!',
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