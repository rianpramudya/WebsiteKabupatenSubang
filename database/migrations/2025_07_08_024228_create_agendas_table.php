<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();

            // [PERBAIKAN 1] Tambahkan kolom untuk Perangkat Daerah
            // Dibuat nullable() karena agenda bisa jadi milik kecamatan ATAU perangkat daerah
            $table->foreignId('perangkat_daerah_id')
                ->nullable() // Izinkan kolom ini untuk kosong (NULL)
                ->constrained('perangkat_daerahs') // Hubungkan ke tabel 'perangkat_daerahs'
                ->onDelete('cascade');

            // [PERBAIKAN 2] Ubah kolom kecamatan_id agar bisa NULL
            $table->foreignId('kecamatan_id')
                ->nullable() // Izinkan kolom ini untuk kosong (NULL)
                ->constrained('kecamatans') // Hubungkan ke tabel 'kecamatans'
                ->onDelete('cascade');

            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
