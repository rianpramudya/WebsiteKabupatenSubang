<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
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

            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'perangkat_daerah_id')) {
                Schema::table($tableName, function (Blueprint $table) {

                    $afterColumn = Schema::hasColumn($table->getTable(), 'kecamatan_id') ? 'kecamatan_id' : 'id';

                    $table->foreignId('perangkat_daerah_id')
                          ->nullable()
                          ->after($afterColumn)
                          ->constrained('perangkat_daerahs')
                          ->onDelete('cascade');
                });
            }
        }
    }

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
