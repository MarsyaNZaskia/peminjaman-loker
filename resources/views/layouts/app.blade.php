{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Peminjaman Buku')</title>
    @vite(['resources/js/app.js'])
    @vite(['resources/css/app.css'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        * { font-family: 'Inter', sans-serif; }

        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.4); }

        .bg-grid {
            background-image: radial-gradient(circle at 1px 1px, rgba(148,163,184,0.06) 1px, transparent 0);
            background-size: 24px 24px;
        }

        .nav-active {
            background: rgba(255,255,255,0.12);
            box-shadow: 0 0 20px rgba(99,102,241,0.15), inset 0 1px 0 rgba(255,255,255,0.08);
        }
    </style>
</head>

@auth
<body class="bg-slate-950" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 flex flex-col transform transition-all duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0
            bg-gradient-to-b from-slate-900 via-slate-900 to-indigo-950
            border-r border-white/5"
            :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">

            <!-- Logo -->
            <div class="shrink-0 flex items-center px-5 h-16 border-b border-white/10">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center">
                        <span class="text-xl">📚</span>
                    </div>
                    <div>
                        <h1 class="text-white font-extrabold text-sm tracking-wide">BOOKBROW</h1>
                        <p class="text-indigo-300/50 text-[10px] font-medium tracking-widest uppercase">Library System</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto sidebar-scroll">

                <p class="px-4 pb-2 text-[10px] font-semibold tracking-widest uppercase text-indigo-300/40">Menu Utama</p>

                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all duration-200 text-sm group {{ request()->routeIs('admin.dashboard') ? 'nav-active text-white font-semibold border border-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        <span class="text-lg shrink-0 group-hover:scale-110 transition-transform">📊</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.buku.index') }}"
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all duration-200 text-sm group {{ request()->routeIs('admin.buku.*') ? 'nav-active text-white font-semibold border border-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        <span class="text-lg shrink-0 group-hover:scale-110 transition-transform">📚</span>
                        <span>Buku</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all duration-200 text-sm group {{ request()->routeIs('admin.users.*') ? 'nav-active text-white font-semibold border border-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        <span class="text-lg shrink-0 group-hover:scale-110 transition-transform">👥</span>
                        <span>User</span>
                    </a>

                    <div class="pt-4 pb-2">
                        <p class="px-4 pb-2 text-[10px] font-semibold tracking-widest uppercase text-indigo-300/40">Transaksi</p>
                    </div>
                    <a href="{{ route('admin.peminjaman.index') }}"
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all duration-200 text-sm group {{ request()->routeIs('admin.peminjaman.*') ? 'nav-active text-white font-semibold border border-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        <span class="text-lg shrink-0 group-hover:scale-110 transition-transform">📋</span>
                        <span>Peminjaman</span>
                    </a>
                    <a href="{{ route('admin.pengembalian.index') }}"
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all duration-200 text-sm group {{ request()->routeIs('admin.pengembalian.*') ? 'nav-active text-white font-semibold border border-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        <span class="text-lg shrink-0 group-hover:scale-110 transition-transform">✅</span>
                        <span>Pengembalian</span>
                    </a>

                    <div class="pt-4 pb-2">
                        <p class="px-4 pb-2 text-[10px] font-semibold tracking-widest uppercase text-indigo-300/40">Laporan</p>
                    </div>
                    <a href="{{ route('admin.log-aktivitas.index') }}"
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all duration-200 text-sm group {{ request()->routeIs('admin.log-aktivitas.*') ? 'nav-active text-white font-semibold border border-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        <span class="text-lg shrink-0 group-hover:scale-110 transition-transform">📝</span>
                        <span>Log Aktivitas</span>
                    </a>
                    <a href="{{ route('admin.laporan.index') }}"
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all duration-200 text-sm group {{ request()->routeIs('admin.laporan.*') ? 'nav-active text-white font-semibold border border-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        <span class="text-lg shrink-0 group-hover:scale-110 transition-transform">📊</span>
                        <span>Laporan</span>
                    </a>

                @elseif(Auth::user()->isPetugas())
                    <a href="{{ route('petugas.dashboard') }}"
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all duration-200 text-sm group {{ request()->routeIs('petugas.dashboard') ? 'nav-active text-white font-semibold border border-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        <span class="text-lg shrink-0 group-hover:scale-110 transition-transform">📊</span>
                        <span>Dashboard</span>
                    </a>

                    <div class="pt-4 pb-2">
                        <p class="px-4 pb-2 text-[10px] font-semibold tracking-widest uppercase text-indigo-300/40">Transaksi</p>
                    </div>
                    <a href="{{ route('petugas.peminjaman.index') }}"
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all duration-200 text-sm group {{ request()->routeIs('petugas.peminjaman.*') ? 'nav-active text-white font-semibold border border-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        <span class="text-lg shrink-0 group-hover:scale-110 transition-transform">📋</span>
                        <span>Kelola Peminjaman</span>
                    </a>
                    <a href="{{ route('petugas.pengembalian.index') }}"
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all duration-200 text-sm group {{ request()->routeIs('petugas.pengembalian.*') ? 'nav-active text-white font-semibold border border-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        <span class="text-lg shrink-0 group-hover:scale-110 transition-transform">✅</span>
                        <span>Data Pengembalian</span>
                    </a>
                    <a href="{{ route('petugas.laporan.index') }}"
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all duration-200 text-sm group {{ request()->routeIs('petugas.laporan.*') ? 'nav-active text-white font-semibold border border-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        <span class="text-lg shrink-0 group-hover:scale-110 transition-transform">📊</span>
                        <span>Laporan</span>
                    </a>

                @else
                    <a href="{{ route('peminjam.dashboard') }}"
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all duration-200 text-sm group {{ request()->routeIs('peminjam.dashboard') ? 'nav-active text-white font-semibold border border-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        <span class="text-lg shrink-0 group-hover:scale-110 transition-transform">📊</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('peminjam.peminjaman.index') }}"
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all duration-200 text-sm group {{ request()->routeIs('peminjam.peminjaman.*') ? 'nav-active text-white font-semibold border border-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        <span class="text-lg shrink-0 group-hover:scale-110 transition-transform">📚</span>
                        <span>Katalog Buku</span>
                    </a>
                    <a href="{{ route('peminjam.riwayat.index') }}"
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition-all duration-200 text-sm group {{ request()->routeIs('peminjam.riwayat.*') ? 'nav-active text-white font-semibold border border-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        <span class="text-lg shrink-0 group-hover:scale-110 transition-transform">📖</span>
                        <span>Riwayat Peminjaman</span>
                    </a>
                @endif
            </nav>

            <!-- User Info -->
            <div class="shrink-0 px-3 py-3 border-t border-white/5" x-data="{ userMenuOpen: false }">
                <div class="flex items-center space-x-3 px-2 py-2 rounded-xl bg-white/5 hover:bg-white/10 transition-all cursor-pointer"
                     @click="userMenuOpen = !userMenuOpen">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shrink-0 shadow-lg shadow-indigo-500/20">
                        <span class="text-sm">
                            @if(Auth::user()->isAdmin()) 👑
                            @elseif(Auth::user()->isPetugas()) 👮
                            @else 👨‍🎓
                            @endif
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white font-medium text-sm truncate">{{ Auth::user()->name }}</p>
                        <p class="text-indigo-300/50 text-[11px] font-medium">
                            @if(Auth::user()->isAdmin()) Administrator
                            @elseif(Auth::user()->isPetugas()) Petugas
                            @else Peminjam
                            @endif
                        </p>
                    </div>
                    <svg class="w-4 h-4 text-slate-500 transition-transform" :class="{ 'rotate-180': userMenuOpen }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                </div>

                <!-- Dropdown -->
                <div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="absolute left-3 right-3 bottom-20 bg-slate-800 border border-white/10 rounded-xl shadow-2xl z-50 overflow-hidden">
                    <a href="{{ route('profile.index') }}"
                       class="flex items-center space-x-2 px-4 py-3 text-slate-300 hover:text-white hover:bg-white/5 transition-colors text-sm border-b border-white/5">
                        <span>👤</span><span>Profile Saya</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center space-x-2 px-4 py-3 text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 transition-colors text-sm">
                            <span>🚪</span><span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Overlay mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden"></div>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- TOPBAR -->
            <header class="shrink-0 h-16 bg-slate-900/80 backdrop-blur-xl border-b border-white/5 z-30 flex items-center justify-between px-4 lg:px-6">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-white hover:bg-white/5 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div>
                        <h2 class="text-base font-bold text-white">@yield('title', 'Dashboard')</h2>
                        <p class="text-xs text-slate-500 hidden sm:block">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950/50 bg-grid">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="shrink-0 bg-slate-900/60 backdrop-blur-sm border-t border-white/5">
                <div class="px-6 py-3 text-center">
                    <p class="text-slate-600 text-xs">&copy; {{ date('Y') }} BOOKBROW &mdash; Sistem Peminjaman Buku</p>
                </div>
            </footer>
        </div>
    </div>
</body>
@endauth

@guest
<main>
    @yield('content')
</main>
@endguest

@include('components.flash-alerts')
@stack('scripts')
</html>