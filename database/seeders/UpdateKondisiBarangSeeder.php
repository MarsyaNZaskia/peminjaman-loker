<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateKondisiBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update kondisi_barang lama dari rusak_ringan/rusak_berat jadi rusak
        DB::table('pengembalian')
            ->whereIn('kondisi_barang', ['rusak_ringan', 'rusak_berat'])
            ->update(['kondisi_barang' => 'rusak']);

        $this->command->info('Updated kondisi_barang from rusak_ringan/rusak_berat to rusak');
    }
}
