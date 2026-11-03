<?php

namespace App\Models;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjekWisata extends Model
{
    use HasFactory;

    protected $table = 'objek_wisatas';

    protected $fillable = [
        'kecamatan_id',
        'nama',
        'slug',
        'kategori',
        'deskripsi_singkat',
        'gambar',
        'lokasi_teks',
        'google_maps_url',
        'is_unggulan',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }

    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class);
    }

}
