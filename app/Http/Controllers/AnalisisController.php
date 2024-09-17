<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kanvasing;
use DB;
use Illuminate\Support\Facades\Http;
use App\Models\Cakada;
use App\Models\TipeCakada;

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



    // public function get_grafik_suara(Request $request)
    // {
    //     // Ambil parameter filter
    //     $provinsi = $request->input('provinsi');
    //     $kabupaten_kota = $request->input('kabupaten_kota');
    //     $kecamatan = $request->input('kecamatan');
    //     $kelurahan = $request->input('kelurahan');
    //     $tipe_cakada_id = $request->input('tipe_cakada_id');
    //     $cakada_id = $request->input('cakada_id');

    //     // Ambil data dari tabel Kanvasing dengan filter
    //     $query = Kanvasing::select(
    //         'provinsi',
    //         'kabupaten_kota',
    //         'kecamatan',
    //         'kelurahan',
    //         'cakada_id',
    //         DB::raw('COUNT(CASE WHEN elektabilitas = 1 THEN 1 END) as setuju'),
    //         DB::raw('COUNT(CASE WHEN elektabilitas = 2 THEN 1 END) as tidak_setuju'),
    //         DB::raw('COUNT(CASE WHEN elektabilitas = 3 THEN 1 END) as ragu_ragu'),
    //         DB::raw('COUNT(CASE WHEN popularitas = 1 THEN 1 END) as kenal'),
    //         DB::raw('COUNT(CASE WHEN popularitas = 2 THEN 1 END) as tidak_kenal')
    //     )->groupBy('provinsi', 'kabupaten_kota', 'kecamatan', 'kelurahan', 'cakada_id');

    //     // Tambahkan filter
    //     if ($provinsi) {
    //         $query->where('provinsi', $provinsi);
    //     }
    //     if ($kabupaten_kota) {
    //         $query->where('kabupaten_kota', $kabupaten_kota);
    //     }
    //     if ($kecamatan) {
    //         $query->where('kecamatan', $kecamatan);
    //     }
    //     if ($kelurahan) {
    //         $query->where('kelurahan', $kelurahan);
    //     }
    //     if ($tipe_cakada_id) {
    //         $query->where('cakada_id', $tipe_cakada_id);
    //     }
    //     if ($cakada_id) {
    //         $query->where('cakada_id', $cakada_id);
    //     }

    //     // Eksekusi query
    //     $data = $query->get();

    //     // Gabungkan data cakada untuk menampilkan nama lengkap
    //     $cakadas = Cakada::all()->keyBy('id');
    //     $data->transform(function ($item) use ($cakadas) {
    //         $cakada = $cakadas[$item->cakada_id] ?? null;
    //         $item->cakada_name = $cakada ? $cakada->nama_calon_kepala . ' & ' . $cakada->nama_calon_wakil : 'Unknown';
    //         return $item;
    //     });

    //     return response()->json($data);
    // }
    // public function get_grafik_suara(Request $request)
    // {
    //     // Ambil parameter filter
    //     $provinsi = $request->input('provinsi');
    //     $kabupaten_kota = $request->input('kabupaten_kota');
    //     $kecamatan = $request->input('kecamatan');
    //     $kelurahan = $request->input('kelurahan');
    //     $tipe_cakada_id = $request->input('tipe_cakada_id');
    //     $cakada_id = $request->input('cakada_id');

    //     // Query data berdasarkan filter
    //     $query = Kanvasing::selectRaw(
    //         'provinsi, kabupaten_kota, kecamatan, kelurahan, tipe_cakada_id, cakada_id,
    //         COUNT(CASE WHEN elektabilitas = 1 THEN 1 END) as setuju,
    //         COUNT(CASE WHEN elektabilitas = 2 THEN 1 END) as tidak_setuju,
    //         COUNT(CASE WHEN elektabilitas = 3 THEN 1 END) as ragu_ragu,
    //         COUNT(CASE WHEN popularitas = 1 THEN 1 END) as kenal,
    //         COUNT(CASE WHEN popularitas = 2 THEN 1 END) as tidak_kenal'
    //     )
    //     ->when($provinsi, fn($query) => $query->where('provinsi', $provinsi))
    //     ->when($kabupaten_kota, fn($query) => $query->where('kabupaten_kota', $kabupaten_kota))
    //     ->when($kecamatan, fn($query) => $query->where('kecamatan', $kecamatan))
    //     ->when($kelurahan, fn($query) => $query->where('kelurahan', $kelurahan))
    //     ->when($tipe_cakada_id, fn($query) => $query->where('tipe_cakada_id', $tipe_cakada_id))
    //     ->when($cakada_id, fn($query) => $query->where('cakada_id', $cakada_id))
    //     ->groupBy('provinsi', 'kabupaten_kota', 'kecamatan', 'kelurahan', 'tipe_cakada_id', 'cakada_id')
    //     ->first();

    //     if (!$query) {
    //         return response()->json(['message' => 'Data not found'], 404);
    //     }

    //     // Siapkan data untuk grafik
    //     return response()->json([
    //         'labels' => ['Setuju', 'Tidak Setuju', 'Ragu-ragu'],
    //         'setuju' => [$query->setuju],
    //         'tidak_setuju' => [$query->tidak_setuju],
    //         'ragu_ragu' => [$query->ragu_ragu],
    //     ]);
    // }

    public function get_grafik_suara(Request $request)
{
    // Ambil parameter filter
    $provinsi = $request->input('provinsi');
    $kabupaten_kota = $request->input('kabupaten_kota');
    $kecamatan = $request->input('kecamatan');
    $kelurahan = $request->input('kelurahan');
    $tipe_cakada_id = $request->input('tipe_cakada_id');
    $cakada_id = $request->input('cakada_id');

    // Query data berdasarkan filter
    $query = Kanvasing::selectRaw(
        'COUNT(CASE WHEN elektabilitas = 1 THEN 1 END) as setuju,
        COUNT(CASE WHEN elektabilitas = 2 THEN 1 END) as tidak_setuju,
        COUNT(CASE WHEN elektabilitas = 3 THEN 1 END) as ragu_ragu'
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
    dd($query);

    // Siapkan data untuk grafik
    return response()->json([
        'labels' => ['Setuju', 'Tidak Setuju', 'Ragu-ragu'],
        'setuju' => $query->setuju,
        'tidak_setuju' => $query->tidak_setuju,
        'ragu_ragu' => $query->ragu_ragu,
    ]);
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
