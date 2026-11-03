<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WilayahAdministrasi extends Model
{
    use HasFactory;

    protected $table = 'wilayah_administrasis';

    protected $fillable = [
        'kecamatan_id',
        'perangkat_daerah_id',
        'nama_desa',
        'kepala_desa',
        'luas_wilayah',
        'jumlah_penduduk',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class);
    }

}
