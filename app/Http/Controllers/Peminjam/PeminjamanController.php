<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Loker;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // Lihat loker yang tersedia
    public function index()
    {
        $lokers = Loker::where('status', 'tersedia')->get();
        $myPeminjaman = Peminjaman::where('user_id', Auth::id())
            ->with(['loker', 'petugas'])
            ->latest()
            ->get();
        
        return view('peminjam.peminjaman.index', compact('lokers', 'myPeminjaman'));
    }

    // Form ajukan peminjaman
    public function create(Loker $loker)
    {
        // Cek apakah loker tersedia
        if ($loker->status !== 'tersedia') {
            return redirect()->route('peminjam.peminjaman.index')
                ->with('error', 'Loker tidak tersedia');
        }

        return view('peminjam.peminjaman.create', compact('loker'));
    }

    // Proses ajukan peminjaman
    public function store(Request $request)
    {
        $validated = $request->validate([
            'loker_id' => 'required|exists:lokers,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'keperluan' => 'required|string|max:500',
        ]);

        // Cek apakah loker masih tersedia
        $loker = Loker::find($validated['loker_id']);
        if ($loker->status !== 'tersedia') {
            return redirect()->route('peminjam.peminjaman.index')
                ->with('error', 'Loker sudah tidak tersedia');
        }

        // Cek apakah user sudah punya peminjaman aktif
        $hasActivePeminjaman = Peminjaman::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'disetujui'])
            ->exists();

        if ($hasActivePeminjaman) {
            return redirect()->route('peminjam.peminjaman.index')
                ->with('error', 'Anda masih memiliki peminjaman aktif');
        }

        // Buat peminjaman baru
        Peminjaman::create([
            'user_id' => Auth::id(),
            'loker_id' => $validated['loker_id'],
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'tanggal_kembali_rencana' => $validated['tanggal_kembali_rencana'],
            'keperluan' => $validated['keperluan'],
            'status' => 'pending',
        ]);

        return redirect()->route('peminjam.peminjaman.index')
            ->with('success', 'Peminjaman berhasil diajukan. Tunggu persetujuan petugas.');
    }

    // Batalkan peminjaman (hanya yang pending)
    public function destroy(Peminjaman $peminjaman)
    {
        // Pastikan peminjaman milik user yang login
        if ($peminjaman->user_id !== Auth::id()) {
            abort(403);
        }

        // Hanya bisa batalkan yang masih pending
        if ($peminjaman->status !== 'pending') {
            return redirect()->route('peminjam.peminjaman.index')
                ->with('error', 'Tidak dapat membatalkan peminjaman ini');
        }

        $peminjaman->delete();

        return redirect()->route('peminjam.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dibatalkan');
    }
}