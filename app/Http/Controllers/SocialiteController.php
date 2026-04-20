<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class SocialiteController extends Controller
{
    public function redirect()
    {
        if (auth('web')->check()) {
            session(['google_connect_user_id' => auth('web')->id()]);
        }

        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $userFromGoogle = Socialite::driver('google')->user();
        $connectUserId = session()->pull('google_connect_user_id');

        // === FLOW: Connect (hubungkan akun) ===
        if ($connectUserId) {
            $currentUser = User::find($connectUserId);

            if (!$currentUser) {
                return redirect('/login')->with('error', 'Session expired, silakan login ulang.');
            }

            $existing = User::where('google_id', $userFromGoogle->getId())
                            ->where('id', '!=', $currentUser->id)
                            ->first();

            if ($existing) {
                return redirect()->route('profile.index')
                    ->with('error', 'Akun Google ini sudah terhubung ke akun lain.');
            }

            $currentUser->update(['google_id' => $userFromGoogle->getId()]);
            Auth::login($currentUser);

            return redirect()->route('profile.index')
                ->with('success', 'Akun Google berhasil dihubungkan!');
        }

        // === FLOW: Login dengan Google ===
        $userFromDB = User::where('google_id', $userFromGoogle->getId())->first();

        if ($userFromDB) {
            Auth::login($userFromDB);
        } else {
            return redirect('/login')
                ->with('error', 'Akun Google belum terhubung. Silakan login manual dulu lalu hubungkan di halaman Profile.');
        }

        session()->regenerate();

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isPetugas()) {
            return redirect()->route('petugas.dashboard');
        } else {
            return redirect()->route('peminjam.dashboard');
        }
    }

    public function logout(Request $request)
    {
        auth('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}