<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CountData extends Model
{
    use HasFactory;

    public static function getTotalTimsesUsers()
    {
        // Menghitung jumlah user dengan role 'timses'
        $totalTimsesUsers = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', 'timses')
            ->count('users.id');

        // Menghitung total kanvasing
        $totalKanvasing = DB::select('SELECT COUNT(id) as total_kanvasing FROM kanvasings');

        // Kembalikan hasil dalam bentuk array atau sesuai kebutuhan
        return [
            'total_timses_users' => $totalTimsesUsers,
            'total_kanvasing' => $totalKanvasing
        ];
    }
}
