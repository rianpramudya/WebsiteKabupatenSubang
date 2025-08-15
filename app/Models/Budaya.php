<?php

namespace App\Models;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budaya extends Model
{
    use HasFactory;

    protected $table = 'budayas';

    protected $fillable = [
        'kecamatan_id',
        'nama',
        'slug',
        'deskripsi',
        'gambar',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    /**
     * Relasi ke PerangkatDaerah (jika berita ini milik perangkat daerah).
     */
    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class);
    }
    // --------------------------------

    /**
 * Terapkan global scope Tenant untuk admin-kecamatan.
 */
/* // <-- Tambahkan komentar di sini
protected static function booted(): void
{
    static::addGlobalScope(new TenantScope);
}
*/ // <-- Dan di sini
}
