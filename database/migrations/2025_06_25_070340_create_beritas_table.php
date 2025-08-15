<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_berita_id')->constrained()->onDelete('cascade');

            $table->foreignId('perangkat_daerah_id')->nullable()->constrained('perangkat_daerahs')->onDelete('cascade');
            
            // [PERBAIKAN KONSISTENSI] Mengubah onDelete menjadi 'cascade'
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatans')->onDelete('cascade');
            
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->text('isi');
            $table->string('gambar')->nullable();
            
            // Tipe data timestamp sudah benar untuk pengurutan
            $table->timestamp('published_at')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};