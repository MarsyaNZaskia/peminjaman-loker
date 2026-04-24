@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-2">
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h1 class="text-2xl font-black text-white tracking-tight">Kategori <span class="text-indigo-400">Siswa</span></h1>
            <a href="{{ route('admin.kategoris.create') }}" 
               class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-500/20 transition-all active:scale-95">
                + Tambah Kategori
            </a>
        </div>
    </div>



    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl overflow-hidden">
        <table class="min-w-full text-sm text-slate-300">
            <thead class="bg-white/5 text-slate-400 uppercase text-[10px] font-bold tracking-widest">
                <tr>
                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Nama Kategori</th>
                    <th class="px-6 py-4 text-left">Keterangan</th>
                    <th class="px-6 py-4 text-left">Jumlah Siswa</th>
                    <th class="px-6 py-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse ($kategoris as $kategori)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4 text-slate-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-bold text-white">{{ $kategori->nama_kategori }}</td>
                        <td class="px-6 py-4 text-slate-400">{{ $kategori->keterangan ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                                {{ $kategori->users_count }} siswa
                            </span>
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="{{ route('admin.kategoris.edit', $kategori) }}"
                               class="px-3 py-1.5 bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-white border border-amber-500/20 rounded-lg text-[10px] font-bold uppercase transition-all">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.kategoris.destroy', $kategori) }}"
                                  id="deleteForm-kategori-{{ $kategori->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="deleteConfirm('deleteForm-kategori-{{ $kategori->id }}')"
                                        class="px-3 py-1.5 bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white border border-rose-500/20 rounded-lg text-[10px] font-bold uppercase transition-all">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center">
                                <span class="text-4xl mb-2 text-white/20">📂</span>
                                <p>Belum ada data kategori</p>
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
        text: 'Data kategori akan dihapus permanen dan tidak bisa dikembalikan!',
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