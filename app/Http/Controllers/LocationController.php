<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{

    public function getProvinces(): JsonResponse
    {
        $provinsi = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')->json();
        return response()->json($provinsi);
    }


    public function getKabupaten($provinsi_id)
    {
        $kabupaten = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/$provinsi_id.json")->json();
        return response()->json($kabupaten);
    }

    // Fungsi untuk mengambil Kecamatan berdasarkan Kabupaten/Kota
    public function getKecamatan($kabupaten_id)
    {
        $kecamatan = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/$kabupaten_id.json")->json();
        return response()->json($kecamatan);
    }

    // Fungsi untuk mengambil Kelurahan berdasarkan Kecamatan
    public function getKelurahan($kecamatan_id)
    {
        $kelurahan = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/$kecamatan_id.json")->json();
        return response()->json($kelurahan);
    }
}
