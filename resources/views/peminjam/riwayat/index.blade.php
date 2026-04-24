@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    {{-- <div class="bg-linear-to-r from-indigo-600 via-blue-600 to-slate-800 rounded-2xl shadow-xl p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">📚 Riwayat Peminjaman</h1>
                <p class="text-purple-100">Lihat semua history peminjaman buku Anda</p>
            </div>
            <div class="hidden md:block text-6xl opacity-40">📜</div>
        </div>
    </div> --}}

    <!-- Filter & Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-slate-900/50 backdrop-blur-xl rounded-2xl border border-amber-500/20 p-5 shadow-2xl">
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mb-1">Total Pending</p>
            <p class="text-2xl font-extrabold text-amber-500 leading-none">
                {{ \App\Models\Peminjaman::where('user_id', Auth::id())->where('status', 'pending')->count() }}
            </p>
        </div>
        <div class="bg-slate-900/50 backdrop-blur-xl rounded-2xl border border-emerald-500/20 p-5 shadow-2xl">
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mb-1">Total Disetujui</p>
            <p class="text-2xl font-extrabold text-emerald-500 leading-none">
                {{ \App\Models\Peminjaman::where('user_id', Auth::id())->where('status', 'disetujui')->count() }}
            </p>
        </div>
        <div class="bg-slate-900/50 backdrop-blur-xl rounded-2xl border border-rose-500/20 p-5 shadow-2xl">
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mb-1">Total Ditolak</p>
            <p class="text-2xl font-extrabold text-rose-500 leading-none">
                {{ \App\Models\Peminjaman::where('user_id', Auth::id())->where('status', 'ditolak')->count() }}
            </p>
        </div>
        <div class="bg-slate-900/50 backdrop-blur-xl rounded-2xl border border-indigo-500/20 p-5 shadow-2xl">
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mb-1">Total Selesai</p>
            <p class="text-2xl font-extrabold text-indigo-500 leading-none">
                {{ \App\Models\Peminjaman::where('user_id', Auth::id())->where('status', 'selesai')->count() }}
            </p>
        </div>
        {{-- <div class="bg-white rounded-xl shadow-lg p-4 border-l-4 border-purple-500">
            <p class="text-gray-500 text-sm mb-1">Total Riwayat</p>
            <p class="text-2xl font-bold text-purple-600">
                {{ \App\Models\Peminjaman::where('user_id', Auth::id())->whereIn('status', ['pending', 'disetujui', 'ditolak', 'selesai'])->count() }}
            </p>
        </div> --}}
    </div>

    <!-- Riwayat List -->
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl overflow-hidden">
        <div class="p-6 border-b border-white/5 bg-white/5">
            <h2 class="text-xl font-bold text-white">📋 Daftar Riwayat</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-slate-300">
                <thead class="bg-white/5 text-slate-400 uppercase text-[10px] font-bold tracking-widest">
                    <tr>
                        <th class="px-6 py-4 text-left">No</th>
                        <th class="px-6 py-4 text-left">Buku</th>
                        <th class="px-6 py-4 text-left">Tanggal Pinjam</th>
                        <th class="px-6 py-4 text-left">Tanggal Kembali</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($riwayat as $item)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-slate-400">
                                {{ $loop->iteration + ($riwayat->currentPage() - 1) * $riwayat->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-xl mr-4 shrink-0">📚</div>
                                    <div class="min-w-0">
                                        <div class="text-sm font-bold text-white truncate">{{ $item->buku?->judul ?? 'Buku Dihapus' }}</div>
                                        <div class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">{{ $item->buku?->kode_buku ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                {{ $item->tanggal_pinjam->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                @if($item->pengembalian)
                                    {{ $item->pengembalian->tgl_kembali_realisasi->format('d M Y') }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->status === 'pending')
                                    <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                        ⏳ Pending
                                    </span>
                                @elseif($item->status === 'disetujui')
                                    <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        ✅ Disetujui
                                    </span>
                                @elseif($item->status === 'ditolak')
                                    <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                        ❌ Ditolak
                                    </span>
                                @elseif($item->status === 'selesai')
                                    <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                                        🏁 Selesai
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('peminjam.riwayat.show', $item) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-slate-600">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="text-6xl mb-4 opacity-50">📭</span>
                                    <p class="text-slate-400 font-bold">Belum ada riwayat peminjaman</p>
                                    <p class="text-slate-500 text-xs mt-2">Katalog buku menantimu untuk dijelajahi!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($riwayat->hasPages())
            <div class="px-6 py-4 border-t border-white/5">
                {{ $riwayat->links() }}
            </div>
        @endif
    </div>

</div>
@endsection