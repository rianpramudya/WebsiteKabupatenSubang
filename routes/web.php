<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\{
    PortalController,
    KecamatanController,
    BeritaController,
    ProfilController,
    TransparansiController,
    PemerintahanController,
    WisataController,
    InfoGrafisController,
    PublicLayananController
};

use App\Http\Controllers\Auth\LoginController;

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
    DashboardController,
    KontakController,
    Pemerintahan\StrukturPemerintahanController,
    Pemerintahan\PeranProgramController,
    Pemerintahan\WilayahAdministrasiController,
    Wisata\BudayaController as AdminBudayaController,
    Wisata\ObjekWisataController as AdminObjekWisataController,
    Wisata\HotelController as AdminHotelController,

    Wisata\RumahMakanController as AdminRumahMakanController
};

use App\Models\{Berita, Kecamatan, PerangkatDaerah};

Route::domain(env('APP_DOMAIN', 'subang.go.id'))->group(function () {

    Route::middleware('clear.tenant.context')->group(function () {

        Route::get('/', [PortalController::class, 'index'])->name('home');

        Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
        Route::get('/berita/{berita:slug}', [BeritaController::class, 'show'])->name('berita.show');
        Route::get('/berita/{berita:slug}/download', [BeritaController::class, 'downloadPDF'])->name('berita.download');
        Route::get('/berita/tag/{tag:slug}', [BeritaController::class, 'indexTag'])->name('berita.tags.index');
        Route::get('/sejarah', [ProfilController::class, 'sejarah'])->name('sejarah.kabupaten');
        Route::get('/profil/wilayah', [ProfilController::class, 'wilayah'])->name('wilayah.kabupaten');
        Route::get('/profil/visi-misi', [ProfilController::class, 'visiMisi'])->name('visimisi.kabupaten');
        Route::get('/profil/penghargaan', [ProfilController::class, 'penghargaan'])->name('penghargaan.kabupaten');
        Route::get('/transparansi', [TransparansiController::class, 'index'])->name('transparansi.kabupaten');
        Route::get('/pemerintahan/struktur', [PemerintahanController::class, 'struktur'])->name('struktur.kabupaten');
        Route::get('/pemerintahan/peran-dan-program', [PemerintahanController::class, 'peranDanProgram'])->name('peran_program.kabupaten');
        Route::get('/pemerintahan/wilayah-administrasi', [PemerintahanController::class, 'wilayahAdministrasi'])->name('wilayah_administrasi.kabupaten');
        Route::get('/wisata/seni-dan-budaya', [WisataController::class, 'seniDanBudaya'])->name('wisata.senibudaya.kabupaten');
        Route::get('/wisata/objek-wisata', [WisataController::class, 'objekWisata'])->name('wisata.objekwisata.kabupaten');
        Route::get('/wisata/hotel', [WisataController::class, 'hotel'])->name('wisata.hotel.kabupaten');
        Route::get('/wisata/rumah-makan', [WisataController::class, 'rumahMakan'])->name('wisata.rumahmakan.kabupaten');
        Route::get('/info-grafis', [InfoGrafisController::class, 'index'])->name('infografis.kabupaten');
        Route::get('/agenda', [PortalController::class, 'agenda'])->name('agenda.kabupaten');
        Route::get('/galeri/foto', [PortalController::class, 'galeriFoto'])->name('galeri.foto.kabupaten');
        Route::get('/galeri/video', [PortalController::class, 'galeriVideo'])->name('galeri.video.kabupaten');
        Route::get('/kontak', [PortalController::class, 'kontak'])->name('kontak.kabupaten');
        Route::get('/halaman/{slug}', [PortalController::class, 'halamanKustom'])->name('halaman.kabupaten');
        Route::get('/statistik', [PortalController::class, 'statistik'])->name('statistik.kabupaten');
        Route::get('/kebijakan-privasi', fn() => view('pages.kebijakan_privasi'))->name('privacy.policy');
    });

    Route::get(env('ADMIN_LOGIN_URL', 'login'), [LoginController::class, 'showLoginForm'])->name('login');
    Route::post(env('ADMIN_LOGIN_URL', 'login'), [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'role:super-admin'])
        ->get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::middleware(['auth', 'role:super-admin', 'clear.tenant.context'])
        ->prefix('admin/kabupaten')
        ->name('admin.kabupaten.')
        ->group(function () {
            Route::resource('berita', AdminBeritaController::class)->parameters(['berita' => 'berita']);
            Route::resource('infografis', AdminInfografisController::class)->except(['show']);
            Route::resource('laporan-keuangan', AdminLaporanKeuanganController::class)->except(['show']);
            Route::resource('agenda', AdminAgendaController::class)->except(['show']);

            Route::prefix('profil')->name('profil.')->group(function () {
                Route::get('/', [AdminProfilController::class, 'index'])->name('index');
                Route::get('/visi-misi', [AdminProfilController::class, 'editVisiMisi'])->name('visimisi.edit');
                Route::put('/visi-misi', [AdminProfilController::class, 'updateVisiMisi'])->name('visimisi.update');
                Route::get('/wilayah', [AdminProfilController::class, 'editWilayah'])->name('wilayah.edit');
                Route::put('/wilayah', [AdminProfilController::class, 'updateWilayah'])->name('wilayah.update');
                Route::get('sejarah/edit-profil', [AdminSejarahController::class, 'editProfil'])->name('sejarah.editProfil');
                Route::put('sejarah/update-profil', [AdminSejarahController::class, 'updateProfil'])->name('sejarah.updateProfil');
                Route::delete('sejarah/destroy-image', [AdminSejarahController::class, 'destroyImage'])->name('sejarah.destroyImage');
                Route::resource('sejarah', AdminSejarahController::class)->except('show');
                Route::resource('penghargaan', AdminPenghargaanController::class)->except('show');
            });

            Route::prefix('pemerintahan')->name('pemerintahan.')->group(function () {
                Route::get('/', fn() => view('admin.pemerintahan_CRUD.index', ['kecamatan' => null, 'perangkatDaerah' => null]))->name('index');
                Route::resource('pejabats', StrukturPemerintahanController::class)->parameters(['pejabats' => 'pejabat']);
                Route::resource('peran-program', PeranProgramController::class)->parameters(['peran-program' => 'peranProgram']);
                Route::resource('wilayah-administrasi', WilayahAdministrasiController::class);
            });

            Route::prefix('wisata')->name('wisata.')->group(function () {
                Route::get('/', fn() => view('admin.wisata_CRUD.index', ['kecamatan' => null]))->name('index');
                Route::resource('budaya', AdminBudayaController::class)->except(['show']);
                Route::resource('objek-wisata', AdminObjekWisataController::class)->except(['show'])->parameters(['objek-wisata' => 'objekWisata']);
                Route::resource('hotel', AdminHotelController::class)->except(['show']);
                Route::resource('rumah-makan', AdminRumahMakanController::class)->except(['show'])->parameters(['rumah-makan' => 'rumahMakan']);
            });

            Route::prefix('banner')->name('banner.')->group(function () {
                Route::get('/edit', [BannerController::class, 'edit'])->name('edit');
                Route::put('/update', [BannerController::class, 'update'])->name('update');
            });

            Route::prefix('kontak')->name('kontak.')->group(function () {
                Route::get('/edit', [KontakController::class, 'edit'])->name('edit');
                Route::put('/update', [KontakController::class, 'update'])->name('update');
            });
        });
});

