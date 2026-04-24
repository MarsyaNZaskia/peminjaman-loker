{{-- resources/views/admin/pengembalian/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Pengembalian')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-2">
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            
            <div>
                <h1 class="text-xl font-bold text-white">Data Pengembalian Buku</h1>
            </div>

        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl overflow-hidden">
        <table class="min-w-full text-sm text-slate-300">
            <thead class="bg-white/5 text-slate-400 uppercase text-xs">
                <tr>
                <tr>
                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Peminjam</th>
                    <th class="px-6 py-4 text-left">Buku</th>
                    <th class="px-6 py-4 text-left">Tgl Kembali</th>
                    <th class="px-6 py-4 text-left">Kondisi</th>
                    <th class="px-6 py-4 text-left">Denda</th>
                    <th class="px-6 py-4 text-left">Aksi</th>
                </tr>
                </tr>
            </thead>

            <tbody>
                @forelse($pengembalian as $item)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-medium text-white">{{ $item->peminjaman->user->name }}</td>
                        <td class="px-6 py-4 font-bold text-white">
                            {{ $item->peminjaman->buku->kode_buku ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-slate-400">
                            {{ $item->tgl_kembali_realisasi->format('d M Y') }}
                        </td>

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
                                <span class="text-rose-400 font-bold">
                                    Rp {{ number_format($item->total_denda, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-slate-500">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 flex items-center gap-2">
                            <a href="{{ route('admin.pengembalian.show', $item) }}"
                               class="px-3 py-1.5 bg-indigo-500/10 hover:bg-indigo-500 text-indigo-400 hover:text-white border border-indigo-500/20 rounded-lg text-[10px] font-bold uppercase transition-all">
                                Detail
                            </a>

                            <a href="{{ route('admin.pengembalian.edit', $item) }}"
                               class="px-3 py-1.5 bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-white border border-amber-500/20 rounded-lg text-[10px] font-bold uppercase transition-all">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.pengembalian.destroy', $item) }}"
                                  id="deleteForm-pengembalian-{{ $item->id }}">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        onclick="deleteConfirm('deleteForm-pengembalian-{{ $item->id }}')"
                                        class="px-3 py-1.5 bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white border border-rose-500/20 rounded-lg text-[10px] font-bold uppercase transition-all">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center">
                                <span class="text-4xl mb-2">✅</span>
                                <p>Belum ada data pengembalian</p>
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
        text: 'Data pengembalian akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endsection