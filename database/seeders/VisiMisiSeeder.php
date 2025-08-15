<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kecamatan; // Pastikan model Kecamatan digunakan

class VisiMisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Mengisi Visi & Misi untuk Kabupaten Subang
        Kecamatan::updateOrCreate(
            [
                'slug' => 'kabupaten-subang' // Kunci untuk mencari data
            ],
            [
                // [PERBAIKAN] Tambahkan 'name' di sini agar tidak error
                'name' => 'Kabupaten Subang',
                
                'visi' => 'Terwujudnya Kabupaten Subang yang bersih, maju, sejahtera, dan berkarakter.',
                'misi' => '<li>Meningkatkan kualitas sumber daya manusia yang berdaya saing.</li>
                           <li>Mewujudkan tata kelola pemerintahan yang baik dan bersih.</li>
                           <li>Meningkatkan pertumbuhan ekonomi daerah yang berbasis potensi lokal.</li>
                           <li>Meningkatkan pemerataan pembangunan infrastruktur yang berkualitas.</li>
                           <li>Menciptakan lingkungan hidup yang lestari dan berkelanjutan.</li>'
            ]
        );

        // 2. Mengisi Visi & Misi untuk Kecamatan Binong
        $kecamatanBinong = Kecamatan::where('slug', 'binong')->first();
        if ($kecamatanBinong) {
            $kecamatanBinong->update([
                'visi' => 'Terwujudnya Kecamatan Binong yang Religius, Maju, dan Sejahtera.',
                'misi' => '<li>Meningkatkan kualitas pelayanan publik yang cepat, tepat, dan transparan.</li>
                           <li>Mendorong partisipasi masyarakat dalam setiap program pembangunan.</li>
                           <li>Mengoptimalkan potensi sumber daya alam dan manusia untuk kesejahteraan bersama.</li>'
            ]);
        }
    }
}
