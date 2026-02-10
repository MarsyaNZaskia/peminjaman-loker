{{-- resources/views/admin/log-aktivitas/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Log Aktivitas Sistem</h1>
        <form method="POST" action="{{ route('admin.log-aktivitas.clear') }}"
              id="deleteAllLogsForm">
            @csrf
            @method('DELETE')
            <button type="button"
                    onclick="deleteAllLogsConfirm()"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                🗑️ Hapus Semua Log
            </button>
        </form>
    </div>

    @if (session('success'))
        <div data-alert class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative">
            <span class="block sm:inline">{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="absolute top-0 right-0 px-4 py-3">
                <span class="text-2xl">&times;</span>
            </button>
        </div>
    @endif

    <!-- Filter -->
    <div class="bg-white p-4 rounded-lg shadow mb-4">
        <form method="GET" action="{{ route('admin.log-aktivitas.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Aksi</label>
                <select name="aksi" class="w-full px-3 py-2 border rounded-lg">
                    <option value="">Semua Aksi</option>
                    <option value="login" {{ request('aksi') === 'login' ? 'selected' : '' }}>Login</option>
                    <option value="logout" {{ request('aksi') === 'logout' ? 'selected' : '' }}>Logout</option>
                    <option value="create" {{ request('aksi') === 'create' ? 'selected' : '' }}>Create</option>
                    <option value="update" {{ request('aksi') === 'update' ? 'selected' : '' }}>Update</option>
                    <option value="delete" {{ request('aksi') === 'delete' ? 'selected' : '' }}>Delete</option>
                    <option value="approve" {{ request('aksi') === 'approve' ? 'selected' : '' }}>Approve</option>
                    <option value="reject" {{ request('aksi') === 'reject' ? 'selected' : '' }}>Reject</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">User</label>
                <select name="user_id" class="w-full px-3 py-2 border rounded-lg">
                    <option value="">Semua User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                       class="w-full px-3 py-2 border rounded-lg">
            </div>

            <div class="flex items-end">
                <button type="submit" 
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    🔍 Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-gray-500 text-sm">Total Aktivitas</p>
            <p class="text-2xl font-bold">{{ \App\Models\LogAktivitas::count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-gray-500 text-sm">Hari Ini</p>
            <p class="text-2xl font-bold">{{ \App\Models\LogAktivitas::whereDate('created_at', today())->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-gray-500 text-sm">Login Hari Ini</p>
            <p class="text-2xl font-bold">{{ \App\Models\LogAktivitas::where('aksi', 'login')->whereDate('created_at', today())->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-gray-500 text-sm">User Aktif Hari Ini</p>
            <p class="text-2xl font-bold">{{ \App\Models\LogAktivitas::whereDate('created_at', today())->distinct('user_id')->count('user_id') }}</p>
        </div>
    </div>

    <!-- Tabel Log -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Model</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP Address</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm">
                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $log->user->name ?? 'System' }}
                            <br>
                            <span class="text-xs text-gray-500">{{ $log->user->role ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($log->aksi === 'login')
                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Login</span>
                            @elseif($log->aksi === 'logout')
                                <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-800">Logout</span>
                            @elseif($log->aksi === 'create')
                                <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">Create</span>
                            @elseif($log->aksi === 'update')
                                <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Update</span>
                            @elseif($log->aksi === 'delete')
                                <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800">Delete</span>
                            @elseif($log->aksi === 'approve')
                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Approve</span>
                            @elseif($log->aksi === 'reject')
                                <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800">Reject</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs bg-purple-100 text-purple-800">{{ ucfirst($log->aksi) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ $log->model ?? '-' }}
                            @if($log->model_id)
                                <span class="text-gray-500">#{{ $log->model_id }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ Str::limit($log->keterangan, 50) ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $log->ip_address }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Belum ada log aktivitas
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>

<script>
function deleteAllLogsConfirm() {
    Swal.fire({
        title: 'Yakin ingin menghapus SEMUA log?',
        text: 'Ini adalah aksi yang tidak bisa dibatalkan. Semua data log aktivitas akan hilang selamanya!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus Semua!',
        confirmButtonColor: '#991b1b',
        cancelButtonText: 'Batal',
        cancelButtonColor: '#6b7280'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteAllLogsForm').submit();
        }
    });
}
</script>
@endsection