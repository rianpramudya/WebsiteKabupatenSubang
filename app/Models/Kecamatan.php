<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'peta_url',
        'sejarah',
        'arti_lambang',
        'sejarah_img_1',
        'sejarah_img_2',
        'sejarah_img_3',
        'visi',
        'misi',
    ];

    /**
     * PERUBAHAN UTAMA DI SINI:
     * Nama relasi diubah dari desas() menjadi perangkatDaerahs().
     * Ini mendefinisikan bahwa satu Kecamatan memiliki banyak PerangkatDaerah.
     */
    public function perangkatDaerahs()
    {
        // Laravel secara otomatis akan mencari model bernama PerangkatDaerah
        return $this->hasMany(PerangkatDaerah::class);
    }

    public function sejarahItems()
    {
        // Nama relasi diubah menjadi sejarahItems untuk menghindari konflik
        return $this->hasMany(Sejarah::class)->orderBy('urutan');
    }

    public function budayas()
    {
        return $this->hasMany(Budaya::class);
    }

    public function objekWisatas()
    {
        return $this->hasMany(ObjekWisata::class);
    }

    public function infografis()
    {
        return $this->hasMany(Infografis::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }

    public function rumahMakans()
    {
        return $this->hasMany(RumahMakan::class);
    }
}
