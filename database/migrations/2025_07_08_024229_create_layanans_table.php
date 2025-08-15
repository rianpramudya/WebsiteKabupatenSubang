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
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();

            // [PERBAIKAN 1] Tambahkan kolom untuk Perangkat Daerah dan buat nullable
            $table->foreignId('perangkat_daerah_id')
                  ->nullable()
                  ->constrained('perangkat_daerahs')
                  ->onDelete('cascade');

            // [PERBAIKAN 2] Ubah kolom kecamatan_id agar bisa NULL
            $table->foreignId('kecamatan_id')
                  ->nullable()
                  ->constrained('kecamatans')
                  ->onDelete('cascade');

            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('icon')->nullable();
            $table->string('link_url')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
