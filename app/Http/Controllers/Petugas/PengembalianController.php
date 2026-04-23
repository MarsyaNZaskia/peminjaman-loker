<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    // Form catat pengembalian
    public function create(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'disetujui') {
            return redirect()->route('petugas.peminjaman.index')
                ->with('error', 'Peminjaman tidak dalam status aktif');
        }

        if ($peminjaman->sudahDikembalikan()) {
            return redirect()->route('petugas.peminjaman.index')
                ->with('error', 'Peminjaman sudah dikembalikan');
        }

        return view('petugas.pengembalian.create', compact('peminjaman'));
    }

    // Proses catat pengembalian
    public function store(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'tgl_kembali_realisasi' => 'required|date',
            'kondisi_barang' => 'required|in:baik,rusak,hilang',
            'total_denda' => 'required|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $peminjaman) {
            // Catat pengembalian
            $pengembalian = Pengembalian::create([
                'user_id' => Auth::id(),
                'peminjaman_id' => $peminjaman->id,
                'tgl_kembali_realisasi' => $validated['tgl_kembali_realisasi'],
                'kondisi_barang' => $validated['kondisi_barang'],
                'total_denda' => $validated['total_denda'],
                'catatan' => $validated['catatan'],
            ]);

            LogAktivitas::catat(
            'return', 
            'Pengembalian', 
            $pengembalian->id, 
            "Mencatat pengembalian buku {$peminjaman->buku->kode_buku} dengan denda Rp " . number_format($validated['total_denda'], 0, ',', '.')
        );

            // Update status peminjaman
            $peminjaman->update(['status' => 'selesai']);

            // Update status buku
            $peminjaman->buku->increment('stok');
            $peminjaman->buku->update(['status' => 'tersedia']);
        });

        return redirect()->route('petugas.peminjaman.index')
            ->with('success', 'Pengembalian berhasil dicatat');
    }

    // Lihat semua pengembalian
    public function index()
    {
        $pengembalian = Pengembalian::with(['peminjaman.user', 'peminjaman.buku', 'user'])
            ->latest()
            ->get();

        return view('petugas.pengembalian.index', compact('pengembalian'));
    }

    // Detail pengembalian
    public function show(Pengembalian $pengembalian)
    {
        $pengembalian->load(['peminjaman.user', 'peminjaman.buku', 'user']);
        return view('petugas.pengembalian.show', compact('pengembalian'));
    }

}
