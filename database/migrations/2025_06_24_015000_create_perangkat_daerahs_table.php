<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create('perangkat_daerahs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();

            $table->string('logo')->nullable();
            $table->string('banner_type')->nullable();
            $table->string('banner_url')->nullable();
            $table->text('sejarah')->nullable();
            $table->text('arti_lambang')->nullable();

            $table->string('sejarah_img_1')->nullable();
            $table->string('sejarah_img_2')->nullable();
            $table->string('sejarah_img_3')->nullable();

            $table->text('visi')->nullable();
            $table->text('misi')->nullable();

            $table->text('peta_url')->nullable();
            $table->text('letak_geografis')->nullable();
            $table->text('iklim')->nullable();
            $table->text('demografi')->nullable();
            $table->text('topografi')->nullable();

            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
            $table->string('link_facebook')->nullable();
            $table->string('link_twitter')->nullable();
            $table->string('link_youtube')->nullable();
            $table->string('link_instagram')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perangkat_daerahs');
    }
};
