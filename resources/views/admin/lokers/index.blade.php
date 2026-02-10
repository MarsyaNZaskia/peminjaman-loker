{{-- resources/views/admin/lokers/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Loker')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Kelola Loker</h1>
        <a href="{{ route('admin.lokers.create') }}" 
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            + Tambah Loker
        </a>
    </div>

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

    <!-- Filter Status -->
    <div class="bg-white p-4 rounded-lg shadow mb-4">
        <div class="flex space-x-4">
            <a href="{{ route('admin.lokers.index') }}" 
               class="px-4 py-2 rounded {{ !request('status') ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                Semua ({{ \App\Models\Loker::count() }})
            </a>
            <a href="{{ route('admin.lokers.index', ['status' => 'tersedia']) }}" 
               class="px-4 py-2 rounded {{ request('status') === 'tersedia' ? 'bg-green-500 text-white' : 'bg-gray-200' }}">
                Tersedia ({{ \App\Models\Loker::where('status', 'tersedia')->count() }})
            </a>
            <a href="{{ route('admin.lokers.index', ['status' => 'dipinjam']) }}" 
               class="px-4 py-2 rounded {{ request('status') === 'dipinjam' ? 'bg-yellow-500 text-white' : 'bg-gray-200' }}">
                Dipinjam ({{ \App\Models\Loker::where('status', 'dipinjam')->count() }})
            </a>
            <a href="{{ route('admin.lokers.index', ['status' => 'rusak']) }}" 
               class="px-4 py-2 rounded {{ request('status') === 'rusak' ? 'bg-red-500 text-white' : 'bg-gray-200' }}">
                Rusak ({{ \App\Models\Loker::where('status', 'rusak')->count() }})
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nomor Loker</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lokasi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ukuran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($lokers as $loker)
                    <tr>
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-semibold">{{ $loker->nomor_loker }}</td>
                        <td class="px-6 py-4">{{ $loker->lokasi }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs bg-gray-100">
                                {{ ucfirst($loker->ukuran) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($loker->status === 'tersedia')
                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Tersedia</span>
                            @elseif($loker->status === 'dipinjam')
                                <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Dipinjam</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800">Rusak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 flex space-x-2">
                            <a href="{{ route('admin.lokers.show', $loker) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                Detail
                            </a>
                            <a href="{{ route('admin.lokers.edit', $loker) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.lokers.destroy', $loker) }}"
                                  id="deleteForm-loker-{{ $loker->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="deleteConfirm('deleteForm-loker-{{ $loker->id }}')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Belum ada loker
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
        text: 'Data loker akan dihapus permanen dan tidak bisa dikembalikan!',
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