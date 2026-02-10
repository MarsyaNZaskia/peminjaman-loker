<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Loker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pengembalian;
use App\Models\LogAktivitas;


class PeminjamanController extends Controller
{
    // Lihat semua peminjaman
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'loker', 'petugas']);
    
    // Filter berdasarkan status
    if ($request->has('status') && $request->status !== '') {
        $query->where('status', $request->status);
    }
    
    $peminjaman = $query->latest()->get();
    
    return view('petugas.peminjaman.index', compact('peminjaman'));
    }

    // Detail peminjaman
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'loker', 'petugas']);
        return view('petugas.peminjaman.show', compact('peminjaman'));
    }

    // Approve peminjaman
    public function approve(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pending') {
            return redirect()->route('petugas.peminjaman.index')
                ->with('error', 'Peminjaman sudah diproses');
        }

        DB::transaction(function () use ($peminjaman) {
            // Update status peminjaman
            $peminjaman->update([
                'status' => 'disetujui',
                'approved_by' => Auth::id(),
            ]);

            // Update status loker
            $peminjaman->loker->update([
                'status' => 'dipinjam',
            ]);
        });

        LogAktivitas::catat(
            'approve', 
            'Peminjaman', 
            $peminjaman->id, 
            "Menyetujui peminjaman loker {$peminjaman->loker->nomor_loker} oleh {$peminjaman->user->name}"
        );

        return redirect()->route('petugas.peminjaman.index')
            ->with('success', 'Peminjaman berhasil disetujui');
    }

    // Reject peminjaman
    public function reject(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pending') {
            return redirect()->route('petugas.peminjaman.index')
                ->with('error', 'Peminjaman sudah diproses');
        }

        $validated = $request->validate([
            'catatan_petugas' => 'required|string|max:500',
        ]);

        $peminjaman->update([
            'status' => 'ditolak',
            'approved_by' => Auth::id(),
            'catatan_petugas' => $validated['catatan_petugas'],
        ]);

        LogAktivitas::catat(
            'reject', 
            'Peminjaman', 
            $peminjaman->id, 
            "Menolak peminjaman loker {$peminjaman->loker->nomor_loker} oleh {$peminjaman->user->name}"
        );

        return redirect()->route('petugas.peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditolak');
    }

    // Catat pengembalian
    public function return(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'disetujui') {
            return redirect()->route('petugas.peminjaman.index')
                ->with('error', 'Peminjaman tidak dalam status aktif');
        }

        return redirect()->route('petugas.pengembalian.create', $peminjaman);

        
    }
}
