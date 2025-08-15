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

    /**
     * Mendefinisikan relasi bahwa setiap wilayah administrasi
     * dimiliki oleh satu kecamatan.
     */
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
    
}
