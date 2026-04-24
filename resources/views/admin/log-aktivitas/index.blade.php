@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
<div class="max-w-7xl mx-auto px-4 space-y-2">
    {{-- HEADER --}}
    <div class="p-2 flex justify-end mb-4">
        <form method="POST" action="{{ route('admin.log-aktivitas.clear') }}" id="deleteAllLogsForm">
            @csrf
            @method('DELETE')

            <button type="button"
                    onclick="deleteAllLogsConfirm()"
                    class="px-6 py-2.5 bg-rose-600/10 hover:bg-rose-600 border border-rose-600/20 text-rose-400 hover:text-white rounded-xl text-sm font-bold transition-all active:scale-95 flex items-center gap-2">
                <span>🗑️</span> Hapus Semua Log
            </button>
        </form>
    </div>

    {{-- FILTER --}}
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl mb-6">
        <form method="GET"
              action="{{ route('admin.log-aktivitas.index') }}"
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div>
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5 block">Aksi</label>
                <select name="aksi"
                        class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-sm text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition appearance-none">
                    <option value="" class="bg-slate-900">Semua Aksi</option>
                    @foreach(['login','logout','create','update','delete','approve','reject'] as $aksi)
                        <option value="{{ $aksi }}" {{ request('aksi') === $aksi ? 'selected' : '' }} class="bg-slate-900">
                            {{ ucfirst($aksi) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5 block">User</label>
                <select name="user_id"
                        class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-sm text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition appearance-none">
                    <option value="" class="bg-slate-900">Semua User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }} class="bg-slate-900">
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5 block">Tanggal</label>
                <input type="date"
                       name="tanggal"
                       value="{{ request('tanggal') }}"
                       class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-sm text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition">
            </div>

            <div class="flex items-end">
                <button class="w-full px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-500/20 transition-all active:scale-95">
                    Terapkan Filter
                </button>
            </div>

        </form>
    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        @php $logModel = \App\Models\LogAktivitas::class; @endphp

        <div class="bg-slate-900/50 backdrop-blur-xl p-5 rounded-2xl border border-white/10">
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mb-1">Total Logs</p>
            <p class="text-2xl font-extrabold text-white leading-none">{{ $logModel::count() }}</p>
        </div>

        <div class="bg-slate-900/50 backdrop-blur-xl p-5 rounded-2xl border border-white/10">
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mb-1">Hari Ini</p>
            <p class="text-2xl font-extrabold text-white leading-none">{{ $logModel::whereDate('created_at', today())->count() }}</p>
        </div>

        <div class="bg-emerald-500/5 backdrop-blur-xl p-5 rounded-2xl border border-emerald-500/10">
            <p class="text-emerald-500/50 text-[10px] font-bold uppercase tracking-widest mb-1">Total Login</p>
            <p class="text-2xl font-extrabold text-emerald-400 leading-none">{{ $logModel::where('aksi','login')->whereDate('created_at',today())->count() }}</p>
        </div>

        <div class="bg-indigo-500/5 backdrop-blur-xl p-5 rounded-2xl border border-indigo-500/10">
            <p class="text-indigo-500/50 text-[10px] font-bold uppercase tracking-widest mb-1">User Aktif</p>
            <p class="text-2xl font-extrabold text-indigo-400 leading-none">{{ $logModel::whereDate('created_at',today())->distinct('user_id')->count('user_id') }}</p>
        </div>

    </div>

    {{-- TABLE WRAPPER --}}
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-slate-300">
                <thead class="bg-white/5 text-slate-400 uppercase text-[10px] font-bold tracking-widest">
                    <tr>
                        <th class="px-6 py-4 text-left">Waktu</th>
                        <th class="px-6 py-4 text-left">User</th>
                        <th class="px-6 py-4 text-left">Aksi</th>
                        <th class="px-6 py-4 text-left">Model</th>
                        <th class="px-6 py-4 text-left">Keterangan</th>
                        <th class="px-6 py-4 text-left">IP Address</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/5">
                @forelse($logs as $log)
                    <tr class="hover:bg-white/5 transition-colors">

                        <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500">
                            {{ $log->created_at->format('d M Y') }}
                            <span class="block text-white font-bold">{{ $log->created_at->format('H:i:s') }}</span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="font-bold text-white">{{ $log->user->name ?? 'System' }}</div>
                            <div class="text-[10px] text-slate-500 uppercase font-bold">{{ $log->user->role ?? '-' }}</div>
                        </td>

                        <td class="px-6 py-4">
                            @php
                                $badge = match($log->aksi) {
                                    'login' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                    'logout' => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                                    'create' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                    'update' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                    'delete' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                    'approve' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                    'reject' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                    default => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
                                };
                            @endphp

                            <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full border {{ $badge }}">
                                {{ $log->aksi }}
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 bg-white/5 rounded text-[10px] font-mono text-slate-400">
                                {{ $log->model ?? '-' }}
                                @if($log->model_id)
                                    <span class="text-white">#{{ $log->model_id }}</span>
                                @endif
                            </span>
                        </td>

                        <td class="px-6 py-4 text-xs text-slate-400 max-w-xs truncate">
                            {{ $log->keterangan ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-xs font-mono text-slate-500">
                            {{ $log->ip_address }}
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-600">
                            <div class="flex flex-col items-center">
                                <span class="text-4xl mb-2">📜</span>
                                <p>Belum ada rekaman aktivitas</p>
                            </div>
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