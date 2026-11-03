<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kecamatan_id',
        'name',
        'slug',
        'subdomain',
        'status',
    ];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function laporanKeuangans(): HasMany
    {
        return $this->hasMany(LaporanKeuangan::class);
    }

    public function perangkatDaerah()
    {
        return $this->belongsTo(PerangkatDaerah::class);
    }

}