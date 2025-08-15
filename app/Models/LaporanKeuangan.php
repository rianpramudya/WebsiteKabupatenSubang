<?php

namespace App\Models;

use App\Scopes\TenantScope; // <-- 1. Import Scope
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanKeuangan extends Model
{
    use HasFactory;

    /**
     * [PERBAIKAN] Menggunakan kecamatan_id dan perangkat_daerah_id agar konsisten.
     */
    protected $fillable = [
        'kecamatan_id',
        'perangkat_daerah_id',
        'tahun',
        'judul_laporan',
        'jenis_laporan',
        'deskripsi_singkat',
        'file_url',
    ];

    /**
     * [PERBAIKAN] Terapkan TenantScope agar filtering otomatis berjalan.
     */
    protected static function booted()
    {
        static::addGlobalScope(new TenantScope);
    }

    /**
     * [PERBAIKAN] Relasi ke Kecamatan.
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }

    /**
     * Relasi ke PerangkatDaerah.
     */
    public function perangkatDaerah(): BelongsTo
    {
        return $this->belongsTo(PerangkatDaerah::class);
    }
}