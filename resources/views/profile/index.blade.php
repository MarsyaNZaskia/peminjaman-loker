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
<div class="rounded-3xl overflow-hidden shadow-2xl border border-white/10 bg-slate-900/50 backdrop-blur-xl">

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
                <div class="w-32 h-32 rounded-3xl ring-4 ring-slate-900 shadow-2xl overflow-hidden bg-gradient-to-br from-indigo-500 to-violet-600">
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
                            <h1 class="text-3xl font-black text-white truncate tracking-tight">{{ $user->name }}</h1>
                            @if($user->isAdmin())
                                <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[10px] font-bold uppercase tracking-widest">👑 Admin</span>
                            @elseif($user->isPetugas())
                                <span class="px-3 py-1 rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 text-[10px] font-bold uppercase tracking-widest">👮 Petugas</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[10px] font-bold uppercase tracking-widest">👨‍🎓 Peminjam</span>
                            @endif
                        </div>
                        <p class="text-slate-400 text-sm mt-1">
                            @if($user->email) {{ $user->email }} @endif
                        </p>
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                            Edit Profile
                        </a>
                        <button onclick="openModal('changePasswordModal')" class="inline-flex items-center gap-2 px-6 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-white text-sm font-bold rounded-xl transition-all active:scale-95">
                            🔒 Password
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Bar --}}
        <div class="mt-8 grid grid-cols-3 gap-4">
            <div class="text-center p-4 rounded-2xl bg-white/5 border border-white/5">
                <p class="text-3xl font-black text-indigo-400">{{ $totalPeminjaman }}</p>
                <p class="text-[10px] text-slate-500 mt-1 font-bold uppercase tracking-widest">Total Peminjaman</p>
            </div>
            <div class="text-center p-4 rounded-2xl bg-white/5 border border-white/5">
                <p class="text-3xl font-black text-emerald-400">{{ $aktif }}</p>
                <p class="text-[10px] text-slate-500 mt-1 font-bold uppercase tracking-widest">Sedang Aktif</p>
            </div>
            <div class="text-center p-4 rounded-2xl bg-white/5 border border-white/5">
                <p class="text-3xl font-black text-violet-400">{{ $selesai }}</p>
                <p class="text-[10px] text-slate-500 mt-1 font-bold uppercase tracking-widest">Selesai</p>
            </div>
        </div>

        {{-- Completion bar --}}
        @if($totalPeminjaman > 0)
        <div class="mt-6 px-2">
            <div class="flex justify-between items-center mb-2">
                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Tingkat Pengembalian</span>
                <span class="text-xs font-black text-indigo-400">{{ $completionPct }}%</span>
            </div>
            <div class="h-1.5 rounded-full bg-white/5 overflow-hidden">
                <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-violet-500 transition-all duration-1000 shadow-[0_0_15px_rgba(99,102,241,0.5)]" style="width: {{ $completionPct }}%"></div>
            </div>
        </div>
        @endif

        {{-- Biodata warning --}}
        @if($user->isPeminjam() && (empty($user->email)||empty($user->phone)||empty($user->address)||empty($user->class)))
        <div class="mt-6 p-4 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center gap-4">
            <span class="text-2xl shrink-0">⚠️</span>
            <div class="flex-1">
                <p class="text-sm font-bold text-amber-400">Biodata belum lengkap</p>
                <p class="text-xs text-amber-400/60 mt-0.5">Lengkapi data Anda agar dapat melakukan peminjaman buku.</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="shrink-0 text-xs font-bold text-amber-400 hover:text-white transition-colors bg-amber-500/20 px-4 py-2 rounded-xl border border-amber-500/30">Lengkapi →</a>
        </div>
        @endif
    </div>
</div>

{{-- ═══════════════ GRID CARDS ═══════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- Informasi Akun --}}
    <div class="lg:col-span-2 rounded-3xl p-8 bg-slate-900/50 backdrop-blur-xl border border-white/10 shadow-2xl">
        <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
            <span class="w-2 h-2 rounded-full bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.5)]"></span>
            Informasi Akun
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach([
                ['label'=>'Nama Lengkap','val'=>$user->name,'icon'=>'👤'],
                ['label'=>'Username','val'=>$user->username,'icon'=>'🆔'],
                ['label'=>'Email','val'=>$user->email,'icon'=>'📧'],
                ['label'=>'No. Telepon','val'=>$user->phone,'icon'=>'📱'],
                ['label'=>'Kelas / Tahun','val'=>$user->class,'icon'=>'🎓'],
                ['label'=>'Alamat','val'=>$user->address,'icon'=>'📍'],
            ] as $item)
            <div class="flex items-start gap-4 p-5 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/[0.08] transition-colors group">
                <span class="text-xl shrink-0 mt-0.5 grayscale group-hover:grayscale-0 transition-all">{{ $item['icon'] }}</span>
                <div class="min-w-0">
                    <p class="text-[10px] text-slate-500 uppercase tracking-wider font-bold mb-1">{{ $item['label'] }}</p>
                    <p class="text-sm font-bold {{ $item['val'] ? 'text-white' : 'text-amber-500/70' }} truncate">
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
        <div class="rounded-3xl p-6 bg-slate-900/50 backdrop-blur-xl border border-white/10 shadow-2xl">
            <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4 flex items-center gap-3">
                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                Akun Google
            </h3>
            @if($user->google_id)
                <div class="flex items-center gap-4 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20">
                    <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400 text-xl">✓</div>
                    <div>
                        <p class="text-sm font-bold text-emerald-400">Terhubung</p>
                        <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-wider mt-0.5">Google Sync Aktif</p>
                    </div>
                </div>
            @else
                <div class="flex flex-col gap-3">
                    <p class="text-xs text-slate-500 italic">Akun Anda belum terhubung dengan Google.</p>
                    <a href="{{ route('google.redirect') }}"
                        class="flex items-center justify-center gap-3 px-4 py-3 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all text-sm font-bold text-white">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.83l3.66-2.74z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                        Hubungkan Sekarang
                    </a>
                </div>
            @endif
        </div>

        {{-- Security widget --}}
        <div class="rounded-3xl p-6 bg-slate-900/50 backdrop-blur-xl border border-white/10 shadow-2xl">
            <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4 flex items-center gap-3">
                <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                Keamanan
            </h3>
            <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 border border-white/5 mb-4">
                <div class="w-10 h-10 rounded-full bg-indigo-500/10 flex items-center justify-center text-indigo-400 text-lg shrink-0">🔑</div>
                <div>
                    <p class="text-sm font-bold text-white">Password</p>
                    <p class="text-[10px] text-slate-500 tracking-[0.3em] font-bold">••••••••</p>
                </div>
            </div>
            <button onclick="openModal('changePasswordModal')"
                class="w-full flex items-center justify-center gap-2 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                🔒 Ganti Password
            </button>
        </div>

        {{-- Member since widget --}}
        <div class="rounded-3xl p-6 bg-gradient-to-br from-indigo-600 to-violet-700 shadow-2xl text-white relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 text-8xl opacity-10 rotate-12">📚</div>
            <p class="text-[10px] font-black uppercase tracking-widest text-indigo-100/50 mb-1">E-Library Member Since</p>
            <p class="text-2xl font-black">{{ Auth::user()->created_at->format('M Y') }}</p>
            <p class="text-indigo-100/70 text-[10px] font-bold uppercase tracking-wider mt-1">{{ Auth::user()->created_at->diffForHumans() }}</p>
        </div>
    </div>
