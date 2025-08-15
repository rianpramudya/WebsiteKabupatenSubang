<?php

namespace App\Models;

use App\Scopes\TenantScope; // Pastikan scope ini juga sudah diperbaiki
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penghargaan extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * [DISESUAIKAN] - Daftar ini sekarang cocok dengan kolom di file migrasi Anda.
     * Ini adalah langkah paling krusial agar metode ::create() berfungsi.
     */
    protected $fillable = [
        'kecamatan_id',
        'perangkat_daerah_id',
        'nama_penghargaan',
        'tahun',
        'tingkat',
        'instansi_pemberi',
    ];

    /**
     * [DISESUAIKAN] - Relasi ke model Kecamatan.
     * Menggunakan foreign key 'kecamatan_id' yang benar.
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    /**
     * [DISESUAIKAN] - Relasi ke model PerangkatDaerah.
     * Menggunakan foreign key 'perangkat_daerah_id' yang benar.
     */
    public function perangkatDaerah(): BelongsTo
    {
        return $this->belongsTo(PerangkatDaerah::class, 'perangkat_daerah_id');
    }

    /**
     * Terapkan global scope.
     * PERHATIAN: Pastikan file App/Scopes/TenantScope.php juga sudah diperbaiki
     * untuk menggunakan 'kecamatan_id' dan bukan 'tenant_id'.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }
}