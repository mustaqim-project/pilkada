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
        Schema::create('cakadas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipe_cakada_id')->nullable(); // Removed foreign key constraint
            $table->string('provinsi')->nullable();
            $table->string('kabupaten_kota')->nullable();
            $table->string('nama_calon_kepala')->nullable();
            $table->string('nama_calon_wakil')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cakadas');
    }
};
