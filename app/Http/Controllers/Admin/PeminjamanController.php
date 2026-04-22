<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // Lihat semua peminjaman
    public function index(Request $request)
{
    $query = Peminjaman::with(['user', 'buku', 'petugas']); // FIX

    if ($request->has('status') && $request->status !== '') {
        $query->where('status', $request->status);
    }

    $peminjaman = $query->latest()->get();

    return view('admin.peminjaman.index', compact('peminjaman'));
}

    // Detail peminjaman
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'buku', 'petugas', 'pengembalian']);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    // Form tambah peminjaman
    public function create()
    {
        $users = User::where('role', 'peminjam')->get();
        $bukus = Buku::where('status', 'tersedia')->get();
        return view('admin.peminjaman.create', compact('users', 'bukus'));
    }

    // Simpan peminjaman
    public function store(Request $request)
    {
        $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'buku_id' => 'required|exists:bukus,id', // FIX
        'tanggal_pinjam' => 'required|date',
        'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
        'keperluan' => 'required|string|max:500',
        'status' => 'required|in:pending,disetujui,ditolak,selesai',
    ]);

    $buku = Buku::find($request->buku_id);
    
    if ($buku->stok <= 0) {
        return back()->with('error', 'Stok buku habis!');
        }

        DB::transaction(function () use ($validated) {

    if (in_array($validated['status'], ['disetujui', 'ditolak'])) {
        $validated['approved_by'] = Auth::id();
    }

    $peminjaman = Peminjaman::create($validated);

    if ($validated['status'] === 'disetujui') {
        $buku = Buku::find($validated['buku_id']);

        if ($buku && $buku->stok > 0) {
            $buku->decrement('stok');

            // optional: ubah status kalau habis
            if ($buku->stok == 0) {
                $buku->update(['status' => 'dipinjam']);
            }
        }
    }
});

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan');
    }

    // Form edit peminjaman
    public function edit(Peminjaman $peminjaman)
    {
        $users = User::where('role', 'peminjam')->get();
        $bukus = Buku::all();
        return view('admin.peminjaman.edit', compact('peminjaman', 'users', 'bukus'));
    }

    // Update peminjaman
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:buku,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'keperluan' => 'required|string|max:500',
            'status' => 'required|in:pending,disetujui,ditolak,selesai',
            'catatan_petugas' => 'nullable|string',
        ]);

        $oldStatus = $peminjaman->status;
$newStatus = $validated['status'];

DB::transaction(function () use ($validated, $peminjaman, $oldStatus, $newStatus) {

    if (in_array($newStatus, ['disetujui', 'ditolak']) && $peminjaman->approved_by === null) {
        $validated['approved_by'] = Auth::id();
    }

    $peminjaman->update($validated);

    if ($peminjaman->buku) {

        // dari selain disetujui → disetujui
        if ($oldStatus !== 'disetujui' && $newStatus === 'disetujui') {
            if ($peminjaman->buku->stok <= 0) {
                throw new \Exception('Stok buku habis!');
            }

            $peminjaman->buku->decrement('stok');
        }

        // dari disetujui → selain disetujui
        if ($oldStatus === 'disetujui' && in_array($newStatus, ['ditolak', 'selesai'])) {
            $peminjaman->buku->increment('stok');
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
            if ($peminjaman->status === 'disetujui' && $peminjaman->buku) {
                $peminjaman->buku->increment('stok');
                }
                $peminjaman->delete();
                });

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dihapus');
    }
}
