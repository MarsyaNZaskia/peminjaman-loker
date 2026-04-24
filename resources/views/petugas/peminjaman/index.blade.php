@extends('layouts.app')

@section('title', 'Kelola Peminjaman')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-2">
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl mb-6">
        <h1 class="text-2xl font-extrabold text-white tracking-tight">Kelola <span class="text-indigo-400">Peminjaman</span></h1>
    </div>


<div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-4 rounded-2xl shadow-2xl mb-6">
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('petugas.peminjaman.index') }}" 
           class="px-4 py-2 text-xs font-bold rounded-xl transition-all
           {{ !request('status') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-white/5 text-slate-400 hover:text-white border border-white/5' }}">
            Semua ({{ \App\Models\Peminjaman::count() }})
        </a>
        <a href="{{ route('petugas.peminjaman.index', ['status' => 'pending']) }}" 
           class="px-4 py-2 text-xs font-bold rounded-xl transition-all
           {{ request('status') === 'pending' ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'bg-white/5 text-slate-400 hover:text-white border border-white/5' }}">
            Pending ({{ \App\Models\Peminjaman::where('status', 'pending')->count() }})
        </a>
        <a href="{{ route('petugas.peminjaman.index', ['status' => 'disetujui']) }}" 
           class="px-4 py-2 text-xs font-bold rounded-xl transition-all
           {{ request('status') === 'disetujui' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'bg-white/5 text-slate-400 hover:text-white border border-white/5' }}">
            Disetujui ({{ \App\Models\Peminjaman::where('status', 'disetujui')->count() }})
        </a>
        <a href="{{ route('petugas.peminjaman.index', ['status' => 'selesai']) }}" 
           class="px-4 py-2 text-xs font-bold rounded-xl transition-all
           {{ request('status') === 'selesai' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-white/5 text-slate-400 hover:text-white border border-white/5' }}">
            Selesai ({{ \App\Models\Peminjaman::where('status', 'selesai')->count() }})
        </a>
        <a href="{{ route('petugas.peminjaman.index', ['status' => 'ditolak']) }}" 
           class="px-4 py-2 text-xs font-bold rounded-xl transition-all
           {{ request('status') === 'ditolak' ? 'bg-rose-500 text-white shadow-lg shadow-rose-500/20' : 'bg-white/5 text-slate-400 hover:text-white border border-white/5' }}">
            Ditolak ({{ \App\Models\Peminjaman::where('status', 'ditolak')->count() }})
        </a>
    </div>
</div>

    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl overflow-hidden">
        <table class="min-w-full text-sm text-slate-300">
            <thead class="bg-white/5 text-slate-400 uppercase text-[10px] font-bold tracking-widest">
                <tr>
                    <th class="px-6 py-4 text-left">Peminjam</th>
                    <th class="px-6 py-4 text-left">Buku</th>
                    <th class="px-6 py-4 text-left">Tanggal Pinjam</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($peminjaman as $pinjam)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4 font-bold text-white">{{ $pinjam->user->name }}</td>
                        <td class="px-6 py-4">
                            <span class="block font-bold text-white">{{ $pinjam->buku?->kode_buku ?? '-' }}</span>
                            <span class="text-xs text-slate-400">{{ $pinjam->buku?->judul ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-400">{{ $pinjam->tanggal_pinjam->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            @if($pinjam->status === 'pending')
                                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20">Pending</span>
                            @elseif($pinjam->status === 'disetujui')
                                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Disetujui</span>
                            @elseif($pinjam->status === 'ditolak')
                                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-rose-500/10 text-rose-400 border border-rose-500/20">Ditolak</span>
                            @else
                                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Selesai</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                        <td class="px-6 py-4">
                            <a href="{{ route('petugas.peminjaman.show', $pinjam) }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                                Detail
                            </a>
                        </td>
                        </td>
                    </tr>
                @empty
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center">
                                <span class="text-4xl mb-2 text-white/20">📋</span>
                                <p>Belum ada data peminjaman</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection