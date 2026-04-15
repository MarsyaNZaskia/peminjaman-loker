<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';

    protected $fillable = [
        'user_id',
        'peminjaman_id',
        'tgl_kembali_realisasi',
        'total_denda',
        'kondisi_barang',
        'catatan',
    ];

    protected $casts = [
        'tgl_kembali_realisasi' => 'date',
    ];

    // Relasi ke User (petugas yang catat pengembalian)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Peminjaman
    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class);
    }

    // Helper: Hitung keterlambatan
    // Terlambat jika tanggal pengembalian aktual > tanggal rencana kembali
    public function hitungKeterlambatan(): int
    {
        if (!$this->tgl_kembali_realisasi || !$this->peminjaman || !$this->peminjaman->tanggal_kembali_rencana) {
            return 0;
        }

        $tanggalRencana = $this->peminjaman->tanggal_kembali_rencana;
        $tanggalRealisasi = $this->tgl_kembali_realisasi;

        // Perbandingan tanggal: Jika realisasi > rencana, maka terlambat
        if ($tanggalRealisasi->gt($tanggalRencana)) {
            return (int) $tanggalRealisasi->diffInDays($tanggalRencana);
        }

        return 0;
    }
}
