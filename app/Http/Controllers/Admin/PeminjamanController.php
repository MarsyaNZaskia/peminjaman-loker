<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Loker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        
        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    // Detail peminjaman
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'loker', 'petugas', 'pengembalian']);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    // Form tambah peminjaman
    public function create()
    {
        $users = User::where('role', 'peminjam')->get();
        $lokers = Loker::where('status', 'tersedia')->get();
        return view('admin.peminjaman.create', compact('users', 'lokers'));
    }

    // Simpan peminjaman
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'loker_id' => 'required|exists:lokers,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'keperluan' => 'required|string|max:500',
            'status' => 'required|in:pending,disetujui,ditolak,selesai',
        ]);

        // Jika status disetujui, update status loker
        DB::transaction(function () use ($validated) {
            $peminjaman = Peminjaman::create($validated);
            
            if ($validated['status'] === 'disetujui') {
                Loker::find($validated['loker_id'])->update(['status' => 'dipinjam']);
            }
        });

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan');
    }

    // Form edit peminjaman
    public function edit(Peminjaman $peminjaman)
    {
        $users = User::where('role', 'peminjam')->get();
        $lokers = Loker::all();
        return view('admin.peminjaman.edit', compact('peminjaman', 'users', 'lokers'));
    }

    // Update peminjaman
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'loker_id' => 'required|exists:lokers,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'keperluan' => 'required|string|max:500',
            'status' => 'required|in:pending,disetujui,ditolak,selesai',
            'catatan_petugas' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $peminjaman) {
            $oldStatus = $peminjaman->status;
            $newStatus = $validated['status'];
            
            // Update peminjaman
            $peminjaman->update($validated);
            
            // Update status loker berdasarkan perubahan status
            if ($oldStatus !== $newStatus) {
                if ($newStatus === 'disetujui') {
                    $peminjaman->loker->update(['status' => 'dipinjam']);
                } elseif (in_array($newStatus, ['ditolak', 'selesai'])) {
                    $peminjaman->loker->update(['status' => 'tersedia']);
                }
            }
        });

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil diupdate');
    }

    // Hapus peminjaman
    public function destroy(Peminjaman $peminjaman)
    {
        // Jika ada pengembalian, tidak bisa dihapus
        if ($peminjaman->pengembalian()->exists()) {
            return redirect()->route('admin.peminjaman.index')
                ->with('error', 'Tidak dapat menghapus peminjaman yang sudah memiliki data pengembalian');
        }

        DB::transaction(function () use ($peminjaman) {
            // Jika status disetujui, kembalikan status loker
            if ($peminjaman->status === 'disetujui') {
                $peminjaman->loker->update(['status' => 'tersedia']);
            }
            
            $peminjaman->delete();
        });

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dihapus');
    }
}
