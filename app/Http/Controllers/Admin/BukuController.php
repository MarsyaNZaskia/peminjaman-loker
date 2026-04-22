<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use App\Models\LogAktivitas;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $bukus = $query->latest()->get();

        return view('admin.buku.index', compact('bukus'));
    }

    public function create()
    {
        return view('admin.buku.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_buku' => 'required|string|unique:buku|max:255',
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'kategori_buku' => 'required|string|max:255',
            'jumlah_halaman' => 'required|integer|min:1',
            'stok' => 'required|integer|min:0',
            'status' => 'nullable|in:tersedia,dipinjam,rusak',
            'foto_cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        // Upload foto
        if ($request->hasFile('foto_cover')) {
            $validated['foto_cover'] = $request->file('foto_cover')->store('covers', 'public');
        }

        $buku = Buku::create($validated);

        LogAktivitas::catat('create', 'Buku', $buku->id, "Menambahkan buku {$buku->judul}");

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    public function show(Buku $buku)
    {
        return view('admin.buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        return view('admin.buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'kode_buku' => 'required|string|max:255|unique:buku,kode_buku,' . $buku->id,
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'kategori_buku' => 'required|string|max:255',
            'jumlah_halaman' => 'required|integer|min:1',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,dipinjam,rusak',
            'foto_cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('foto_cover')) {
            $validated['foto_cover'] = $request->file('foto_cover')->store('covers', 'public');
        }

        $buku->update($validated);

        LogAktivitas::catat('update', 'Buku', $buku->id, "Update buku {$buku->judul}");

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil diupdate');
    }

    public function destroy(Buku $buku)
    {
        $judul = $buku->judul;
        $buku->delete();

        LogAktivitas::catat('delete', 'Buku', null, "Hapus buku {$judul}");

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil dihapus');
    }
}