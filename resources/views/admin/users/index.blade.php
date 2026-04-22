{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold">Kelola User</h1>
        </div>

        <div class="flex space-x-2">
            <button type="button" onclick="toggleModal('modalImport')" 
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Import User
            </button>
            <a href="{{ route('admin.users.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                + Tambah User
            </a>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Username</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($users as $user)
                    <tr>
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->username }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs {{ $user->role == 'petugas' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex space-x-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" id="deleteForm-user-{{ $user->id }}">
                                @csrf @method('DELETE')
                                <button type="button" onclick="deleteConfirm('deleteForm-user-{{ $user->id }}')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada user</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div> {{-- Tutup max-w-7xl --}}

<div id="modalImport" class="fixed inset-0 z-999 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4">
        
        <div class="fixed inset-0 bg-black/30 backdrop-blur-sm transition-opacity" onclick="toggleModal('modalImport')"></div>

        <div class="relative bg-white rounded-2xl shadow-2xl transform transition-all sm:max-w-lg sm:w-full overflow-hidden border border-gray-100">
            <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Import User Excel</h3>
                        <button type="button" onclick="toggleModal('modalImport')" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-blue-400 transition-colors">
                            <input type="file" name="file_excel" id="file_excel" class="hidden" required onchange="updateFileName(this)">
                            <label for="file_excel" class="cursor-pointer">
                                <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <span id="file-name" class="text-sm text-gray-600">Klik untuk pilih file atau drag n drop</span>
                                <p class="text-xs text-gray-400 mt-1">Hanya file .xlsx atau .xls</p>
                            </label>
                        </div>
                        
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-xs text-blue-700 leading-relaxed">
                                <strong>💡 Info:</strong> Pastikan kolom excel sesuai urutan: <br>
                                <span class="font-mono">nama, username, email, password, role, kategori_id</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-8 py-4 flex flex-col sm:flex-row-reverse gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-semibold transition-all shadow-lg shadow-blue-200">
                        Proses Import
                    </button>
                    <button type="button" onclick="toggleModal('modalImport')" class="bg-white border border-gray-200 text-gray-600 px-6 py-2.5 rounded-xl hover:bg-gray-50 transition-all text-sm font-medium">
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