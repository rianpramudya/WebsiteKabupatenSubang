<?php

namespace App\Models;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pejabat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * Menggunakan $fillable lebih disarankan karena secara eksplisit mendefinisikan
     * field mana saja yang boleh diisi, ini mencegah kerentanan Mass Assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'jabatan',
        'urutan',
        'foto',
        'kecamatan_id',
        'tenant_id',
        'perangkat_daerah_id'
    ];

    /**
     * The "booted" method of the model.
     * Menerapkan Global Scope untuk multi-tenancy.
     *
     * @return void
     */
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