Route::domain('{kecamatan}.' . env('APP_DOMAIN', 'subang.go.id'))
    ->whereIn('kecamatan', Kecamatan::pluck('slug')->all())
    ->group(function () {

        Route::middleware('set.tenant.context:kecamatan', 'block.kabupaten.slug')
            ->group(function () {
                Route::get('/', [KecamatanController::class, 'show'])->name('kecamatan.show');
                Route::get('/berita', [BeritaController::class, 'indexKecamatan'])->name('berita.kecamatan.index');
                Route::get('/berita/tag/{tag:slug}', [BeritaController::class, 'indexTagKecamatan'])->name('berita.tags.kecamatan.index');
                Route::get('/sejarah', [ProfilController::class, 'sejarah'])->name('sejarah.kecamatan');
                Route::get('/profil/wilayah', [ProfilController::class, 'wilayah'])->name('wilayah.kecamatan');
                Route::get('/profil/visi-misi', [ProfilController::class, 'visiMisi'])->name('visimisi.kecamatan');
                Route::get('/profil/penghargaan', [ProfilController::class, 'penghargaan'])->name('penghargaan.kecamatan');
                Route::get('/transparansi', [TransparansiController::class, 'index'])->name('transparansi.kecamatan');
                Route::get('/pemerintahan/struktur', [PemerintahanController::class, 'struktur'])->name('struktur.kecamatan');
                Route::get('/pemerintahan/peran-dan-program', [PemerintahanController::class, 'peranDanProgram'])->name('peran_program.kecamatan');
                Route::get('/pemerintahan/wilayah-administrasi', [PemerintahanController::class, 'wilayahAdministrasi'])->name('wilayah_administrasi.kecamatan');
                Route::get('/wisata/seni-dan-budaya', [WisataController::class, 'seniDanBudaya'])->name('wisata.senibudaya.kecamatan');
                Route::get('/wisata/objek-wisata', [WisataController::class, 'objekWisata'])->name('wisata.objekwisata.kecamatan');
                Route::get('/wisata/hotel', [WisataController::class, 'hotel'])->name('wisata.hotel.kecamatan');
                Route::get('/wisata/rumah-makan', [WisataController::class, 'rumahMakan'])->name('wisata.rumahmakan.kecamatan');
                Route::get('/info-grafis', [InfoGrafisController::class, 'index'])->name('infografis.kecamatan');
                Route::get('/agenda', [PortalController::class, 'agenda'])->name('agenda.kecamatan');
                Route::get('/galeri/foto', [KecamatanController::class, 'galeriFoto'])->name('kecamatan.galeri.foto');
                Route::get('/galeri/video', [KecamatanController::class, 'galeriVideo'])->name('kecamatan.galeri.video');
                Route::get('/layanan', [KecamatanController::class, 'semuaLayanan'])->name('kecamatan.layanan.index');
                Route::get('/layanan/{layanan}', [PublicLayananController::class, 'show'])->name('layanan.detail');
                Route::get('/kontak', [PortalController::class, 'kontak'])->name('kontak.kecamatan');
                Route::post('/pengaduan', [PortalController::class, 'kirimPengaduan'])->name('pengaduan.kecamatan');
                Route::get('/halaman/{halamanSlug}', [PortalController::class, 'halamanKustom'])->name('halaman.kecamatan');
                Route::get('/statistik', [PortalController::class, 'statistik'])->name('statistik.kecamatan');
            });

        Route::middleware(['auth', 'set.tenant.context:kecamatan', 'block.kabupaten.slug', 'auth.kecamatan'])
            ->prefix('admin')->name('admin.kecamatan.')->group(function () {
                Route::get('/profil', [AdminProfilController::class, 'index'])->name('profil.index');
                Route::get('/pemerintahan', fn(Kecamatan $kecamatan) => view('admin.pemerintahan_CRUD.index', compact('kecamatan')))->name('pemerintahan.index');
                Route::get('/wisata', fn(Kecamatan $kecamatan) => view('admin.wisata_CRUD.index', compact('kecamatan')))->name('wisata.index');
                Route::resource('berita', AdminBeritaController::class)->parameters(['berita' => 'berita'])->scoped();
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
                    Route::delete('sejarah/destroy-image', [AdminSejarahController::class, 'destroyImage'])->name('sejarah.destroyImage');
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
                Route::prefix('wisata')->name('wisata.')->group(function () {
                    Route::resource('budaya', AdminBudayaController::class)->except(['show'])->scoped();
                    Route::resource('objek-wisata', AdminObjekWisataController::class)->except(['show'])->parameters(['objek-wisata' => 'objekWisata'])->scoped();
                    Route::resource('hotel', AdminHotelController::class)->except(['show'])->scoped();
                    Route::resource('rumah-makan', AdminRumahMakanController::class)->except(['show'])->parameters(['rumah-makan' => 'rumahMakan'])->scoped();
                });
                Route::prefix('banner')->name('banner.')->group(function () {
                    Route::get('/edit', [BannerController::class, 'edit'])->name('edit');
                    Route::put('/update', [BannerController::class, 'update'])->name('update');
                    Route::delete('/destroy', [BannerController::class, 'destroy'])->name('destroy');
                });
            });
    });

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
