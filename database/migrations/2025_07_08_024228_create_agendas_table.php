<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('perangkat_daerah_id')
                ->nullable()
                ->constrained('perangkat_daerahs')
                ->onDelete('cascade');

            $table->foreignId('kecamatan_id')
                ->nullable()
                ->constrained('kecamatans')
                ->onDelete('cascade');

            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
