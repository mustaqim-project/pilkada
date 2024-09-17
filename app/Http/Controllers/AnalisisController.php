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



    // public function strength()
    // {
    //     // Mencari daerah dengan elektabilitas setuju tertinggi berdasarkan kabupaten dan kecamatan
    //     $topKabupatenKotaKecamatanSetuju = DB::table(DB::raw('(
    //         SELECT kabupaten_kota, kecamatan,
    //                COUNT(CASE WHEN elektabilitas = 1 THEN 1 END) AS setuju
    //         FROM kanvasings
    //         GROUP BY kabupaten_kota, kecamatan
    //     ) AS subquery'))
    //     ->orderBy('setuju', 'DESC')
    //     ->limit(3)
    //     ->get();

    //     // Mencari daerah dengan elektabilitas ragu-ragu tertinggi berdasarkan kabupaten dan kecamatan
    //     $topKabupatenKotaKecamatanRaguRagu = DB::table(DB::raw('(
    //         SELECT kabupaten_kota, kecamatan,
    //                COUNT(CASE WHEN elektabilitas = 3 THEN 1 END) AS ragu_ragu
    //         FROM kanvasings
    //         GROUP BY kabupaten_kota, kecamatan
    //     ) AS subquery'))
    //     ->orderBy('ragu_ragu', 'DESC')
    //     ->limit(3)
    //     ->get();

    //     // Mencari daerah dengan elektabilitas setuju tertinggi berdasarkan kecamatan dan kelurahan
    //     $topKecamatanKelurahanSetuju = DB::table(DB::raw('(
    //         SELECT kecamatan, kelurahan,
    //                COUNT(CASE WHEN elektabilitas = 1 THEN 1 END) AS setuju
    //         FROM kanvasings
    //         GROUP BY kecamatan, kelurahan
    //     ) AS subquery'))
    //     ->orderBy('setuju', 'DESC')
    //     ->limit(3)
    //     ->get();

    //     // Mencari daerah dengan elektabilitas ragu-ragu tertinggi berdasarkan kecamatan dan kelurahan
    //     $topKecamatanKelurahanRaguRagu = DB::table(DB::raw('(
    //         SELECT kecamatan, kelurahan,
    //                COUNT(CASE WHEN elektabilitas = 3 THEN 1 END) AS ragu_ragu
    //         FROM kanvasings
    //         GROUP BY kecamatan, kelurahan
    //     ) AS subquery'))
    //     ->orderBy('ragu_ragu', 'DESC')
    //     ->limit(3)
    //     ->get();

    //     // Mencari daerah dengan popularitas setuju tertinggi berdasarkan kabupaten dan kecamatan
    //     $topKabupatenKotaKecamatanPopularitasSetuju = DB::table(DB::raw('(
    //         SELECT kabupaten_kota, kecamatan,
    //                COUNT(CASE WHEN popularitas = 1 THEN 1 END) AS setuju
    //         FROM kanvasings
    //         GROUP BY kabupaten_kota, kecamatan
    //     ) AS subquery'))
    //     ->orderBy('setuju', 'DESC')
    //     ->limit(3)
    //     ->get();

    //     // Mencari daerah dengan popularitas setuju tertinggi berdasarkan kecamatan dan kelurahan
    //     $topKecamatanKelurahanPopularitasSetuju = DB::table(DB::raw('(
    //         SELECT kecamatan, kelurahan,
    //                COUNT(CASE WHEN popularitas = 1 THEN 1 END) AS setuju
    //         FROM kanvasings
    //         GROUP BY kecamatan, kelurahan
    //     ) AS subquery'))
    //     ->orderBy('setuju', 'DESC')
    //     ->limit(3)
    //     ->get();

    //     // Ambil nama kecamatan dan kelurahan dari API
    //     $getDistrictNames = function ($districtId) {
    //         $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/$districtId.json");
    //         return $response->successful() ? $response->json()['name'] : 'Unknown';
    //     };

    //     $getVillageNames = function ($villageId) {
    //         $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/$villageId.json");
    //         return $response->successful() ? $response->json()['name'] : 'Unknown';
    //     };

    //     // Tambahkan nama kecamatan dan kelurahan dari API ke hasil query
    //     $topKabupatenKotaKecamatanSetuju = $topKabupatenKotaKecamatanSetuju->map(function ($item) use ($getDistrictNames) {
    //         $item->kecamatan_name = $getDistrictNames($item->kecamatan);
    //         return $item;
    //     });

    //     $topKabupatenKotaKecamatanRaguRagu = $topKabupatenKotaKecamatanRaguRagu->map(function ($item) use ($getDistrictNames) {
    //         $item->kecamatan_name = $getDistrictNames($item->kecamatan);
    //         return $item;
    //     });

    //     $topKecamatanKelurahanSetuju = $topKecamatanKelurahanSetuju->map(function ($item) use ($getVillageNames) {
    //         $item->kelurahan_name = $getVillageNames($item->kelurahan);
    //         return $item;
    //     });

    //     $topKecamatanKelurahanRaguRagu = $topKecamatanKelurahanRaguRagu->map(function ($item) use ($getVillageNames) {
    //         $item->kelurahan_name = $getVillageNames($item->kelurahan);
    //         return $item;
    //     });

    //     $topKabupatenKotaKecamatanPopularitasSetuju = $topKabupatenKotaKecamatanPopularitasSetuju->map(function ($item) use ($getDistrictNames) {
    //         $item->kecamatan_name = $getDistrictNames($item->kecamatan);
    //         return $item;
    //     });

    //     $topKecamatanKelurahanPopularitasSetuju = $topKecamatanKelurahanPopularitasSetuju->map(function ($item) use ($getVillageNames) {
    //         $item->kelurahan_name = $getVillageNames($item->kelurahan);
    //         return $item;
    //     });

    //     // Mengirimkan data dalam format JSON
    //     return response()->json([
    //         'topKabupatenKotaKecamatanSetuju' => $topKabupatenKotaKecamatanSetuju,
    //         'topKabupatenKotaKecamatanRaguRagu' => $topKabupatenKotaKecamatanRaguRagu,
    //         'topKecamatanKelurahanSetuju' => $topKecamatanKelurahanSetuju,
    //         'topKecamatanKelurahanRaguRagu' => $topKecamatanKelurahanRaguRagu,
    //         'topKabupatenKotaKecamatanPopularitasSetuju' => $topKabupatenKotaKecamatanPopularitasSetuju,
    //         'topKecamatanKelurahanPopularitasSetuju' => $topKecamatanKelurahanPopularitasSetuju
    //     ]);
    // }
    public function strength()
    {
        // Ambil seluruh data dari kanvasings
        $kanvasings = DB::table('kanvasings')
            ->select('kabupaten_kota', 'kecamatan', 'kelurahan', 'elektabilitas', 'popularitas')
            ->get();

        // Hitung berdasarkan elektabilitas dan popularitas
        $groupedData = $kanvasings->groupBy(['kabupaten_kota', 'kecamatan', 'kelurahan']);

        $results = [
            'topKabupatenKotaKecamatanSetuju' => [],
            'topKabupatenKotaKecamatanRaguRagu' => [],
            'topKecamatanKelurahanSetuju' => [],
            'topKecamatanKelurahanRaguRagu' => [],
            'topKabupatenKotaKecamatanPopularitasSetuju' => [],
            'topKecamatanKelurahanPopularitasSetuju' => []
        ];

        // Store API responses to prevent multiple requests for the same data
        $districtNamesCache = [];
        $villageNamesCache = [];

        $getDistrictName = function ($kabupaten_kota) use (&$districtNamesCache) {
            if (!isset($districtNamesCache[$kabupaten_kota])) {
                $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/$kabupaten_kota.json");
                $districtNamesCache[$kabupaten_kota] = $response->successful() ? $response->json()['name'] : 'Unknown';
            }
            return $districtNamesCache[$kabupaten_kota];
        };

        $getVillageName = function ($kecamatan) use (&$villageNamesCache) {
            if (!isset($villageNamesCache[$kecamatan])) {
                $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/$kecamatan.json");
                $villageNamesCache[$kecamatan] = $response->successful() ? $response->json()['name'] : 'Unknown';
            }
            return $villageNamesCache[$kecamatan];
        };

        foreach ($groupedData as $kabupatenKota => $kecamatanData) {
            foreach ($kecamatanData as $kecamatan => $kelurahanData) {
                $districtName = $getDistrictName($kabupatenKota);
                foreach ($kelurahanData as $kelurahan => $data) {
                    $villageName = $getVillageName($kecamatan);

                    // Hitung jumlah "setuju" dan "ragu-ragu" berdasarkan elektabilitas dan popularitas
                    $setujuCount = $data->where('elektabilitas', 1)->count();
                    $raguRaguCount = $data->where('elektabilitas', 3)->count();
                    $popularitasSetujuCount = $data->where('popularitas', 1)->count();

                    // Simpan hasil dengan nama kecamatan dan kelurahan
                    if ($setujuCount > 0) {
                        $results['topKabupatenKotaKecamatanSetuju'][] = [
                            'kabupaten_kota' => $kabupatenKota,
                            'kecamatan' => $kecamatan,
                            'kecamatan_name' => $districtName,
                            'setuju' => $setujuCount
                        ];
                    }
                    if ($raguRaguCount > 0) {
                        $results['topKabupatenKotaKecamatanRaguRagu'][] = [
                            'kabupaten_kota' => $kabupatenKota,
                            'kecamatan' => $kecamatan,
                            'kecamatan_name' => $districtName,
                            'ragu_ragu' => $raguRaguCount
                        ];
                    }
                    if ($popularitasSetujuCount > 0) {
                        $results['topKabupatenKotaKecamatanPopularitasSetuju'][] = [
                            'kabupaten_kota' => $kabupatenKota,
                            'kecamatan' => $kecamatan,
                            'kecamatan_name' => $districtName,
                            'setuju' => $popularitasSetujuCount
                        ];
                    }
                    if ($setujuCount > 0) {
                        $results['topKecamatanKelurahanSetuju'][] = [
                            'kecamatan' => $kecamatan,
                            'kelurahan' => $kelurahan,
                            'kelurahan_name' => $villageName,
                            'setuju' => $setujuCount
                        ];
                    }
                    if ($raguRaguCount > 0) {
                        $results['topKecamatanKelurahanRaguRagu'][] = [
                            'kecamatan' => $kecamatan,
                            'kelurahan' => $kelurahan,
                            'kelurahan_name' => $villageName,
                            'ragu_ragu' => $raguRaguCount
                        ];
                    }
                    if ($popularitasSetujuCount > 0) {
                        $results['topKecamatanKelurahanPopularitasSetuju'][] = [
                            'kecamatan' => $kecamatan,
                            'kelurahan' => $kelurahan,
                            'kelurahan_name' => $villageName,
                            'setuju' => $popularitasSetujuCount
                        ];
                    }
                }
            }
        }

        // Sort and limit the results to the top 3
        foreach ($results as &$result) {
            usort($result, function ($a, $b) {
                return $b['setuju'] <=> $a['setuju'];
            });
            $result = array_slice($result, 0, 3);
        }

        // Mengirimkan data dalam format JSON
        return response()->json($results);
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
