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
    Schema::create('tenants', function (Blueprint $table) {
       $table->id();
            // Foreign key untuk relasi one-to-one ke data kecamatan
            // onDelete('cascade') berarti jika data kecamatan dihapus, tenant juga ikut terhapus.
            $table->foreignId('kecamatan_id')->unique()->constrained('kecamatans')->onDelete('cascade');
            
            $table->string('name'); // Bisa diambil dari relasi kecamatan, atau spesifik untuk tenant
            $table->string('slug')->unique();
            $table->string('subdomain')->unique()->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};