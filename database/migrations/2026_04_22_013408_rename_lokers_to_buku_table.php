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
        Schema::rename('lokers', 'buku');

        Schema::table('buku', function (Blueprint $table) {
            $table->renameColumn('nomor_loker', 'kode_buku');
            $table->renameColumn('keterangan', 'deskripsi');
            $table->dropColumn('lokasi', 'ukuran');

            // Add new columns
            $table->string('judul')->after('kode_buku');
            $table->string('pengarang')->after('judul');
            $table->string('penerbit')->nullable()->after('pengarang');
            $table->year('tahun_terbit')->nullable()->after('penerbit');
            $table->string('kategori_buku')->nullable()->after('tahun_terbit');
            $table->integer('jumlah_halaman')->nullable()->after('kategori_buku');
            $table->integer('stok')->default(1)->after('jumlah_halaman');
            $table->string('foto_cover')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            //
        });
    }
};
