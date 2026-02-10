<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogAktivitas;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ], [
        'username.required' => 'Username harus diisi',
        'password.required' => 'Password harus diisi',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        LogAktivitas::catat('login', 'User', Auth::id(), 'User login ke sistem');

        // Redirect berdasarkan role
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang, ' . $user->name . '!');
        } elseif ($user->isPetugas()) {
            return redirect()->intended(route('petugas.dashboard'))
                ->with('success', 'Selamat datang, ' . $user->name . '!');
        } else {
            return redirect()->intended(route('peminjam.dashboard'))
                ->with('success', 'Selamat datang, ' . $user->name . '!');
        }
    }

    return back()->withErrors([
        'username' => 'Username atau password salah. Silakan coba lagi.',
    ])->onlyInput('username');
}

public function logout(Request $request)
{
    LogAktivitas::catat('logout', 'User', Auth::id(), 'User logout dari sistem');
    
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('success', 'Anda telah logout');
}
}