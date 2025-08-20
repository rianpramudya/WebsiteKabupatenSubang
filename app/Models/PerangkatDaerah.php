<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PerangkatDaerah extends Model
{
    use HasFactory;

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
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // --- RELASI DATABASE ---

    public function sejarahs(): HasMany
    {
        return $this->hasMany(Sejarah::class, 'perangkat_daerah_id', 'id');
    }

    public function penghargaans(): HasMany
    {
        return $this->hasMany(Penghargaan::class, 'perangkat_daerah_id');
    }

    public function wilayahAdministrasi(): HasMany
    {
        return $this->hasMany(WilayahAdministrasi::class, 'perangkat_daerah_id', 'id');
    }

    public function beritas(): HasMany
    {
        return $this->hasMany(Berita::class, 'perangkat_daerah_id');
    }

    public function agendas(): HasMany
    {
        return $this->hasMany(Agenda::class, 'perangkat_daerah_id');
    }

    public function galeris(): HasMany
    {
        return $this->hasMany(Galeri::class, 'perangkat_daerah_id');
    }

    public function layanans(): HasMany
    {
        return $this->hasMany(Layanan::class, 'perangkat_daerah_id');
    }

    public function infografis(): HasMany
    {
        return $this->hasMany(Infografis::class, 'perangkat_daerah_id');
    }

    public function pejabats(): HasMany
    {
        return $this->hasMany(Pejabat::class, 'perangkat_daerah_id');
    }

    public function wilayahAdministrasis(): HasMany
    {
        return $this->hasMany(WilayahAdministrasi::class, 'perangkat_daerah_id');
    }

    public function laporanKeuangans(): HasMany
    {
        return $this->hasMany(LaporanKeuangan::class, 'perangkat_daerah_id');
    }


    public function peranPrograms(): HasMany
    {
        return $this->hasMany(PeranDanProgram::class, 'perangkat_daerah_id');
    }

    // ======================================================

    // --- ACCESSOR & MUTATOR ---
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

    public function getYoutubeVideoIdAttribute(): ?string
    {
        if ($this->getBannerTypeAttribute() !== 'youtube') {
            return null;
        }
        $pattern = '/(?:v=|\/embed\/|\.be\/|watch\?v=|\/shorts\/)([a-zA-Z0-9_-]{11})/';
        preg_match($pattern, (string) $this->banner_url, $matches);
        return $matches[1] ?? null;
    }

    // --- EVENTS ---
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
