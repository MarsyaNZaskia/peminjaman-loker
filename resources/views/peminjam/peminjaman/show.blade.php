<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku - Peminjaman</title>
    
    <!-- Tailwind CSS (CDN untuk keperluan demo tanpa build step) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku - Peminjaman</title>
    
    <!-- Tailwind CSS (CDN untuk keperluan demo tanpa build step) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- SweetAlert2 (Sesuai kode yang kamu gunakan sebelumnya) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* bg-gray-100 */
        }
        /* Line clamp untuk sinopsis agar rapi */
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body>

    <!-- Navbar Mockup (Untuk keperluan demo visual saja) -->
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-blue-600">Perpustakaan</span>
                </div>
                <div class="flex items-center">
                    <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">P</div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="#" class="hover:text-blue-600">Home</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="#" class="hover:text-blue-600">Katalog Buku</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="font-medium text-gray-800">Detail Buku</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Tombol Kembali -->
        <a href="#" onclick="history.back()" class="inline-flex items-center text-gray-500 hover:text-blue-600 mb-6 transition">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Katalog
        </a>

        <!-- Bagian Utama Detail Buku -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-0">
                
                <!-- Kolom Kiri: Cover Buku (4/12) -->
                <div class="md:col-span-4 bg-gray-50 p-8 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-200">
                    <div class="relative w-64 h-96 shadow-xl rounded-lg overflow-hidden group">
                        <!-- Placeholder Cover Image -->
                        <img src="https://picsum.photos/seed/bookcover1/400/600" alt="Cover Buku" class="w-full h-full object-cover">
                        
                        <!-- Badge Stok (Sama seperti halaman index) -->
                        <span class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-bold shadow-sm bg-green-500 text-white">
                            Tersedia
                        </span>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-500">ISBN</p>
                        <p class="font-mono font-medium text-gray-700">978-623-02-1234-5</p>
                    </div>
                </div>

                <!-- Kolom Kanan: Informasi Buku (8/12) -->
                <div class="md:col-span-8 p-8 flex flex-col">
                    
                    <!-- Header Info -->
                    <div class="mb-6 border-b border-gray-100 pb-4">
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded">Teknologi</span>
                            <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded">Best Seller</span>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Pemrograman Web Modern dengan Laravel & Tailwind</h1>
                        <p class="text-lg text-gray-600">oleh <span class="font-medium text-gray-900">Budi Santoso, S.Kom</span></p>
                    </div>

                    <!-- Grid Metadata -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 mb-6">
                        <div class="flex items-start">
                            <div class="shrink-0 w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Penerbit</p>
                                <p class="text-sm font-medium text-gray-900">Informatika Bandung</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="shrink-0 w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Tahun Terbit</p>
                                <p class="text-sm font-medium text-gray-900">2023</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="shrink-0 w-8 h-8 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Halaman</p>
                                <p class="text-sm font-medium text-gray-900">450 Halaman</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="shrink-0 w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Bahasa</p>
                                <p class="text-sm font-medium text-gray-900">Indonesia</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sinopsis -->
                    <div class="mb-auto">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Sinopsis</h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-4">
                            Buku ini membahas secara mendalam tentang pengembangan aplikasi web modern menggunakan framework Laravel dan utility-first CSS Tailwind. Cocok untuk pemula hingga developer tingkat lanjut. Membahas konsep MVC, Eloquent ORM, Authentication, hingga deployment ke server produksi. Dilengkapi dengan studi kasus aplikasi perpustakaan digital yang realistis.
                        </p>
                    </div>

                    <!-- Status & Aksi -->
                    <div class="mt-6 pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-center sm:text-left">
                            <p class="text-sm text-gray-500">Sisa Stok</p>
                            <p class="text-xl font-bold text-green-600">5 Buku</p>
                            <p class="text-xs text-gray-400">Maksimal peminjaman: <strong>14 Hari</strong></p>
                        </div>
                        
                        <div class="flex gap-3 w-full sm:w-auto">
                            <a href="#" onclick="showDetailToast()" class="flex-1 sm:flex-none text-center border border-gray-300 hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-lg transition text-sm font-semibold">
                                Simpan
                            </a>
                            <button onclick="confirmBorrow()" class="flex-1 sm:flex-none text-center bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 text-sm font-semibold flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Ajukan Peminjaman
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rekomendasi Buku Lainnya -->
        <div class="mt-10">
            <h2 class="text-xl font-bold text-gray-800 mb-5 flex items-center">
                <span class="w-1 h-6 bg-blue-500 rounded-full mr-3"></span>
                Buku Terkait
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Card 1 -->
                <div class="bg-white border border-gray-100 rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300 group cursor-pointer">
                    <div class="h-40 bg-gray-100 relative overflow-hidden">
                        <img src="https://picsum.photos/seed/book2/300/200" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-2 right-2 px-2 py-1 rounded text-xs font-medium bg-green-500 text-white">Stok: 2</span>
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2">Belajar Dasar-Dasar HTML & CSS</h4>
                        <p class="text-xs text-gray-500">Rina Wijaya</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white border border-gray-100 rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300 group cursor-pointer">
                    <div class="h-40 bg-gray-100 relative overflow-hidden">
                        <img src="https://picsum.photos/seed/book3/300/200" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-2 right-2 px-2 py-1 rounded text-xs font-medium bg-yellow-500 text-white">Stok: 1</span>
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2">Algoritma dan Pemrograman</h4>
                        <p class="text-xs text-gray-500">Andi Saputra</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white border border-gray-100 rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300 group cursor-pointer">
                    <div class="h-40 bg-gray-100 relative overflow-hidden">
                        <img src="https://picsum.photos/seed/book4/300/200" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-2 right-2 px-2 py-1 rounded text-xs font-medium bg-green-500 text-white">Stok: 8</span>
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2">Database Management System</h4>
                        <p class="text-xs text-gray-500">Cantika Putri</p>
                    </div>
                </div>

                 <!-- Card 4 -->
                 <div class="bg-white border border-gray-100 rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300 group cursor-pointer">
                    <div class="h-40 bg-gray-100 relative overflow-hidden">
                        <img src="https://picsum.photos/seed/book5/300/200" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-2 right-2 px-2 py-1 rounded text-xs font-medium bg-red-500 text-white">Habis</span>
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2">Artificial Intelligence for Beginners</h4>
                        <p class="text-xs text-gray-500">John Doe</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Script Javascript -->
    <script>
        // Fungsi Konfirmasi Peminjaman
        function confirmBorrow() {
            Swal.fire({
                title: 'Ajukan Peminjaman?',
                text: "Anda akan meminjam 'Pemrograman Web Modern dengan Laravel & Tailwind'.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb', // blue-600
                cancelButtonColor: '#d1d5db', // gray-300
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Simulasi redirect ke halaman create atau submit form
                    Swal.fire(
                        'Berhasil!',
                        'Silakan lengkapi tanggal peminjaman pada form selanjutnya.',
                        'success'
                    ).then(() => {
                        // Di Blade asli, kamu gunakan: window.location.href = "{{ route('peminjam.peminjaman.create', $buku->id) }}";
                        console.log("Redirecting to borrowing form...");
                    });
                }
            })
        }

        // Fungsi Toast Simpan (Hanya visual feedback)
        function showDetailToast() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'info',
                title: 'Buku disimpan ke favorit'
            })
        }
    </script>
