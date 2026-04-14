<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $riwayat= Peminjaman::with(['loker', 'petugas', 'pengembalian'])
        ->where('user_id', Auth::id())
        ->whereIn('status', ['pending', 'disetujui', 'ditolak', 'selesai'])
        ->latest()
        ->paginate(10);

        return view('peminjam.riwayat.index', compact('riwayat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== Auth::id()) {
            abort(403);
        }

        $peminjaman->load(['loker', 'petugas', 'pengembalian']);

        return view('peminjam.riwayat.show', compact ('peminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
