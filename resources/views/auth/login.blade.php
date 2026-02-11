@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-magenta-500 to-pink-600">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md">
        <div class="text-center mb-8">
            <div class="text-6xl mb-4">🔐</div>
            <h2 class="text-3xl font-bold text-gray-800">Peminjaman Loker</h2>
            <p class="text-gray-600 mt-2">Silakan login untuk melanjutkan</p>
        </div>

        @if (session('success'))
            <div data-alert class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div data-alert class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <span class="text-red-500">*</span> Username
                </label>
                <input type="text" name="username" value="{{ old('username') }}" 
                       class="w-full px-4 py-3 border-2 rounded-lg focus:outline-none focus:border-blue-500 transition" 
                       placeholder="Masukkan username"
                       required autofocus>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <span class="text-red-500">*</span> Password
                </label>
                <input type="password" name="password" 
                       class="w-full px-4 py-3 border-2 rounded-lg focus:outline-none focus:border-blue-500 transition" 
                       placeholder="Masukkan password"
                       required>
            </div>

            <button type="submit" 
                    class="w-full bg-gradient-to-r from-rose-400 to-violet-300 text-black hover:from-rose-600 hover:to-purple-700 text-white font-bold py-3 px-4 rounded-lg transition transform hover:scale-105">
                Login
            </button>
        </form>

    </div>
</div>
@endsection