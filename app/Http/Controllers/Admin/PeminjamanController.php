<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // Lihat semua peminjaman
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku', 'petugas']);

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
            'user_id'                => 'required|exists:users,id',
            'buku_id'                => 'required|exists:buku,id',
            'tanggal_pinjam'         => 'required|date',
            'tanggal_kembali_rencana'=> 'required|date|after:tanggal_pinjam',
            'keperluan'              => 'required|string|max:500',
            'status'                 => 'required|in:pending,disetujui,ditolak,selesai',
        ]);

        $buku = Buku::find($request->buku_id);

        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        // FIX: tampung $peminjaman di luar closure supaya bisa diakses setelah transaction
        $peminjaman = null;

        DB::transaction(function () use ($validated, &$peminjaman) {
            if (in_array($validated['status'], ['disetujui', 'ditolak'])) {
                $validated['approved_by'] = Auth::id();
            }

            $peminjaman = Peminjaman::create($validated);

            if ($validated['status'] === 'disetujui') {
                $buku = Buku::find($validated['buku_id']);

                if ($buku && $buku->stok > 0) {
                    $buku->decrement('stok');

                    if ($buku->stok == 0) {
                        $buku->update(['status' => 'dipinjam']);
                    }
                }
            }
        });

        // FIX: catat log setelah transaction selesai
        if ($peminjaman) {
            LogAktivitas::catat('create', 'Peminjaman', $peminjaman->id,
            'Menambahkan peminjaman buku: ' . $peminjaman->buku->judul);
}

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan');
    }

    // Setujui peminjaman
    public function setujui(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pending') {
            return redirect()->back()->with('error', 'Peminjaman tidak dalam status pending!');
        }

        if ($peminjaman->buku->stok <= 0) {
            return redirect()->back()->with('error', 'Stok buku habis!');
        }

        DB::transaction(function () use ($peminjaman) {
            $peminjaman->update([
                'status'      => 'disetujui',
                'approved_by' => Auth::id(),
            ]);

            $peminjaman->buku->decrement('stok');

            if ($peminjaman->buku->stok == 0) {
                $peminjaman->buku->update(['status' => 'dipinjam']);
            }
        });

        LogAktivitas::catat('approve', 'Peminjaman', $peminjaman->id,
            'Menyetujui peminjaman buku: ' . $peminjaman->buku->judul);

        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui!');
    }

    // Tolak peminjaman
    public function tolak(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pending') {
            return redirect()->back()->with('error', 'Peminjaman tidak dalam status pending!');
        }

        $peminjaman->update([
            'status'           => 'ditolak',
            'approved_by'      => Auth::id(),
            'catatan_petugas'  => $request->catatan_petugas,
        ]);

        LogAktivitas::catat('tolak', 'Peminjaman', $peminjaman->id,
            'Menolak peminjaman buku: ' . $peminjaman->buku->judul);

        return redirect()->back()->with('success', 'Peminjaman berhasil ditolak!');
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
        $rules = [
            'status'           => 'required|in:pending,disetujui,ditolak,selesai',
            'catatan_petugas'  => 'nullable|string',
        ];

        if ($request->has('user_id')) {
            $rules['user_id']                 = 'required|exists:users,id';
            $rules['buku_id']                 = 'required|exists:buku,id';
            $rules['tanggal_pinjam']          = 'required|date';
            $rules['tanggal_kembali_rencana'] = 'required|date|after_or_equal:tanggal_pinjam';
            $rules['keperluan']               = 'required|string|max:500';
        }

        $validated = $request->validate($rules);

        $oldStatus = $peminjaman->status;
        $newStatus = $validated['status'];

        DB::transaction(function () use ($validated, $peminjaman, $oldStatus, $newStatus) {
            if (in_array($newStatus, ['disetujui', 'ditolak']) && $peminjaman->approved_by === null) {
                $validated['approved_by'] = Auth::id();
            }

            $peminjaman->update($validated);

            if ($peminjaman->buku) {
                if ($oldStatus !== 'disetujui' && $newStatus === 'disetujui') {
                    if ($peminjaman->buku->stok <= 0) {
                        throw new \Exception('Stok buku habis!');
                    }

                    $peminjaman->buku->decrement('stok');

                    if ($peminjaman->buku->stok == 0) {
                        $peminjaman->buku->update(['status' => 'dipinjam']);
                    }
                }

                if ($oldStatus === 'disetujui' && in_array($newStatus, ['ditolak', 'selesai'])) {
                    $peminjaman->buku->increment('stok');
                    $peminjaman->buku->update(['status' => 'tersedia']);
                }
            }
        });

        LogAktivitas::catat('update', 'Peminjaman', $peminjaman->id,
            'Mengupdate peminjaman buku: ' . $peminjaman->buku->judul . ' (status: ' . $oldStatus . ' → ' . $newStatus . ')');

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil diupdate');
    }

    // Hapus peminjaman
    public function destroy(Peminjaman $peminjaman)
    {
        if ($peminjaman->pengembalian()->exists()) {
            return redirect()->route('admin.peminjaman.index')
                ->with('error', 'Tidak dapat menghapus peminjaman yang sudah memiliki data pengembalian');
        }

        $judulBuku = $peminjaman->buku->judul ?? '-';
        $peminjamanId = $peminjaman->id;

        DB::transaction(function () use ($peminjaman) {
            if ($peminjaman->status === 'disetujui' && $peminjaman->buku) {
                $peminjaman->buku->increment('stok');
            }
            $peminjaman->delete();
        });

        LogAktivitas::catat('delete', 'Peminjaman', $peminjamanId,
            'Menghapus peminjaman buku: ' . $judulBuku);

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dihapus');
    }
}