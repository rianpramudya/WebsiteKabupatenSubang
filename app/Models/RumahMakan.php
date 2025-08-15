<?php

namespace App\Models;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumahMakan extends Model
{
    use HasFactory;

    protected $table = 'rumah_makans';

    protected $fillable = [
        'kecamatan_id',
        'nama',
        'slug',
        'jenis_kuliner',
        'deskripsi',
        'alamat',
        'gambar',
        'telepon',
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
     * Terapkan global scope Tenant untuk admin-kecamatan.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
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
