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

    // Menampilkan halaman utama analisis
    public function index()
    {
        return view('mobile.frontend.analisis.index');
    }

    public function grafik_suara()
    {

        // Fetch the data from the API
        $tipe_cakada = TipeCakada::all();
        $cakada = Cakada::all();

        // Pass the data to the view
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
            'setuju' => $query->setuju, // No array wrapping
            'tidak_setuju' => $query->tidak_setuju, // No array wrapping
            'ragu_ragu' => $query->ragu_ragu, // No array wrapping
            'kenal' => $query->kenal, // No array wrapping
            'tidak_kenal' => $query->tidak_kenal, // No array wrapping
        ]);

    }




    public function strength()
    {

        return view('mobile.frontend.analisis.strength');
    }

    public function get_strength()
    {
        // Mencari daerah dengan elektabilitas setuju tertinggi berdasarkan kabupaten dan kecamatan
        $topKabupatenKotaKecamatanSetuju = DB::table(DB::raw('(
            SELECT kabupaten_kota, kecamatan,
                   COUNT(CASE WHEN elektabilitas = 1 THEN 1 END) AS setuju
            FROM kanvasings
            GROUP BY kabupaten_kota, kecamatan
        ) AS subquery'))
        ->orderBy('setuju', 'DESC')
        ->limit(3)
        ->get();

        // Mencari daerah dengan elektabilitas ragu-ragu tertinggi berdasarkan kabupaten dan kecamatan
        $topKabupatenKotaKecamatanRaguRagu = DB::table(DB::raw('(
            SELECT kabupaten_kota, kecamatan,
                   COUNT(CASE WHEN elektabilitas = 3 THEN 1 END) AS ragu_ragu
            FROM kanvasings
            GROUP BY kabupaten_kota, kecamatan
        ) AS subquery'))
        ->orderBy('ragu_ragu', 'DESC')
        ->limit(3)
        ->get();

        // Mencari daerah dengan elektabilitas setuju tertinggi berdasarkan kecamatan dan kelurahan
        $topKecamatanKelurahanSetuju = DB::table(DB::raw('(
            SELECT kecamatan, kelurahan,
                   COUNT(CASE WHEN elektabilitas = 1 THEN 1 END) AS setuju
            FROM kanvasings
            GROUP BY kecamatan, kelurahan
        ) AS subquery'))
        ->orderBy('setuju', 'DESC')
        ->limit(3)
        ->get();

        // Mencari daerah dengan elektabilitas ragu-ragu tertinggi berdasarkan kecamatan dan kelurahan
        $topKecamatanKelurahanRaguRagu = DB::table(DB::raw('(
            SELECT kecamatan, kelurahan,
                   COUNT(CASE WHEN elektabilitas = 3 THEN 1 END) AS ragu_ragu
            FROM kanvasings
            GROUP BY kecamatan, kelurahan
        ) AS subquery'))
        ->orderBy('ragu_ragu', 'DESC')
        ->limit(3)
        ->get();

        // Mencari daerah dengan popularitas setuju tertinggi berdasarkan kabupaten dan kecamatan
        $topKabupatenKotaKecamatanPopularitasSetuju = DB::table(DB::raw('(
            SELECT kabupaten_kota, kecamatan,
                   COUNT(CASE WHEN popularitas = 1 THEN 1 END) AS setuju
            FROM kanvasings
            GROUP BY kabupaten_kota, kecamatan
        ) AS subquery'))
        ->orderBy('setuju', 'DESC')
        ->limit(3)
        ->get();

        // Mencari daerah dengan popularitas setuju tertinggi berdasarkan kecamatan dan kelurahan
        $topKecamatanKelurahanPopularitasSetuju = DB::table(DB::raw('(
            SELECT kecamatan, kelurahan,
                   COUNT(CASE WHEN popularitas = 1 THEN 1 END) AS setuju
            FROM kanvasings
            GROUP BY kecamatan, kelurahan
        ) AS subquery'))
        ->orderBy('setuju', 'DESC')
        ->limit(3)
        ->get();

        // Cache untuk kecamatan dan kelurahan
        $districtsCache = [];
        $villagesCache = [];

        // Fungsi untuk mengambil semua kecamatan dalam kabupaten_kota dan mencocokkan nama kecamatan berdasarkan ID kecamatan
        $getDistrictName = function ($regencyId, $districtId) use (&$districtsCache) {
            if (!isset($districtsCache[$regencyId])) {
                // Mengambil semua kecamatan berdasarkan kabupaten/kota
                $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/$regencyId.json");
                if ($response->successful()) {
                    $districtsCache[$regencyId] = collect($response->json());
                } else {
                    $districtsCache[$regencyId] = collect([]);
                }
            }

            // Mencari kecamatan yang sesuai berdasarkan districtId
            $district = $districtsCache[$regencyId]->firstWhere('id', $districtId);
            return $district ? $district['name'] : 'Unknown';
        };

        // Fungsi untuk mengambil semua kelurahan dalam kecamatan dan mencocokkan nama kelurahan berdasarkan ID kelurahan
        $getVillageName = function ($districtId, $villageId) use (&$villagesCache) {
            if (!isset($villagesCache[$districtId])) {
                // Mengambil semua kelurahan berdasarkan kecamatan
                $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/$districtId.json");
                if ($response->successful()) {
                    $villagesCache[$districtId] = collect($response->json());
                } else {
                    $villagesCache[$districtId] = collect([]);
                }
            }

            // Mencari kelurahan yang sesuai berdasarkan villageId
            $village = $villagesCache[$districtId]->firstWhere('id', $villageId);
            return $village ? $village['name'] : 'Unknown';
        };

        // Tambahkan nama kecamatan dan kelurahan dari API ke hasil query
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

        // Mengirimkan data dalam format JSON
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
        $kabupatenKecamatanElektabilitas = DB::table(DB::raw('(
            SELECT kabupaten_kota, kecamatan,
                   COUNT(CASE WHEN elektabilitas = 2 THEN 1 END) AS tidak_setuju
            FROM kanvasings
            GROUP BY kabupaten_kota, kecamatan
        ) AS subquery'))
        ->orderBy('tidak_setuju', 'DESC')
        ->limit(3)
        ->get();

        // Query untuk mencari kecamatan dan kelurahan dengan tidak setuju tertinggi berdasarkan elektabilitas
        $kecamatanKelurahanElektabilitas = DB::table(DB::raw('(
            SELECT kecamatan, kelurahan,
                   COUNT(CASE WHEN elektabilitas = 2 THEN 1 END) AS tidak_setuju
            FROM kanvasings
            GROUP BY kecamatan, kelurahan
        ) AS subquery'))
        ->orderBy('tidak_setuju', 'DESC')
        ->limit(3)
        ->get();

        // Query untuk mencari kabupaten/kota dan kecamatan dengan tidak setuju tertinggi berdasarkan popularitas
        $kabupatenKecamatanPopularitas = DB::table(DB::raw('(
            SELECT kabupaten_kota, kecamatan,
                   COUNT(CASE WHEN popularitas = 2 THEN 1 END) AS tidak_setuju
            FROM kanvasings
            GROUP BY kabupaten_kota, kecamatan
        ) AS subquery'))
        ->orderBy('tidak_setuju', 'DESC')
        ->limit(3)
        ->get();

        // Query untuk mencari kecamatan dan kelurahan dengan tidak setuju tertinggi berdasarkan popularitas
        $kecamatanKelurahanPopularitas = DB::table(DB::raw('(
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

        // Tambahkan nama kecamatan dan kelurahan dari API ke hasil query
        $kabupatenKecamatanElektabilitas = $kabupatenKecamatanElektabilitas->map(function ($item) use ($getDistrictName) {
            $item->kecamatan_name = $getDistrictName($item->kabupaten_kota, $item->kecamatan);
            return $item;
        });

        $kecamatanKelurahanElektabilitas = $kecamatanKelurahanElektabilitas->map(function ($item) use ($getVillageName) {
            $item->kelurahan_name = $getVillageName($item->kecamatan, $item->kelurahan);
            return $item;
        });

        $kabupatenKecamatanPopularitas = $kabupatenKecamatanPopularitas->map(function ($item) use ($getDistrictName) {
            $item->kecamatan_name = $getDistrictName($item->kabupaten_kota, $item->kecamatan);
            return $item;
        });

        $kecamatanKelurahanPopularitas = $kecamatanKelurahanPopularitas->map(function ($item) use ($getVillageName) {
            $item->kelurahan_name = $getVillageName($item->kecamatan, $item->kelurahan);
            return $item;
        });

        // Kirimkan semua hasil query ke dalam view
        return view('mobile.frontend.analisis.weakness', compact(
            'kabupatenKecamatanElektabilitas',
            'kecamatanKelurahanElektabilitas',
            'kabupatenKecamatanPopularitas',
            'kecamatanKelurahanPopularitas'
        ));
    }

}
