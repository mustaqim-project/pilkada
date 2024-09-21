<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kanvasing;
use Illuminate\Support\Facades\Http;
use App\Models\Cakada;
use App\Models\TipeCakada;
use Illuminate\Support\Facades\DB;

class AnalisisController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:analisis read')->only(['index', 'grafik_suara', 'segmen_pemilih', 'tren_suara', 'strength', 'weakness', 'satisfaction']);
    }

    public function index()
    {
        return view('mobile.frontend.analisis.index');
    }

    public function grafik_suara()
    {

        $tipe_cakada = TipeCakada::all();
        $cakada = Cakada::all();

        return view('mobile.frontend.analisis.grafik_suara', [
            'tipe_cakada' => $tipe_cakada,
            'cakada' => $cakada
        ]);
    }



    public function get_grafik_suara(Request $request)
    {
        $provinsi = $request->input('provinsi');
        $kabupaten_kota = $request->input('kabupaten_kota');
        $kecamatan = $request->input('kecamatan');
        $kelurahan = $request->input('kelurahan');
        $tipe_cakada_id = $request->input('tipe_cakada_id');
        $cakada_id = $request->input('cakada_id');

        $query = Kanvasing::selectRaw(
            'COUNT(CASE WHEN elektabilitas = 1 THEN 1 END) as setuju,
             COUNT(CASE WHEN elektabilitas = 2 THEN 1 END) as tidak_setuju,
             COUNT(CASE WHEN elektabilitas = 3 THEN 1 END) as ragu_ragu,
             COUNT(CASE WHEN popularitas = 1 THEN 1 END) as kenal,
             COUNT(CASE WHEN popularitas = 2 THEN 1 END) as tidak_kenal'
        )
            ->when($provinsi, fn($query) => $query->where('provinsi', $provinsi))
            ->when($kabupaten_kota, fn($query) => $query->where('kabupaten_kota', $kabupaten_kota))
            ->when($kecamatan, fn($query) => $query->where('kecamatan', $kecamatan))
            ->when($kelurahan, fn($query) => $query->where('kelurahan', $kelurahan))
            ->when($tipe_cakada_id, fn($query) => $query->where('tipe_cakada_id', $tipe_cakada_id))
            ->when($cakada_id, fn($query) => $query->where('cakada_id', $cakada_id))
            ->first();

        if (!$query) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        return response()->json([
            'setuju' => $query->setuju,
            'tidak_setuju' => $query->tidak_setuju,
            'ragu_ragu' => $query->ragu_ragu,
            'kenal' => $query->kenal,
            'tidak_kenal' => $query->tidak_kenal,
        ]);
    }




    public function strength()
    {

        return view('mobile.frontend.analisis.strength');
    }

    public function get_strength()
    {
        $topKabupatenKotaKecamatanSetuju = DB::table(DB::raw('(
            SELECT kabupaten_kota, kecamatan,
                   COUNT(CASE WHEN elektabilitas = 1 THEN 1 END) AS setuju
            FROM kanvasings
            GROUP BY kabupaten_kota, kecamatan
        ) AS subquery'))
            ->orderBy('setuju', 'DESC')
            ->limit(3)
            ->get();

        $topKabupatenKotaKecamatanRaguRagu = DB::table(DB::raw('(
            SELECT kabupaten_kota, kecamatan,
                   COUNT(CASE WHEN elektabilitas = 3 THEN 1 END) AS ragu_ragu
            FROM kanvasings
            GROUP BY kabupaten_kota, kecamatan
        ) AS subquery'))
            ->orderBy('ragu_ragu', 'DESC')
            ->limit(3)
            ->get();

        $topKecamatanKelurahanSetuju = DB::table(DB::raw('(
            SELECT kecamatan, kelurahan,
                   COUNT(CASE WHEN elektabilitas = 1 THEN 1 END) AS setuju
            FROM kanvasings
            GROUP BY kecamatan, kelurahan
        ) AS subquery'))
            ->orderBy('setuju', 'DESC')
            ->limit(3)
            ->get();

        $topKecamatanKelurahanRaguRagu = DB::table(DB::raw('(
            SELECT kecamatan, kelurahan,
                   COUNT(CASE WHEN elektabilitas = 3 THEN 1 END) AS ragu_ragu
            FROM kanvasings
            GROUP BY kecamatan, kelurahan
        ) AS subquery'))
            ->orderBy('ragu_ragu', 'DESC')
            ->limit(3)
            ->get();

        $topKabupatenKotaKecamatanPopularitasSetuju = DB::table(DB::raw('(
            SELECT kabupaten_kota, kecamatan,
                   COUNT(CASE WHEN popularitas = 1 THEN 1 END) AS setuju
            FROM kanvasings
            GROUP BY kabupaten_kota, kecamatan
        ) AS subquery'))
            ->orderBy('setuju', 'DESC')
            ->limit(3)
            ->get();

        $topKecamatanKelurahanPopularitasSetuju = DB::table(DB::raw('(
            SELECT kecamatan, kelurahan,
                   COUNT(CASE WHEN popularitas = 1 THEN 1 END) AS setuju
            FROM kanvasings
            GROUP BY kecamatan, kelurahan
        ) AS subquery'))
            ->orderBy('setuju', 'DESC')
            ->limit(3)
            ->get();

        $districtsCache = [];
        $villagesCache = [];

        $getDistrictName = function ($regencyId, $districtId) use (&$districtsCache) {
            if (!isset($districtsCache[$regencyId])) {
                $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/$regencyId.json");
                if ($response->successful()) {
                    $districtsCache[$regencyId] = collect($response->json());
                } else {
                    $districtsCache[$regencyId] = collect([]);
                }
            }

            $district = $districtsCache[$regencyId]->firstWhere('id', $districtId);
            return $district ? $district['name'] : 'Unknown';
        };

        $getVillageName = function ($districtId, $villageId) use (&$villagesCache) {
            if (!isset($villagesCache[$districtId])) {
                $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/$districtId.json");
                if ($response->successful()) {
                    $villagesCache[$districtId] = collect($response->json());
                } else {
                    $villagesCache[$districtId] = collect([]);
                }
            }
            $village = $villagesCache[$districtId]->firstWhere('id', $villageId);
            return $village ? $village['name'] : 'Unknown';
        };

        $topKabupatenKotaKecamatanSetuju = $topKabupatenKotaKecamatanSetuju->map(function ($item) use ($getDistrictName) {
            $item->kecamatan_name = $getDistrictName($item->kabupaten_kota, $item->kecamatan);
            return $item;
        });

        $topKabupatenKotaKecamatanRaguRagu = $topKabupatenKotaKecamatanRaguRagu->map(function ($item) use ($getDistrictName) {
            $item->kecamatan_name = $getDistrictName($item->kabupaten_kota, $item->kecamatan);
            return $item;
        });

        $topKecamatanKelurahanSetuju = $topKecamatanKelurahanSetuju->map(function ($item) use ($getVillageName) {
            $item->kelurahan_name = $getVillageName($item->kecamatan, $item->kelurahan);
            return $item;
        });

        $topKecamatanKelurahanRaguRagu = $topKecamatanKelurahanRaguRagu->map(function ($item) use ($getVillageName) {
            $item->kelurahan_name = $getVillageName($item->kecamatan, $item->kelurahan);
            return $item;
        });

        $topKabupatenKotaKecamatanPopularitasSetuju = $topKabupatenKotaKecamatanPopularitasSetuju->map(function ($item) use ($getDistrictName) {
            $item->kecamatan_name = $getDistrictName($item->kabupaten_kota, $item->kecamatan);
            return $item;
        });

        $topKecamatanKelurahanPopularitasSetuju = $topKecamatanKelurahanPopularitasSetuju->map(function ($item) use ($getVillageName) {
            $item->kelurahan_name = $getVillageName($item->kecamatan, $item->kelurahan);
            return $item;
        });

        return response()->json([
            'topKabupatenKotaKecamatanSetuju' => $topKabupatenKotaKecamatanSetuju,
            'topKabupatenKotaKecamatanRaguRagu' => $topKabupatenKotaKecamatanRaguRagu,
            'topKecamatanKelurahanSetuju' => $topKecamatanKelurahanSetuju,
            'topKecamatanKelurahanRaguRagu' => $topKecamatanKelurahanRaguRagu,
            'topKabupatenKotaKecamatanPopularitasSetuju' => $topKabupatenKotaKecamatanPopularitasSetuju,
            'topKecamatanKelurahanPopularitasSetuju' => $topKecamatanKelurahanPopularitasSetuju
        ]);
    }

    public function weakness()
    {

        return view('mobile.frontend.analisis.weakness');
    }


    public function get_weakness()
    {
        // Query untuk mencari kabupaten/kota dan kecamatan dengan tidak setuju tertinggi berdasarkan elektabilitas
        $topKabupatenKotaKecamatanTidakSetuju = DB::table(DB::raw('(
        SELECT kabupaten_kota, kecamatan,
               COUNT(CASE WHEN elektabilitas = 2 THEN 1 END) AS tidak_setuju
        FROM kanvasings
        GROUP BY kabupaten_kota, kecamatan
    ) AS subquery'))
            ->orderBy('tidak_setuju', 'DESC')
            ->limit(3)
            ->get();

        // Query untuk mencari kecamatan dan kelurahan dengan tidak setuju tertinggi berdasarkan elektabilitas
        $topKecamatanKelurahanTidakSetuju = DB::table(DB::raw('(
        SELECT kecamatan, kelurahan,
               COUNT(CASE WHEN elektabilitas = 2 THEN 1 END) AS tidak_setuju
        FROM kanvasings
        GROUP BY kecamatan, kelurahan
    ) AS subquery'))
            ->orderBy('tidak_setuju', 'DESC')
            ->limit(3)
            ->get();

        // Query untuk mencari kabupaten/kota dan kecamatan dengan tidak setuju tertinggi berdasarkan popularitas
        $topKabupatenKotaKecamatanPopularitasTidakSetuju = DB::table(DB::raw('(
        SELECT kabupaten_kota, kecamatan,
               COUNT(CASE WHEN popularitas = 2 THEN 1 END) AS tidak_setuju
        FROM kanvasings
        GROUP BY kabupaten_kota, kecamatan
    ) AS subquery'))
            ->orderBy('tidak_setuju', 'DESC')
            ->limit(3)
            ->get();

        // Query untuk mencari kecamatan dan kelurahan dengan tidak setuju tertinggi berdasarkan popularitas
        $topKecamatanKelurahanPopularitasTidakSetuju = DB::table(DB::raw('(
        SELECT kecamatan, kelurahan,
               COUNT(CASE WHEN popularitas = 2 THEN 1 END) AS tidak_setuju
        FROM kanvasings
        GROUP BY kecamatan, kelurahan
    ) AS subquery'))
            ->orderBy('tidak_setuju', 'DESC')
            ->limit(3)
            ->get();

        // Cache untuk kecamatan dan kelurahan
        $districtsCache = [];
        $villagesCache = [];

        // Fungsi untuk mengambil nama kecamatan berdasarkan ID kecamatan
        $getDistrictName = function ($regencyId, $districtId) use (&$districtsCache) {
            if (!isset($districtsCache[$regencyId])) {
                $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/$regencyId.json");
                if ($response->successful()) {
                    $districtsCache[$regencyId] = collect($response->json());
                } else {
                    $districtsCache[$regencyId] = collect([]);
                }
            }

            $district = $districtsCache[$regencyId]->firstWhere('id', $districtId);
            return $district ? $district['name'] : 'Unknown';
        };

        // Fungsi untuk mengambil nama kelurahan berdasarkan ID kelurahan
        $getVillageName = function ($districtId, $villageId) use (&$villagesCache) {
            if (!isset($villagesCache[$districtId])) {
                $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/$districtId.json");
                if ($response->successful()) {
                    $villagesCache[$districtId] = collect($response->json());
                } else {
                    $villagesCache[$districtId] = collect([]);
                }
            }

            $village = $villagesCache[$districtId]->firstWhere('id', $villageId);
            return $village ? $village['name'] : 'Unknown';
        };

        // Menambahkan nama kecamatan dan kelurahan dari API ke hasil query
        $topKabupatenKotaKecamatanTidakSetuju = $topKabupatenKotaKecamatanTidakSetuju->map(function ($item) use ($getDistrictName) {
            $item->kecamatan_name = $getDistrictName($item->kabupaten_kota, $item->kecamatan);
            return $item;
        });

        $topKecamatanKelurahanTidakSetuju = $topKecamatanKelurahanTidakSetuju->map(function ($item) use ($getVillageName) {
            $item->kelurahan_name = $getVillageName($item->kecamatan, $item->kelurahan);
            return $item;
        });

        $topKabupatenKotaKecamatanPopularitasTidakSetuju = $topKabupatenKotaKecamatanPopularitasTidakSetuju->map(function ($item) use ($getDistrictName) {
            $item->kecamatan_name = $getDistrictName($item->kabupaten_kota, $item->kecamatan);
            return $item;
        });

        $topKecamatanKelurahanPopularitasTidakSetuju = $topKecamatanKelurahanPopularitasTidakSetuju->map(function ($item) use ($getVillageName) {
            $item->kelurahan_name = $getVillageName($item->kecamatan, $item->kelurahan);
            return $item;
        });

        // Mengirimkan data dalam format JSON
        return response()->json([
            'topKabupatenKotaKecamatanTidakSetuju' => $topKabupatenKotaKecamatanTidakSetuju,
            'topKecamatanKelurahanTidakSetuju' => $topKecamatanKelurahanTidakSetuju,
            'topKabupatenKotaKecamatanPopularitasTidakSetuju' => $topKabupatenKotaKecamatanPopularitasTidakSetuju,
            'topKecamatanKelurahanPopularitasTidakSetuju' => $topKecamatanKelurahanPopularitasTidakSetuju
        ]);
    }
}
