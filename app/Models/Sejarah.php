<?php

namespace App\Models;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sejarah extends Model
{
    use HasFactory;

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

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }

    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class);
    }

}
