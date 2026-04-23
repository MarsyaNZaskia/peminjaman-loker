@extends('layouts.app')

@section('title', 'Login')

@section('content')
<!-- Pakai h-screen dan overflow-hidden agar tidak ada scroll -->
<div class="h-screen w-full flex items-center justify-center bg-cover bg-center bg-fixed bg-no-repeat p-4 overflow-hidden" 
     style="background-image: url('{{ asset('img/header.png') }}');">
    
    <!-- Ukuran card diperketat dengan max-h agar tidak melebihi layar -->
    <div class="bg-white/20 backdrop-blur-lg border border-white/30 p-6 md:p-8 rounded-3xl shadow-2xl w-full max-w-md max-h-[95vh] overflow-y-auto">
        
        <div class="text-center mb-6"> <!-- Margin dikurangi -->
            <div class="text-4xl mb-2">📚</div> <!-- Ukuran icon dikecilkan -->
            <h2 class="text-2xl font-extrabold text-white tracking-tight">Peminjaman Buku</h2>
            <p class="text-indigo-100 text-sm font-medium">Selamat Datang! Silakan Login</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-500/80 backdrop-blur-sm border border-red-400 text-white px-4 py-2 rounded-xl mb-4 text-xs">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4"> <!-- Jarak antar input dipersempit -->
            @csrf

            <div>
                <label class="block text-white text-sm font-medium mb-1.5 ml-1">Username atau Email</label>
                <input type="text" name="username" value="{{ old('username') }}" 
                       class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-xl text-white placeholder-indigo-200 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 focus:bg-white/20 transition duration-300" 
                       placeholder="Masukkan akun anda"
                       required autofocus>
            </div>

            <div class="relative"><label class="block text-white text-sm font-medium mb-1.5 ml-1">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" 
                    class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-xl text-white placeholder-indigo-200 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 focus:bg-white/20 transition duration-300 pr-12" 
                    placeholder="••••••••" required>
                    
                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-white/50 hover:text-white transition">
                        <svg id="eyeIcon" xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" 
                    class="w-full bg-linear-to-r from-purple-500 to-blue-400 hover:from-purple-600 hover:to-blue-500 text-white font-bold py-3 rounded-xl shadow-lg transition transform hover:scale-[1.01] active:scale-95 duration-200 text-sm">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-6 text-center">
            <div class="relative flex items-center justify-center">
                <div class="grow border-t border-white/20"></div>
                <span class="mx-3 text-white/60 text-[10px] uppercase tracking-widest">Atau</span>
                <div class="grow border-t border-white/20"></div>
            </div>
            
            <div class="flex justify-center mt-4">
                <a href="{{ route('google.redirect') }}" 
                   class="flex items-center justify-center w-full py-2.5 bg-white hover:bg-gray-100 rounded-xl transition-all duration-300 shadow-md group">
                    <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.83l2.66-2.07z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    <span class="text-gray-700 text-sm font-semibold group-hover:text-blue-600 transition">Google Account</span>
                </a>
            </div>
        </div>

    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            // Ganti ikon ke mata coret (opsional)
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />';
        } else {
            passwordInput.type = 'password';
            // Balikin ke ikon mata biasa
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />';
        }
    }
</script>

@endsection
