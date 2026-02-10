<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Kelas 10', 'keterangan' => 'Siswa Kelas 10'],
            ['nama_kategori' => 'Kelas 11', 'keterangan' => 'Siswa Kelas 11'],
            ['nama_kategori' => 'Kelas 12', 'keterangan' => 'Siswa Kelas 12'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}
