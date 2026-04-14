{{-- resources/views/profile/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Profile Saya')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Success Message -->
    @if (session('success'))
        <div data-alert class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-lg animate-slide-down">
            <div class="flex items-center">
                <span class="text-2xl mr-3">✅</span>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Profile Card -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header with Gradient -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-32"></div>
        
        <!-- Profile Content -->
        <div class="px-8 pb-8">
            <div class="flex flex-col md:flex-row items-center md:items-start -mt-16">
                <!-- Profile Photo -->
                <div class="relative group">
                    <div class="w-32 h-32 rounded-full border-4 border-white shadow-xl overflow-hidden bg-gray-200">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}?{{ time() }}" 
                                 alt="Profile Photo" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-5xl bg-gradient-to-br from-blue-400 to-purple-500 text-white">
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
                        {{-- <div>
                            <p class="text-xs text-gray-500">Role</p>
                            <p class="font-semibold text-gray-800">{{ ucfirst(Auth::user()->role) }}</p>
                        </div> --}}
                    </div>
                </div>

                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-500 mb-3">Keamanan</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500">Password</p>
                            <p class="font-semibold text-gray-800">••••••••</p>
                        </div>
                        <button onclick="openModal('changePasswordModal')" 
                                class="mt-4 w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-all transform hover:scale-105 shadow-lg">
                            🔒 Ganti Password
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal Edit Profile -->
<div id="editProfileModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all" onclick="event.stopPropagation()">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-800">✏️ Edit Profile</h2>
                <button onclick="closeModal('editProfileModal')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <form method="POST" action="{{ route('profile.update') }}" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all @error('name') border-red-500 @enderror" 
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Username</label>
                    <input type="text" name="username" value="{{ old('username', Auth::user()->username) }}" 
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all @error('username') border-red-500 @enderror" 
                           required>
                    @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all @error('email') border-red-500 @enderror"
                           required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex space-x-3">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg">
                    💾 Simpan
                </button>
                <button type="button" onclick="closeModal('editProfileModal')" 
                        class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-semibold transition-colors">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Foto -->
<div id="editFotoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
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
                        class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg">
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
<div id="changePasswordModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
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
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all @error('current_password') border-red-500 @enderror" 
                           required>
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Password Baru</label>
                    <input type="password" name="password" 
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all @error('password') border-red-500 @enderror" 
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
                        class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg">
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