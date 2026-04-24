@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-8 rounded-3xl shadow-2xl">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-2xl shadow-lg shadow-indigo-500/10">📝</div>
            <h1 class="text-2xl font-black text-white tracking-tight">Edit <span class="text-indigo-400">Profile</span></h1>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}"
                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder-slate-600">
            </div>

            <!-- Name -->
            <div class="mb-5">
                <label for="name" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all @error('name') border-rose-500 @enderror">
                @error('name')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-5">
                <label for="email" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all @error('email') border-rose-500 @enderror">
                @error('email')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div class="mb-5">
                <label for="phone" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Nomor Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all @error('phone') border-rose-500 @enderror">
                @error('phone')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div class="mb-5">
                <label for="address" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Alamat Lengkap</label>
                <textarea id="address" name="address" rows="3"
                          class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all @error('address') border-rose-500 @enderror">{{ old('address', $user->address) }}</textarea>
                @error('address')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <!-- Class / Kelas -->
            <div class="mb-8">
                <label for="class" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Kelas / Tahun</label>
                <input type="text" id="class" name="class" value="{{ old('class', $user->class) }}"
                       placeholder="Contoh: XI IPA 1 atau 2024"
                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder-slate-600 @error('class') border-rose-500 @enderror">
                @error('class')
                    <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo -->
            <div class="mb-10 p-5 rounded-2xl bg-white/5 border border-white/5">
                <label for="photo" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Perbarui Foto Profil</label>
                <div class="flex items-center gap-6">
                    @if($user->photo)
                        <div class="shrink-0">
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Current Photo" class="w-16 h-16 rounded-2xl object-cover ring-2 ring-white/10 shadow-lg">
                        </div>
                    @else
                        <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-2xl">👤</div>
                    @endif
                    <div class="flex-1">
                        <input type="file" id="photo" name="photo" accept="image/*" class="block w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-white/10 file:text-white hover:file:bg-white/20 file:cursor-pointer transition-all">
                        <p class="text-[10px] text-slate-500 mt-2 font-bold uppercase tracking-widest">JPG, PNG • Maksimal 2MB</p>
                    </div>
                </div>
                @error('photo')
                    <p class="text-rose-500 text-[10px] font-bold mt-2 ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>


            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-white/5">
                <a href="{{ route('profile.index') }}" class="px-6 py-3 bg-white/5 hover:bg-white/10 text-white rounded-2xl text-xs font-bold transition-all active:scale-95">Batal</a>
                <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-xs font-bold transition-all shadow-lg shadow-indigo-500/20 active:scale-95">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
