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
        Schema::create('kecamatans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            
            // Kolom-kolom yang dibutuhkan oleh Seeder dan Controller
            $table->string('logo')->nullable();
            $table->text('sejarah')->nullable();
            $table->text('arti_lambang')->nullable();
            $table->string('sejarah_img_1')->nullable();
            $table->string('sejarah_img_2')->nullable();
            $table->string('sejarah_img_3')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            
            // Kolom untuk peta wilayah
            $table->text('peta_url')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kecamatans');
    }
};
