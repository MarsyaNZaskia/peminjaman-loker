<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AktivasiController extends Controller
{
    public function index()
    {
        return view('auth.aktivasi');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8|confirmed',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'address' => 'required',
            'class' => 'required',
        ]);

        $user = Auth::user();

        $user->update([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'class' => $request->class,
            'is_active' => true,
        ]);

        return redirect()->route('dashboard')->with('success', 'Akun berhasil diaktivasi!');
    }
}
