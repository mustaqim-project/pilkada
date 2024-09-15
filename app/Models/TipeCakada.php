<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeCakada extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural form of the model name
    protected $table = 'tipe_cakadas';

    // Specify which attributes can be mass assigned
    protected $fillable = ['id,name'];
}
