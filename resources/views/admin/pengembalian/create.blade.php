@extends('layouts.app')

@section('title', 'Catat Pengembalian')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-4 rounded-2xl shadow-2xl mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-xl shadow-lg shadow-indigo-500/10">🔄</div>
            <h1 class="text-xl font-black text-white tracking-tight">Catat <span class="text-indigo-400">Pengembalian Buku</span></h1>
        </div>
    </div>

    <!-- Info Peminjaman -->
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl mb-8">
        <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 ml-1">Informasi Peminjaman</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Peminjam</p>
                <p class="font-bold text-white">{{ $peminjaman->user->name }}</p>
            </div>
            <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Buku</p>
                <p class="font-bold text-white text-xs">{{ $peminjaman->buku->kode_buku }} - {{ $peminjaman->buku->judul }}</p>
            </div>
            <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Tanggal Pinjam</p>
                <p class="font-bold text-white">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
            </div>
            <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Rencana Kembali</p>
                <p class="font-bold {{ $peminjaman->isTerlambat() ? 'text-rose-400' : 'text-indigo-400' }}">
                    {{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}
                    @if($peminjaman->isTerlambat())
                        <span class="text-[8px] uppercase tracking-tighter">(Terlambat)</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Form Pengembalian -->
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-8 rounded-3xl shadow-2xl">
        <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-8 ml-1">Form Pengembalian</h2>
        
        <form method="POST" action="{{ route('admin.pengembalian.store', $peminjaman) }}" id="formPengembalian">
            @csrf

            <div class="mb-5">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Tanggal Pengembalian</label>
                <input type="date" name="tgl_kembali_realisasi" 
                       value="{{ old('tgl_kembali_realisasi', $peminjaman->tanggal_kembali_rencana->format('Y-m-d')) }}" 
                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all @error('tgl_kembali_realisasi') border-rose-500 @enderror" 
                       id="tglKembali"
                       onchange="hitungDenda()"
                       required>
                @error('tgl_kembali_realisasi')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
                <p class="text-[10px] text-slate-500 mt-1 ml-1 uppercase font-bold tracking-tight">Pilih tanggal kapan buku dikembalikan</p>
            </div>

            <div class="mb-5">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Kondisi Buku</label>
                <select name="kondisi_barang" 
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all appearance-none @error('kondisi_barang') border-rose-500 @enderror"
                        onchange="hitungDenda()" 
                        required>
                    <option value="baik" {{ old('kondisi_barang') === 'baik' ? 'selected' : '' }} class="bg-slate-900">Baik</option>
                    <option value="rusak" {{ old('kondisi_barang') === 'rusak' ? 'selected' : '' }} class="bg-slate-900">Rusak</option>
                    <option value="hilang" {{ old('kondisi_barang') === 'hilang' ? 'selected' : '' }} class="bg-slate-900">Buku Hilang</option>
                </select>
                @error('kondisi_barang')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5 bg-indigo-500/5 p-6 rounded-2xl border border-indigo-500/10">
                <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-3 ml-1">Total Denda Estimasi (Rp)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white font-black">Rp</span>
                    <input type="number" name="total_denda" 
                           value="{{ old('total_denda', 0) }}" 
                           min="0"
                           id="totalDenda"
                           class="w-full pl-12 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-2xl font-black text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all @error('total_denda') border-rose-500 @enderror" 
                           required>
                </div>
                @error('total_denda')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
                <p class="text-[10px] text-indigo-400 mt-2 ml-1 uppercase font-bold tracking-widest" id="infoDenda"></p>
            </div>

            <div class="mb-8">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Catatan (Opsional)</label>
                <textarea name="catatan" rows="3" 
                          class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all @error('catatan') border-rose-500 @enderror" 
                          placeholder="Catatan tambahan...">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-white/5">
                <a href="{{ route('admin.peminjaman.show', $peminjaman) }}"
                   class="px-6 py-3 bg-white/5 hover:bg-white/10 text-white rounded-2xl text-xs font-bold transition-all active:scale-95">
                    Batal
                </a>
                <button type="button"
                        onclick="submitFormConfirm()"
                        class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-xs font-bold transition-all shadow-lg shadow-indigo-500/20 active:scale-95 uppercase tracking-widest">
                    Simpan Pengembalian
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const tanggalRencana = new Date('{{ $peminjaman->tanggal_kembali_rencana->format('Y-m-d') }}');
const DENDA_PER_HARI = 2000; // Rp 2.000 per hari
const DENDA_RUSAK = 20000; // Rp 20.000
const DENDA_HILANG = 25000; // Rp 25.000

function hitungDenda() {
    const tglKembali = document.getElementById('tglKembali').value;
    const kondisi = document.querySelector('[name="kondisi_barang"]').value;
    const totalDendaInput = document.getElementById('totalDenda');
    const infoDenda = document.getElementById('infoDenda');
    
    if (!tglKembali) return;
    
    let denda = 0;
    let info = '';
    
    // Prioritas: hilang > rusak > telat > tidak_ada
    if (kondisi === 'hilang') {
        denda = DENDA_HILANG;
        info = `✓ Denda kehilangan: Rp ${denda.toLocaleString()}`;
    } else if (kondisi === 'rusak') {
        denda = DENDA_RUSAK;
        info = `✓ Denda kerusakan: Rp ${denda.toLocaleString()}`;
    } else if (kondisi === 'baik') {
        // Cek keterlambatan: Terlambat jika tanggal pengembalian aktual > tanggal rencana kembali
        const tanggalRencanaStr = tanggalRencana.toISOString().split('T')[0];
        const tanggalKembaliStr = tglKembali;

        if (tanggalKembaliStr > tanggalRencanaStr) {
            // Hitung selisih hari untuk denda
            const tanggalRencanaDate = new Date(tanggalRencanaStr);
            const tanggalKembaliDate = new Date(tanggalKembaliStr);
            const diffTime = tanggalKembaliDate - tanggalRencanaDate;
            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
            denda = diffDays * DENDA_PER_HARI;
            info = `Terlambat ${diffDays} hari × Rp ${DENDA_PER_HARI.toLocaleString()} = Rp ${denda.toLocaleString()}`;
        } else {
            info = 'Tepat Waktu - Tidak ada denda';
        }
    }
    
    totalDendaInput.value = denda;
    infoDenda.textContent = info;
}

// Initial calculation
document.addEventListener('DOMContentLoaded', function() {
    hitungDenda();
});

function submitFormConfirm() {
    const totalDenda = document.getElementById('totalDenda').value;
    const kondisi = document.querySelector('[name="kondisi_barang"]').value;

    let message = 'Simpan data pengembalian buku ini?';
    if (totalDenda > 0) {
        message = `Simpan pengembalian dengan denda Rp ${parseInt(totalDenda).toLocaleString()}?`;
    }

    Swal.fire({
        title: 'Konfirmasi Pengembalian',
        text: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan',
        confirmButtonColor: '#3b82f6',
        cancelButtonText: 'Batal',
        cancelButtonColor: '#6b7280'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formPengembalian').submit();
        }
    });
}
</script>
@endsection
