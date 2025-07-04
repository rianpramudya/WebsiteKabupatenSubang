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
        Schema::create('rumah_makans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatans')->onDelete('cascade');
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('jenis_kuliner')->nullable(); // Contoh: Sunda, Seafood, Bakso
            $table->text('deskripsi');
            $table->string('alamat');
            $table->string('gambar')->nullable();
            $table->string('telepon')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumah_makans');
    }
};
