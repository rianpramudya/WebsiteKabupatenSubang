<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne; // <-- DITAMBAHKAN
use Illuminate\Database\Eloquent\Relations\HasManyThrough; // <-- DITAMBAHKAN
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Kecamatan extends Model
{
    use HasFactory;

    /**
     * Field yang dapat diisi massal.
     */
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'banner_url',
        'banner_type',
        'sejarah',
        'arti_lambang',
        'sejarah_img_1',
        'sejarah_img_2',
        'sejarah_img_3',
        'visi',
        'misi',
        'peta_url',
        'letak_geografis',
        'iklim',
        'demografi',
        'topografi',
        'telepon',
        'email',
        'alamat',
        'link_facebook',
        'link_twitter',
        'link_youtube',
        'link_instagram',
    ];

    /**
     * Implicit route model binding menggunakan kolom 'slug'.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // =================================================================
    // RELASI DATABASE
    // =================================================================

    /**
     * Relasi satu-ke-satu dari Kecamatan ke Tenant.
     */
    public function tenant(): HasOne
    {
        return $this->hasOne(Tenant::class);
    }

    /**
     * Relasi untuk mendapatkan LaporanKeuangan melalui Tenant.
     * Ini menggantikan relasi hasMany yang lama.
     */
    public function laporanKeuangans(): HasManyThrough
    {
        return $this->hasManyThrough(LaporanKeuangan::class, Tenant::class);
    }

    public function beritas(): HasMany
    {
        return $this->hasMany(Berita::class);
    }

    public function agendas(): HasMany
    {
        return $this->hasMany(Agenda::class);
    }

    public function galeris(): HasMany
    {
        return $this->hasMany(Galeri::class);
    }

    public function layanans(): HasMany
    {
        return $this->hasMany(Layanan::class);
    }

    public function sejarahs(): HasMany
    {
        return $this->hasMany(Sejarah::class);
    }

    public function penghargaans(): HasMany
    {
        return $this->hasMany(Penghargaan::class, 'tenant_id');
    }

    public function wilayahAdministrasi(): HasMany
    {
        return $this->hasMany(WilayahAdministrasi::class);
    }

    public function infografis(): HasMany
    {
        return $this->hasMany(Infografis::class);
    }

    public function pejabats(): HasMany
    {
        return $this->hasMany(Pejabat::class);
    }

    public function budayas(): HasMany
    {
        return $this->hasMany(Budaya::class);
    }

    public function objekWisatas(): HasMany
    {
        return $this->hasMany(ObjekWisata::class);
    }

    public function hotels(): HasMany
    {
        return $this->hasMany(Hotel::class);
    }

    public function rumahMakans(): HasMany
    {
        return $this->hasMany(RumahMakan::class);
    }

    public function peranPrograms()
    {
        return $this->hasMany(PeranDanProgram::class);
    }

    public function scopeNotKabupatenSubang($query)
    {
        return $query->where('slug', '!=', 'kabupaten-subang');
    }

    // =================================================================
    // ACCESSOR & MUTATOR
    // =================================================================

    /**
     * URL logo kecamatan (mendukung URL eksternal & storage).
     */
    public function getLogoUrlAttribute(): string
    {
        if ($this->logo && Str::startsWith($this->logo, ['http://', 'https://'])) {
            return $this->logo;
        }
        if ($this->logo && Storage::disk('public')->exists($this->logo)) {
            return asset('storage/' . ltrim($this->logo, '/'));
        }
        return 'https://placehold.co/100x100/e2e8f0/64748b?text=Logo';
    }

    /**
     * Menentukan tipe banner: image_default, youtube, video_file, image_file.
     */
    public function getBannerTypeAttribute(): string
    {
        $banner = $this->banner_url;
        if (!$banner || trim($banner) === '') {
            return 'image_default';
        }
        if (Str::contains($banner, ['youtube.com/watch', 'youtu.be/', 'youtube.com/embed', 'youtube.com/shorts'])) {
            return 'youtube';
        }
        if (Str::endsWith(Str::lower($banner), ['.mp4', '.webm', '.ogv'])) {
            return 'video_file';
        }
        return 'image_file';
    }


    /**
     * Mengambil ID video YouTube dari banner_url (jika tipe youtube).
     */
    public function getYoutubeVideoIdAttribute(): ?string
    {
        if ($this->banner_type !== 'youtube') {
            return null;
        }
        $pattern = '/(?:v=|\/embed\/|\.be\/|watch\?v=|\/shorts\/)([a-zA-Z0-9_-]{11})/';
        preg_match($pattern, (string) $this->banner_url, $matches);
        return $matches[1] ?? null;
    }

    // =================================================================
    // EVENTS (opsional) – auto generate slug
    // =================================================================

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->slug) && !empty($model->name)) {
                $model->slug = Str::slug($model->name);
            }
        });
        static::updating(function (self $model) {
            if (empty($model->slug) && !empty($model->name)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
}
