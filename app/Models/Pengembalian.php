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

    // Helper: Hitung keterlambatan berdasarkan tanggal pengembalian tersimpan
    public function hitungKeterlambatan()
{
    $tglRencana = \Carbon\Carbon::parse($this->peminjaman->tanggal_kembali_rencana);
    $tglRealisasi = \Carbon\Carbon::parse($this->tgl_kembali_realisasi);

    if ($tglRealisasi->gt($tglRencana)) {
        return $tglRencana->diffInDays($tglRealisasi);
    }

    return 0;
}

    // Helper: Ambil denda yang sudah disimpan oleh controller
    public function hitungDenda(): int
    {
        return (int) ($this->total_denda ?? 0);
    }
}
