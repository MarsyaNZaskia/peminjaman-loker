@extends('layouts.app')

@section('title', 'Kelola Peminjaman')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Kelola Peminjaman</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filter Status -->
<div class="bg-white p-4 rounded-lg shadow mb-4">
    <div class="flex space-x-4">
        <a href="{{ route('petugas.peminjaman.index') }}" 
           class="px-4 py-2 rounded {{ !request('status') ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
            Semua ({{ \App\Models\Peminjaman::count() }})
        </a>
        <a href="{{ route('petugas.peminjaman.index', ['status' => 'pending']) }}" 
           class="px-4 py-2 rounded {{ request('status') === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-200' }}">
            Pending ({{ \App\Models\Peminjaman::where('status', 'pending')->count() }})
        </a>
        <a href="{{ route('petugas.peminjaman.index', ['status' => 'disetujui']) }}" 
           class="px-4 py-2 rounded {{ request('status') === 'disetujui' ? 'bg-green-500 text-white' : 'bg-gray-200' }}">
            Disetujui ({{ \App\Models\Peminjaman::where('status', 'disetujui')->count() }})
        </a>
        <a href="{{ route('petugas.peminjaman.index', ['status' => 'selesai']) }}" 
           class="px-4 py-2 rounded {{ request('status') === 'selesai' ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
            Selesai ({{ \App\Models\Peminjaman::where('status', 'selesai')->count() }})
        </a>
        <a href="{{ route('petugas.peminjaman.index', ['status' => 'ditolak']) }}" 
           class="px-4 py-2 rounded {{ request('status') === 'ditolak' ? 'bg-red-500 text-white' : 'bg-gray-200' }}">
            Ditolak ({{ \App\Models\Peminjaman::where('status', 'ditolak')->count() }})
        </a>
    </div>
</div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peminjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Loker</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pinjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($peminjaman as $pinjam)
                    <tr>
                        <td class="px-6 py-4">{{ $pinjam->user->name }}</td>
                        <td class="px-6 py-4 font-semibold">{{ $pinjam->loker->nomor_loker }}</td>
                        <td class="px-6 py-4">{{ $pinjam->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            @if($pinjam->status === 'pending')
                                <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($pinjam->status === 'disetujui')
                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Disetujui</span>
                            @elseif($pinjam->status === 'ditolak')
                                <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800">Ditolak</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">Selesai</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('petugas.peminjaman.show', $pinjam) }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Belum ada peminjaman
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection