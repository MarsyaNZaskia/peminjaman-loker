@extends('layouts.app')

@section('title', 'Catat Pengembalian')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Catat Pengembalian Buku</h1>

    <!-- Info Peminjaman -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="text-xl font-bold mb-4">Informasi Peminjaman</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">Peminjam</p>
                <p class="font-semibold">{{ $peminjaman->user->name }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Buku</p>
                <p class="font-semibold">{{ $peminjaman->buku->kode_buku }} - {{ $peminjaman->buku->judul }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Tanggal Pinjam</p>
                <p class="font-semibold">{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Rencana Kembali</p>
                <p class="font-semibold {{ $peminjaman->isTerlambat() ? 'text-red-600' : '' }}">
                    {{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}
                    @if($peminjaman->isTerlambat())
                        <span class="text-xs">(Terlambat)</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Form Pengembalian -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Form Pengembalian</h2>
        
        <form method="POST" action="{{ route('admin.pengembalian.store', $peminjaman) }}" id="formPengembalian">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Tanggal Pengembalian</label>
                <input type="date" name="tgl_kembali_realisasi" 
                       value="{{ old('tgl_kembali_realisasi', $peminjaman->tanggal_kembali_rencana->format('Y-m-d')) }}" 
                       class="w-full px-3 py-2 border rounded-lg @error('tgl_kembali_realisasi') border-red-500 @enderror" 
                       id="tglKembali"
                       onchange="hitungDenda()"
                       required>
                @error('tgl_kembali_realisasi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Pilih tanggal kapan buku dikembalikan</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Kondisi Buku</label>
                <select name="kondisi_barang" 
                        class="w-full px-3 py-2 border rounded-lg @error('kondisi_barang') border-red-500 @enderror"
                        onchange="hitungDenda()" 
                        required>
                    <option value="baik" {{ old('kondisi_barang') === 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="rusak" {{ old('kondisi_barang') === 'rusak' ? 'selected' : '' }}>Rusak</option>
                    <option value="hilang" {{ old('kondisi_barang') === 'hilang' ? 'selected' : '' }}>Buku Hilang</option>
                </select>
                @error('kondisi_barang')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Total Denda (Rp)</label>
                <input type="number" name="total_denda" 
                       value="{{ old('total_denda', 0) }}" 
                       min="0"
                       id="totalDenda"
                       class="w-full px-3 py-2 border rounded-lg @error('total_denda') border-red-500 @enderror" 
                       required>
                @error('total_denda')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1" id="infoDenda"></p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Catatan (Opsional)</label>
                <textarea name="catatan" rows="3" 
                          class="w-full px-3 py-2 border rounded-lg @error('catatan') border-red-500 @enderror" 
                          placeholder="Catatan tambahan...">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-2">
                <button type="button"
                        onclick="submitFormConfirm()"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Simpan Pengembalian
                </button>
                <a href="{{ route('admin.peminjaman.show', $peminjaman) }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Batal
                </a>
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
