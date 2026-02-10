<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user')->latest();
        
        // Filter berdasarkan aksi
        if ($request->has('aksi') && $request->aksi !== '') {
            $query->where('aksi', $request->aksi);
        }
        
        // Filter berdasarkan user
        if ($request->has('user_id') && $request->user_id !== '') {
            $query->where('user_id', $request->user_id);
        }
        
        // Filter berdasarkan tanggal
        if ($request->has('tanggal') && $request->tanggal !== '') {
            $query->whereDate('created_at', $request->tanggal);
        }
        
        $logs = $query->paginate(50);
        $users = \App\Models\User::all();
        
        return view('admin.log-aktivitas.index', compact('logs', 'users'));
    }

    public function show(LogAktivitas $logAktivita)
    {
        $logAktivita->load('user');
        return view('admin.log-aktivitas.show', compact('logAktivita'));
    }

    public function clear()
    {
        LogAktivitas::truncate();
        
        LogAktivitas::catat('clear', 'LogAktivitas', null, 'Menghapus semua log aktivitas');
        
        return redirect()->route('admin.log-aktivitas.index')
            ->with('success', 'Semua log aktivitas berhasil dihapus');
    }
}
