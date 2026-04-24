@extends('layouts.app')

@section('title', 'Kelola Peminjaman')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        
        <!-- FILTER -->
        <div class="flex flex-wrap gap-2">

            <!-- Semua -->
            <a href="{{ route('admin.peminjaman.index') }}"
               class="px-4 py-2 text-sm font-medium rounded-full transition
               {{ !request('status') 
                    ? 'bg-blue-500 text-white shadow' 
                    : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                Semua 
                <span class="ml-1 text-xs opacity-80">
                    ({{ \App\Models\Peminjaman::count() }})
                </span>
            </a>

            <!-- Pending -->
            <a href="{{ route('admin.peminjaman.index', ['status' => 'pending']) }}"
               class="px-4 py-2 text-sm font-medium rounded-full transition
               {{ request('status') === 'pending' 
                    ? 'bg-yellow-500 text-white shadow' 
                    : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                Pending 
                <span class="ml-1 text-xs opacity-80">
                    ({{ \App\Models\Peminjaman::where('status', 'pending')->count() }})
                </span>
            </a>

            <!-- Disetujui -->
            <a href="{{ route('admin.peminjaman.index', ['status' => 'disetujui']) }}"
               class="px-4 py-2 text-sm font-medium rounded-full transition
               {{ request('status') === 'disetujui' 
                    ? 'bg-green-500 text-white shadow' 
                    : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                Disetujui 
                <span class="ml-1 text-xs opacity-80">
                    ({{ \App\Models\Peminjaman::where('status', 'disetujui')->count() }})
                </span>
            </a>

            <!-- Selesai -->
            <a href="{{ route('admin.peminjaman.index', ['status' => 'selesai']) }}"
               class="px-4 py-2 text-sm font-medium rounded-full transition
               {{ request('status') === 'selesai' 
                    ? 'bg-blue-500 text-white shadow' 
                    : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                Selesai 
                <span class="ml-1 text-xs opacity-80">
                    ({{ \App\Models\Peminjaman::where('status', 'selesai')->count() }})
                </span>
            </a>

        </div>

        <!-- BUTTON TAMBAH -->
        <div>
            <a href="{{ route('admin.peminjaman.create') }}"
               class="inline-flex items-center gap-2 bg-linear-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 
               text-white px-4 py-2 rounded-xl text-sm font-semibold shadow transition">
            + Tambah
            </a>
        </div>

    </div>
</div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peminjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Buku</th>
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
                        <td class="px-6 py-4 font-semibold">{{ $item->buku?->kode_buku ?? '-' }} - {{ $item->buku?->judul ?? '-'}}</td>
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
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-2xl text-sm">
                                Detail
                            </a>
                            {{-- @if($item->status === 'disetujui')
                                <a href="{{ route('admin.pengembalian.create', $item) }}"
                                   class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-sm">
                                    Kembalikan
                                </a>
                            @endif --}}
                            <a href="{{ route('admin.peminjaman.edit', $item) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-2xl text-sm">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.peminjaman.destroy', $item) }}"
                                  id="deleteForm-peminjaman-{{ $item->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="deleteConfirm('deleteForm-peminjaman-{{ $item->id }}')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-2xl text-sm">
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