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
        'jenis_denda',
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
    public function hitungKeterlambatan(): int
    {
        $tanggalRencana = $this->peminjaman->tanggal_kembali_rencana;
        $tanggalRealisasi = $this->tgl_kembali_realisasi;
        
        if ($tanggalRealisasi > $tanggalRencana) {
            return $tanggalRealisasi->diffInDays($tanggalRencana);
        }
        
        return 0;
    }
}
