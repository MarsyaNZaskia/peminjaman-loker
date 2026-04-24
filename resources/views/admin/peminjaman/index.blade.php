@extends('layouts.app')

@section('title', 'Kelola Peminjaman')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-2">
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl mb-6">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        
        <!-- FILTER -->
        <div class="flex flex-wrap gap-2">

            <!-- Semua -->
            <a href="{{ route('admin.peminjaman.index') }}"
               class="px-4 py-2 text-sm font-bold rounded-xl transition-all
               {{ !request('status') 
                    ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' 
                    : 'bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white border border-white/5' }}">
                Semua 
                <span class="ml-1 text-[10px] opacity-60">
                    {{ \App\Models\Peminjaman::count() }}
                </span>
            </a>

            <!-- Pending -->
            <a href="{{ route('admin.peminjaman.index', ['status' => 'pending']) }}"
               class="px-4 py-2 text-sm font-bold rounded-xl transition-all
               {{ request('status') === 'pending' 
                    ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/20' 
                    : 'bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white border border-white/5' }}">
                Pending 
                <span class="ml-1 text-[10px] opacity-60">
                    {{ \App\Models\Peminjaman::where('status', 'pending')->count() }}
                </span>
            </a>

            <!-- Disetujui -->
            <a href="{{ route('admin.peminjaman.index', ['status' => 'disetujui']) }}"
               class="px-4 py-2 text-sm font-bold rounded-xl transition-all
               {{ request('status') === 'disetujui' 
                    ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' 
                    : 'bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white border border-white/5' }}">
                Disetujui 
                <span class="ml-1 text-[10px] opacity-60">
                    {{ \App\Models\Peminjaman::where('status', 'disetujui')->count() }}
                </span>
            </a>

            <!-- Selesai -->
            <a href="{{ route('admin.peminjaman.index', ['status' => 'selesai']) }}"
               class="px-4 py-2 text-sm font-bold rounded-xl transition-all
               {{ request('status') === 'selesai' 
                    ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' 
                    : 'bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white border border-white/5' }}">
                Selesai 
                <span class="ml-1 text-[10px] opacity-60">
                    {{ \App\Models\Peminjaman::where('status', 'selesai')->count() }}
                </span>
            </a>

        </div>

        <!-- BUTTON TAMBAH -->
        <div>
            <a href="{{ route('admin.peminjaman.create') }}"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 
               text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-500/20 transition-all active:scale-95">
            + Tambah Peminjaman
            </a>
        </div>

    </div>
</div>

    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl overflow-hidden">
        <table class="min-w-full text-sm text-slate-300">
            <thead class="bg-white/5 text-slate-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Peminjam</th>
                    <th class="px-6 py-4 text-left">Buku</th>
                    <th class="px-6 py-4 text-left">Tanggal Pinjam</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($peminjaman as $item)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-medium text-white">{{ $item->user->name }}</td>
                        <td class="px-6 py-4">
                            <span class="block font-bold text-white">{{ $item->buku?->kode_buku ?? '-' }}</span>
                            <span class="text-xs text-slate-400">{{ $item->buku?->judul ?? '-'}}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-400">{{ $item->tanggal_pinjam->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            @if($item->status === 'pending')
                                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20">Pending</span>
                            @elseif($item->status === 'disetujui')
                                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Disetujui</span>
                            @elseif($item->status === 'ditolak')
                                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-rose-500/10 text-rose-400 border border-rose-500/20">Ditolak</span>
                            @else
                                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Selesai</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 flex items-center gap-2">
                            <a href="{{ route('admin.peminjaman.show', $item) }}"
                               class="px-3 py-1.5 bg-indigo-500/10 hover:bg-indigo-500 text-indigo-400 hover:text-white border border-indigo-500/20 rounded-lg text-[10px] font-bold uppercase transition-all">
                                Detail
                            </a>
                            <a href="{{ route('admin.peminjaman.edit', $item) }}"
                               class="px-3 py-1.5 bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-white border border-amber-500/20 rounded-lg text-[10px] font-bold uppercase transition-all">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.peminjaman.destroy', $item) }}"
                                  id="deleteForm-peminjaman-{{ $item->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="deleteConfirm('deleteForm-peminjaman-{{ $item->id }}')"
                                        class="px-3 py-1.5 bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white border border-rose-500/20 rounded-lg text-[10px] font-bold uppercase transition-all">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center">
                                <span class="text-4xl mb-2">📋</span>
                                <p>Belum ada data peminjaman</p>
                            </div>
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