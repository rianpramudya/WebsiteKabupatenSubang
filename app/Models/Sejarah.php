<?php

namespace App\Models;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sejarah extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'sejarahs';

    protected $fillable = [
        'kecamatan_id',
        'perangkat_daerah_id',
        'tahun',
        'judul',
        'deskripsi',
        'urutan',
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
