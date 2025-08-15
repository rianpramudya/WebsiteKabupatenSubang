<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $kecamatan_id
 * @property string $judul
 * @property string|null $deskripsi
 * @property string $tanggal_mulai
 * @property string|null $tanggal_selesai
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kecamatan $kecamatan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agenda newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agenda newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agenda query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agenda whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agenda whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agenda whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agenda whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agenda whereKecamatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agenda whereTanggalMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agenda whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agenda whereUpdatedAt($value)
 */
	class Agenda extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $kategori_berita_id
 * @property int|null $kecamatan_id
 * @property string $judul
 * @property string $slug
 * @property string $excerpt
 * @property string $isi
 * @property string|null $gambar
 * @property string|null $published_at
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\KategoriBerita $kategori
 * @property-read \App\Models\Kecamatan|null $kecamatan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereIsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereKategoriBeritaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereKecamatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereViews($value)
 */
	class Berita extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $kecamatan_id
 * @property string $nama
 * @property string $slug
 * @property string $deskripsi
 * @property string|null $gambar
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kecamatan|null $kecamatan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Budaya newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Budaya newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Budaya query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Budaya whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Budaya whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Budaya whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Budaya whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Budaya whereKecamatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Budaya whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Budaya wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Budaya whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Budaya whereUpdatedAt($value)
 */
	class Budaya extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $kecamatan_id
 * @property string $judul
 * @property string $tipe
 * @property string $file_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kecamatan $kecamatan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereKecamatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereTipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereUpdatedAt($value)
 */
	class Galeri extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $kecamatan_id
 * @property string $nama
 * @property string $slug
 * @property int|null $bintang
 * @property string $deskripsi
 * @property string $alamat
 * @property string|null $gambar
 * @property string|null $telepon
 * @property string|null $website_url
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kecamatan|null $kecamatan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereBintang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereKecamatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Hotel whereWebsiteUrl($value)
 */
	class Hotel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $kecamatan_id
 * @property string $judul
 * @property string $slug
 * @property string $gambar
 * @property string|null $deskripsi
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kecamatan|null $kecamatan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Infografis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Infografis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Infografis query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Infografis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Infografis whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Infografis whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Infografis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Infografis whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Infografis whereKecamatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Infografis wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Infografis whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Infografis whereUpdatedAt($value)
 */
	class Infografis extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nama
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriBerita newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriBerita newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriBerita query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriBerita whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriBerita whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriBerita whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriBerita whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriBerita whereUpdatedAt($value)
 */
	class KategoriBerita extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $logo
 * @property string|null $sejarah
 * @property string|null $arti_lambang
 * @property string|null $sejarah_img_1
 * @property string|null $sejarah_img_2
 * @property string|null $sejarah_img_3
 * @property string|null $visi
 * @property string|null $misi
 * @property string|null $peta_url
 * @property string|null $letak_geografis
 * @property string|null $iklim
 * @property string|null $demografi
 * @property string|null $topografi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Agenda> $agendas
 * @property-read int|null $agendas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Berita> $beritas
 * @property-read int|null $beritas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Galeri> $galeris
 * @property-read int|null $galeris_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Layanan> $layanans
 * @property-read int|null $layanans_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PerangkatDaerah> $perangkatDaerahs
 * @property-read int|null $perangkat_daerahs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sejarah> $sejarahs
 * @property-read int|null $sejarahs_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereArtiLambang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereDemografi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereIklim($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereLetakGeografis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereMisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan wherePetaUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereSejarah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereSejarahImg1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereSejarahImg2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereSejarahImg3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereTopografi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereVisi($value)
 */
	class Kecamatan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $tenant_id
 * @property string $tahun
 * @property string $judul_laporan
 * @property string $jenis_laporan
 * @property string|null $deskripsi_singkat
 * @property string $file_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKeuangan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKeuangan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKeuangan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKeuangan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKeuangan whereDeskripsiSingkat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKeuangan whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKeuangan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKeuangan whereJenisLaporan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKeuangan whereJudulLaporan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKeuangan whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKeuangan whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKeuangan whereUpdatedAt($value)
 */
	class LaporanKeuangan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $kecamatan_id
 * @property string $nama
 * @property string|null $deskripsi
 * @property string|null $icon
 * @property string|null $link_url
 * @property int $urutan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kecamatan $kecamatan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereKecamatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereLinkUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereUrutan($value)
 */
	class Layanan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $kecamatan_id
 * @property string $nama
 * @property string $slug
 * @property string $kategori
 * @property string $deskripsi_singkat
 * @property string|null $gambar
 * @property string $lokasi_teks
 * @property string|null $google_maps_url
 * @property int $is_unggulan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kecamatan|null $kecamatan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObjekWisata newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObjekWisata newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObjekWisata query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObjekWisata whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObjekWisata whereDeskripsiSingkat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObjekWisata whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObjekWisata whereGoogleMapsUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObjekWisata whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObjekWisata whereIsUnggulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObjekWisata whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObjekWisata whereKecamatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObjekWisata whereLokasiTeks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObjekWisata whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObjekWisata whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ObjekWisata whereUpdatedAt($value)
 */
	class ObjekWisata extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $tenant_id
 * @property string $nama
 * @property string $jabatan
 * @property string|null $foto_url
 * @property int $urutan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pejabat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pejabat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pejabat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pejabat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pejabat whereFotoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pejabat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pejabat whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pejabat whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pejabat whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pejabat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pejabat whereUrutan($value)
 */
	class Pejabat extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $tenant_id
 * @property string $nama_penghargaan
 * @property string $tahun
 * @property string $tingkat
 * @property string $instansi_pemberi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kecamatan|null $kecamatan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penghargaan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penghargaan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penghargaan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penghargaan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penghargaan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penghargaan whereInstansiPemberi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penghargaan whereNamaPenghargaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penghargaan whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penghargaan whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penghargaan whereTingkat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penghargaan whereUpdatedAt($value)
 */
	class Penghargaan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $kecamatan_id
 * @property string $judul
 * @property string $deskripsi
 * @property int $urutan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kecamatan|null $kecamatan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeranDanProgram newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeranDanProgram newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeranDanProgram query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeranDanProgram whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeranDanProgram whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeranDanProgram whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeranDanProgram whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeranDanProgram whereKecamatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeranDanProgram whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeranDanProgram whereUrutan($value)
 */
	class PeranDanProgram extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $kecamatan_id
 * @property string $nama_desa
 * @property string|null $kepala_desa
 * @property string|null $luas_wilayah
 * @property int|null $jumlah_penduduk
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kecamatan|null $kecamatan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDaerah newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDaerah newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDaerah query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDaerah whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDaerah whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDaerah whereJumlahPenduduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDaerah whereKecamatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDaerah whereKepalaDesa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDaerah whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDaerah whereLuasWilayah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDaerah whereNamaDesa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDaerah whereUpdatedAt($value)
 */
	class PerangkatDaerah extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $kecamatan_id
 * @property string $nama
 * @property string $slug
 * @property string|null $jenis_kuliner
 * @property string $deskripsi
 * @property string $alamat
 * @property string|null $gambar
 * @property string|null $telepon
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kecamatan|null $kecamatan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RumahMakan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RumahMakan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RumahMakan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RumahMakan whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RumahMakan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RumahMakan whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RumahMakan whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RumahMakan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RumahMakan whereJenisKuliner($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RumahMakan whereKecamatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RumahMakan whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RumahMakan wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RumahMakan whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RumahMakan whereTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RumahMakan whereUpdatedAt($value)
 */
	class RumahMakan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $kecamatan_id
 * @property string $tahun
 * @property string $judul
 * @property string $deskripsi
 * @property int $urutan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kecamatan|null $kecamatan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sejarah newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sejarah newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sejarah query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sejarah whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sejarah whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sejarah whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sejarah whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sejarah whereKecamatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sejarah whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sejarah whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sejarah whereUrutan($value)
 */
	class Sejarah extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $kecamatan_id
 * @property string $name
 * @property string $slug
 * @property string|null $subdomain
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereKecamatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereSubdomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereUpdatedAt($value)
 */
	class Tenant extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int|null $kecamatan_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kecamatan|null $kecamatan
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereKecamatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

