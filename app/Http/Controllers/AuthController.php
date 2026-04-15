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
            'username.required' => 'Username atau Email harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        // Try to authenticate with username first, then email
        $usernameAttempt = Auth::attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password']
        ]);

        if (!$usernameAttempt) {
            // Try email instead
            $usernameAttempt = Auth::attempt([
                'email' => $credentials['username'],
                'password' => $credentials['password']
            ]);
        }

        if ($usernameAttempt) {
            $request->session()->regenerate();
            LogAktivitas::catat('login', 'User', Auth::id(), 'User login ke sistem');

            // Redirect berdasarkan role
            $user = Auth::user();
            
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->isPetugas()) {
                return redirect()->intended(route('petugas.dashboard'));
            } else {
                return redirect()->intended(route('peminjam.dashboard'));
            }
        }

        return back()->withErrors([
            'username' => 'Username/Email atau password salah. Silakan coba lagi.',
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