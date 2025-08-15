<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_keuangans', function (Blueprint $table) {
            $table->id();

            // [PERBAIKAN] Ganti tenant_id dengan relasi yang jelas
            $table->foreignId('perangkat_daerah_id')->nullable()->constrained('perangkat_daerahs')->onDelete('cascade');
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatans')->onDelete('cascade');
            
            $table->year('tahun');
            $table->string('judul_laporan');
            $table->string('jenis_laporan');
            $table->text('deskripsi_singkat')->nullable();
            $table->string('file_url');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_keuangans');
    }
};