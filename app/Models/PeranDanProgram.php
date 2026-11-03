<?php

namespace App\Models;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeranDanProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'kecamatan_id',
        'perangkat_daerah_id',
        'judul',
        'deskripsi',
        'urutan',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new TenantScope);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class);
    }
}