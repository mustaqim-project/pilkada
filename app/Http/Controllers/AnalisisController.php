<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kanvasing;
use DB;
// Menampilkan grafik analisis suara
use Illuminate\Support\Facades\Http;
use App\Models\Cakada;

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



    public function grafik_suara()
    {
        // Ambil data dari tabel Kanvasing
        $data = Kanvasing::select(
                'provinsi',
                'kabupaten_kota',
                'kecamatan',
                'kelurahan',
                'cakada_id',
                DB::raw('COUNT(CASE WHEN elektabilitas = 1 THEN 1 END) as setuju'),
                DB::raw('COUNT(CASE WHEN elektabilitas = 2 THEN 1 END) as tidak_setuju'),
                DB::raw('COUNT(CASE WHEN elektabilitas = 3 THEN 1 END) as ragu_ragu'),
                DB::raw('COUNT(CASE WHEN popularitas = 1 THEN 1 END) as kenal'),
                DB::raw('COUNT(CASE WHEN popularitas = 2 THEN 1 END) as tidak_kenal')
            )
            ->groupBy('provinsi', 'kabupaten_kota', 'kecamatan', 'kelurahan', 'cakada_id')
            ->get();

        // Ambil data cakada
        $cakadas = Cakada::all()->keyBy('id');

        // Ambil data dari API
        $provinces = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')->json();
        $regencies = [];
        $districts = [];
        $villages = [];

        foreach ($data as $item) {
            if (!isset($regencies[$item->provinsi])) {
                $regencies[$item->provinsi] = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$item->provinsi}.json")->json();
            }
            if (!isset($districts[$item->kabupaten_kota])) {
                $districts[$item->kabupaten_kota] = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$item->kabupaten_kota}.json")->json();
            }
            if (!isset($villages[$item->kecamatan])) {
                $villages[$item->kecamatan] = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/{$item->kecamatan}.json")->json();
            }
        }

        // Gabungkan data
        $data->transform(function($item) use ($cakadas, $provinces, $regencies, $districts, $villages) {
            $cakada = $cakadas[$item->cakada_id] ?? null;
            $item->cakada_name = $cakada ? $cakada->name : 'Unknown';

            $item->provinsi_name = collect($provinces)->firstWhere('id', $item->provinsi)['name'] ?? 'Unknown';
            $item->kabupaten_name = collect($regencies[$item->provinsi] ?? [])->firstWhere('id', $item->kabupaten_kota)['name'] ?? 'Unknown';
            $item->kecamatan_name = collect($districts[$item->kabupaten_kota] ?? [])->firstWhere('id', $item->kecamatan)['name'] ?? 'Unknown';
            $item->kelurahan_name = collect($villages[$item->kecamatan] ?? [])->firstWhere('id', $item->kelurahan)['name'] ?? 'Unknown';

            return $item;
        });

        // Pisahkan data berdasarkan level geografis dan cakada_id
        $elektabilitasData = $data->groupBy(['provinsi_name', 'kabupaten_name', 'kecamatan_name', 'kelurahan_name', 'cakada_id']);
        $popularitasData = $data->groupBy(['provinsi_name', 'kabupaten_name', 'kecamatan_name', 'kelurahan_name', 'cakada_id']);

        return view('mobile.frontend.analisis.grafik_suara', compact('elektabilitasData', 'popularitasData'));
    }

    public function tren_suara()
    {
        // Mengelompokkan data pemilih berdasarkan wilayah dari kabupaten/kota ke kelurahan
        $trenPemilih = Kanvasing::select(
            'provinsi',
            'kabupaten_kota',
            'kecamatan',
            'kelurahan',
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
            'provinsi',
            'kabupaten_kota',
            'kecamatan',
            'kelurahan',
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
            'provinsi',
            'kabupaten_kota',
            'kecamatan',
            'kelurahan',
            DB::raw('COUNT(CASE WHEN elektabilitas = 1 THEN 1 END) as setuju')
        )
            ->groupBy('provinsi', 'kabupaten_kota', 'kecamatan', 'kelurahan')
            ->orderBy('setuju', 'ASC') // Urutkan berdasarkan jumlah "setuju"
            ->first(); // Ambil daerah terendah

        return view('mobile.frontend.analisis.weakness', compact('weaknessDaerah'));
    }
}
