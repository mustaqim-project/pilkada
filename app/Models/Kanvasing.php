<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kanvasing extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari bentuk jamak model
    protected $table = 'kanvasings';

    // Tentukan atribut yang bisa diisi secara massal
    protected $fillable = [
        'user_id',
        'provinsi',
        'kabupaten_kota',
        'kecamatan',
        'kelurahan',
        'rw',
        'rt',
        'tipe_cakada_id',
        'cakada_id',
        'elektabilitas',
        'popularitas',
        'stiker',
        'alasan',
        'pesan',
        'deskripsi',
        'alamat',
        'nama_kk',
        'nomor_hp',
        'pekerjaan_id',
        'jenis_kelamin',
        'usia',
        'jum_pemilih',
        'foto',
        'lang',
        'lat',
    ];

    /**
     * Relasi ke model Cakada.
     */
    public function cakada()
    {
        return $this->belongsTo(Cakada::class, 'cakada_id');
    }

    public function tipe_cakada()
    {
        return $this->belongsTo(TipeCakada::class, 'tipe_cakada_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }

}
