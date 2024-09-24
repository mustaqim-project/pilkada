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
        Schema::create('penggalangan_danas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('target_dana')->nullable();
            $table->string('kampanye_penggalangan')->nullable();
            $table->bigInteger('jumlah_terkumpul')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggalangan_danas');
    }
};
