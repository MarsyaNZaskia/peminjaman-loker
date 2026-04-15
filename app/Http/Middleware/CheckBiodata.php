<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBiodata
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isPeminjam()) {
            $user = Auth::user();
            
            // Check if biodata is complete
            if (empty($user->email) || empty($user->phone) || empty($user->address) || empty($user->class)) {
                return redirect()->route('profile.index')
                    ->with('warning', 'Silakan lengkapi biodata terlebih dahulu sebelum melakukan peminjaman.');
            }
        }

        return $next($request);
    }
}
