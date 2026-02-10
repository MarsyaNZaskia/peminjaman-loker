<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loker;
use Illuminate\Http\Request;
use App\Models\LogAktivitas;

class LokerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Loker::query();
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status !== '') {
        $query->where('status', $request->status);
        }
        $lokers = $query->latest()->get();
        return view('admin.lokers.index', compact('lokers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.lokers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'nomor_loker'=>'required|string|unique:lokers|max:225',
            'lokasi'=>'required|string|max:225',
            'ukuran'=>'required|in:kecil,sedang,besar',
            'status'=>'required|in:tersedia,dipinjam,rusak',
            'keterangan'=>'nullable|string',
        ]);

        $loker = Loker::create($validated);

        LogAktivitas::catat('create', 'Loker', $loker->id, "Menambahkan loker {$loker->nomor_loker}");

        return redirect()->route('admin.lokers.index')
        ->with('success', 'Loker berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Loker $loker)
    {
        $loker->load(['peminjaman.user', 'peminjaman.petugas']);
        return view('admin.loker.show', compact('loker'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loker $loker)
    {
        return view('admin.lokers.edit', compact('loker'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loker $loker)
    {
         $validated = $request->validate([
            'nomor_loker' => 'required|string|max:255|unique:lokers,nomor_loker,' . $loker->id,
            'lokasi' => 'required|string|max:255',
            'ukuran' => 'required|in:kecil,sedang,besar',
            'status' => 'required|in:tersedia,dipinjam,rusak',
            'keterangan' => 'nullable|string',
        ]);

        $loker->update($validated);

        LogAktivitas::catat('update', 'Loker', $loker->id, "Mengupdate loker {$loker->nomor_loker}");

        return redirect()->route('admin.lokers.index')
            ->with('success', 'Loker berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loker $loker)
    {
        // Cek apakah loker sedang dipinjam
        if ($loker->status === 'dipinjam') {
            return redirect()->route('admin.lokers.index')
                ->with('error', 'Tidak dapat menghapus loker yang sedang dipinjam');
        }

        $nomorLoker = $loker->nomor_loker;
        $loker->delete();

        LogAktivitas::catat('delete', 'Loker', null, "Menghapus loker {$nomorLoker}");

        return redirect()->route('admin.lokers.index')
            ->with('success', 'Loker berhasil dihapus');
    }
}
