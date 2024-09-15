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
        'cakada_id',
        'foto',
        'lang',         // Koordinat longitude
        'lat',          // Koordinat latitude
        'elektabilitas',
        'popularitas',
        'stiker',
        'alasan',
        'pesan',
        'deskripsi',
        'alamat',
        'nama_kk',
        'nomor_hp',
        'jum_pemilih',
    ];

    /**
     * Relasi ke model Cakada.
     */
    public function cakada()
    {
        return $this->belongsTo(Cakada::class, 'cakada_id');
    }

    /**
     * Relasi ke model User (untuk field user_id).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
