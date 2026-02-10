{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Peminjaman Loker')</title>
     @vite(['resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
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
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: false }">
    @auth
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-600 to-blue-800 flex flex-col transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
               :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
            
            <!-- Logo / Brand (Fixed di atas) -->
            <div class="flex-shrink-0 flex items-center justify-center h-20 bg-blue-900/30 border-b border-blue-500/30">
                <div class="flex items-center space-x-3">
                    <div class="bg-white p-2 rounded-lg shadow-lg">
                        <span class="text-2xl">🔐</span>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg">Loker System</h1>
                        <p class="text-blue-200 text-xs">Manajemen</p>
                    </div>
                </div>
            </div>

            <!-- User Info (Fixed di atas) -->
            <div class="flex-shrink-0 p-4 bg-white/10 backdrop-blur-sm border-b border-blue-500/30">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-3 rounded-full flex-shrink-0">
                        <span class="text-2xl">
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
                        <p class="text-white font-semibold text-sm truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs mt-1">
                            @if(Auth::user()->isAdmin())
                                <span class="px-2 py-0.5 rounded bg-red-500 text-white text-xs">Admin</span>
                            @elseif(Auth::user()->isPetugas())
                                <span class="px-2 py-0.5 rounded bg-blue-400 text-white text-xs">Petugas</span>
                            @else
                                <span class="px-2 py-0.5 rounded bg-green-500 text-white text-xs">Peminjam</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu (Scrollable) -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto sidebar-scroll">
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white/10' }}">
                        <span class="text-xl">📊</span>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.kategoris.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.kategoris.*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white/10' }}">
                        <span class="text-xl">📚</span>
                        <span class="font-medium">Kategori</span>
                    </a>
                    
                    <a href="{{ route('admin.lokers.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.lokers.*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white/10' }}">
                        <span class="text-xl">🔐</span>
                        <span class="font-medium">Loker</span>
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white/10' }}">
                        <span class="text-xl">👥</span>
                        <span class="font-medium">User</span>
                    </a>
                    
                    <a href="{{ route('admin.peminjaman.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.peminjaman.*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white/10' }}">
                        <span class="text-xl">📋</span>
                        <span class="font-medium">Peminjaman</span>
                    </a>
                    
                    <a href="{{ route('admin.pengembalian.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.pengembalian.*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white/10' }}">
                        <span class="text-xl">✅</span>
                        <span class="font-medium">Pengembalian</span>
                    </a>
                    
                    <a href="{{ route('admin.log-aktivitas.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.log-aktivitas.*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white/10' }}">
                        <span class="text-xl">📝</span>
                        <span class="font-medium">Log Aktivitas</span>
                    </a>
                    
                    <a href="{{ route('admin.laporan.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.laporan.*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white/10' }}">
                        <span class="text-xl">📊</span>
                        <span class="font-medium">Laporan</span>
                    </a>
                    
                @elseif(Auth::user()->isPetugas())
                    <a href="{{ route('petugas.dashboard') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('petugas.dashboard') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white/10' }}">
                        <span class="text-xl">📊</span>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('petugas.peminjaman.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('petugas.peminjaman.*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white/10' }}">
                        <span class="text-xl">📋</span>
                        <span class="font-medium">Kelola Peminjaman</span>
                    </a>
                    
                    <a href="{{ route('petugas.pengembalian.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('petugas.pengembalian.*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white/10' }}">
                        <span class="text-xl">✅</span>
                        <span class="font-medium">Data Pengembalian</span>
                    </a>
                    
                    <a href="{{ route('petugas.laporan.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('petugas.laporan.*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white/10' }}">
                        <span class="text-xl">📊</span>
                        <span class="font-medium">Laporan</span>
                    </a>
                    
                @else
                    <a href="{{ route('peminjam.dashboard') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('peminjam.dashboard') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white/10' }}">
                        <span class="text-xl">📊</span>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('peminjam.peminjaman.index') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('peminjam.peminjaman.*') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-white/10' }}">
                        <span class="text-xl">🔐</span>
                        <span class="font-medium">Peminjaman Loker</span>
                    </a>
                @endif
                
                <!-- Extra space di bawah menu agar tidak tertutup logout button -->
                <div class="h-4"></div>
            </nav>

            <!-- Logout Button (Fixed di bawah) -->
            <div class="flex-shrink-0 p-4 border-t border-blue-500/30 bg-blue-900/30">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center justify-center space-x-2 bg-red-500 hover:bg-red-600 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span class="text-xl">🚪</span>
                        <span>Logout</span>
                    </button>
                </form>
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
            <header class="bg-white shadow-md lg:hidden">
                <div class="flex items-center justify-between p-4">
                    <button @click="sidebarOpen = !sidebarOpen" 
                            class="text-gray-600 hover:text-gray-900 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-lg font-bold text-gray-800">🔐 Loker System</h1>
                    <div class="w-6"></div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white shadow-lg border-t border-gray-200 flex-shrink-0">
                <div class="px-6 py-4">
                    <div class="text-center">
                        <p class="text-gray-600 text-sm">
                            &copy; {{ date('Y') }} Sistem Peminjaman Loker. Made with ❤️
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

    <!-- Auto hide alerts script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('[data-alert]');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
    
    @if (session('success') || session('error'))
    <script>
        setTimeout(function() {
            const alerts = document.querySelectorAll('[data-alert]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
    @endif
</body>
</html>