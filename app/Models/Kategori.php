<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $fillable = [
        'nama_kategori',
        'keterangan',
    ];

    // Relasi ke User
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
