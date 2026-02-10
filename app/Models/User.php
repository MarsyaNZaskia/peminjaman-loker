<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;  
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
    
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function peminjamanDisetujui(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'approved_by');
    }

    public function pengembalian(): HasMany
    {
        return $this->hasMany(Pengembalian::class);
    }

    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'kategori_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

     // Helper methods untuk cek role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPetugas()
    {
        return $this->role === 'petugas';
    }

    public function isPeminjam()
    {
        return $this->role === 'peminjam';
    }

    
}
