@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">

    {{-- HEADER ACTION --}}
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6">
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
                        class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white rounded-xl text-sm transition">
                        Setujui
                    </button>
                </form>

                    {{-- TOLAK (MODAL) --}}
                    <button type="button"
                            onclick="tolakPeminjaman('{{ route('admin.peminjaman.tolak', $peminjaman) }}')"
                            class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl text-sm transition">
                        Tolak
                    </button>
                @endif

                {{-- EDIT --}}
                <a href="{{ route('admin.peminjaman.edit', $peminjaman) }}"
                   class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl text-sm transition">
                    Edit
                </a>

                {{-- KEMBALI --}}
                <a href="{{ route('admin.peminjaman.index') }}"
                   class="px-3 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-xl text-sm transition">
                    Kembali
                </a>

            </div>
        </div>
    </div>

    {{-- GRID --}}
    <div class="grid md:grid-cols-2 gap-6 mb-6">

        {{-- PEMINJAM --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-lg font-semibold mb-4 text-gray-700">Informasi Peminjam</h2>

            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-gray-500">Nama</p>
                    <p class="font-semibold text-gray-800">{{ $peminjaman->user->name }}</p>
                </div>

                <div>
                    <p class="text-gray-500">Username</p>
                    <p class="font-semibold text-gray-800">{{ $peminjaman->user->username }}</p>
                </div>

                @if($peminjaman->user->kategori)
                <div>
                    <p class="text-gray-500">Kategori</p>
                    <p class="font-semibold text-gray-800">
                        {{ $peminjaman->user->kategori->nama_kategori }}
                    </p>
                </div>
                @endif
            </div>
        </div>

        {{-- BUKU --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-lg font-semibold mb-4 text-gray-700">Informasi Buku</h2>

            <div class="flex gap-4">
                <img
                    src="{{ Str::startsWith($peminjaman->buku?->foto_cover, 'storage/')
                        ? asset($peminjaman->buku->foto_cover)
                        : asset('storage/'.$peminjaman->buku?->foto_cover) }}"
                    class="w-24 h-32 object-cover rounded-xl shadow-sm"
                >

                <div class="space-y-2 text-sm">
                    <div>
                        <p class="text-gray-500">Kode Buku</p>
                        <p class="font-semibold text-gray-800">{{ $peminjaman->buku?->kode_buku ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Judul</p>
                        <p class="font-semibold text-gray-800">{{ $peminjaman->buku?->judul ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Stok</p>
                        <p class="font-semibold text-gray-800">{{ $peminjaman->buku?->stok ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- DETAIL --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-lg font-semibold mb-4 text-gray-700">Detail Peminjaman</h2>

        <div class="grid md:grid-cols-2 gap-4 text-sm">

            <div>
                <p class="text-gray-500">Tanggal Pinjam</p>
                <p class="font-semibold text-gray-800">
                    {{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Rencana Kembali</p>
                <p class="font-semibold text-gray-800">
                    {{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Status</p>
                <p>
                    @if($peminjaman->status === 'pending')
                        <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                    @elseif($peminjaman->status === 'disetujui')
                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">Disetujui</span>
                    @elseif($peminjaman->status === 'ditolak')
                        <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">Ditolak</span>
                    @else
                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">Selesai</span>
                    @endif
                </p>
            </div>

            <div>
                <p class="text-gray-500">Disetujui Oleh</p>
                <p class="font-semibold text-gray-800">{{ $peminjaman->petugas->name ?? '-' }}</p>
            </div>

            <div class="md:col-span-2">
                <p class="text-gray-500">Keperluan</p>
                <p class="font-semibold text-gray-800">{{ $peminjaman->keperluan }}</p>
            </div>

            @if($peminjaman->catatan_petugas)
            <div class="md:col-span-2">
                <p class="text-gray-500">Catatan Petugas</p>
                <p class="font-semibold text-red-500">
                    {{ $peminjaman->catatan_petugas }}
                </p>
            </div>
            @endif

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