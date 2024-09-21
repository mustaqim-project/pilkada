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
            $table->id(); // Primary key ID untuk tabel ini
            $table->foreignId('user_id')->constrained(); // Foreign key ke tabel users
            $table->string('provinsi')->nullable();
            $table->string('kabupaten_kota')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('rw')->nullable();
            $table->string('rt')->nullable();
            $table->foreignId('tipe_cakada_id')->constrained(); // Foreign key ke tabel cakada
            $table->foreignId('cakada_id')->constrained(); // Foreign key ke tabel cakada
            $table->string('foto')->nullable();
            $table->string('lang')->nullable(); // Koordinat longitude
            $table->string('lat')->nullable(); // Koordinat latitude
            $table->enum('elektabilitas', [1, 2, 3])->nullable(); // Pilihan 1/2/3 untuk elektabilitas
            $table->enum('popularitas', [1, 2, 3])->nullable();  // Pilihan 1/2/3 untuk popularitas
            $table->enum('stiker', [1, 2, 3])->nullable();  // Pilihan 1/2/3 untuk stiker
            $table->text('alasan')->nullable(); // Teks alasan tanpa batasan karakter
            $table->text('pesan')->nullable();  // Teks pesan tanpa batasan karakter
            $table->text('deskripsi')->nullable(); // Teks deskripsi tanpa batasan karakter
            $table->string('alamat')->nullable(); // Alamat
            $table->string('nama_kk')->nullable(); // Nama kepala keluarga
            $table->integer('usia')->nullable(); // Nama kepala keluarga
            $table->foreignId('pekerjaan_id')->constrained(); // Foreign key ke tabel cakada
            $table->string('nomor_hp')->nullable(); // Nomor handphone
            $table->integer('jum_pemilih')->nullable(); // Jumlah pemilih
            $table->timestamps(); // Kolom created_at dan updated_at
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
