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
        Schema::create('laporan_keuangans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pemasukan')->nullable();
            $table->bigInteger('pengeluaran')->nullable();
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
        Schema::dropIfExists('laporan_keuangans');
    }
};
