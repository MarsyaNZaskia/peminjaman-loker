{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Peminjaman Buku')</title>
     @vite(['resources/js/app.js'])
     @vite(['resources/css/app.css'])
    <style>
    [x-cloak] { display: none !important; }
    
    /* Smooth transition for theme changes */
    * {
        transition-property: background-color, border-color, color;
        transition-duration: 200ms;
        transition-timing-function: ease-in-out;
    }

    /* Custom scrollbar untuk sidebar */
    .sidebar-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .sidebar-scroll::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }
    .sidebar-scroll::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }
    .sidebar-scroll::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }
</style>
<script>
        // Taruh di HEAD supaya tidak "kedip" putih saat refresh
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.remove('dark');
        } else {
            // Default tetap dark kalau belum ada settingan atau memang set dark
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        }
    </script>
</head>
@auth
<body 
    x-data="{ 
        darkMode: localStorage.getItem('theme') === 'light' ? false : true,
        sidebarOpen: false,
        toggleTheme() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    }"
    x-init="
        if (darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    "
    class="bg-slate-950 dark:bg-slate-950 transition-colors duration-300"
>
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 flex flex-col transform transition-all duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-2xl
    {{-- Warna saat Light Mode (Putih-Biru-Ungu) --}}
    bg-linear-to-b from-slate-950 to-indigo-600 
    {{-- Warna saat Dark Mode (Hitam-Ungu-Biru Gelap) --}}
    dark:from-slate-950 dark:via-indigo-950 dark:to-slate-900"
    :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
            <!-- Logo / Brand (Fixed di atas) -->
            <div class="shrink-0 flex items-center justify-between px-4 h-16 bg-white/5 border-b border-white/10 backdrop-blur-sm">
                <div class="flex items-center space-x-2.5">
                    <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                        <span class="text-xl">🔐</span>
                    </div>
                    <div class="flex-1">
                        <h1 class="text-white font-bold text-sm leading-tight">BOOKBROW</h1>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu (Scrollable) -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto sidebar-scroll">
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white font-semibold backdrop-blur-sm border border-white/30' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span class="text-lg shrink-0">📊</span>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.kategoris.index') }}" 
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('admin.kategoris.*') ? 'bg-white/20 text-white font-semibold backdrop-blur-sm border border-white/30' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span class="text-lg shrink-0">📚</span>
                        <span>Kategori</span>
                    </a>
                    
                    <a href="{{ route('admin.buku.index') }}" 
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('admin.buku.*') ? 'bg-white/20 text-white font-semibold backdrop-blur-sm border border-white/30' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span class="text-lg shrink-0">🔐</span>
                        <span>Buku</span>
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('admin.users.*') ? 'bg-white/20 text-white font-semibold backdrop-blur-sm border border-white/30' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span class="text-lg shrink-0">👥</span>
                        <span>User</span>
                    </a>
                    
                    <a href="{{ route('admin.peminjaman.index') }}" 
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('admin.peminjaman.*') ? 'bg-white/20 text-white font-semibold backdrop-blur-sm border border-white/30' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span class="text-lg shrink-0">📋</span>
                        <span>Peminjaman</span>
                    </a>
                    
                    <a href="{{ route('admin.pengembalian.index') }}" 
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('admin.pengembalian.*') ? 'bg-white/20 text-white font-semibold backdrop-blur-sm border border-white/30' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span class="text-lg shrink-0">✅</span>
                        <span>Pengembalian</span>
                    </a>
                    
                    <a href="{{ route('admin.log-aktivitas.index') }}" 
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('admin.log-aktivitas.*') ? 'bg-white/20 text-white font-semibold backdrop-blur-sm border border-white/30' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span class="text-lg shrink-0">📝</span>
                        <span>Log Aktivitas</span>
                    </a>
                    
                    <a href="{{ route('admin.laporan.index') }}" 
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('admin.laporan.*') ? 'bg-white/20 text-white font-semibold backdrop-blur-sm border border-white/30' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span class="text-lg shrink-0">📊</span>
                        <span>Laporan</span>
                    </a>
                    
                @elseif(Auth::user()->isPetugas())
                    <a href="{{ route('petugas.dashboard') }}" 
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('petugas.dashboard') ? 'bg-white/20 text-white font-semibold backdrop-blur-sm border border-white/30' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span class="text-lg shrink-0">📊</span>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('petugas.peminjaman.index') }}" 
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('petugas.peminjaman.*') ? 'bg-white/20 text-white font-semibold backdrop-blur-sm border border-white/30' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span class="text-lg shrink-0">📋</span>
                        <span>Kelola Peminjaman</span>
                    </a>
                    
                    <a href="{{ route('petugas.pengembalian.index') }}" 
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('petugas.pengembalian.*') ? 'bg-white/20 text-white font-semibold backdrop-blur-sm border border-white/30' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span class="text-lg shrink-0">✅</span>
                        <span>Data Pengembalian</span>
                    </a>
                    
                    <a href="{{ route('petugas.laporan.index') }}" 
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('petugas.laporan.*') ? 'bg-white/20 text-white font-semibold backdrop-blur-sm border border-white/30' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span class="text-lg shrink-0">📊</span>
                        <span>Laporan</span>
                    </a>
                    
                @else
                    <a href="{{ route('peminjam.dashboard') }}" 
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('peminjam.dashboard') ? 'bg-white/20 text-white font-semibold backdrop-blur-sm border border-white/30' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span class="text-lg shrink-0">📊</span>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('peminjam.peminjaman.index') }}" 
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('peminjam.peminjaman.*') ? 'bg-white/20 text-white font-semibold backdrop-blur-sm border border-white/30' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span class="text-lg shrink-0">🔐</span>
                        <span>Peminjaman Loker</span>
                    </a>

                    <a href="{{ route('peminjam.riwayat.index') }}" 
                        class="flex items-center space-x-3 px-4 py-2.5 rounded-lg transition-all duration-200 text-sm {{ request()->routeIs('peminjam.riwayat.*') ? 'bg-white/20 text-white font-semibold backdrop-blur-sm border border-white/30' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span class="text-lg shrink-0">📚</span>
                        <span>Riwayat Peminjaman</span>
                    </a>
                @endif
            </nav>

            <div class="shrink-0 px-4 py-3 border-t border-white/10">
    <button @click="toggleTheme()" 
            class="w-full flex items-center justify-center space-x-2 px-4 py-2.5 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-200 text-white">
        <span class="text-xl" x-text="darkMode ? '☀️' : '🌙'"></span>
        <span class="text-sm font-medium" x-text="darkMode ? 'Mode Terang' : 'Mode Gelap'"></span>
    </button>
