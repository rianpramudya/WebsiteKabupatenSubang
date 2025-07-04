<?php

namespace App\Models;

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
}
