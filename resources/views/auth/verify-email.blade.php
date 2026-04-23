@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md">
        
        <!-- Card -->
        <div class="bg-white dark:bg-slate-800/50 backdrop-blur-sm 
                    border border-gray-200 dark:border-slate-700/50
                    rounded-2xl shadow-xl dark:shadow-slate-900/50 p-8 text-center">

            <!-- Icon -->
            <div class="w-16 h-16 mx-auto mb-4 rounded-full 
                        bg-gradient-to-br from-indigo-500 to-purple-500 
                        flex items-center justify-center text-white text-2xl shadow-lg">
                📧
            </div>

            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                Verifikasi Email
            </h1>

            <!-- Description -->
            <p class="text-gray-500 dark:text-slate-400 text-sm mb-6 leading-relaxed">
                Kami sudah mengirim link verifikasi ke email kamu.  
                Silakan cek inbox atau folder spam lalu klik link tersebut untuk mengaktifkan akun.
            </p>

            <!-- Alert Success -->
            @if (session('success'))
                <div class="mb-4 p-3 rounded-lg text-sm 
                            bg-green-50 dark:bg-green-900/20 
                            border border-green-200 dark:border-green-700/50 
                            text-green-700 dark:text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Resend Button -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                    class="w-full py-2.5 rounded-xl font-semibold text-sm text-white
                           bg-indigo-500 hover:bg-indigo-600
                           transition-all shadow-md hover:shadow-lg">
                    📩 Kirim Ulang Email
                </button>
            </form>

            <!-- Hint -->
            <p class="text-xs text-gray-400 dark:text-slate-500 mt-4">
                Belum menerima email? Tunggu beberapa detik lalu coba kirim ulang.
            </p>

        </div>

        <!-- Back -->
        <div class="text-center mt-4">
            <a href="{{ route('profile.index') }}"
               class="text-sm text-gray-500 dark:text-slate-400 hover:text-indigo-500 transition">
                ← Kembali ke Profile
            </a>
        </div>

    </div>

</div>
@endsection