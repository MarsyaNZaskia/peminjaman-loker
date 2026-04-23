<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->user()->id,
            'username' => 'required|string|max:255|unique:users,username,' . $request->user()->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'class' => 'nullable|string|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = $request->user();

        if (!$user->is_active) {
            $user->is_active = true;
            $user->save();
            }

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && \Storage::disk('public')->exists($user->photo)) {
                \Storage::disk('public')->delete($user->photo);
            }

            // Store new photo
            $path = $request->file('photo')->store('profile-photos', 'public');
            $validated['photo'] = $path;
        }

        $user->update($validated);

        if (!$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
            }

        return redirect()->route('profile.index')
            ->with('success', 'Profile berhasil diupdate!');
    }

    public function updatePhoto(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = $request->user();

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->update(['photo' => $path]);
        }

        return redirect()->route('profile.index')
            ->with('success', 'Foto profile berhasil diupdate!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ], [
            'current_password.required' => 'Password lama harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak sama',
        ]);

        // Cek password lama
        if (!Hash::check($validated['current_password'], Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
        }

        // Update password baru
        Auth::user()->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Password berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteFoto()
    {
        $user = Auth::user();

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->update(['photo' => null]);

        return redirect()->route('profile.index')
            ->with('success', 'Foto profile berhasil dihapus!');
    }
}