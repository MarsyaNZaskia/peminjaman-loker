<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    // Lihat semua pengembalian
    public function index()
    {
        $pengembalian = Pengembalian::with(['peminjaman.user', 'peminjaman.loker', 'user'])
            ->latest()
            ->get();

        return view('admin.pengembalian.index', compact('pengembalian'));
    }

    // Detail pengembalian
    public function show(Pengembalian $pengembalian)
    {
        $pengembalian->load(['peminjaman.user', 'peminjaman.loker', 'user']);
        return view('admin.pengembalian.show', compact('pengembalian'));
    }

    // Form edit pengembalian
    public function edit(Pengembalian $pengembalian)
    {
        $pengembalian->load(['peminjaman.user', 'peminjaman.loker']);
        return view('admin.pengembalian.edit', compact('pengembalian'));
    }

    // Update pengembalian
    public function update(Request $request, Pengembalian $pengembalian)
    {
        $validated = $request->validate([
            'tgl_kembali_realisasi' => 'required|date',
            'kondisi_barang' => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
            'jenis_denda' => 'required|in:tidak_ada,telat,rusak,hilang',
            'total_denda' => 'required|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        $pengembalian->update($validated);

        return redirect()->route('admin.pengembalian.index')
            ->with('success', 'Data pengembalian berhasil diupdate');
    }

    // Hapus pengembalian
    public function destroy(Pengembalian $pengembalian)
    {
        DB::transaction(function () use ($pengembalian) {
            // Kembalikan status peminjaman ke disetujui
            $pengembalian->peminjaman->update(['status' => 'disetujui']);
            
            // Kembalikan status loker ke dipinjam
            $pengembalian->peminjaman->loker->update(['status' => 'dipinjam']);
            
            $pengembalian->delete();
        });

        return redirect()->route('admin.pengembalian.index')
            ->with('success', 'Data pengembalian berhasil dihapus');
    }
}
