<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// ==============================
// Import Controller Umum (Publik)
// ==============================
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

// ==============================
// Import Auth Controller
// ==============================
use App\Http\Controllers\Auth\LoginController;

// ==============================
// Import Admin Controllers
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

// ==============================
// Import Model
// ==============================
use App\Models\{Berita, Kecamatan, PerangkatDaerah};


/*
|--------------------------------------------------------------------------
| RUTE PUBLIK
|--------------------------------------------------------------------------
*/

Route::middleware('clear.tenant.context')->group(function () {

    // HOME (Portal Kabupaten)
    Route::get('/', [PortalController::class, 'index'])->name('home');

    // RUTE PUBLIK KABUPATEN
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
});

// RUTE PUBLIK KECAMATAN
Route::prefix('kecamatan/{kecamatan}')
    ->middleware('set.tenant.context', 'block.kabupaten.slug')
    ->group(function () {
        Route::get('/', [KecamatanController::class, 'show'])->name('kecamatan.show');
        Route::get('/berita', [BeritaController::class, 'indexKecamatan'])->name('berita.kecamatan.index');
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

/*
|--------------------------------------------------------------------------
| AUTENTIKASI & DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get(env('ADMIN_LOGIN_URL', 'login'), [LoginController::class, 'showLoginForm'])->name('login');
Route::post(env('ADMIN_LOGIN_URL', 'login'), [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard utama, hanya untuk super-admin
Route::middleware(['auth', 'role:super-admin'])
    ->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| RUTE ADMIN (Struktur Baru yang Diperbaiki)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // --- RUTE ADMIN KABUPATEN (Eksklusif Super Admin) ---
    Route::middleware(['role:super-admin', 'clear.tenant.context'])
        ->prefix('kabupaten')
        ->name('kabupaten.')
        ->group(function () {

            // ======================================================
            // Rute Resource untuk Konten (Berita, Infografis, dll.)
            // ======================================================

            Route::resource('berita', AdminBeritaController::class)
                ->names('berita')
                ->parameters(['berita' => 'berita']); // <--- TAMBAHKAN BARIS INI
            Route::resource('infografis', AdminInfografisController::class)->except(['show'])->names('infografis');
            Route::resource('laporan-keuangan', AdminLaporanKeuanganController::class)->except(['show'])->names('laporan-keuangan');

            Route::resource('agenda', AdminAgendaController::class)->except(['show'])->names('agenda');


            // ======================================================
            // Rute untuk Halaman Utama Modul (Profil, Pemerintahan, Wisata)
            // ======================================================
            Route::prefix('profil')->name('profil.')->group(function () {
                Route::get('/', [AdminProfilController::class, 'index'])->name('index');
                Route::get('/visi-misi', [AdminProfilController::class, 'editVisiMisi'])->name('visimisi.edit');
                Route::put('/visi-misi', [AdminProfilController::class, 'updateVisiMisi'])->name('visimisi.update');
                Route::get('/wilayah', [AdminProfilController::class, 'editWilayah'])->name('wilayah.edit');
                Route::put('/wilayah', [AdminProfilController::class, 'updateWilayah'])->name('wilayah.update');
                Route::get('sejarah/edit-profil', [AdminSejarahController::class, 'editProfil'])->name('sejarah.editProfil');
                Route::put('sejarah/update-profil', [AdminSejarahController::class, 'updateProfil'])->name('sejarah.updateProfil');

                Route::resource('sejarah', AdminSejarahController::class)->except('show');
                Route::resource('penghargaan', AdminPenghargaanController::class)->except('show');
            });

            // --- Grup Rute untuk Manajemen Pemerintahan Kabupaten --
            Route::prefix('pemerintahan')->name('pemerintahan.')->group(function () {
                // Rute Induk untuk halaman landing Pemerintahan
                Route::get('/', function () {
                    $kecamatan = null;
                    $perangkatDaerah = null;
                    return view('admin.pemerintahan_CRUD.index', compact('kecamatan', 'perangkatDaerah'));
                })->name('index');

                // Rute Resource untuk setiap modul di dalam Pemerintahan
                Route::resource('pejabats', StrukturPemerintahanController::class)->parameters(['pejabats' => 'pejabat']);
                Route::resource('peran-program', PeranProgramController::class)->parameters(['peran-program' => 'peranProgram']);
                Route::resource('wilayah-administrasi', WilayahAdministrasiController::class);
            });

            // --- Grup Rute untuk Manajemen Wisata Kabupaten ---
            Route::prefix('wisata')->name('wisata.')->group(function () {
                // Rute Induk untuk halaman landing Wisata
                Route::get('/', function () {
                    $kecamatan = null;
                    return view('admin.wisata_CRUD.index', compact('kecamatan'));
                })->name('index');

                // Rute Resource untuk setiap modul di dalam Wisata
                Route::resource('budaya', AdminBudayaController::class)->except(['show']);
                Route::resource('objek-wisata', AdminObjekWisataController::class)->except(['show'])->parameters(['objek-wisata' => 'objekWisata']);
                Route::resource('hotel', AdminHotelController::class)->except(['show']);
                Route::resource('rumah-makan', AdminRumahMakanController::class)->except(['show'])->parameters(['rumah-makan' => 'rumahMakan']);
            });

            // ======================================================
            // Rute Utilitas (Banner & Kontak)
            // ======================================================
            Route::prefix('banner')->name('banner.')->group(function () {
                Route::get('/edit', [BannerController::class, 'edit'])->name('edit');
                Route::put('/update', [BannerController::class, 'update'])->name('update');
            });

            Route::prefix('kontak')->name('kontak.')->group(function () {
                Route::get('/edit', [KontakController::class, 'edit'])->name('edit');
                Route::put('/update', [KontakController::class, 'update'])->name('update');
            });
        });

    // --- RUTE ADMIN KECAMATAN (Untuk Admin Kecamatan & Super Admin) ---
    Route::prefix('kecamatan/{kecamatan}')
        ->middleware(['set.tenant.context', 'block.kabupaten.slug', 'auth.kecamatan'])
        ->name('kecamatan.')
        ->group(function () {
            // Halaman Induk Modul
            Route::get('/profil', [AdminProfilController::class, 'index'])->name('profil.index');
            Route::get('/pemerintahan', fn(Kecamatan $kecamatan) => view('admin.pemerintahan_CRUD.index', compact('kecamatan')))->name('pemerintahan.index');
            Route::get('/wisata', fn(Kecamatan $kecamatan) => view('admin.wisata_CRUD.index', compact('kecamatan')))->name('wisata.index');

            // KONTEN UTAMA KECAMATAN
            Route::resource('berita', AdminBeritaController::class)
               // ->except(['show']) 
                ->parameters(['berita' => 'berita'])
                ->scoped();
            Route::resource('galeri', AdminGaleriController::class)->except(['show', 'edit', 'update'])->scoped();
            Route::resource('agenda', AdminAgendaController::class)->except(['show'])->scoped();
            Route::resource('layanan', AdminLayananController::class)->except(['show'])->scoped();

            // [TAMBAHKAN BLOK INI]
            // Rute untuk mengelola kontak kecamatan
            Route::prefix('kontak')->name('kontak.')->group(function () {
                Route::get('/edit', [KontakController::class, 'edit'])->name('edit');
                Route::put('/', [KontakController::class, 'update'])->name('update');
            });

            // PROFIL KECAMATAN (admin)
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



            // PEMERINTAHAN KECAMATAN (admin)
            Route::prefix('pemerintahan')->name('pemerintahan.')->group(function () {
                Route::resource('pejabats', StrukturPemerintahanController::class)->parameters(['pejabats' => 'pejabat']);
                Route::resource('peran-program', PeranProgramController::class)->parameters(['peran-program' => 'peranProgram'])->scoped();
                Route::resource('wilayah-administrasi', WilayahAdministrasiController::class)->scoped();
            });

            // TRANSPARANSI KECAMATAN (admin)
            Route::resource('laporan-keuangan', AdminLaporanKeuanganController::class)->except('show')->scoped();

            // WISATA KECAMATAN (admin)
            Route::prefix('wisata')->name('wisata.')->group(function () {
                Route::resource('budaya', AdminBudayaController::class)->except(['show'])->scoped();
                Route::resource('objek-wisata', AdminObjekWisataController::class)->except(['show'])->parameters(['objek-wisata' => 'objekWisata'])->scoped();
                Route::resource('hotel', AdminHotelController::class)->except(['show'])->scoped();
                Route::resource('rumah-makan', AdminRumahMakanController::class)->except(['show'])->parameters(['rumah-makan' => 'rumahMakan'])->scoped();
            });

            // BANNER KECAMATAN (admin)
            Route::prefix('banner')->name('banner.')->group(function () {
                Route::get('/edit', [BannerController::class, 'edit'])->name('edit');
                Route::put('/update', [BannerController::class, 'update'])->name('update');
                Route::delete('/destroy', [BannerController::class, 'destroy'])->name('destroy');
            });
        });
});

/*
|--------------------------------------------------------------------------
| FALLBACK 404
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
