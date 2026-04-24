{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-2">

    <!-- HEADER -->
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h1 class="text-2xl font-black text-white tracking-tight">Kelola <span class="text-indigo-400">Users</span></h1>

            <!-- BUTTON -->
            <div class="flex gap-2">
                <button type="button" onclick="toggleModal('modalImport')" 
                    class="px-4 py-2.5 bg-green-500 hover:bg-green-600 text-white rounded-xl text-sm font-medium shadow-sm transition">
                    Import
                </button>

                <a href="{{ route('admin.users.create') }}" 
                    class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-500/20 transition-all active:scale-95">
                    Tambah User
                </a>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-slate-300">
                
                <thead class="bg-white/5 text-slate-400 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Username</th>
                        <th class="px-6 py-3 text-left">Role</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <!-- ❌ HAPUS divide-y -->
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">

                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 font-bold text-white">
                                {{ $user->name }}
                            </td>

                            <td class="px-6 py-4 text-slate-400">
                                {{ $user->username }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full
                                    {{ $user->role == 'petugas'
                                        ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20'
                                        : 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="px-3 py-1.5 bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-white border border-amber-500/20 rounded-lg text-[10px] font-bold uppercase transition-all">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                          id="deleteForm-user-{{ $user->id }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                            onclick="deleteConfirm('deleteForm-user-{{ $user->id }}')"
                                            class="px-3 py-1.5 bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white border border-rose-500/20 rounded-lg text-[10px] font-bold uppercase transition-all">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <span class="text-4xl mb-2">👥</span>
                                    <p>Belum ada data user</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>

<div id="modalImport" class="fixed inset-0 z-999 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4">
        
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity" onclick="toggleModal('modalImport')"></div>

        <div class="relative bg-slate-900 rounded-2xl shadow-2xl transform transition-all sm:max-w-lg sm:w-full overflow-hidden border border-white/10">
            <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-white">Import User Excel</h3>
                        <button type="button" onclick="toggleModal('modalImport')" class="text-slate-500 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div class="border-2 border-dashed border-white/10 rounded-xl p-8 text-center hover:border-indigo-500 transition-colors group">
                            <input type="file" name="file_excel" id="file_excel" class="hidden" required onchange="updateFileName(this)">
                            <label for="file_excel" class="cursor-pointer">
                                <svg class="w-12 h-12 mx-auto text-slate-600 mb-3 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <span id="file-name" class="text-sm text-slate-300 font-medium">Klik untuk pilih file atau drag n drop</span>
                                <p class="text-xs text-slate-500 mt-1">Hanya file .xlsx atau .xls</p>
                            </label>
                        </div>
                        
                        <div class="bg-indigo-500/10 border border-indigo-500/20 p-4 rounded-xl">
                            <p class="text-xs text-indigo-300 leading-relaxed">
                                <strong class="text-indigo-400">💡 Info:</strong> Pastikan kolom excel sesuai urutan: <br>
                                <span class="font-mono opacity-80">nama, username, email, password, role, kategori_id</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/5 px-8 py-6 flex flex-col sm:flex-row-reverse gap-3 border-t border-white/10">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                        Proses Import
                    </button>
                    <button type="button" onclick="toggleModal('modalImport')" class="bg-transparent border border-white/10 text-slate-400 px-8 py-2.5 rounded-xl hover:bg-white/5 transition-all text-sm font-bold">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateFileName(input) {
    const fileName = input.files[0] ? input.files[0].name : 'Klik untuk pilih file atau drag n drop';
    document.getElementById('file-name').textContent = fileName;
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Waduh!',
            text: "{{ session('error') }}",
        });
    @endif

    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.toggle('hidden');
            // Toggle overflow body agar tidak bisa scroll saat modal buka
            if (!modal.classList.contains('hidden')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        }
    }

    function deleteConfirm(formId) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Data user akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            confirmButtonColor: '#dc2626',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>
@endsection