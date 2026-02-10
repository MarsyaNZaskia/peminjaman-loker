<?php

namespace App\Exports;

use App\Models\Loker;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LokerExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $status;

    public function __construct($status = null)
    {
        $this->status = $status;
    }

    public function collection()
    {
        $query = Loker::query();
        
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Loker',
            'Lokasi',
            'Ukuran',
            'Status',
            'Keterangan',
        ];
    }

    public function map($loker): array
    {
        static $no = 0;
        $no++;
        
        return [
            $no,
            $loker->nomor_loker,
            $loker->lokasi,
            ucfirst($loker->ukuran),
            ucfirst($loker->status),
            $loker->keterangan ?? '-',
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
        return 'Data Loker';
    }
}
