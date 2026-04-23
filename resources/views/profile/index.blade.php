{{-- resources/views/profile/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Profile Saya')

@section('content')

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl">
        ✅ {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">
        ❌ {{ session('error') }}
    </div>
@endif
<div class="max-w-4xl mx-auto space-y-6">

    {{-- <!-- Skeleton Loading -->
    <div id="skeleton" class="animate-pulse space-y-4">
        <div class="h-32 bg-gray-200 rounded-xl"></div>
        <div class="flex items-center space-x-4 -mt-16 px-6">
            <div class="w-28 h-28 bg-gray-300 rounded-full"></div>
            <div class="space-y-3 flex-1">
                <div class="h-6 bg-gray-300 rounded w-1/3"></div>
                <div class="h-4 bg-gray-200 rounded w-1/4"></div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 px-6">
            <div class="h-32 bg-gray-200 rounded-xl"></div>
            <div class="h-32 bg-gray-200 rounded-xl"></div>
        </div>
    </div> --}}


    <!-- Profile Card -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header with Gradient -->
        <div class="bg-linear-to-r from-indigo-500 to-blue-400 h-28"></div>
        
        <!-- Profile Content -->
        <div class="px-8 pb-8">
            <div class="flex flex-col md:flex-row items-center md:items-start -mt-16">
                <!-- Profile Photo -->
                <div class="relative group">
                    <div class="w-28 h-28 rounded-full ring-4 ring-white shadow-lg overflow-hidden bg-gray-200">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}?{{ time() }}" 
                                 alt="Profile Photo" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-5xl bg-linear-to-br from-blue-400 to-purple-500 text-white">
                                @if(Auth::user()->isAdmin())
                                    👑
                                @elseif(Auth::user()->isPetugas())
                                    👮
                                @else
                                    👨‍🎓
                                @endif
                            </div>
                        @endif
                    </div>
                    
                    <!-- Edit Photo Button -->
                    <button onclick="openModal('editFotoModal')" 
                            class="absolute bottom-0 right-0 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full shadow-lg transform transition-transform hover:scale-110">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Profile Info -->
                <div class="md:ml-8 mt-4 md:mt-0 text-center md:text-left flex-1">
                    <div class="flex items-center justify-center md:justify-start space-x-3 mb-2">
                        <h1 class="text-3xl font-bold text-gray-800">{{ Auth::user()->name }}</h1>
                        <button onclick="openModal('editProfileModal')" 
                                class="text-blue-500 hover:text-blue-700 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <p class="text-gray-600 mb-3">@<span class="font-medium">{{ Auth::user()->username }}</span></p>
                    
                    <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                        @if(Auth::user()->isAdmin())
                            <span class="px-4 py-1.5 rounded-full bg-red-100 text-red-700 text-sm font-semibold">
                                👑 Administrator
                            </span>
                        @elseif(Auth::user()->isPetugas())
                            <span class="px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">
                                👮 Petugas
                            </span>
                        @else
                            <span class="px-4 py-1.5 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                                👨‍🎓 Peminjam
                            </span>
                        @endif

                        @if(Auth::user()->kategori)
                            <span class="px-4 py-1.5 rounded-full bg-purple-100 text-purple-700 text-sm font-semibold">
                                📚 {{ Auth::user()->kategori->nama_kategori }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Account Details -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-500 mb-3">Informasi Akun</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500">Nama Lengkap</p>
                            <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Username</p>
                            <p class="font-semibold text-gray-800">{{ Auth::user()->username }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Email</p>
                            <p class="font-semibold text-gray-800">
                                @if(Auth::user()->email)
                                    {{ Auth::user()->email }}
                                @else
                                    <span class="text-red-500">⚠️ Belum diisi</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-500 mb-3">Informasi Biodata</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500">No. Telepon</p>
                            <p class="font-semibold text-gray-800">
                                @if(Auth::user()->phone)
                                    {{ Auth::user()->phone }}
                                @else
                                    <span class="text-red-500">⚠️ Belum diisi</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Alamat</p>
                            <p class="font-semibold text-gray-800">
                                @if(Auth::user()->address)
                                    {{ Auth::user()->address }}
                                @else
                                    <span class="text-red-500">⚠️ Belum diisi</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Kelas/Tahun</p>
                            <p class="font-semibold text-gray-800">
                                @if(Auth::user()->class)
                                    {{ Auth::user()->class }}
                                @else
                                    <span class="text-red-500">⚠️ Belum diisi</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Biodata Warning for Peminjam -->
            @if(Auth::user()->isPeminjam() && (empty(Auth::user()->email) || empty(Auth::user()->phone) || empty(Auth::user()->address) || empty(Auth::user()->class)))
            <div class="mt-6 bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">
                <div class="flex items-start">
                    <div class="shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-semibold">Peringatan: Biodata Belum Lengkap</p>
                        <p class="text-sm text-red-600 mt-1">Lengkapi semua data biodata untuk dapat melakukan peminjaman buku. Klik tombol Edit untuk melengkapi data.</p>
                        <a href="{{ route('profile.edit') }}" class="text-blue-500 hover:text-blue-700">✏️ Lengkapi biodata</a>
                     </div>
                </div>
            </div>
            @endif

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Akun Google</h3>
                @if($user->google_id)
                    <div class="flex items-center p-3 bg-green-50 border border-green-200 rounded-lg">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-green-800 font-medium">Akun Google sudah terhubung</span>
                    </div>
                @else
                    <div class="text-center py-4">
                        <a href="{{ route('google.redirect') }}" 
                           class="inline-flex items-center px-6 py-3 bg-white border-2 border-blue-500 rounded-lg hover:border-blue-600 hover:shadow-lg transition transform hover:scale-105 text-blue-600 font-semibold">
                            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.83l2.66-2.07z"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            Hubungkan Akun Google
                        </a>
                        <p class="text-sm text-gray-500 mt-2">Hubungkan akun Google untuk login lebih mudah</p>
                    </div>
                @endif
                </div>


                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-500 mb-3">Keamanan</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500">Password</p>
                            <p class="font-semibold text-gray-800">••••••••</p>
                        </div>
                        <button onclick="openModal('changePasswordModal')" 
                                class="mt-4 w-full bg-linear-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-all transform hover:scale-105 shadow-lg">
                            🔒 Ganti Password
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <a href="{{ route('profile.edit')}}" class="mt-4 w-full bg-linear-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-70 text-center px-4 py-2 rounded-lg transition-all transform hover:scale-105 shadow-lgtext-2xl font-bold text-gray-800">✏️ Edit Profile</a>
            </div>
        </div>
    </div>

</div>

{{-- edit profil --}}
<div class="p-6 border-b border-gray-200">
            
        </div>


<!-- Modal Edit Foto -->
<div id="editFotoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all" onclick="event.stopPropagation()">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-800">📸 Edit Foto Profile</h2>
                <button onclick="closeModal('editFotoModal')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <form method="POST" action="{{ route('profile.updatePhoto') }}" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <!-- Preview Foto -->
            <div class="mb-6">
                <div class="w-48 h-48 mx-auto rounded-full border-4 border-gray-200 overflow-hidden bg-gray-100">
                    <img id="fotoPreview" 
                         src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) . '?' . time() : '' }}" 
                         alt="Preview" 
                         class="w-full h-full object-cover {{ Auth::user()->photo ? '' : 'hidden' }}">
                    <div id="fotoPlaceholder" class="w-full h-full flex items-center justify-center text-6xl {{ Auth::user()->photo ? 'hidden' : '' }}">
                        📷
                    </div>
                </div>
            </div>

            <!-- Upload Input -->
            <div class="mb-6">
                <label class="block text-center">
                    <span class="sr-only">Pilih foto</span>
                    <input type="file" name="photo" accept="image/*" 
                           onchange="previewImage(event)"
                           class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-3 file:px-6
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-blue-50 file:text-blue-700
                                  hover:file:bg-blue-100
                                  file:cursor-pointer cursor-pointer">
                </label>
                <p class="text-xs text-gray-500 text-center mt-2">JPG, PNG (Max 2MB)</p>
                @error('photo')
                    <p class="text-red-500 text-sm text-center mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col space-y-3">
                <button type="submit" 
                        class="w-full bg-linear-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg">
                    💾 Upload Foto
                </button>
            </div>
        </form>

        @if(Auth::user()->photo)
            <form method="POST" action="{{ route('profile.deleteFoto') }}" onsubmit="return confirm('Yakin ingin menghapus foto profile?')" class="p-6">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="w-full bg-red-100 hover:bg-red-200 text-red-700 px-6 py-3 rounded-xl font-semibold transition-colors">
                    🗑️ Hapus Foto
                </button>
            </form>
        @endif
    </div>
</div>

<!-- Modal Change Password -->
<div id="changePasswordModal" class=" fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all" onclick="event.stopPropagation()">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-800">🔒 Ganti Password</h2>
                <button onclick="closeModal('changePasswordModal')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <form method="POST" action="{{ route('profile.password') }}" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Password Lama</label>
                    <input type="password" name="current_password" 
                           class="w-full px-4 py-3 border-2 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all @error('current_password') border-red-500 @enderror" 
                           required>
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Password Baru</label>
                    <input type="password" name="password" 
                           class="w-full px-4 py-3 border-2 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all @error('password') border-red-500 @enderror" 
                           required>
                    <p class="text-xs text-gray-500 mt-1">Min 8 karakter, huruf besar, kecil, angka, simbol</p>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" 
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all" 
                           required>
                </div>
            </div>

            <div class="mt-6 flex space-x-3">
                <button type="submit" 
                        class="flex-1 bg-linear-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg">
                    💾 Ganti Password
                </button>
                <button type="button" onclick="closeModal('changePasswordModal')" 
                        class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-semibold transition-colors">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>

    window.onload = () => {
    setTimeout(() => {
        document.getElementById('skeleton').style.display = 'none';
        document.getElementById('content').classList.remove('hidden');
    }, 600);
};

// Modal functions
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.querySelectorAll('[id$="Modal"]').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal(this.id);
        }
    });
});

// Preview image before upload
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('fotoPreview').src = e.target.result;
            document.getElementById('fotoPreview').classList.remove('hidden');
            document.getElementById('fotoPlaceholder').classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }
}

</script>

<style>
@keyframes slide-down {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-slide-down { animation: slide-down 0.3s ease-out; }
</style>
@endsection