</div>

            <!-- User Info (Fixed di atas) -->
            <div class="shrink-0 px-4 py-3 bg-white/5 border-b border-white/10 backdrop-blur-sm" x-data="{ userMenuOpen: false }">
                <div class="flex items-center space-x-3">
                    <div class="relative bg-white/20 p-2.5 rounded-full shrink-0 backdrop-blur-sm">
                        <span class="text-lg">
                            @if(Auth::user()->isAdmin())
                                👑
                            @elseif(Auth::user()->isPetugas())
                                👮
                            @else
                                👨‍🎓
                            @endif
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white font-medium text-sm truncate">{{ Auth::user()->name }}</p>
                        <div class="mt-1">
                            @if(Auth::user()->isAdmin())
                                <span class="inline-block px-2 py-0.5 rounded-full bg-yellow-400/90 text-yellow-900 text-xs font-medium">Admin</span>
                            @elseif(Auth::user()->isPetugas())
                                <span class="inline-block px-2 py-0.5 rounded-full bg-blue-400 text-white text-xs font-medium">Petugas</span>
                            @else
                                <span class="inline-block px-2 py-0.5 rounded-full bg-green-400 text-green-900 text-xs font-medium">Peminjam</span>
                            @endif
                        </div>
                    </div>
                    <!-- Menu Dropdown Button -->
                    <div class="relative">
                        <button @click="userMenuOpen = !userMenuOpen" 
                                class="p-1.5 rounded-lg hover:bg-white/10 transition-colors text-white/80 hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 8c1.1 0 2-0.9 2-2s-0.9-2-2-2-2 0.9-2 2 0.9 2 2 2zm0 2c-1.1 0-2 0.9-2 2s0.9 2 2 2 2-0.9 2-2-0.9-2-2-2zm0 6c-1.1 0-2 0.9-2 2s0.9 2 2 2 2-0.9 2-2-0.9-2-2-2z" />
                            </svg>
                        </button>
                        <!-- Dropdown Menu -->
                        <div x-show="userMenuOpen" 
                        @click.away="userMenuOpen = false"
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="absolute right-0 bottom-full mb-2 w-48 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-xl backdrop-blur-sm z-50">
                        <a href="{{ route('profile.index') }}" 
                            class="flex items-center space-x-2 w-full px-4 py-2.5 text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-50 dark:hover:bg-slate-700 rounded-t-lg transition-colors text-sm border-b border-gray-200 dark:border-slate-600">
                                <span class="text-base">👤</span>
                                <span>Profile Saya</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" 
                            class="w-full flex items-center space-x-2 px-4 py-2.5 text-rose-600 dark:text-rose-400 hover:text-rose-700 dark:hover:text-rose-300 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-b-lg transition-colors text-sm">
                                <span class="text-base">🚪</span>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
                </div>
            </div>


        </aside>

        <!-- Overlay for mobile -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             x-cloak
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Header (Mobile) -->
            <header class="bg-white dark:bg-slate-900 border-b border-gray-200 dark:border-slate-700 shadow-sm lg:hidden">
                <div class="flex items-center justify-between px-4 py-3">
                    <button @click="sidebarOpen = !sidebarOpen" 
                    class="inline-flex items-center justify-center p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-slate-800 focus:outline-none transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    </button>
                    <div class="flex-1 text-center">
                        <h1 class="text-base font-bold text-gray-800 dark:text-white">🔐 Loker System</h1>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-slate-900 shadow-lg border-t border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4">
                    <div class="text-center">
                        <p class="text-gray-600 text-sm">
                            &copy; {{ date('Y') }} Sistem Peminjaman Loker.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    @endauth

    @guest
    <main>
        @yield('content')
    </main>
    @endguest

    <!-- Flash Message Alerts -->
    @include('components.flash-alerts')

</body>
</html>