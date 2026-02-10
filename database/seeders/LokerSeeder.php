<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Loker;

class LokerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // database/seeders/LokerSeeder.php
        $lokers = [
            // Lantai 1 - Loker Kecil
            ['nomor_loker' => 'L1-001', 'lokasi' => 'Lantai 1', 'ukuran' => 'kecil'],
            ['nomor_loker' => 'L1-002', 'lokasi' => 'Lantai 1', 'ukuran' => 'kecil'],
            ['nomor_loker' => 'L1-003', 'lokasi' => 'Lantai 1', 'ukuran' => 'kecil'],
            ['nomor_loker' => 'L1-004', 'lokasi' => 'Lantai 1', 'ukuran' => 'kecil'],
            ['nomor_loker' => 'L1-005', 'lokasi' => 'Lantai 1', 'ukuran' => 'kecil'],
            
            // Lantai 1 - Loker Sedang
            ['nomor_loker' => 'L1-006', 'lokasi' => 'Lantai 1', 'ukuran' => 'sedang'],
            ['nomor_loker' => 'L1-007', 'lokasi' => 'Lantai 1', 'ukuran' => 'sedang'],
            ['nomor_loker' => 'L1-008', 'lokasi' => 'Lantai 1', 'ukuran' => 'sedang'],
            
            // Lantai 2 - Loker Sedang
            ['nomor_loker' => 'L2-001', 'lokasi' => 'Lantai 2', 'ukuran' => 'sedang'],
            ['nomor_loker' => 'L2-002', 'lokasi' => 'Lantai 2', 'ukuran' => 'sedang'],
            ['nomor_loker' => 'L2-003', 'lokasi' => 'Lantai 2', 'ukuran' => 'sedang'],
            
            // Lantai 2 - Loker Besar
            ['nomor_loker' => 'L2-004', 'lokasi' => 'Lantai 2', 'ukuran' => 'besar'],
            ['nomor_loker' => 'L2-005', 'lokasi' => 'Lantai 2', 'ukuran' => 'besar'],
        ];

        foreach ($lokers as $loker) {
            Loker::create([
                'nomor_loker' => $loker['nomor_loker'],
                'lokasi' => $loker['lokasi'],
                'ukuran' => $loker['ukuran'],
                'status' => 'tersedia',
                'keterangan' => 'Loker dalam kondisi baik',
            ]);
        }
    }

}
