<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Buku;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bukus = [
            [
                'kode_buku' => 'BK001',
                'judul' => 'Laskar Pelangi',
                'pengarang' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun_terbit' => 2005,
                'kategori_buku' => 'Fiksi',
                'jumlah_halaman' => 529,
                'stok' => 3,
                'status' => 'tersedia',
                'deskripsi' => 'Kisah inspiratif tentang anak-anak miskin di Belitung',
            ],
            [
                'kode_buku' => 'BK002',
                'judul' => 'Harry Potter and the Philosopher\'s Stone',
                'pengarang' => 'J.K. Rowling',
                'penerbit' => 'Bloomsbury',
                'tahun_terbit' => 1997,
                'kategori_buku' => 'Fantasy',
                'jumlah_halaman' => 309,
                'stok' => 5,
                'status' => 'tersedia',
                'deskripsi' => 'Petualangan awal Harry Potter di Hogwarts',
            ],
            [
                'kode_buku' => 'BK003',
                'judul' => 'The Lord of the Rings',
                'pengarang' => 'J.R.R. Tolkien',
                'penerbit' => 'Allen & Unwin',
                'tahun_terbit' => 1954,
                'kategori_buku' => 'Fantasy',
                'jumlah_halaman' => 1178,
                'stok' => 2,
                'status' => 'tersedia',
                'deskripsi' => 'Epik fantasi tentang pertempuran melawan kegelapan',
            ],
            [
                'kode_buku' => 'BK004',
                'judul' => 'Bumi',
                'pengarang' => 'Tere Liye',
                'penerbit' => 'Gramedia Pustaka Utama',
                'tahun_terbit' => 2014,
                'kategori_buku' => 'Fiksi Ilmiah',
                'jumlah_halaman' => 376,
                'stok' => 4,
                'status' => 'tersedia',
                'deskripsi' => 'Seri Dunia Paralel pertama dengan dunia penuh misteri',
            ],
            [
                'kode_buku' => 'BK005',
                'judul' => 'Sapiens',
                'pengarang' => 'Yuval Noah Harari',
                'penerbit' => 'Harper',
                'tahun_terbit' => 2011,
                'kategori_buku' => 'Non-Fiksi',
                'jumlah_halaman' => 443,
                'stok' => 3,
                'status' => 'tersedia',
                'deskripsi' => 'Sejarah singkat umat manusia dari zaman kuno hingga modern',
            ],
            [
                'kode_buku' => 'BK006',
                'judul' => 'Perahu Kertas',
                'pengarang' => 'Dee',
                'penerbit' => 'Grasindo',
                'tahun_terbit' => 2008,
                'kategori_buku' => 'Fiksi Remaja',
                'jumlah_halaman' => 198,
                'stok' => 2,
                'status' => 'tersedia',
                'deskripsi' => 'Cerita cinta yang indah diantara dua remaja yang berbeda status sosial',
            ],
            [
                'kode_buku' => 'BK007',
                'judul' => 'Filosofi Teras',
                'pengarang' => 'Henry Manampiring',
                'penerbit' => 'Kompas',
                'tahun_terbit' => 2017,
                'kategori_buku' => 'Filsafat',
                'jumlah_halaman' => 272,
                'stok' => 1,
                'status' => 'tersedia',
                'deskripsi' => 'Pengantar filosofi Stoa untuk kehidupan modern',
            ],
            [
                'kode_buku' => 'BK008',
                'judul' => 'The Hobbit',
                'pengarang' => 'J.R.R. Tolkien',
                'penerbit' => 'Allen & Unwin',
                'tahun_terbit' => 1937,
                'kategori_buku' => 'Fantasy',
                'jumlah_halaman' => 310,
                'stok' => 3,
                'status' => 'tersedia',
                'deskripsi' => 'Petualangan Bilbo Baggins sebelum Cincin Satu ditemukan',
            ],
            [
                'kode_buku' => 'BK009',
                'judul' => 'Rantau 1 Muara',
                'pengarang' => 'Ahda Imran',
                'penerbit' => 'Gramedia Pustaka Utama',
                'tahun_terbit' => 2019,
                'kategori_buku' => 'Fiksi',
                'jumlah_halaman' => 336,
                'stok' => 2,
                'status' => 'tersedia',
                'deskripsi' => 'Kisah seorang anak muda yang merantau untuk mencari jati diri',
            ],
            [
                'kode_buku' => 'BK010',
                'judul' => '1984',
                'pengarang' => 'George Orwell',
                'penerbit' => 'Secker & Warburg',
                'tahun_terbit' => 1949,
                'kategori_buku' => 'Distopia',
                'jumlah_halaman' => 328,
                'stok' => 1,
                'status' => 'tersedia',
                'deskripsi' => 'Novel distopia tentang negara totaliter yang menakutkan',
            ],
        ];

        foreach ($bukus as $buku) {
            Buku::create($buku);
        }
    }
}
