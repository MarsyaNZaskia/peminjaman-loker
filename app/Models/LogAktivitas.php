<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';

    protected $fillable = [
        'user_id',
        'aksi',
        'model',
        'model_id',
        'keterangan',
        'ip_address',
        'user_agent',
    ];

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Helper: Catat aktivitas
    public static function catat(string $aksi, ?string $model = null, ?int $modelId = null, ?string $keterangan = null)
    {
        return self::create([
            'user_id' => Auth::id(),
            'aksi' => $aksi,
            'model' => $model,
            'model_id' => $modelId,
            'keterangan' => $keterangan,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
