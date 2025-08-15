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
        'perangkat_daerah_id', // <-- TAMBAHKAN BARIS INI
        'judul',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    /**
     * Terapkan global scope Tenant untuk admin-kecamatan.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }

    /**
     * Mendefinisikan relasi "milik" ke model Kecamatan.
     * Setiap Agenda dimiliki oleh satu Kecamatan.
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }

    /**
     * Relasi ke PerangkatDaerah (jika agenda ini milik perangkat daerah).
     */
    public function perangkatDaerah(): BelongsTo
    {
        // Menambahkan tipe return BelongsTo untuk konsistensi
        return $this->belongsTo(PerangkatDaerah::class, 'perangkat_daerah_id');
    }
}