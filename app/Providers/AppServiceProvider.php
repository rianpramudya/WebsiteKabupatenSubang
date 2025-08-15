<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Berita;
use App\Observers\BeritaObserver;
use App\Models\Galeri;
use App\Observers\GaleriObserver;
use App\Models\Infografis;
use App\Observers\InfografisObserver;
use App\Models\Agenda;
use App\Observers\AgendaObserver;
use App\Models\Budaya;
use App\Observers\BudayaObserver;
use App\Models\Hotel;
use App\Observers\HotelObserver;
use App\Models\ObjekWisata;
use App\Observers\ObjekWisataObserver;
use App\Models\RumahMakan;
use App\Observers\RumahMakanObserver;
use App\Models\Sejarah;
use App\Observers\SejarahObserver;
use App\Models\Penghargaan;
use App\Observers\PenghargaanObserver;
use App\Models\Kecamatan;
use App\Observers\KecamatanObserver;
use App\Models\LaporanKeuangan;
use App\Observers\LaporanKeuanganObserver;
use App\Models\Pejabat;
use App\Observers\StrukturPemerintahanObserver;
use App\Models\PeranDanProgram;
use App\Observers\PeranDanProgramObserver;
use App\Models\Layanan;
use App\Observers\LayananObserver;
use App\Models\WilayahAdministrasi;
use App\Observers\WilayahAdministrasiObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Berita::observe(BeritaObserver::class);
        Galeri::observe(GaleriObserver::class);
        Infografis::observe(InfografisObserver::class);
        Agenda::observe(AgendaObserver::class);
        Budaya::observe(BudayaObserver::class);
        Hotel::observe(HotelObserver::class);
        ObjekWisata::observe(ObjekWisataObserver::class);
        RumahMakan::observe(RumahMakanObserver::class);
        Sejarah::observe(SejarahObserver::class);
        Penghargaan::observe(PenghargaanObserver::class);
        Kecamatan::observe(KecamatanObserver::class);
        LaporanKeuangan::observe(LaporanKeuanganObserver::class);
        Pejabat::observe(StrukturPemerintahanObserver::class);
        PeranDanProgram::observe(PeranDanProgramObserver::class);
        Layanan::observe(LayananObserver::class);
        WilayahAdministrasi::observe(WilayahAdministrasiObserver::class);
    }
}
