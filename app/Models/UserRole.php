<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    // Specify the table name if it differs from the plural form of the model name
    protected $table = 'cakadas';

    // Specify which attributes can be mass assigned
    protected $fillable = [
        'tipe_cakada_id',
        'provinsi',
        'kabupaten_kota',
        'nama_calon_kepala',
        'nama_calon_wakil',
    ];

    /**
     * Get the TipeCakada that owns the Cakada.
     */
    public function tipeCakada()
    {
        return $this->belongsTo(TipeCakada::class, 'tipe_cakada_id');
    }
}
