@extends('layouts.app')
@section('title', 'Profile Saya')
@section('content')

@php
    $user = Auth::user();
    $totalPeminjaman = $user->peminjaman()->count();
    $aktif = $user->peminjaman()->where('status', 'disetujui')->count();
    $selesai = $user->peminjaman()->where('status', 'dikembalikan')->count();
    $completionPct = $totalPeminjaman > 0 ? round(($selesai / $totalPeminjaman) * 100) : 0;
@endphp

<div class="max-w-5xl mx-auto space-y-5">

{{-- ═══════════════ HERO CARD ═══════════════ --}}
<div class="rounded-2xl overflow-hidden shadow-xl border border-white/10 dark:border-slate-700/50 bg-white dark:bg-slate-800/60 backdrop-blur-sm">

    {{-- Cover / Banner --}}
    <div class="h-28 relative overflow-hidden bg-slate-800">
        {{-- Animated blobs --}}
        <div class="absolute -top-10 -left-10 w-60 h-60 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-10 -right-10 w-72 h-72 bg-pink-400/20 rounded-full blur-3xl animate-pulse delay-700"></div>
        <div class="absolute top-4 right-4 grid grid-cols-8 gap-1 opacity-20">
            @for($i=0;$i<64;$i++)<div class="w-1.5 h-1.5 bg-white rounded-full"></div>@endfor
        </div>
    </div>

    {{-- Profile Identity Row --}}
    <div class="px-6 sm:px-8 pb-6">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">

            {{-- Avatar --}}
            <div class="relative -mt-16 shrink-0">
                <div class="w-32 h-32 rounded-2xl ring-4 ring-white dark:ring-slate-800 shadow-2xl overflow-hidden bg-gradient-to-br from-indigo-400 to-purple-600">
                    @if($user->photo)
                        <img src="{{ asset('storage/'.$user->photo) }}?{{ time() }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-5xl text-white">
                            @if($user->isAdmin()) 👑 @elseif($user->isPetugas()) 👮 @else 👨‍🎓 @endif
                        </div>
                    @endif
                </div>
                <button onclick="openModal('editFotoModal')"
                    class="absolute -bottom-2 -right-2 w-9 h-9 bg-indigo-500 hover:bg-indigo-600 text-white rounded-xl flex items-center justify-center shadow-lg border-2 border-white dark:border-slate-800 transition hover:scale-110">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-1.414.586H9v-2.414a2 2 0 01.586-1.414z"/></svg>
                </button>
            </div>

            {{-- Name + Actions --}}
            <div class="flex-1 min-w-0 mt-3 sm:mt-0 sm:pb-1">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white truncate">{{ $user->name }}</h1>
                            @if($user->isAdmin())
                                <span class="px-2 py-0.5 rounded-lg bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 text-xs font-bold">👑 Admin</span>
                            @elseif($user->isPetugas())
                                <span class="px-2 py-0.5 rounded-lg bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 text-xs font-bold">👮 Petugas</span>
                            @else
                                <span class="px-2 py-0.5 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 text-xs font-bold">👨‍🎓 Peminjam</span>
                            @endif
                        </div>
                        <p class="text-gray-500 dark:text-slate-400 text-sm mt-0.5">
                            @if($user->email) {{ $user->email }} @endif
                        </p>
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition shadow-md shadow-indigo-500/25">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-1.414.586H9v-2.414a2 2 0 01.586-1.414z"/></svg>
                            Edit Profile
                        </a>
                        <button onclick="openModal('changePasswordModal')" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-slate-200 text-sm font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-slate-600 transition">
                            🔒 Password
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Bar --}}
        <div class="mt-5 grid grid-cols-3 gap-3">
            <div class="text-center p-3 rounded-xl bg-slate-50 dark:bg-slate-700/40 border border-gray-100 dark:border-slate-600/30">
                <p class="text-2xl font-black text-indigo-600 dark:text-indigo-400">{{ $totalPeminjaman }}</p>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5 font-medium">Total Peminjaman</p>
            </div>
            <div class="text-center p-3 rounded-xl bg-slate-50 dark:bg-slate-700/40 border border-gray-100 dark:border-slate-600/30">
                <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ $aktif }}</p>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5 font-medium">Sedang Aktif</p>
            </div>
            <div class="text-center p-3 rounded-xl bg-slate-50 dark:bg-slate-700/40 border border-gray-100 dark:border-slate-600/30">
                <p class="text-2xl font-black text-purple-600 dark:text-purple-400">{{ $selesai }}</p>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5 font-medium">Selesai</p>
            </div>
        </div>

        {{-- Completion bar --}}
        @if($totalPeminjaman > 0)
        <div class="mt-3">
            <div class="flex justify-between items-center mb-1">
                <span class="text-xs text-gray-400 dark:text-slate-500">Tingkat Pengembalian</span>
                <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400">{{ $completionPct }}%</span>
            </div>
            <div class="h-2 rounded-full bg-gray-100 dark:bg-slate-700 overflow-hidden">
                <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-700" style="width: {{ $completionPct }}%"></div>
            </div>
        </div>
        @endif

        {{-- Biodata warning --}}
        @if($user->isPeminjam() && (empty($user->email)||empty($user->phone)||empty($user->address)||empty($user->class)))
        <div class="mt-4 p-3 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700/40 flex items-center gap-3">
            <span class="text-amber-500 text-xl shrink-0">⚠️</span>
            <div class="flex-1">
                <p class="text-sm font-semibold text-amber-800 dark:text-amber-300">Biodata belum lengkap</p>
                <p class="text-xs text-amber-600 dark:text-amber-400">Lengkapi data agar bisa meminjam buku.</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="shrink-0 text-xs font-bold text-amber-700 dark:text-amber-300 hover:underline">Lengkapi →</a>
        </div>
        @endif
    </div>
