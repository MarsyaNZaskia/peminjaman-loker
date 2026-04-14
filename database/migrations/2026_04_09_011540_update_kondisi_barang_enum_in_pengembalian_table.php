<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update enum values untuk kondisi_barang
        DB::statement("ALTER TABLE pengembalian MODIFY COLUMN kondisi_barang ENUM('baik', 'rusak', 'hilang') DEFAULT 'baik'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert ke enum lama
        DB::statement("ALTER TABLE pengembalian MODIFY COLUMN kondisi_barang ENUM('baik', 'rusak_ringan', 'rusak_berat', 'hilang') DEFAULT 'baik'");
    }
};
