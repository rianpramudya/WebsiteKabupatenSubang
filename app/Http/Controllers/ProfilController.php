<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Tenant;
use App\Models\Penghargaan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfilController extends Controller
{
    private function getProfilData($slug, &$nama_wilayah)
    {
        if ($slug) {
            // Jika ada slug, cari data kecamatan berdasarkan slug.
            $data = Kecamatan::where('slug', $slug)->firstOrFail();
            $nama_wilayah = 'Kecamatan ' . $data->name;
        } else {
            // Jika tidak ada slug, ini adalah halaman kabupaten.
            // Ambil data kabupaten (asumsi slug 'kabupaten-subang' adalah unik).
            $data = Kecamatan::where('slug', 'kabupaten-subang')->first();
            $nama_wilayah = 'Kabupaten Subang';
        }
        return $data;
    }

    /**
     * Menampilkan halaman Sejarah.
     */
    public function sejarah($slug = null)
    {
    $nama_wilayah = '';
    $data_wilayah = $this->getProfilData($slug, $nama_wilayah); 

    // Jika kabupaten (slug == null), ambil sejarah dengan kecamatan_id NULL
    if ($slug === null) {
        $sejarah_items = \App\Models\Sejarah::whereNull('kecamatan_id')->orderBy('urutan')->get();
    } else {
        // Jika kecamatan, ambil data dari relasi
        $sejarah_items = $data_wilayah ? $data_wilayah->sejarahItems : collect();
    }

    return view('profil.sejarah', [
        'kecamatan' => $data_wilayah,
        'nama_wilayah' => $nama_wilayah,
        'sejarah' => $data_wilayah->sejarah ?? 'Konten sejarah utama belum diisi.',
        'arti_lambang' => $data_wilayah->arti_lambang ?? 'Deskripsi arti lambang belum diisi.',
        'logo_url' => $data_wilayah->logo ? asset('storage/' . $data_wilayah->logo) : null,
        'sejarah_items' => $sejarah_items,
    ]);
}

    /**
     * Menampilkan halaman Wilayah (Peta, Letak Geografis, Iklim, Demografi, Topografi).
     */
    public function wilayah(string $slug = null): View
    {
        if ($slug) {
            $tenant = Tenant::where('slug', $slug)->firstOrFail();
            return view('profil.wilayah', [
                'nama_wilayah'      => 'Kecamatan ' . $tenant->name,
                'peta_url'          => $tenant->peta_url ?? null,
                'letak_geografis'   => $tenant->letak_geografis ?? 'Data letak geografis belum tersedia.',
                'iklim'             => $tenant->iklim ?? 'Data iklim belum tersedia.',
                'demografi'         => $tenant->demografi ?? 'Data demografi belum tersedia.',
                'topografi'         => $tenant->topografi ?? 'Data topografi belum tersedia.',
                'kecamatan'         => $tenant,
            ]);
        } else {
            return view('profil.wilayah', [
                'nama_wilayah'      => 'Kabupaten Subang',
                'peta_url'          => 'https://maps.google.com/...', // Tambahkan embed default kabupaten di sini
                'letak_geografis'   => 'Kabupaten Subang terletak di bagian utara Provinsi Jawa Barat...',
                'iklim'             => 'Kabupaten Subang memiliki iklim tropis dengan musim hujan dan kemarau...',
                'demografi'         => 'Jumlah penduduk Kabupaten Subang berdasarkan sensus terakhir adalah ... jiwa.',
                'topografi'         => 'Topografi wilayah Kabupaten Subang bervariasi mulai dari dataran rendah hingga pegunungan di selatan.',
                'kecamatan'         => null
            ]);
        }
    }

    /**
     * Menampilkan halaman Visi & Misi.
     */
   public function visiMisi($slug = null): View
    {
        $nama_wilayah = '';
        $data_wilayah = $this->getProfilData($slug, $nama_wilayah);

        return view('profil.visi_misi', [
            'kecamatan' => $data_wilayah,
            'nama_wilayah' => $nama_wilayah,
            'visi' => $data_wilayah->visi ?? 'Visi untuk wilayah ini belum ditetapkan.',
            'misi' => $data_wilayah->misi ?? '<li>Misi untuk wilayah ini belum ditetapkan.</li>',
        ]);
    }
    /**
     * Menampilkan halaman daftar Penghargaan.
     */
    public function penghargaan(string $slug = null): View
    {
        $query = Penghargaan::query();
        $nama_wilayah = 'Kabupaten Subang';
        $kecamatan = null;

        if ($slug) {
            $tenant = Tenant::where('slug', $slug)->firstOrFail();
            $query->where('tenant_id', $tenant->id);
            $nama_wilayah = 'Kecamatan ' . $tenant->name;
            $kecamatan = $tenant;
        } else {
            $query->whereNull('tenant_id');
        }

        $penghargaan_per_tahun = $query->orderBy('tahun', 'desc')->get()->groupBy('tahun');

        return view('profil.penghargaan', [
            'nama_wilayah' => $nama_wilayah,
            'penghargaan_per_tahun' => $penghargaan_per_tahun,
            'kecamatan' => $kecamatan
        ]);
    }
}
