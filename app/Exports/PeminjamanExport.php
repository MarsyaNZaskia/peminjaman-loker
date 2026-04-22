<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Request;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $status;
    protected $tanggalDari;
    protected $tanggalSampai;

    public function __construct($status = null, $tanggalDari = null, $tanggalSampai = null)
    {
        $this->status = $status;
        $this->tanggalDari = $tanggalDari;
        $this->tanggalSampai = $tanggalSampai;
    }

    public function collection()
    {
        $query = Peminjaman::with(['user', 'buku', 'petugas']);
        
        // Filter berdasarkan status
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        // Filter berdasarkan tanggal
        if ($this->tanggalDari && $this->tanggalSampai) {
            $query->whereBetween('tanggal_pinjam', [$this->tanggalDari, $this->tanggalSampai]);
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Peminjam',
            'Username',
            'Kategori',
            'Kode Buku',
            'Judul',
            'Pengarang',
            'Tanggal Pinjam',
            'Tanggal Rencana Kembali',
            'Status',
            'Disetujui Oleh',
            'Keperluan',
            'Catatan Petugas',
        ];
    }

    public function map($peminjaman): array
    {
        static $no = 0;
        $no++;
        
        return [
            $no,
            $peminjaman->user->name,
            $peminjaman->user->username,
            $peminjaman->user->kategori->nama_kategori ?? '-',
            $peminjaman->buku->kode_buku,
            $peminjaman->buku->judul,
            $peminjaman->buku->pengarang,
            $peminjaman->tanggal_pinjam->format('d/m/Y'),
            $peminjaman->tanggal_kembali_rencana->format('d/m/Y'),
            ucfirst($peminjaman->status),
            $peminjaman->petugas->name ?? '-',
            $peminjaman->keperluan,
            $peminjaman->catatan_petugas ?? '-',
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
        return 'Data Peminjaman';
    }
}