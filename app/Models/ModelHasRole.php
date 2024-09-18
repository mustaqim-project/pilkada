<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelHasRole extends Model
{
    protected $table = 'model_has_roles';

    // Tidak ada primary key di tabel ini
    public $incrementing = false;

    // Menggunakan integer unsigned untuk role_id dan model_id
    protected $casts = [
        'role_id' => 'integer',
        'model_id' => 'integer',
    ];

    protected $fillable = [
        'role_id', 'model_type', 'model_id'
    ];

    public $timestamps = false;

    // Relasi dengan model Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Relasi dengan model User (atau model lain yang ditentukan di 'model_type')
    public function model()
    {
        return $this->morphTo();
    }
}