</body>
</html>
    <!-- SweetAlert2 (Sesuai kode yang kamu gunakan sebelumnya) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* bg-gray-100 */
        }
        /* Line clamp untuk sinopsis agar rapi */
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body>

    <!-- Navbar Mockup (Untuk keperluan demo visual saja) -->
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-blue-600">Perpustakaan</span>
                </div>
                <div class="flex items-center">
                    <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">P</div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="#" class="hover:text-blue-600">Home</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="#" class="hover:text-blue-600">Katalog Buku</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="font-medium text-gray-800">Detail Buku</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Tombol Kembali -->
        <a href="#" onclick="history.back()" class="inline-flex items-center text-gray-500 hover:text-blue-600 mb-6 transition">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Katalog
        </a>

        <!-- Bagian Utama Detail Buku -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-0">
                
                <!-- Kolom Kiri: Cover Buku (4/12) -->
                <div class="md:col-span-4 bg-gray-50 p-8 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-200">
                    <div class="relative w-64 h-96 shadow-xl rounded-lg overflow-hidden group">
                        <!-- Placeholder Cover Image -->
                        <img src="https://picsum.photos/seed/bookcover1/400/600" alt="Cover Buku" class="w-full h-full object-cover">
                        
                        <!-- Badge Stok (Sama seperti halaman index) -->
                        <span class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-bold shadow-sm bg-green-500 text-white">
                            Tersedia
                        </span>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-500">ISBN</p>
                        <p class="font-mono font-medium text-gray-700">978-623-02-1234-5</p>
                    </div>
                </div>

                <!-- Kolom Kanan: Informasi Buku (8/12) -->
                <div class="md:col-span-8 p-8 flex flex-col">
                    
                    <!-- Header Info -->
                    <div class="mb-6 border-b border-gray-100 pb-4">
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded">Teknologi</span>
                            <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded">Best Seller</span>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Pemrograman Web Modern dengan Laravel & Tailwind</h1>
                        <p class="text-lg text-gray-600">oleh <span class="font-medium text-gray-900">Budi Santoso, S.Kom</span></p>
                    </div>

                    <!-- Grid Metadata -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 mb-6">
                        <div class="flex items-start">
                            <div class="shrink-0 w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Penerbit</p>
                                <p class="text-sm font-medium text-gray-900">Informatika Bandung</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="shrink-0 w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Tahun Terbit</p>
                                <p class="text-sm font-medium text-gray-900">2023</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="shrink-0 w-8 h-8 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Halaman</p>
                                <p class="text-sm font-medium text-gray-900">450 Halaman</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="shrink-0 w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Bahasa</p>
                                <p class="text-sm font-medium text-gray-900">Indonesia</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sinopsis -->
                    <div class="mb-auto">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Sinopsis</h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-4">
                            Buku ini membahas secara mendalam tentang pengembangan aplikasi web modern menggunakan framework Laravel dan utility-first CSS Tailwind. Cocok untuk pemula hingga developer tingkat lanjut. Membahas konsep MVC, Eloquent ORM, Authentication, hingga deployment ke server produksi. Dilengkapi dengan studi kasus aplikasi perpustakaan digital yang realistis.
                        </p>
                    </div>

                    <!-- Status & Aksi -->
                    <div class="mt-6 pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-center sm:text-left">
                            <p class="text-sm text-gray-500">Sisa Stok</p>
                            <p class="text-xl font-bold text-green-600">5 Buku</p>
                            <p class="text-xs text-gray-400">Maksimal peminjaman: <strong>14 Hari</strong></p>
                        </div>
                        
                        <div class="flex gap-3 w-full sm:w-auto">
                            <a href="#" onclick="showDetailToast()" class="flex-1 sm:flex-none text-center border border-gray-300 hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-lg transition text-sm font-semibold">
                                Simpan
                            </a>
                            <button onclick="confirmBorrow()" class="flex-1 sm:flex-none text-center bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 text-sm font-semibold flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Ajukan Peminjaman
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rekomendasi Buku Lainnya -->
        <div class="mt-10">
            <h2 class="text-xl font-bold text-gray-800 mb-5 flex items-center">
                <span class="w-1 h-6 bg-blue-500 rounded-full mr-3"></span>
                Buku Terkait
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Card 1 -->
                <div class="bg-white border border-gray-100 rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300 group cursor-pointer">
                    <div class="h-40 bg-gray-100 relative overflow-hidden">
                        <img src="https://picsum.photos/seed/book2/300/200" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-2 right-2 px-2 py-1 rounded text-xs font-medium bg-green-500 text-white">Stok: 2</span>
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2">Belajar Dasar-Dasar HTML & CSS</h4>
                        <p class="text-xs text-gray-500">Rina Wijaya</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white border border-gray-100 rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300 group cursor-pointer">
                    <div class="h-40 bg-gray-100 relative overflow-hidden">
                        <img src="https://picsum.photos/seed/book3/300/200" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-2 right-2 px-2 py-1 rounded text-xs font-medium bg-yellow-500 text-white">Stok: 1</span>
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2">Algoritma dan Pemrograman</h4>
                        <p class="text-xs text-gray-500">Andi Saputra</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white border border-gray-100 rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300 group cursor-pointer">
                    <div class="h-40 bg-gray-100 relative overflow-hidden">
                        <img src="https://picsum.photos/seed/book4/300/200" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-2 right-2 px-2 py-1 rounded text-xs font-medium bg-green-500 text-white">Stok: 8</span>
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2">Database Management System</h4>
                        <p class="text-xs text-gray-500">Cantika Putri</p>
                    </div>
                </div>

                 <!-- Card 4 -->
                 <div class="bg-white border border-gray-100 rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300 group cursor-pointer">
                    <div class="h-40 bg-gray-100 relative overflow-hidden">
                        <img src="https://picsum.photos/seed/book5/300/200" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-2 right-2 px-2 py-1 rounded text-xs font-medium bg-red-500 text-white">Habis</span>
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2">Artificial Intelligence for Beginners</h4>
                        <p class="text-xs text-gray-500">John Doe</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Script Javascript -->
    <script>
        // Fungsi Konfirmasi Peminjaman
        function confirmBorrow() {
            Swal.fire({
                title: 'Ajukan Peminjaman?',
                text: "Anda akan meminjam 'Pemrograman Web Modern dengan Laravel & Tailwind'.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb', // blue-600
                cancelButtonColor: '#d1d5db', // gray-300
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Simulasi redirect ke halaman create atau submit form
                    Swal.fire(
                        'Berhasil!',
                        'Silakan lengkapi tanggal peminjaman pada form selanjutnya.',
                        'success'
                    ).then(() => {
                        // Di Blade asli, kamu gunakan: window.location.href = "{{ route('peminjam.peminjaman.create', $buku->id) }}";
                        console.log("Redirecting to borrowing form...");
                    });
                }
            })
        }

        // Fungsi Toast Simpan (Hanya visual feedback)
        function showDetailToast() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'info',
                title: 'Buku disimpan ke favorit'
            })
        }
    </script>
</body>
</html>