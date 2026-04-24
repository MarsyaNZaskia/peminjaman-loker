@extends('layouts.app')

@section('title', 'Data Pengembalian')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-2">
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl mb-6">
        <h1 class="text-2xl font-extrabold text-white tracking-tight">Data <span class="text-indigo-400">Pengembalian</span></h1>
    </div>



    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl overflow-hidden">
        <table class="min-w-full text-sm text-slate-300">
            <thead class="bg-white/5 text-slate-400 uppercase text-[10px] font-bold tracking-widest">
                <tr>
                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Peminjam</th>
                    <th class="px-6 py-4 text-left">Buku</th>
                    <th class="px-6 py-4 text-left">Tgl Kembali</th>
                    <th class="px-6 py-4 text-left">Kondisi</th>
                    <th class="px-6 py-4 text-left">Denda</th>
                    <th class="px-6 py-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($pengembalian as $item)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4 text-slate-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-bold text-white">{{ $item->peminjaman->user->name }}</td>
                        <td class="px-6 py-4">
                            <span class="block font-bold text-white">{{ $item->peminjaman->buku->kode_buku ?? '-' }}</span>
                            <span class="text-xs text-slate-400">{{ $item->peminjaman->buku->judul ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-400">{{ $item->tgl_kembali_realisasi->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            @if($item->kondisi_barang === 'baik')
                                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Baik</span>
                            @elseif($item->kondisi_barang === 'rusak')
                                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-orange-500/10 text-orange-400 border border-orange-500/20">Rusak</span>
                            @else
                                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-rose-500/10 text-rose-400 border border-rose-500/20">Hilang</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($item->total_denda > 0)
                                <span class="text-rose-400 font-bold">Rp {{ number_format($item->total_denda, 0, ',', '.') }}</span>
                            @else
                                <span class="text-slate-500">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('petugas.pengembalian.show', $item) }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center">
                                <span class="text-4xl mb-2 text-white/20">✅</span>
                                <p>Belum ada data pengembalian</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection