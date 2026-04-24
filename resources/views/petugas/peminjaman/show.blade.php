{{-- resources/views/petugas/peminjaman/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-4 rounded-2xl shadow-2xl mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-xl shadow-lg shadow-indigo-500/10">📜</div>
            <h1 class="text-xl font-black text-white tracking-tight">Detail <span class="text-indigo-400">Peminjaman</span></h1>
        </div>
        <a href="{{ route('petugas.peminjaman.index') }}" 
           class="px-4 py-2 bg-white/5 hover:bg-white/10 text-white border border-white/10 rounded-xl text-xs font-bold transition-all active:scale-95 uppercase tracking-wider">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Info Peminjam -->
        <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl">
            <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 ml-1">Informasi Peminjam</h2>
            <div class="space-y-4">
                <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Nama Peminjam</p>
                    <p class="font-bold text-white">{{ $peminjaman->user->name }}</p>
                </div>
                <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Username</p>
                    <p class="font-bold text-white">{{ $peminjaman->user->username }}</p>
                </div>
            </div>
        </div>

        <!-- Info Buku -->
        <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl">
            <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 ml-1">Informasi Buku</h2>
            <div class="space-y-4">
                <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Kode Buku</p>
                    <p class="font-black text-xl text-white tracking-tighter">{{ $peminjaman->buku->kode_buku }}</p>
                </div>
                <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Judul</p>
                    <p class="font-bold text-white">{{ $peminjaman->buku->judul }}</p>
                </div>
                <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Pengarang</p>
                    <p class="font-bold text-slate-400">{{ $peminjaman->buku->pengarang }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Peminjaman -->
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl mb-6">
        <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 ml-1">Detail Peminjaman</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Tanggal Pinjam</p>
                <p class="font-bold text-white">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
            </div>
            <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Rencana Kembali</p>
                <p class="font-bold text-indigo-400">{{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</p>
            </div>
            <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Status</p>
                <p>
                    @if($peminjaman->status === 'pending')
                        <span class="px-3 py-1 text-[8px] font-black uppercase tracking-widest rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20">Pending</span>
                    @elseif($peminjaman->status === 'disetujui')
                        <span class="px-3 py-1 text-[8px] font-black uppercase tracking-widest rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Disetujui</span>
                    @elseif($peminjaman->status === 'ditolak')
                        <span class="px-3 py-1 text-[8px] font-black uppercase tracking-widest rounded-full bg-rose-500/10 text-rose-400 border border-rose-500/20">Ditolak</span>
                    @else
                        <span class="px-3 py-1 text-[8px] font-black uppercase tracking-widest rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Selesai</span>
                    @endif
                </p>
            </div>
            <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Diproses Oleh</p>
                <p class="font-bold text-white">{{ $peminjaman->petugas->name ?? '-' }}</p>
            </div>
            <div class="col-span-2 bg-white/5 p-4 rounded-xl border border-white/5">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Keperluan</p>
                <p class="font-medium text-slate-300">{{ $peminjaman->keperluan }}</p>
            </div>
            @if($peminjaman->catatan_petugas)
                <div class="col-span-2 bg-rose-500/5 p-4 rounded-xl border border-rose-500/10">
                    <p class="text-[10px] font-bold text-rose-400 uppercase tracking-widest mb-1">Catatan Petugas</p>
                    <p class="font-bold text-rose-400">{{ $peminjaman->catatan_petugas }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Aksi -->
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-8 rounded-3xl shadow-2xl">
        <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 ml-1">Aksi Petugas</h2>
        
        @if($peminjaman->status === 'pending')
            <div class="flex flex-wrap gap-3">
                <form method="POST" action="{{ route('petugas.peminjaman.approve', $peminjaman) }}"
                      id="approveForm">
                    @csrf
                    <button type="button"
                            onclick="approveConfirm()"
                            class="px-8 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-emerald-500/20 active:scale-95 flex items-center gap-2">
                        <span>✓</span> Setujui Peminjaman
                    </button>
                </form>

                <button type="button"
                        onclick="showRejectModal()"
                        class="px-8 py-3 bg-white/5 hover:bg-rose-500 text-white border border-white/10 hover:border-rose-500 rounded-2xl text-xs font-black uppercase tracking-widest transition-all active:scale-95 flex items-center gap-2 group">
                    <span class="text-rose-500 group-hover:text-white transition-colors">✗</span> Tolak
                </button>
            </div>

            <!-- Modal Tolak -->
            <div id="rejectModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md hidden flex items-center justify-center z-50 p-4">
                <div class="bg-slate-900 border border-white/10 p-8 rounded-3xl max-w-md w-full shadow-2xl">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-rose-500/10 flex items-center justify-center text-xl">✗</div>
                        <h3 class="text-xl font-black text-white">Tolak Peminjaman</h3>
                    </div>
                    
                    <form method="POST" action="{{ route('petugas.peminjaman.reject', $peminjaman) }}">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Alasan Penolakan</label>
                            <textarea name="catatan_petugas" rows="4" 
                                      class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-rose-500/50 outline-none transition-all text-sm" 
                                      placeholder="Jelaskan alasan penolakan..."
                                      required></textarea>
                        </div>
                        <div class="flex gap-3">
                            <button type="submit" 
                                    class="flex-1 px-6 py-3 bg-rose-500 hover:bg-rose-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all active:scale-95">
                                Tolak Sekarang
                            </button>
                            <button type="button" onclick="hideRejectModal()" 
                                    class="px-6 py-3 bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all active:scale-95">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        @elseif($peminjaman->status === 'disetujui')
            <form method="GET" action="{{ route('petugas.peminjaman.return', $peminjaman) }}"
                  id="returnForm">
                <button type="button"
                        onclick="returnConfirm()"
                        class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-indigo-500/20 active:scale-95 flex items-center gap-2">
                    <span>🔄</span> Catat Pengembalian
                </button>
            </form>
        @else
            <div class="bg-white/5 p-4 rounded-xl border border-dashed border-white/10 text-center">
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Tidak ada aksi yang tersedia</p>
            </div>
        @endif
    </div>
</div>

<script>
function approveConfirm() {
    Swal.fire({
        title: 'Setujui Peminjaman?',
        text: 'Peminjaman akan disetujui dan buku siap dipinjam',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Ya, Setujui',
        confirmButtonColor: '#22c55e',
        cancelButtonText: 'Batal',
        cancelButtonColor: '#6b7280'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('approveForm').submit();
        }
    });
}

function returnConfirm() {
    Swal.fire({
        title: 'Catat Pengembalian?',
        text: 'Lanjut ke halaman pencatatan pengembalian buku',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Lanjut',
        confirmButtonColor: '#3b82f6',
        cancelButtonText: 'Batal',
        cancelButtonColor: '#6b7280'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('returnForm').submit();
        }
    });
}

function showRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endsection