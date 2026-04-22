<?php

namespace App\Exports;

use App\Models\Pengembalian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PengembalianExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $tanggalDari;
    protected $tanggalSampai;

    public function __construct($tanggalDari = null, $tanggalSampai = null)
    {
        $this->tanggalDari = $tanggalDari;
        $this->tanggalSampai = $tanggalSampai;
    }

    public function collection()
    {
        $query = Pengembalian::with(['peminjaman.user', 'peminjaman.buku', 'user']);
        
        // Filter berdasarkan tanggal
        if ($this->tanggalDari && $this->tanggalSampai) {
            $query->whereBetween('tgl_kembali_realisasi', [$this->tanggalDari, $this->tanggalSampai]);
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Peminjam',
            'Kode Buku',
            'Judul',
            'Pengarang',
            'Tanggal Pinjam',
            'Tanggal Rencana Kembali',
            'Tanggal Kembali Aktual',
            'Keterangan Waktu',
            'Kondisi Barang',
            'Total Denda (Rp)',
            'Dicatat Oleh',
            'Catatan',
        ];
    }

    public function map($pengembalian): array
    {
        static $no = 0;
        $no++;
        
        $keterlambatan = $pengembalian->hitungKeterlambatan();
        
        // Keterangan waktu hanya untuk kondisi baik
        $keteranganWaktu = '-';
        if ($pengembalian->kondisi_barang === 'baik') {
            $keteranganWaktu = $keterlambatan > 0 ? 'Terlambat' : 'Tepat Waktu';
        }
        
        return [
            $no,
            $pengembalian->peminjaman->user->name,
            $pengembalian->peminjaman->buku->kode_buku,
            $pengembalian->peminjaman->buku->judul,
            $pengembalian->peminjaman->buku->pengarang,
            $pengembalian->peminjaman->tanggal_pinjam->format('d/m/Y'),
            $pengembalian->peminjaman->tanggal_kembali_rencana->format('d/m/Y'),
            $pengembalian->tgl_kembali_realisasi->format('d/m/Y'),
            $keteranganWaktu,
            ucfirst(str_replace('_', ' ', $pengembalian->kondisi_barang)),
            $pengembalian->total_denda,
            $pengembalian->user->name,
            $pengembalian->catatan ?? '-',
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
        return 'Data Pengembalian';
    }
}