<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('donaturs', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('kontak')->nullable();
            $table->bigInteger('jumlah_donasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('bukti_upload')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donaturs');
    }
};
