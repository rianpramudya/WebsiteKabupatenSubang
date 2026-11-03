<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatans')->onDelete('cascade');
            $table->string('nama');
            $table->string('slug')->unique();
            $table->unsignedTinyInteger('bintang')->nullable();
            $table->text('deskripsi');
            $table->string('alamat');
            $table->string('gambar')->nullable();
            $table->string('telepon')->nullable();
            $table->string('website_url')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
