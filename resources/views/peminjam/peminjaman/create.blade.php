@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Ajukan Peminjaman Buku</h1>

    <!-- Informasi Buku -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="text-xl font-bold mb-4">Informasi Buku</h2>
        <div class="flex flex-col sm:flex-row gap-4">
            <!-- Thumbnail Buku (Opsional, agar lebih menarik) -->
            <div class="shrink-0 w-full sm:w-32 h-48 bg-gray-100 rounded-lg overflow-hidden relative">
                @if($buku->cover)
                    <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                @endif
            </div>

            <!-- Detail Buku -->
            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-4">
                <div class="sm:col-span-2">
                    <p class="text-gray-500 text-xs uppercase tracking-wide font-semibold">Judul Buku</p>
                    <p class="font-bold text-lg leading-tight text-gray-900">{{ $buku-> judul }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs uppercase tracking-wide font-semibold">Penulis</p>
                    <p class="font-semibold">{{ $buku-> pengarang }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs uppercase tracking-wide font-semibold">Kategori</p>
                    <p class="font-semibold">{{ $buku-> kategori_buku}}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs uppercase tracking-wide font-semibold">ISBN</p>
                    <p class="font-mono text-sm">{{ $buku-> kode_buku }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs uppercase tracking-wide font-semibold">Stok Tersedia</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $buku->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $buku->stok }} Buku
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Peminjaman -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Form Peminjaman</h2>
        
        <form method="POST" action="{{ route('peminjam.peminjaman.store') }}">
            @csrf
            {{-- GANTI: loker_id menjadi buku_id --}}
            <input type="hidden" name="buku_id" value="{{ $buku->id }}">

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Tanggal Mulai Pinjam</label>
                <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" 
                       value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" 
                       min="{{ date('Y-m-d') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none @error('tanggal_pinjam') border-red-500 @enderror" 
                       required>
                @error('tanggal_pinjam')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Tanggal Rencana Kembali</label>
                <input type="date" id="tanggal_kembali_rencana" name="tanggal_kembali_rencana" 
                    value="{{ old('tanggal_kembali_rencana') }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none @error('tanggal_kembali_rencana') border-red-500 @enderror" 
                    required>
                @error('tanggal_kembali_rencana')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">
                    Maksimal peminjaman adalah <strong>{{ $buku->max_pinjam ?? 14 }} hari</strong>.
                </p>

                <script>
                    const tglPinjam = document.getElementById('tanggal_pinjam');
                    const tglKembali = document.getElementById('tanggal_kembali_rencana');
                    
                    {{-- Hitung tanggal maksimal kembali dari data buku --}}
                    const maxHari = {{ $buku->max_pinjam ?? 14 }};

                    function updateMinDate() {
                        if (tglPinjam.value) {
                            tglKembali.min = tglPinjam.value;
                            
                            // Hitung tanggal maksimal berdasarkan max_pinjam
                            const datePinjam = new Date(tglPinjam.value);
                            const dateMax = new Date(datePinjam);
                            dateMax.setDate(dateMax.getDate() + maxHari);
                            tglKembali.max = dateMax.toISOString().split('T')[0];

                            // Jika tanggal kembali lebih kecil dari tanggal pinjam, reset ke tanggal pinjam
                            if (tglKembali.value && tglKembali.value < tglPinjam.value) {
                                tglKembali.value = tglPinjam.value;
                            }
                        }
                    }

                    tglPinjam.addEventListener('change', updateMinDate);
                    updateMinDate(); // Initialize on page load
                </script>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Catatan / Keperluan</label>
                <textarea name="keperluan" rows="3" 
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none @error('keperluan') border-red-500 @enderror" 
                          placeholder="Tuliskan catatan tambahan (opsional)...">{{ old('keperluan') }}</textarea>
                @error('keperluan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition shadow-sm">
                    Ajukan Peminjaman
                </button>
                <a href="{{ route('peminjam.peminjaman.index') }}" 
                   class="flex-1 text-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-lg font-medium transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection