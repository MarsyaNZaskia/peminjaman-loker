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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Peminjam
            $table->foreignId('loker_id')->constrained()->onDelete('cascade'); // Loker yang dipinjam
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null'); // Petugas yang approve
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'selesai'])->default('pending');
            $table->text('keperluan')->nullable(); // Alasan peminjaman
            $table->text('catatan_petugas')->nullable(); // Catatan dari petugas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
