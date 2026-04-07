<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|unique:users|max:255|alpha_dash',
        'password' => [
            'required',
            'string',
            'min:8',              // Minimal 8 karakter
            'confirmed',          // Harus sama dengan password_confirmation
            Password::min(8)
                ->letters()       // Harus ada huruf
                ->mixedCase()     // Harus ada huruf besar DAN kecil
                ->numbers()       // Harus ada angka
                ->symbols()       // Harus ada simbol (!@#$%^&*)
        ],
        'role' => 'required|in:petugas,peminjam',
        'kategori_id' => 'nullable|exists:kategoris,id',
    ], [
        // Custom error messages dalam bahasa Indonesia
        'password.min' => 'Password minimal harus 8 karakter',
        'password.confirmed' => 'Konfirmasi password tidak sama',
        'password.letters' => 'Password harus mengandung huruf',
        'password.mixed_case' => 'Password harus mengandung huruf besar dan kecil',
        'password.numbers' => 'Password harus mengandung angka',
        'password.symbols' => 'Password harus mengandung simbol (!@#$%^&*)',
    ]);

    $validated['password'] = Hash::make($validated['password']);

    User::create($validated);

    return redirect()->route('admin.users.index')
        ->with('success', 'User berhasil ditambahkan');
}

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|alpha_dash|unique:users,username,' . $user->id,
        'password' => [
            'nullable',           // Password opsional saat update
            'string',
            'min:8',
            'confirmed',
            Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
        ],
        'role' => 'required|in:petugas,peminjam',
        'kategori_id' => 'nullable|exists:kategoris,id',
    ], [
        'password.min' => 'Password minimal harus 8 karakter',
        'password.confirmed' => 'Konfirmasi password tidak sama',
        'password.letters' => 'Password harus mengandung huruf',
        'password.mixed_case' => 'Password harus mengandung huruf besar dan kecil',
        'password.numbers' => 'Password harus mengandung angka',
        'password.symbols' => 'Password harus mengandung simbol (!@#$%^&*)',
    ]);

    if (!empty($validated['password'])) {
        $validated['password'] = Hash::make($validated['password']);
    } else {
        unset($validated['password']);
    }

    $user->update($validated);

    return redirect()->route('admin.users.index')
        ->with('success', 'User berhasil diupdate');
}

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus');
    }

}
