<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Tambah kolom baru
            $table->date('tanggal_kembali_rencana')->after('tanggal_pinjam');
            
            // Hapus kolom tanggal_kembali (pindah ke tabel pengembalian)
            $table->dropColumn('tanggal_kembali');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn('tanggal_kembali_rencana');
            $table->date('tanggal_kembali')->nullable();
        });
    }
};
