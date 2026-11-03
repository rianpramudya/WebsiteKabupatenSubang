<?php

namespace App\Models;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penghargaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kecamatan_id',
        'perangkat_daerah_id',
        'nama_penghargaan',
        'tahun',
        'tingkat',
        'instansi_pemberi',
    ];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function perangkatDaerah(): BelongsTo
    {
        return $this->belongsTo(PerangkatDaerah::class, 'perangkat_daerah_id');
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }
}