<?php

namespace App\Models;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agenda extends Model
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
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function perangkatDaerah(): BelongsTo
    {

        return $this->belongsTo(PerangkatDaerah::class, 'perangkat_daerah_id');
    }
}