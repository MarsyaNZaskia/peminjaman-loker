<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loker extends Model
{
    protected $fillable = [
        'nomor_loker',
        'lokasi',
        'ukuran',
        'status',
        'keterangan',
    ];

    // Relasi ke peminjaman
    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }

    // Helper method cek status
    public function isTersedia(): bool
    {
        return $this->status === 'tersedia';
    }

    public function isPeminjaman(): bool
    {
        return $this->status === 'dipinjam';
    }

    // Get peminjaman aktif
    public function peminjamanAktif()
    {
        return $this->peminjaman()
            ->where('status', 'disetujui')
            ->whereNull('tanggal_kembali')
            ->first();
    }
}
