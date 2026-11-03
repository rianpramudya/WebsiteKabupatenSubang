<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PeranDanProgram;
use App\Models\Kecamatan;

class PeranDanProgramSeeder extends Seeder
{

    public function run(): void
    {

        PeranDanProgram::create([
            'kecamatan_id' => null,
            'judul' => 'Sekretariat Daerah',
            'deskripsi' => 'Sekretariat Daerah Kabupaten Subang bertugas membantu Bupati dalam penyusunan kebijakan dan pengoordinasian administratif terhadap pelaksanaan tugas Perangkat Daerah serta pelayanan administratif.',
            'urutan' => 1,
        ]);

        PeranDanProgram::create([
            'kecamatan_id' => null,
            'judul' => 'Dinas Pendidikan dan Kebudayaan',
            'deskripsi' => 'Melaksanakan urusan pemerintahan di bidang pendidikan anak usia dini, pendidikan dasar, pendidikan nonformal, dan kebudayaan.',
            'urutan' => 2,
        ]);

        $kecamatanBinong = Kecamatan::where('slug', 'binong')->first();
        if ($kecamatanBinong) {
            PeranDanProgram::create([
                'kecamatan_id' => $kecamatanBinong->id,
                'judul' => 'Seksi Pemerintahan Kecamatan Binong',
                'deskripsi' => 'Bertugas melaksanakan sebagian tugas Camat dalam perumusan kebijakan teknis, pengoordinasian, pembinaan, pengawasan, pengendalian, dan evaluasi di bidang pemerintahan.',
                'urutan' => 1,
            ]);
            PeranDanProgram::create([
                'kecamatan_id' => $kecamatanBinong->id,
                'judul' => 'Seksi Kesejahteraan Sosial',
                'deskripsi' => 'Menangani urusan kesejahteraan sosial, pemberdayaan masyarakat, serta penanggulangan bencana di tingkat Kecamatan Binong.',
                'urutan' => 2,
            ]);
        }
    }
}
