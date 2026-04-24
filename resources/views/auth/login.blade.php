@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="h-screen w-full flex items-center justify-center bg-cover bg-center bg-fixed bg-no-repeat p-4 overflow-hidden" 
     style="background-image: url('{{ asset('img/header.png') }}');">

    <!-- CARD -->
    <div class="bg-white/10 backdrop-blur-xl border border-white/20 p-6 md:p-8 rounded-3xl shadow-2xl w-full max-w-md max-h-[95vh] overflow-y-auto">

        <!-- HEADER -->
        <div class="text-center mb-6">
            <div class="text-4xl mb-2">📚</div>
            <h2 class="text-2xl font-extrabold text-white tracking-tight">Peminjaman Buku</h2>
            <p class="text-indigo-100 text-sm">Silakan login untuk melanjutkan</p>
        </div>

        <!-- ERROR -->
        @if ($errors->any())
            <div class="bg-red-500/80 border border-red-400 text-white px-4 py-2 rounded-xl mb-4 text-sm animate-pulse">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- USERNAME -->
            <div>
                <label class="block text-white text-sm mb-1 ml-1">Username / Email</label>
                <input type="text" name="username" value="{{ old('username') }}" 
                       class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-xl text-white placeholder-indigo-200 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 focus:bg-white/20 transition"
                       placeholder="Masukkan akun..."
                       required autofocus>
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block text-white text-sm mb-1 ml-1">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" 
                           class="w-full px-4 py-2.5 pr-12 bg-white/10 border border-white/20 rounded-xl text-white placeholder-indigo-200 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 focus:bg-white/20 transition"
                           placeholder="••••••••" required>

                    <button type="button" onclick="togglePassword()" 
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-white/60 hover:text-white">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" 
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                             class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- BUTTON -->
            <button type="submit"
                    class="w-full bg-gradient-to-r from-purple-500 to-blue-400 hover:from-purple-600 hover:to-blue-500 text-white font-bold py-3 rounded-xl shadow-lg transition transform hover:scale-[1.02] active:scale-95">
                Masuk
            </button>
        </form>

        <!-- DIVIDER -->
        <div class="mt-6 flex items-center">
            <div class="flex-grow border-t border-white/20"></div>
            <span class="mx-3 text-white/60 text-xs">ATAU</span>
            <div class="flex-grow border-t border-white/20"></div>
        </div>

        <!-- GOOGLE LOGIN -->
        <div class="mt-4">
            <a href="{{ route('google.redirect') }}" 
               class="flex items-center justify-center w-full py-2.5 bg-white hover:bg-gray-100 rounded-xl transition shadow-md group">

                <!-- SVG GOOGLE FIX -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="w-5 h-5 mr-3">
                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.73 1.22 9.24 3.6l6.9-6.9C35.64 2.3 30.2 0 24 0 14.6 0 6.4 5.4 2.5 13.3l8 6.2C12.3 13.2 17.7 9.5 24 9.5z"/>
                    <path fill="#4285F4" d="M46.1 24.5c0-1.6-.1-3.1-.4-4.5H24v9h12.4c-.5 2.7-2 5-4.2 6.5l6.5 5c3.8-3.5 7.4-9 7.4-16z"/>
                    <path fill="#FBBC05" d="M10.5 28.7c-.5-1.3-.8-2.7-.8-4.2s.3-2.9.8-4.2l-8-6.2C.9 17.2 0 20.5 0 24s.9 6.8 2.5 9.9l8-6.2z"/>
                    <path fill="#34A853" d="M24 48c6.5 0 12-2.1 16-5.8l-6.5-5c-2 1.4-4.5 2.2-9.5 2.2-6.3 0-11.7-3.7-13.5-9l-8 6.2C6.4 42.6 14.6 48 24 48z"/>
                </svg>

                <span class="text-gray-700 text-sm font-semibold group-hover:text-blue-600">
                    Login dengan Google
                </span>
            </a>
        </div>

    </div>
</div>

<!-- SCRIPT -->
<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');

    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M9.88 9.88a3 3 0 104.24 4.24"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round"
            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
            <path stroke-linecap="round" stroke-linejoin="round"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0Z"/>`;
    }
}
</script>

@endsection