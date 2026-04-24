{{-- resources/views/admin/peminjaman/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Peminjaman')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-8 rounded-3xl shadow-2xl">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 flex items-center justify-center text-2xl shadow-lg shadow-amber-500/10">✏️</div>
            <h1 class="text-2xl font-black text-white tracking-tight">Edit <span class="text-amber-400">Peminjaman</span></h1>
        </div>

        <form method="POST" action="{{ route('admin.peminjaman.update', $peminjaman) }}">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Peminjam</label>
                <select name="user_id" 
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all appearance-none @error('user_id') border-rose-500 @enderror" 
                        required>
                    <option value="" class="bg-slate-900">Pilih Peminjam</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $peminjaman->user_id) == $user->id ? 'selected' : '' }} class="bg-slate-900">
                            {{ $user->name }} ({{ $user->username }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Buku</label>
                <select name="buku_id" 
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all appearance-none @error('buku_id') border-rose-500 @enderror" 
                        required>
                    <option value="" class="bg-slate-900">Pilih Buku</option>
                    @foreach($bukus as $buku)
                        <option value="{{ $buku->id }}" {{ old('buku_id', $peminjaman->buku_id) == $buku->id ? 'selected' : '' }} class="bg-slate-900">
                            {{ $buku->kode_buku }} - {{ $buku->judul }} ({{ ucfirst($buku->status) }})
                        </option>
                    @endforeach
                </select>
                @error('buku_id')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Tanggal Mulai Pinjam</label>
                <input type="date" name="tanggal_pinjam" 
                       value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam->format('Y-m-d')) }}" 
                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all @error('tanggal_pinjam') border-rose-500 @enderror" 
                       required>
                @error('tanggal_pinjam')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Tanggal Rencana Kembali</label>
                <input type="date" name="tanggal_kembali_rencana" 
                       value="{{ old('tanggal_kembali_rencana', $peminjaman->tanggal_kembali_rencana->format('Y-m-d')) }}" 
                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all @error('tanggal_kembali_rencana') border-rose-500 @enderror" 
                       required>
                @error('tanggal_kembali_rencana')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Keperluan</label>
                <textarea name="keperluan" rows="3" 
                          class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all @error('keperluan') border-rose-500 @enderror" 
                          required>{{ old('keperluan', $peminjaman->keperluan) }}</textarea>
                @error('keperluan')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Status</label>
                <select name="status" 
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all appearance-none @error('status') border-rose-500 @enderror" 
                        required>
                    <option value="pending" {{ old('status', $peminjaman->status) === 'pending' ? 'selected' : '' }} class="bg-slate-900">Pending</option>
                    <option value="disetujui" {{ old('status', $peminjaman->status) === 'disetujui' ? 'selected' : '' }} class="bg-slate-900">Disetujui</option>
                    <option value="ditolak" {{ old('status', $peminjaman->status) === 'ditolak' ? 'selected' : '' }} class="bg-slate-900">Ditolak</option>
                    <option value="selesai" {{ old('status', $peminjaman->status) === 'selesai' ? 'selected' : '' }} class="bg-slate-900">Selesai</option>
                </select>
                @error('status')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Catatan Petugas (Opsional)</label>
                <textarea name="catatan_petugas" rows="2" 
                          class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all @error('catatan_petugas') border-rose-500 @enderror" 
                          placeholder="Catatan tambahan dari petugas...">{{ old('catatan_petugas', $peminjaman->catatan_petugas) }}</textarea>
                @error('catatan_petugas')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-white/5">
                <a href="{{ route('admin.peminjaman.index') }}" 
                   class="px-6 py-3 bg-white/5 hover:bg-white/10 text-white rounded-2xl text-xs font-bold transition-all active:scale-95">
                    Batal
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-2xl text-xs font-bold transition-all shadow-lg shadow-amber-500/20 active:scale-95">
                    Update Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>
@endsection