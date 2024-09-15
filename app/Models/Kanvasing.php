<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kanvasing extends Model
{
    use HasFactory;

    // Specify the table name if it differs from the plural form of the model name
    protected $table = 'kanvasings';

    // Specify which attributes can be mass assigned
    protected $fillable = [
        'provinsi',
        'kabupaten_kota',
        'kecamatan',
        'kelurahan',
        'rw',
        'rt',
        'cakada_id',
        'foto',
        'koordinat',
        'elektabilitas',
        'popularitas',
        'alamat',
        'nama_kk',
        'nomor_hp',
        'jum_pemilih',
    ];

    /**
     * Get the Cakada that owns the Kanvasing.
     */
    public function cakada()
    {
        return $this->belongsTo(Cakada::class, 'cakada_id');
    }
}
