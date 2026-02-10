<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'loker_id',
        'approved_by',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'status',
        'keperluan',
        'catatan_petugas',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
    ];

    // Relasi ke User (Peminjam)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Loker
    public function loker(): BelongsTo
    {
        return $this->belongsTo(Loker::class);
    }

    // Relasi ke User (Petugas yang approve)
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Helper methods
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isDisetujui(): bool
    {
        return $this->status === 'disetujui';
    }

    public function isDitolak(): bool
    {
        return $this->status === 'ditolak';
    }

    public function isSelesai(): bool
    {
        return $this->status === 'selesai';
    }

    // Relasi ke Pengembalian
public function pengembalian(): HasOne
{
    return $this->hasOne(Pengembalian::class);
}

// Helper: Cek apakah sudah dikembalikan
public function sudahDikembalikan(): bool
{
    return $this->pengembalian()->exists();
}

public function isTerlambat(): bool
    {
        if (!$this->sudahDikembalikan()) {
            // Belum dikembalikan, cek dari hari ini
            return now()->gt($this->tanggal_kembali_rencana);
        }
        
        // Sudah dikembalikan, cek dari tanggal pengembalian
        return $this->pengembalian->tgl_kembali_realisasi->gt($this->tanggal_kembali_rencana);
    }
}
