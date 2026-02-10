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
        $query = Pengembalian::with(['peminjaman.user', 'peminjaman.loker', 'user']);
        
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
            'Nomor Loker',
            'Lokasi Loker',
            'Tanggal Pinjam',
            'Tanggal Rencana Kembali',
            'Tanggal Kembali Aktual',
            'Keterlambatan (Hari)',
            'Kondisi Barang',
            'Jenis Denda',
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
        
        return [
            $no,
            $pengembalian->peminjaman->user->name,
            $pengembalian->peminjaman->loker->nomor_loker,
            $pengembalian->peminjaman->loker->lokasi,
            $pengembalian->peminjaman->tanggal_pinjam->format('d/m/Y'),
            $pengembalian->peminjaman->tanggal_kembali_rencana->format('d/m/Y'),
            $pengembalian->tgl_kembali_realisasi->format('d/m/Y'),
            $keterlambatan > 0 ? $keterlambatan . ' hari' : 'Tepat Waktu',
            ucfirst(str_replace('_', ' ', $pengembalian->kondisi_barang)),
            ucfirst(str_replace('_', ' ', $pengembalian->jenis_denda)),
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