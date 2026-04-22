@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="bg-linear-to-r from-indigo-600 via-blue-600 to-slate-800 rounded-2xl shadow-xl p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">📚 Riwayat Peminjaman</h1>
                <p class="text-purple-100">Lihat semua history peminjaman loker Anda</p>
            </div>
            <div class="hidden md:block text-6xl opacity-40">📜</div>
        </div>
    </div>

    <!-- Filter & Stats -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl shadow-lg p-4 border-l-4 border-yellow-500">
            <p class="text-gray-500 text-sm mb-1">Total Pending</p>
            <p class="text-2xl font-bold text-yellow-600">
                {{ \App\Models\Peminjaman::where('user_id', Auth::id())->where('status', 'pending')->count() }}
            </p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-4 border-l-4 border-green-500">
            <p class="text-gray-500 text-sm mb-1">Total Disetujui</p>
            <p class="text-2xl font-bold text-green-600">
                {{ \App\Models\Peminjaman::where('user_id', Auth::id())->where('status', 'disetujui')->count() }}
            </p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-4 border-l-4 border-red-500">
            <p class="text-gray-500 text-sm mb-1">Total Ditolak</p>
            <p class="text-2xl font-bold text-red-600">
                {{ \App\Models\Peminjaman::where('user_id', Auth::id())->where('status', 'ditolak')->count() }}
            </p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-4 border-l-4 border-blue-500">
            <p class="text-gray-500 text-sm mb-1">Total Selesai</p>
            <p class="text-2xl font-bold text-blue-600">
                {{ \App\Models\Peminjaman::where('user_id', Auth::id())->where('status', 'selesai')->count() }}
            </p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-4 border-l-4 border-purple-500">
            <p class="text-gray-500 text-sm mb-1">Total Riwayat</p>
            <p class="text-2xl font-bold text-purple-600">
                {{ \App\Models\Peminjaman::where('user_id', Auth::id())->whereIn('status', ['pending', 'disetujui', 'ditolak', 'selesai'])->count() }}
            </p>
        </div>
    </div>

    <!-- Riwayat List -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">📋 Daftar Riwayat</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loker</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($riwayat as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $loop->iteration + ($riwayat->currentPage() - 1) * $riwayat->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-2xl mr-3">🔐</span>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $item->buku->kode_buku }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->buku->judul }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->tanggal_pinjam->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($item->pengembalian)
                                    {{ $item->pengembalian->tgl_kembali_realisasi->format('d M Y') }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->status === 'pending')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        ⏳ Pending
                                    </span>
                                @elseif($item->status === 'disetujui')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        ✅ Disetujui
                                    </span>
                                @elseif($item->status === 'ditolak')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        ❌ Ditolak
                                    </span>
                                @elseif($item->status === 'selesai')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        🏁 Selesai
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('peminjam.riwayat.show', $item) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors shadow-sm hover:shadow-md">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="text-6xl mb-4">📭</span>
                                    <p class="text-gray-500 font-medium">Belum ada riwayat peminjaman</p>
                                    <p class="text-gray-400 text-sm mt-1">Mulai ajukan peminjaman loker untuk melihat riwayat di sini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($riwayat->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $riwayat->links() }}
            </div>
        @endif
    </div>

</div>
@endsection