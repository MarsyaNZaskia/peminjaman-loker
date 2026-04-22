<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BukuExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $status;

    public function __construct($status = null)
    {
        $this->status = $status;
    }

    public function collection()
    {
        $query = Buku::query();
        
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Buku',
            'Judul',
            'Pengarang',
            'Penerbit',
            'Tahun Terbit',
            'Kategori',
            'Jumlah Halaman',
            'Stok',
            'Status',
            'Deskripsi',
        ];
    }

    public function map($buku): array
    {
        static $no = 0;
        $no++;
        
        return [
            $no,
            $buku->kode_buku,
            $buku->judul,
            $buku->pengarang,
            $buku->penerbit ?? '-',
            $buku->tahun_terbit ?? '-',
            $buku->kategori_buku ?? '-',
            $buku->jumlah_halaman ?? '-',
            $buku->stok,
            ucfirst($buku->status),
            $buku->deskripsi ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Data Buku';
    }
}
