@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
<div class="max-w-7xl mx-auto px-4 space-y-2">
    {{-- HEADER --}}
    <div class="p-2 flex justify-end">
        <form method="POST" action="{{ route('admin.log-aktivitas.clear') }}" id="deleteAllLogsForm">
            @csrf
            @method('DELETE')

            <button type="button"
                    onclick="deleteAllLogsConfirm()"
                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl text-sm">
                Hapus Semua Log
            </button>
        </form>
    </div>

    {{-- FILTER --}}
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <form method="GET"
              action="{{ route('admin.log-aktivitas.index') }}"
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

            <div>
                <label class="text-sm text-gray-600">Aksi</label>
                <select name="aksi"
                        class="w-full mt-1 px-3 py-2 border rounded-xl text-sm">
                    <option value="">Semua</option>
                    @foreach(['login','logout','create','update','delete','approve','reject'] as $aksi)
                        <option value="{{ $aksi }}" {{ request('aksi') === $aksi ? 'selected' : '' }}>
                            {{ ucfirst($aksi) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600">User</label>
                <select name="user_id"
                        class="w-full mt-1 px-3 py-2 border rounded-xl text-sm">
                    <option value="">Semua User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600">Tanggal</label>
                <input type="date"
                       name="tanggal"
                       value="{{ request('tanggal') }}"
                       class="w-full mt-1 px-3 py-2 border rounded-xl text-sm">
            </div>

            <div class="flex items-end">
                <button class="w-full px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl text-sm">
                    Filter
                </button>
            </div>

        </form>
    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

        @php $logModel = \App\Models\LogAktivitas::class; @endphp

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-sm">Total</p>
            <p class="text-xl font-bold">{{ $logModel::count() }}</p>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-sm">Hari Ini</p>
            <p class="text-xl font-bold">{{ $logModel::whereDate('created_at', today())->count() }}</p>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-sm">Login</p>
            <p class="text-xl font-bold">{{ $logModel::where('aksi','login')->whereDate('created_at',today())->count() }}</p>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-sm">User Aktif</p>
            <p class="text-xl font-bold">{{ $logModel::whereDate('created_at',today())->distinct('user_id')->count('user_id') }}</p>
        </div>

    </div>

    {{-- TABLE WRAPPER (RESPONSIVE FIX) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-x-auto">

        <table class="min-w-225 w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs uppercase text-gray-500">Waktu</th>
                    <th class="px-4 py-3 text-left text-xs uppercase text-gray-500">User</th>
                    <th class="px-4 py-3 text-left text-xs uppercase text-gray-500">Aksi</th>
                    <th class="px-4 py-3 text-left text-xs uppercase text-gray-500">Model</th>
                    <th class="px-4 py-3 text-left text-xs uppercase text-gray-500">Keterangan</th>
                    <th class="px-4 py-3 text-left text-xs uppercase text-gray-500">IP</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($logs as $log)
                    <tr class="hover:bg-gray-50">

                        <td class="px-4 py-3 text-sm whitespace-nowrap">
                            {{ $log->created_at->format('d/m/Y H:i') }}
                        </td>

                        <td class="px-4 py-3 text-sm">
                            <div class="font-semibold">{{ $log->user->name ?? 'System' }}</div>
                            <div class="text-xs text-gray-500">{{ $log->user->role ?? '-' }}</div>
                        </td>

                        <td class="px-4 py-3">
                            @php
                                $badge = match($log->aksi) {
                                    'login' => 'bg-green-100 text-green-700',
                                    'logout' => 'bg-gray-100 text-gray-700',
                                    'create' => 'bg-blue-100 text-blue-700',
                                    'update' => 'bg-yellow-100 text-yellow-700',
                                    'delete' => 'bg-red-100 text-red-700',
                                    'approve' => 'bg-green-100 text-green-700',
                                    'reject' => 'bg-red-100 text-red-700',
                                    default => 'bg-purple-100 text-purple-700',
                                };
                            @endphp

                            <span class="px-2 py-1 text-xs rounded-full {{ $badge }}">
                                {{ ucfirst($log->aksi) }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                            {{ $log->model ?? '-' }}
                            @if($log->model_id)
                                <span class="text-gray-400">#{{ $log->model_id }}</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ \Illuminate\Support\Str::limit($log->keterangan, 40) ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-500">
                            {{ $log->ip_address }}
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            Belum ada log aktivitas
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $logs->links() }}
    </div>

</div>

{{-- SWEETALERT --}}
<script>
function deleteAllLogsConfirm() {
    Swal.fire({
        title: 'Hapus semua log?',
        text: 'Data tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteAllLogsForm').submit();
        }
    });
}
</script>
@endsection