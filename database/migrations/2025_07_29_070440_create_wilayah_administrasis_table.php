<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('wilayah_administrasis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatans')->onDelete('cascade');
            $table->foreignId('perangkat_daerah_id')->nullable()->constrained('perangkat_daerahs')->onDelete('cascade');

            $table->string('nama_desa');
            $table->string('kepala_desa')->nullable();
            $table->string('luas_wilayah')->nullable();
            $table->unsignedInteger('jumlah_penduduk')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wilayah_administrasis');
    }
};