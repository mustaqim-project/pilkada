<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Kanvasing;
use DB;
class AnalisisController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:analisis read')->only(['index', 'grafik_suara', 'segmen_pemilih', 'tren_suara', 'strength', 'weakness', 'satisfaction']);
    }

    // Menampilkan halaman utama analisis
    public function index()
    {
        return view('mobile.frontend.analisis.index');
    }

    // Menampilkan grafik analisis suara
    public function grafik_suara()
    {
        // Mengelompokkan data elektabilitas dan popularitas berdasarkan wilayah
        $data = Kanvasing::select(
                'provinsi',
                DB::raw('COUNT(CASE WHEN elektabilitas = 1 THEN 1 END) as setuju'),
                DB::raw('COUNT(CASE WHEN elektabilitas = 2 THEN 1 END) as tidak_setuju'),
                DB::raw('COUNT(CASE WHEN elektabilitas = 3 THEN 1 END) as ragu_ragu'),
                DB::raw('COUNT(CASE WHEN popularitas = 1 THEN 1 END) as kenal'),
                DB::raw('COUNT(CASE WHEN popularitas = 2 THEN 1 END) as tidak_kenal')
            )
            ->groupBy('provinsi')
            ->get();

        // Kirim data ke view
        return view('mobile.frontend.analisis.grafik_suara', compact('data'));
    }

     public function tren_suara()
     {
         // Mengelompokkan data pemilih berdasarkan wilayah dari kabupaten/kota ke kelurahan
         $trenPemilih = Kanvasing::select(
                 'provinsi', 'kabupaten_kota', 'kecamatan', 'kelurahan',
                 DB::raw('COUNT(CASE WHEN elektabilitas = 1 THEN 1 END) as setuju'),
                 DB::raw('COUNT(CASE WHEN elektabilitas = 2 THEN 1 END) as tidak_setuju'),
                 DB::raw('COUNT(CASE WHEN elektabilitas = 3 THEN 1 END) as ragu_ragu')
             )
             ->groupBy('provinsi', 'kabupaten_kota', 'kecamatan', 'kelurahan')
             ->get();

         return view('mobile.frontend.analisis.tren_suara', compact('trenPemilih'));
     }

     // Menampilkan daerah strength (elektabilitas tertinggi)
     public function strength()
     {
         // Mencari daerah dengan elektabilitas tertinggi (kabupaten, kecamatan, kelurahan)
         $strengthDaerah = Kanvasing::select(
                 'provinsi', 'kabupaten_kota', 'kecamatan', 'kelurahan',
                 DB::raw('COUNT(CASE WHEN elektabilitas = 1 THEN 1 END) as setuju')
             )
             ->groupBy('provinsi', 'kabupaten_kota', 'kecamatan', 'kelurahan')
             ->orderBy('setuju', 'DESC') // Urutkan berdasarkan jumlah "setuju"
             ->first(); // Ambil daerah tertinggi

         return view('mobile.frontend.analisis.strength', compact('strengthDaerah'));
     }

     // Menampilkan daerah weakness (elektabilitas terendah)
     public function weakness()
     {
         // Mencari daerah dengan elektabilitas terendah (kabupaten, kecamatan, kelurahan)
         $weaknessDaerah = Kanvasing::select(
                 'provinsi', 'kabupaten_kota', 'kecamatan', 'kelurahan',
                 DB::raw('COUNT(CASE WHEN elektabilitas = 1 THEN 1 END) as setuju')
             )
             ->groupBy('provinsi', 'kabupaten_kota', 'kecamatan', 'kelurahan')
             ->orderBy('setuju', 'ASC') // Urutkan berdasarkan jumlah "setuju"
             ->first(); // Ambil daerah terendah

         return view('mobile.frontend.analisis.weakness', compact('weaknessDaerah'));
     }
}
