<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan foreign key 'perangkat_daerah_id' ke semua tabel konten yang relevan.
     * Ini dijalankan sebagai migrasi terakhir untuk memastikan semua tabel sudah ada.
     */
    public function up(): void
    {
        // Daftar tabel yang akan dimodifikasi
        $tables = [
            'beritas',
            'agendas',
            'penghargaans',
            'laporan_keuangans',
            'pejabats',
            'peran_dan_programs',
            'sejarahs',
            'budayas',
            'objek_wisatas',
            'infografis',
            'hotels',
            'rumah_makans',
            'galeris',
            'layanans',
            'wilayah_administrasis',
            // 'users' sudah ditangani di migrasi aslinya, jadi tidak perlu di sini.
        ];

        foreach ($tables as $tableName) {
            // Pastikan tabelnya ada dan belum memiliki kolom perangkat_daerah_id
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'perangkat_daerah_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    // Tentukan posisi kolom baru
                    $afterColumn = Schema::hasColumn($table->getTable(), 'kecamatan_id') ? 'kecamatan_id' : 'id';

                    $table->foreignId('perangkat_daerah_id')
                          ->nullable()
                          ->after($afterColumn)
                          ->constrained('perangkat_daerahs')
                          ->onDelete('cascade'); // Menggunakan cascade agar data terkait ikut terhapus
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'beritas',
            'agendas',
            'penghargaans',
            'laporan_keuangans',
            'pejabats',
            'peran_dan_programs',
            'sejarahs',
            'budayas',
            'objek_wisatas',
            'infografis',
            'hotels',
            'rumah_makans',
            'galeris',
            'layanans',
            'wilayah_administrasis',
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'perangkat_daerah_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropForeign(['perangkat_daerah_id']);
                    $table->dropColumn('perangkat_daerah_id');
                });
            }
        }
    }
};
