<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKanvasingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kanvasings', function (Blueprint $table) {
            $table->id();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten_kota')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('rw')->nullable();
            $table->string('rt')->nullable();
            $table->foreignId('cakada_id')->nullable()->constrained()->onDelete('cascade'); // Foreign key ke cakada
            $table->string('foto')->nullable();
            $table->string('koordinat')->nullable();
            $table->string('elektabilitas', 1)->nullable(); // VARCHAR(1)
            $table->string('popularitas', 1)->nullable(); // VARCHAR(1)
            $table->string('alamat')->nullable(); // New field
            $table->string('nama_kk')->nullable(); // New field
            $table->string('nomor_hp')->nullable(); // New field
            $table->integer('jum_pemilih')->nullable(); // New field
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kanvasings');
    }
}
