<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Exports\PeminjamanExport;
use App\Exports\PengembalianExport;
use App\Exports\LokerExport;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        return view('petugas.laporan.index');
    }

    // Export Peminjaman
    public function exportPeminjaman(Request $request)
    {
        $validated = $request->validate([
            'status' => 'nullable|in:pending,disetujui,ditolak,selesai',
            'tanggal_dari' => 'nullable|date',
            'tanggal_sampai' => 'nullable|date|after_or_equal:tanggal_dari',
        ]);

        $status = $validated['status'] ?? null;
        $tanggalDari = $validated['tanggal_dari'] ?? null;
        $tanggalSampai = $validated['tanggal_sampai'] ?? null;

        // Log aktivitas
        LogAktivitas::catat('export', 'Peminjaman', null, 'Export laporan peminjaman ke Excel');

        $filename = 'Laporan_Peminjaman_' . date('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new PeminjamanExport($status, $tanggalDari, $tanggalSampai), $filename);
    }

    // Export Pengembalian
    public function exportPengembalian(Request $request)
    {
        $validated = $request->validate([
            'tanggal_dari' => 'nullable|date',
            'tanggal_sampai' => 'nullable|date|after_or_equal:tanggal_dari',
        ]);

        $tanggalDari = $validated['tanggal_dari'] ?? null;
        $tanggalSampai = $validated['tanggal_sampai'] ?? null;

        // Log aktivitas
        LogAktivitas::catat('export', 'Pengembalian', null, 'Export laporan pengembalian ke Excel');

        $filename = 'Laporan_Pengembalian_' . date('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new PengembalianExport($tanggalDari, $tanggalSampai), $filename);
    }

    // Export Loker
    public function exportLoker(Request $request)
    {
        $validated = $request->validate([
            'status' => 'nullable|in:tersedia,dipinjam,rusak',
        ]);

        $status = $validated['status'] ?? null;

        // Log aktivitas
        LogAktivitas::catat('export', 'Loker', null, 'Export laporan loker ke Excel');

        $filename = 'Laporan_Loker_' . date('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new LokerExport($status), $filename);
    }
}