</div>

{{-- ═══════════════ GRID CARDS ═══════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- Informasi Akun --}}
    <div class="lg:col-span-2 rounded-2xl p-5 bg-white/70 dark:bg-slate-800/50 backdrop-blur-sm border border-gray-100 dark:border-slate-700/50 shadow-sm">
        <h3 class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-4 flex items-center gap-2">
            <span class="w-5 h-5 rounded-md bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-xs">👤</span>
            Informasi Akun
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach([
                ['label'=>'Nama Lengkap','val'=>$user->name,'icon'=>'🏷️'],
                ['label'=>'Username','val'=>$user->username,'icon'=>'@'],
                ['label'=>'Email','val'=>$user->email,'icon'=>'📧'],
                ['label'=>'No. Telepon','val'=>$user->phone,'icon'=>'📱'],
                ['label'=>'Kelas / Tahun','val'=>$user->class,'icon'=>'🎓'],
                ['label'=>'Alamat','val'=>$user->address,'icon'=>'📍'],
            ] as $item)
            <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-700/30">
                <span class="text-lg shrink-0 mt-0.5">{{ $item['icon'] }}</span>
                <div class="min-w-0">
                    <p class="text-[11px] text-gray-400 dark:text-slate-500 uppercase tracking-wide font-semibold">{{ $item['label'] }}</p>
                    <p class="text-sm font-semibold {{ $item['val'] ? 'text-gray-800 dark:text-white' : 'text-amber-500 dark:text-amber-400' }} truncate">
                        {{ $item['val'] ?? '— Belum diisi' }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Right column widgets --}}
    <div class="flex flex-col gap-4">

        {{-- Google widget --}}
        <div class="rounded-2xl p-5 bg-white/70 dark:bg-slate-800/50 backdrop-blur-sm border border-gray-100 dark:border-slate-700/50 shadow-sm">
            <h3 class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-2">
                <span class="w-5 h-5 rounded-md bg-red-100 dark:bg-red-900/40 flex items-center justify-center text-xs">🌐</span>
                Akun Google
            </h3>
            @if($user->google_id)
                <div class="flex items-center gap-3 p-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700/40">
                    <div class="w-9 h-9 rounded-full bg-emerald-100 dark:bg-emerald-800 flex items-center justify-center text-emerald-600 dark:text-emerald-300 text-lg">✓</div>
                    <div>
                        <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">Terhubung</p>
                        <p class="text-xs text-emerald-600 dark:text-emerald-500">Login Google aktif</p>
                    </div>
                </div>
            @else
                <div class="flex flex-col gap-2">
                    <p class="text-xs text-gray-400 dark:text-slate-500">Belum terhubung ke akun Google.</p>
                    <a href="{{ route('google.redirect') }}"
                        class="flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 hover:shadow-md transition text-sm font-semibold text-gray-700 dark:text-slate-200">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.83l3.66-2.74z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                        Hubungkan Google
                    </a>
                </div>
            @endif
        </div>

        {{-- Security widget --}}
        <div class="rounded-2xl p-5 bg-white/70 dark:bg-slate-800/50 backdrop-blur-sm border border-gray-100 dark:border-slate-700/50 shadow-sm">
            <h3 class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-2">
                <span class="w-5 h-5 rounded-md bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-xs">🔒</span>
                Keamanan
            </h3>
            <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-700/30 mb-3">
                <div class="w-9 h-9 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-300 text-lg shrink-0">🔑</div>
                <div>
                    <p class="text-sm font-semibold text-gray-700 dark:text-slate-200">Password</p>
                    <p class="text-xs text-gray-400 dark:text-slate-500 tracking-widest">••••••••••</p>
                </div>
            </div>
            <button onclick="openModal('changePasswordModal')"
                class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition shadow-md shadow-indigo-500/20">
                🔒 Ganti Password
            </button>
        </div>

        {{-- Member since widget --}}
        <div class="rounded-2xl p-5 bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg shadow-indigo-500/20 text-white">
            <p class="text-xs font-bold uppercase tracking-widest text-indigo-100 mb-1">Member Sejak</p>
            <p class="text-xl font-extrabold">{{ Auth::user()->created_at->format('M Y') }}</p>
            <p class="text-indigo-200 text-xs mt-1">{{ Auth::user()->created_at->diffForHumans() }}</p>
            <div class="mt-4 text-3xl opacity-30">📚</div>
        </div>
    </div>
