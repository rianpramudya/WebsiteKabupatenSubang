<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- TAMBAHKAN INI
use Illuminate\Database\Eloquent\Relations\HasMany;   // <-- TAMBAHKAN INI

class Tenant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kecamatan_id', // <-- Pastikan ini ada di fillable
        'name',
        'slug',
        'subdomain',
        'status',
    ];

    /**
     * Relasi bahwa Tenant ini milik satu Kecamatan.
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }

    /**
     * Relasi bahwa satu Tenant memiliki banyak LaporanKeuangan.
     */
    public function laporanKeuangans(): HasMany
    {
        return $this->hasMany(LaporanKeuangan::class);
    }

    /**
     * Relasi ke PerangkatDaerah (jika berita ini milik perangkat daerah).
     */
    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class);
    }
    // --------------------------------
}