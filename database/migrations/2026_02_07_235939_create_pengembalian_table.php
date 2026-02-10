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
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User yang mengembalikan (petugas)
            $table->foreignId('peminjaman_id')->constrained('peminjaman')->onDelete('cascade');
            $table->date('tgl_kembali_realisasi'); // Tanggal pengembalian actual
            $table->enum('jenis_denda', ['tidak_ada', 'telat', 'rusak', 'hilang'])->default('tidak_ada');
            $table->integer('total_denda')->default(0); // Dalam rupiah
            $table->enum('kondisi_barang', ['baik', 'rusak_ringan', 'rusak_berat', 'hilang'])->default('baik');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
