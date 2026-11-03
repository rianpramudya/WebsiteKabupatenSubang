<?php

namespace App\Providers;

use App\Models\{
    Kecamatan,
    PerangkatDaerah,
    Berita,
    Layanan,
    Agenda,
    Galeri,
    Pejabat,
    PeranDanProgram,
    Infografis,
    LaporanKeuangan,
    Budaya,
    ObjekWisata,
    Hotel,
    WilayahAdministrasi,
    Sejarah,
    Penghargaan,
    RumahMakan
};

use App\Policies\{
    KecamatanPolicy,
    BeritaPolicy,
    LayananPolicy,
    AgendaPolicy,
    GaleriPolicy,
    PejabatPolicy,
    PeranDanProgramPolicy,
    InfografisPolicy,
    LaporanKeuanganPolicy,
    SejarahPolicy,
    PenghargaanPolicy,
    WilayahAdministrasiPolicy,
    KontakPolicy,
    Wisata\BudayaPolicy,
    Wisata\ObjekWisataPolicy,
    Wisata\HotelPolicy,

    Wisata\RumahMakanPolicy
};

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Kecamatan::class => KecamatanPolicy::class,
        Berita::class => BeritaPolicy::class,
        Layanan::class => LayananPolicy::class,
        Agenda::class => AgendaPolicy::class,
        Galeri::class => GaleriPolicy::class,
        Pejabat::class => PejabatPolicy::class,
        PeranDanProgram::class => PeranDanProgramPolicy::class,
        Infografis::class => InfografisPolicy::class,
        LaporanKeuangan::class => LaporanKeuanganPolicy::class,
        Budaya::class => BudayaPolicy::class,
        ObjekWisata::class => ObjekWisataPolicy::class,
        Hotel::class => HotelPolicy::class,
        RumahMakan::class => RumahMakanPolicy::class,
        WilayahAdministrasi::class => WilayahAdministrasiPolicy::class,
        Sejarah::class => SejarahPolicy::class,
        Penghargaan::class => PenghargaanPolicy::class,
        Kecamatan::class => KontakPolicy::class,
        PerangkatDaerah::class => KontakPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
