@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">

    {{-- HEADER ACTION --}}
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-4 rounded-2xl shadow-2xl mb-6 flex flex-col md:flex-row md:justify-end md:items-center gap-3">
        <div class="flex flex-col md:flex-row md:justify-end md:items-center gap-2">

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="w-full bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded-xl text-xs">
                    <strong>Error!</strong>
                    <ul class="list-disc ml-5 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex flex-wrap gap-2">

                {{-- SETUJUI --}}
                @if($peminjaman->status === 'pending')
                    <form id="form-setujui-{{ $peminjaman->id }}"
                        action="{{ route('admin.peminjaman.setujui', $peminjaman) }}"
                        method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="button"
                        onclick="setujuiPeminjaman({{ $peminjaman->id }})"
                        class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-emerald-500/20 active:scale-95 uppercase tracking-wider">
                        Setujui
                    </button>
                </form>

                    {{-- TOLAK (MODAL) --}}
                    <button type="button"
                            onclick="tolakPeminjaman('{{ route('admin.peminjaman.tolak', $peminjaman) }}')"
                            class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-rose-500/20 active:scale-95 uppercase tracking-wider">
                        Tolak
                    </button>
                @endif

                {{-- EDIT --}}
                <a href="{{ route('admin.peminjaman.edit', $peminjaman) }}"
                   class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-amber-500/20 active:scale-95 uppercase tracking-wider">
                    Edit
                </a>

                {{-- KEMBALI / KEMBALIKAN --}}
                @if($peminjaman->status === 'disetujui' && !$peminjaman->pengembalian)
                    <a href="{{ route('admin.pengembalian.create', $peminjaman) }}"
                       class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-indigo-500/20 active:scale-95 uppercase tracking-wider">
                        Catat Pengembalian
                    </a>
                @endif

                <a href="{{ route('admin.peminjaman.index') }}"
                   class="px-4 py-2 bg-white/5 hover:bg-white/10 text-white border border-white/10 rounded-xl text-xs font-bold transition-all active:scale-95 uppercase tracking-wider">
                    Kembali
                </a>

            </div>
        </div>
    </div>

    {{-- GRID --}}
    <div class="grid md:grid-cols-2 gap-6 mb-6">

        {{-- PEMINJAM --}}
        <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl">
            <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 ml-1">Informasi Peminjam</h2>

            <div class="space-y-4">
                <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Nama</p>
                    <p class="font-bold text-white">{{ $peminjaman->user->name }}</p>
                </div>

                <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Username</p>
                    <p class="font-bold text-white">{{ $peminjaman->user->username }}</p>
                </div>

                @if($peminjaman->user->kategori)
                <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Kategori</p>
                    <p class="font-bold text-indigo-400">
                        {{ $peminjaman->user->kategori->nama_kategori }}
                    </p>
                </div>
                @endif
            </div>
        </div>

        {{-- BUKU --}}
        <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl">
            <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 ml-1">Informasi Buku</h2>

            <div class="flex gap-6">
                <div class="shrink-0">
                    <img
                        src="{{ Str::startsWith($peminjaman->buku?->foto_cover, 'storage/')
                            ? asset($peminjaman->buku->foto_cover)
                            : asset('storage/'.$peminjaman->buku?->foto_cover) }}"
                        class="w-24 h-32 object-cover rounded-xl shadow-2xl ring-2 ring-white/10"
                    >
                </div>

                <div class="flex-1 space-y-4">
                    <div class="bg-white/5 p-3 rounded-xl border border-white/5">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-0.5">Kode Buku</p>
                        <p class="font-bold text-white">{{ $peminjaman->buku?->kode_buku ?? '-' }}</p>
                    </div>

                    <div class="bg-white/5 p-3 rounded-xl border border-white/5">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-0.5">Judul</p>
                        <p class="font-bold text-white leading-tight">{{ $peminjaman->buku?->judul ?? '-' }}</p>
                    </div>

                    <div class="bg-white/5 p-3 rounded-xl border border-white/5">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-0.5">Stok</p>
                        <p class="font-bold text-white">{{ $peminjaman->buku?->stok ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- DETAIL --}}
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-8 rounded-3xl shadow-2xl">
        <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-8 ml-1">Detail Peminjaman</h2>

        <div class="grid md:grid-cols-2 gap-8">

            <div class="space-y-6">
                <div class="bg-white/5 p-5 rounded-2xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Tanggal Pinjam</p>
                    <p class="text-xl font-black text-white">
                        {{ $peminjaman->tanggal_pinjam->format('d M Y') }}
                    </p>
                </div>

                <div class="bg-white/5 p-5 rounded-2xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Rencana Kembali</p>
                    <p class="text-xl font-black text-indigo-400">
                        {{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}
                    </p>
                </div>

                <div class="bg-white/5 p-5 rounded-2xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3">Status Saat Ini</p>
                    <p>
                        @if($peminjaman->status === 'pending')
                            <span class="px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20 shadow-lg shadow-amber-500/10">Pending Approval</span>
                        @elseif($peminjaman->status === 'disetujui')
                            <span class="px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 shadow-lg shadow-emerald-500/10">Sedang Dipinjam</span>
                        @elseif($peminjaman->status === 'ditolak')
                            <span class="px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-full bg-rose-500/10 text-rose-400 border border-rose-500/20 shadow-lg shadow-rose-500/10">Ditolak</span>
                        @else
                            <span class="px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 shadow-lg shadow-indigo-500/10">Sudah Kembali</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white/5 p-5 rounded-2xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Disetujui Oleh</p>
                    <p class="font-bold text-white">{{ $peminjaman->petugas->name ?? '-' }}</p>
                </div>

                <div class="bg-white/5 p-5 rounded-2xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Keperluan</p>
                    <p class="font-medium text-slate-300 leading-relaxed">{{ $peminjaman->keperluan }}</p>
                </div>

                @if($peminjaman->catatan_petugas)
                <div class="bg-rose-500/10 p-5 rounded-2xl border border-rose-500/20 shadow-lg shadow-rose-500/5">
                    <p class="text-[10px] font-bold text-rose-400 uppercase tracking-widest mb-2">Catatan Petugas</p>
                    <p class="font-bold text-rose-400">
                        {{ $peminjaman->catatan_petugas }}
                    </p>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

{{-- 🔥 SWEETALERT MODAL --}}
<script>
function setujuiPeminjaman(id) {
    Swal.fire({
        title: 'Setujui Peminjaman?',
        text: 'Data akan disetujui dan status akan berubah',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Setujui',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#22c55e',
        cancelButtonColor: '#6b7280'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-setujui-' + id).submit();
        }
    });
}

function tolakPeminjaman(actionUrl) {
    Swal.fire({
        title: 'Tolak Peminjaman?',
        text: 'Masukkan alasan penolakan (opsional)',
        icon: 'warning',
        input: 'textarea',
        inputPlaceholder: 'Contoh: Buku sedang dipinjam orang lain',
        showCancelButton: true,
        confirmButtonText: 'Ya, Tolak',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280'
    }).then((result) => {
        if (result.isConfirmed) {

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = actionUrl;

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';

            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PATCH';

            const alasan = document.createElement('input');
            alasan.type = 'hidden';
            alasan.name = 'catatan_petugas';
            alasan.value = result.value || '';

            form.appendChild(csrf);
            form.appendChild(method);
            form.appendChild(alasan);

            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

@endsection