</div>

</div>{{-- end max-w --}}

{{-- Modal Edit Foto --}}
<div id="editFotoModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4" onclick="closeModal('editFotoModal')">
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full border border-gray-100 dark:border-slate-700" onclick="event.stopPropagation()">
        <div class="p-6 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between">
            <h2 class="text-base font-bold text-gray-800 dark:text-white">📸 Edit Foto Profile</h2>
            <button onclick="closeModal('editFotoModal')" class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('profile.updatePhoto') }}" enctype="multipart/form-data" class="p-6">
            @csrf @method('PUT')
            <div class="flex flex-col items-center gap-4 mb-5">
                <div class="w-36 h-36 rounded-2xl overflow-hidden bg-gray-100 dark:bg-slate-700 border-2 border-dashed border-gray-200 dark:border-slate-600">
                    <img id="fotoPreview" src="{{ $user->photo ? asset('storage/'.$user->photo).'?'.time() : '' }}" class="w-full h-full object-cover {{ $user->photo ? '' : 'hidden' }}">
                    <div id="fotoPlaceholder" class="w-full h-full flex items-center justify-center text-5xl {{ $user->photo ? 'hidden' : '' }}">📷</div>
                </div>
                <input type="file" name="photo" accept="image/*" onchange="previewImage(event)"
                    class="block w-full text-sm text-gray-500 dark:text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900/30 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 file:cursor-pointer">
                <p class="text-xs text-gray-400">JPG, PNG • Max 2MB</p>
                @error('photo')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold text-sm transition shadow-md">💾 Upload Foto</button>
        </form>
        @if($user->photo)
        <form method="POST" action="{{ route('profile.deleteFoto') }}" onsubmit="return confirm('Hapus foto?')" class="px-6 pb-6">
            @csrf @method('DELETE')
            <button type="submit" class="w-full py-2.5 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 text-red-600 dark:text-red-400 rounded-xl font-semibold text-sm transition">🗑️ Hapus Foto</button>
        </form>
        @endif
    </div>
</div>

{{-- Modal Ganti Password --}}
<div id="changePasswordModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4" onclick="closeModal('changePasswordModal')">
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full border border-gray-100 dark:border-slate-700" onclick="event.stopPropagation()">
        <div class="p-6 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between">
            <h2 class="text-base font-bold text-gray-800 dark:text-white">🔒 Ganti Password</h2>
            <button onclick="closeModal('changePasswordModal')" class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('profile.password') }}" class="p-6">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Password Lama</label>
                    <input type="password" name="current_password" required class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-800 dark:text-white focus:border-indigo-500 focus:outline-none text-sm @error('current_password') border-red-500 @enderror">
                    @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Password Baru</label>
                    <input type="password" name="password" required class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-800 dark:text-white focus:border-indigo-500 focus:outline-none text-sm @error('password') border-red-500 @enderror">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-800 dark:text-white focus:border-indigo-500 focus:outline-none text-sm">
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <button type="submit" class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold text-sm transition shadow-md">💾 Simpan</button>
                <button type="button" onclick="closeModal('changePasswordModal')" class="px-5 py-2.5 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-300 rounded-xl font-semibold text-sm transition">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.remove('hidden'); document.body.style.overflow='hidden'; }
function closeModal(id) { document.getElementById(id).classList.add('hidden'); document.body.style.overflow='auto'; }
function previewImage(e) {
    const f = e.target.files[0];
    if (!f) return;
    const r = new FileReader();
    r.onload = ev => {
        document.getElementById('fotoPreview').src = ev.target.result;
        document.getElementById('fotoPreview').classList.remove('hidden');
        document.getElementById('fotoPlaceholder').classList.add('hidden');
    };
    r.readAsDataURL(f);
}
</script>
@endsection