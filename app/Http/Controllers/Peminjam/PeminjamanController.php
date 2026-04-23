<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar buku yang tersedia untuk dipinjam
     */
    public function index(Request $request)
    {
        $bukus = Buku::where('stok', '>', 0)
            ->when($request->search, function($query, $search) {
                $query->where('judul', 'like', "%{$search}%")
                      ->orWhere('pengarang', 'like', "%{$search}%")
                      ->orWhere('kode_buku', 'like', "%{$search}%");
            })
            ->when($request->kategori, function($query, $kategori) {
                $query->where('kategori_id', $kategori);
            })
            ->paginate(9);

        $kategoris = Kategori::all();

        return view('peminjam.peminjaman.index', compact('bukus', 'kategoris'));
    }

    /**
     * Menampilkan detail buku sebelum meminjam
     * (Ini function baru yang tadi tidak ada)
     */
    public function show(Buku $buku)
    {
        return view('peminjam.peminjaman.show', compact('buku'));
    }

    /**
     * Menampilkan form pengajuan peminjaman
     */
    public function create(Buku $buku)
    {
        // Cek apakah buku masih punya stok (bukan status)
        if ($buku->stok < 1) {
            return redirect()->route('peminjam.peminjaman.index')
                ->with('error', 'Maaf, stok buku ini sedang habis.');
        }

        return view('peminjam.peminjaman.create', compact('buku'));
    }

    /**
     * Memproses penyimpanan data peminjaman baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'buku_id' => 'required|exists:buku,id', // Pastikan nama tabel benar (buku)
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali_rencana' => 'required|date|after_or_equal:tanggal_pinjam',
            'keperluan' => 'nullable|string|max:500', // Saya buat nullable karena untuk buku biasanya opsional
        ]);

        // Cek lagi ketersediaan stok buku di saat submit (race condition prevention)
        $buku = Buku::find($validated['buku_id']);
        if ($buku->stok < 1) {
            return redirect()->route('peminjam.peminjaman.index')
                ->with('error', 'Maaf, stok buku habis saat Anda mengajukan.');
        }

        // Cek apakah user punya peminjaman aktif (Pending atau Disetujui)
        // Logika: 1 User hanya bisa pinjam 1 buku dalam satu waktu (opsional, sesuaikan kebutuhan)
        $hasActivePeminjaman = Peminjaman::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'disetujui'])
            ->exists();

        if ($hasActivePeminjaman) {
            return redirect()->route('peminjam.peminjaman.index')
                ->with('error', 'Anda masih memiliki peminjaman yang sedang diproses atau aktif.');
        }

        // Simpan data peminjaman
        Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $validated['buku_id'],
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'tanggal_kembali_rencana' => $validated['tanggal_kembali_rencana'],
            'keperluan' => $validated['keperluan'] ?? '-', // Default '-' jika kosong
            'status' => 'pending',
        ]);

        return redirect()->route('peminjam.peminjaman.index')
            ->with('success', 'Peminjaman berhasil diajukan. Silakan tunggu persetujuan petugas.');
    }

    /**
     * Membatalkan peminjaman yang masih berstatus pending
     */
    public function destroy(Peminjaman $peminjaman)
    {
        // Pastikan peminjaman milik user yang login
        if ($peminjaman->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengakses peminjaman ini.');
        }

        // Hanya bisa batalkan yang masih pending
        if ($peminjaman->status !== 'pending') {
            return redirect()->route('peminjam.peminjaman.index')
                ->with('error', 'Hanya pengajuan yang statusnya Pending yang bisa dibatalkan.');
        }

        $peminjaman->delete();

        return redirect()->route('peminjam.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil dibatalkan.');
    }
}