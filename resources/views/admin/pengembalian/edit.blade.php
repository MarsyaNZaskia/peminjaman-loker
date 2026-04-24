{{-- resources/views/admin/pengembalian/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Pengembalian')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-8 rounded-3xl shadow-2xl">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 flex items-center justify-center text-2xl shadow-lg shadow-amber-500/10">✏️</div>
            <h1 class="text-2xl font-black text-white tracking-tight">Edit <span class="text-amber-400">Pengembalian</span></h1>
        </div>

        <div class="bg-white/5 p-6 rounded-2xl border border-white/5 mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Peminjam</p>
                <p class="font-bold text-white">{{ $pengembalian->peminjaman->user->name }}</p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Buku</p>
                <p class="font-bold text-indigo-400 text-sm">{{ $pengembalian->peminjaman->buku->kode_buku }} - {{ $pengembalian->peminjaman->buku->judul }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.pengembalian.update', $pengembalian) }}">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Tanggal Pengembalian</label>
                <input type="date" name="tgl_kembali_realisasi" 
                       value="{{ old('tgl_kembali_realisasi', $pengembalian->tgl_kembali_realisasi->format('Y-m-d')) }}" 
                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all @error('tgl_kembali_realisasi') border-rose-500 @enderror" 
                       required>
                @error('tgl_kembali_realisasi')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Kondisi Buku</label>
                <select name="kondisi_barang" 
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all appearance-none @error('kondisi_barang') border-rose-500 @enderror" 
                        required>
                    <option value="baik" {{ old('kondisi_barang', $pengembalian->kondisi_barang) === 'baik' ? 'selected' : '' }} class="bg-slate-900">Baik</option>
                    <option value="rusak" {{ old('kondisi_barang', $pengembalian->kondisi_barang) === 'rusak' ? 'selected' : '' }} class="bg-slate-900">Rusak</option>
                    <option value="hilang" {{ old('kondisi_barang', $pengembalian->kondisi_barang) === 'hilang' ? 'selected' : '' }} class="bg-slate-900">Buku Hilang</option>
                </select>
                @error('kondisi_barang')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5 bg-indigo-500/5 p-6 rounded-2xl border border-indigo-500/10">
                <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-3 ml-1">Total Denda (Rp)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white font-black">Rp</span>
                    <input type="number" name="total_denda" 
                           value="{{ old('total_denda', $pengembalian->total_denda) }}" 
                           min="0"
                           class="w-full pl-12 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-2xl font-black text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all @error('total_denda') border-rose-500 @enderror" 
                           required>
                </div>
                @error('total_denda')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Catatan</label>
                <textarea name="catatan" rows="3" 
                          class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all @error('catatan') border-rose-500 @enderror">{{ old('catatan', $pengembalian->catatan) }}</textarea>
                @error('catatan')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-white/5">
                <a href="{{ route('admin.pengembalian.index') }}" 
                   class="px-6 py-3 bg-white/5 hover:bg-white/10 text-white rounded-2xl text-xs font-bold transition-all active:scale-95">
                    Batal
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-2xl text-xs font-bold transition-all shadow-lg shadow-amber-500/20 active:scale-95 uppercase tracking-widest">
                    Update Pengembalian
                </button>
            </div>
        </form>
    </div>
</div>
@endsection