</div>

</div>{{-- end max-w --}}

{{-- Modal Edit Foto --}}
<div id="editFotoModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-50 flex items-center justify-center p-4 hidden" onclick="closeModal('editFotoModal')">
    <div class="bg-slate-900 border border-white/10 rounded-3xl shadow-2xl max-w-md w-full overflow-hidden" onclick="event.stopPropagation()">
        <div class="p-6 border-b border-white/10 flex items-center justify-between bg-white/5">
            <h2 class="text-base font-bold text-white">📸 Perbarui Foto Profile</h2>
            <button onclick="closeModal('editFotoModal')" class="text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('profile.updatePhoto') }}" enctype="multipart/form-data" class="p-6">
            @csrf @method('PUT')
            <div class="flex flex-col items-center gap-5 mb-8">
                <div class="w-40 h-40 rounded-3xl overflow-hidden bg-white/5 border-2 border-dashed border-white/10 relative group">
                    <img id="fotoPreview" src="{{ $user->photo ? asset('storage/'.$user->photo).'?'.time() : '' }}" class="w-full h-full object-cover {{ $user->photo ? '' : 'hidden' }}">
                    <div id="fotoPlaceholder" class="w-full h-full flex items-center justify-center text-6xl {{ $user->photo ? 'hidden' : '' }}">📷</div>
                </div>
                <div class="w-full">
                    <input type="file" name="photo" id="photoInput" accept="image/*" onchange="previewImage(event)" class="hidden">
                    <label for="photoInput" class="w-full flex items-center justify-center gap-2 py-3 bg-white/5 border border-white/10 rounded-2xl text-sm font-bold text-white cursor-pointer hover:bg-white/10 transition-all mb-2">
                        <span>📁</span> Pilih File Gambar
                    </label>
                    <p class="text-[10px] text-center text-slate-500 font-bold uppercase tracking-widest">Format: JPG, PNG • Max: 2MB</p>
                </div>
                @error('photo')<p class="text-rose-500 text-xs font-bold">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-sm transition shadow-lg shadow-indigo-500/20 active:scale-95">💾 Simpan Perubahan</button>
        </form>
        @if($user->photo)
        <form method="POST" action="{{ route('profile.deleteFoto') }}" onsubmit="return confirm('Hapus foto profile Anda?')" class="px-6 pb-6">
            @csrf @method('DELETE')
            <button type="submit" class="w-full py-3 bg-rose-500/10 hover:bg-rose-600 text-rose-400 hover:text-white rounded-2xl font-bold text-sm transition-all border border-rose-500/20 active:scale-95">🗑️ Hapus Foto</button>
        </form>
        @endif
    </div>
</div>

{{-- Modal Ganti Password --}}
<div id="changePasswordModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-50 flex items-center justify-center p-4 hidden" onclick="closeModal('changePasswordModal')">
    <div class="bg-slate-900 border border-white/10 rounded-3xl shadow-2xl max-w-md w-full overflow-hidden" onclick="event.stopPropagation()">
        <div class="p-6 border-b border-white/10 flex items-center justify-between bg-white/5">
            <h2 class="text-base font-bold text-white">🔒 Keamanan Akun</h2>
            <button onclick="closeModal('changePasswordModal')" class="text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('profile.password') }}" class="p-6">
            @csrf @method('PUT')
            <div class="space-y-5">
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Password Lama</label>
                    <input type="password" name="current_password" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-sm @error('current_password') border-rose-500 @enderror">
                    @error('current_password')<p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Password Baru</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-sm @error('password') border-rose-500 @enderror">
                    @error('password')<p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition text-sm">
                </div>
            </div>
            <div class="mt-8 flex gap-3">
                <button type="submit" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-sm transition-all shadow-lg shadow-indigo-500/20 active:scale-95">💾 Perbarui Password</button>
                <button type="button" onclick="closeModal('changePasswordModal')" class="px-6 py-3 bg-white/5 hover:bg-white/10 text-slate-300 rounded-2xl font-bold text-sm transition-all active:scale-95">Batal</button>
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