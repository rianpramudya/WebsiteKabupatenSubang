<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
{
    Schema::create('tenants', function (Blueprint $table) {
       $table->id();

            $table->foreignId('kecamatan_id')->unique()->constrained('kecamatans')->onDelete('cascade');

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('subdomain')->unique()->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};