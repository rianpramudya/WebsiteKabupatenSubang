<?php

namespace App\Models;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Galeri extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'kecamatan_id',
        'perangkat_daerah_id',
        'judul',
        'tipe',
        'file_url',
    ];

    /**
     * Mendefinisikan relasi "milik" ke model Kecamatan.
     * Setiap item Galeri dimiliki oleh satu Kecamatan.
     */
    public function kecamatan(): BelongsTo
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