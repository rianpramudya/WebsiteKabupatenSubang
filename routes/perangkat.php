<?php

use Illuminate\Support\Facades\Route;

// ==============================
// Import Controller Publik
// ==============================
use App\Http\Controllers\{
    PerangkatController,
    BeritaController,
    ProfilController,
    TransparansiController,
    PemerintahanController,
    WisataController,
    InfoGrafisController,
    PublicLayananController,
    PortalController
};

// ==============================
// Import Controller Admin (Lengkap)
// ==============================
use App\Http\Controllers\Admin\{
    ProfilController as AdminProfilController,
    BeritaController as AdminBeritaController,
    GaleriController as AdminGaleriController,
    AgendaController as AdminAgendaController,
    PenghargaanController as AdminPenghargaanController,
    SejarahController as AdminSejarahController,
    LayananController as AdminLayananController,
    InfografisController as AdminInfografisController,
    LaporanKeuanganController as AdminLaporanKeuanganController,
    BannerController,
    KontakController,
    Pemerintahan\StrukturPemerintahanController,
    Pemerintahan\PeranProgramController,
    Pemerintahan\WilayahAdministrasiController
};
use App\Models\PerangkatDaerah;

/*
|--------------------------------------------------------------------------
| RUTE SUBDOMAIN PERANGKAT DAERAH
|--------------------------------------------------------------------------
*/
Route::domain('{perangkatDaerah}.' . env('APP_DOMAIN', 'subang.go.id'))
    // ======================================================================
    // === PERBAIKAN UTAMA ADA DI SINI ======================================
    // ======================================================================
    ->whereIn('perangkatDaerah', PerangkatDaerah::pluck('slug')->all())
    ->group(function () {

    /*
    |--------------------------------------------------------------------------
    | RUTE PUBLIK PERANGKAT DAERAH
    |--------------------------------------------------------------------------
    */
    Route::middleware('set.tenant.context:perangkat_daerah')
        ->group(function () {
            Route::get('/', [PerangkatController::class, 'show'])->name('perangkat.show');
            Route::get('/berita', [BeritaController::class, 'indexPerangkatDaerah'])->name('perangkat.berita.index');
            Route::get('/sejarah', [ProfilController::class, 'sejarah'])->name('perangkat.sejarah');
            Route::get('/profil/wilayah', [ProfilController::class, 'wilayah'])->name('perangkat.wilayah');
            Route::get('/profil/visi-misi', [ProfilController::class, 'visiMisi'])->name('perangkat.visimisi');
            Route::get('/profil/penghargaan', [ProfilController::class, 'penghargaan'])->name('perangkat.penghargaan');
            Route::get('/transparansi', [TransparansiController::class, 'index'])->name('perangkat.transparansi');
            Route::get('/pemerintahan/struktur', [PemerintahanController::class, 'struktur'])->name('perangkat.struktur');
            Route::get('/pemerintahan/peran-dan-program', [PemerintahanController::class, 'peranDanProgram'])->name('perangkat.peran_program');
            Route::get('/pemerintahan/wilayah-administrasi', [PemerintahanController::class, 'wilayahAdministrasi'])->name('perangkat.wilayah_administrasi');
            Route::get('/wisata/seni-dan-budaya', [WisataController::class, 'seniDanBudaya'])->name('perangkat.wisata.senibudaya');
            Route::get('/wisata/objek-wisata', [WisataController::class, 'objekWisata'])->name('perangkat.wisata.objekwisata');
            Route::get('/wisata/hotel', [WisataController::class, 'hotel'])->name('perangkat.wisata.hotel');
            Route::get('/wisata/rumah-makan', [WisataController::class, 'rumahMakan'])->name('perangkat.wisata.rumahmakan');
            Route::get('/info-grafis', [InfoGrafisController::class, 'index'])->name('perangkat.infografis');
            Route::get('/agenda', [PortalController::class, 'agenda'])->name('perangkat.agenda');
            Route::get('/galeri/foto', [PerangkatController::class, 'galeriFoto'])->name('perangkat.galeri.foto');
            Route::get('/galeri/video', [PerangkatController::class, 'galeriVideo'])->name('perangkat.galeri.video');
            Route::get('/layanan', [PerangkatController::class, 'semuaLayanan'])->name('perangkat.layanan.index');
            Route::get('/layanan/{layanan}', [PublicLayananController::class, 'show'])->name('perangkat.layanan.detail');
            Route::get('/kontak', [PortalController::class, 'kontak'])->name('perangkat.kontak');
            Route::post('/pengaduan', [PortalController::class, 'kirimPengaduan'])->name('perangkat.pengaduan');
            Route::get('/halaman/{halamanSlug}', [PortalController::class, 'halamanKustom'])->name('perangkat.halaman');
            Route::get('/statistik', [PortalController::class, 'statistik'])->name('perangkat.statistik');
        });

    /*
    |--------------------------------------------------------------------------
    | RUTE ADMIN PERANGKAT DAERAH
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'set.tenant.context:perangkat_daerah', 'auth.perangkat_daerah'])
        ->prefix('admin')->name('admin.perangkat-daerah.')->group(function () {
            Route::get('/profil', [AdminProfilController::class, 'index'])->name('profil.index');
            Route::get('/pemerintahan', fn(PerangkatDaerah $perangkatDaerah) => view('admin.pemerintahan_CRUD.index', compact('perangkatDaerah')))->name('pemerintahan.index');
            Route::resource('berita', AdminBeritaController::class)->parameters(['berita' => 'berita']);
            Route::resource('galeri', AdminGaleriController::class)->except(['show', 'edit', 'update'])->scoped();
            Route::resource('agenda', AdminAgendaController::class)->except(['show'])->scoped();
            Route::resource('layanan', AdminLayananController::class)->except(['show'])->scoped();
            Route::prefix('kontak')->name('kontak.')->group(function () {
                Route::get('/edit', [KontakController::class, 'edit'])->name('edit');
                Route::put('/', [KontakController::class, 'update'])->name('update');
            });
            Route::prefix('profil')->name('profil.')->group(function () {
                Route::get('/visi-misi', [AdminProfilController::class, 'editVisiMisi'])->name('visimisi.edit');
                Route::put('/visi-misi', [AdminProfilController::class, 'updateVisiMisi'])->name('visimisi.update');
                Route::get('/wilayah', [AdminProfilController::class, 'editWilayah'])->name('wilayah.edit');
                Route::put('/wilayah', [AdminProfilController::class, 'updateWilayah'])->name('wilayah.update');
                Route::get('sejarah/edit-profil', [AdminSejarahController::class, 'editProfil'])->name('sejarah.editProfil');
                Route::put('sejarah/update-profil', [AdminSejarahController::class, 'updateProfil'])->name('sejarah.updateProfil');
                Route::resource('sejarah', AdminSejarahController::class)->except(['show'])->scoped();
                Route::resource('penghargaan', AdminPenghargaanController::class)->except(['show'])->scoped();
                Route::resource('infografis', AdminInfografisController::class)->except(['show'])->scoped();
            });
            Route::prefix('pemerintahan')->name('pemerintahan.')->group(function () {
                Route::resource('pejabats', StrukturPemerintahanController::class)->parameters(['pejabats' => 'pejabat']);
                Route::resource('peran-program', PeranProgramController::class)->parameters(['peran-program' => 'peranProgram'])->scoped();
                Route::resource('wilayah-administrasi', WilayahAdministrasiController::class)->scoped();
            });
            Route::resource('laporan-keuangan', AdminLaporanKeuanganController::class)->except('show')->scoped();
            Route::prefix('banner')->name('banner.')->group(function () {
                Route::get('/edit', [BannerController::class, 'edit'])->name('edit');
                Route::put('/update', [BannerController::class, 'update'])->name('update');
                Route::delete('/destroy', [BannerController::class, 'destroy'])->name('destroy');
            });
        });
});
