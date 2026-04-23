<?php

namespace App\Imports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BukuImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Buku([
            'kode_buku' => $row['kode_buku'],
            'judul' => $row['judul'],
            'pengarang' => $row['pengarang'],
            'penerbit' => $row['penerbit'],
            'tahun_terbit' => $row['tahun_terbit'],
            'kategori_buku' => $row['kategori_buku'],
            'jumlah_halaman' => $row['jumlah_halaman'],
            'stok' => $row['stok'],
            'deskripsi' => $row['deskripsi'] ?? null,
        ]);
    }
}
