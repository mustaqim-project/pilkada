<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kanvasing;
use App\Models\Cakada;
use App\Models\Pekerjaan;
use App\Models\TipeCakada;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

use Detection\MobileDetect;

class KanvasingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:kanvasing read')->only('index');
        $this->middleware('can:kanvasing create')->only(['store', 'create']);
    }


    // app/Http/Controllers/KanvasingController.php

    public function index()
    {
        $detect = new MobileDetect;

        // Mengambil data Kanvasing beserta data relasi
        $kanvasings = Kanvasing::with(['tipeCakada', 'cakada', 'pekerjaan','user'])->get();

        // Mendapatkan daftar semua provinsi terlebih dahulu
        $provinsiResponse = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json");
        $provinces = $provinsiResponse->json();

        foreach ($kanvasings as $kanvasing) {
            // Mendapatkan nama provinsi
            $provinsi = collect($provinces)->firstWhere('id', $kanvasing->provinsi);
            $kanvasing->provinsi_name = $provinsi ? $provinsi['name'] : 'Tidak Diketahui';

            // Mendapatkan nama kabupaten/kota
            $kabupatenResponse = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regency/{$kanvasing->kabupaten_kota}.json");
            $kabupaten = $kabupatenResponse->json();
            $kanvasing->kabupaten_name = $kabupaten['name'] ?? 'Tidak Diketahui';

            // Mendapatkan nama kecamatan
            $kecamatanResponse = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/district/{$kanvasing->kecamatan}.json");
            $kecamatan = $kecamatanResponse->json();
            $kanvasing->kecamatan_name = $kecamatan['name'] ?? 'Tidak Diketahui';

            // Mendapatkan nama kelurahan
            $kelurahanResponse = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/village/{$kanvasing->kelurahan}.json");
            $kelurahan = $kelurahanResponse->json();
            $kanvasing->kelurahan_name = $kelurahan['name'] ?? 'Tidak Diketahui';

            // Mendapatkan nama tipe cakada
            $kanvasing->user_name = $kanvasing->user->name ?? 'Tidak Diketahui';

            $kanvasing->tipe_cakada_name = $kanvasing->tipeCakada->name ?? 'Tidak Diketahui';

            // Mendapatkan nama cakada
            $kanvasing->cakada_kelapa = $kanvasing->cakada->nama_calon_kepala ?? 'Tidak Diketahui';
            $kanvasing->cakada_wakil = $kanvasing->cakada->nama_calon_wakil ?? 'Tidak Diketahui';

            // Mendapatkan nama pekerjaan
            $kanvasing->pekerjaan_name = $kanvasing->pekerjaan->nama_pekerjaan ?? 'Tidak Diketahui';
        }

        if ($detect->isMobile() || $detect->isTablet()) {
            return view('mobile.frontend.kanvasing.index', compact('kanvasings'));
        } else {
            if (Auth::check()) {
                return view('desktop.kanvasing.index', compact('kanvasings'));
            } else {
                return redirect('/');
            }
        }
    }






    public function create()
    {
        // Fetch data from API
        $provinsi = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')->json();
        $tipe_cakada = TipeCakada::all();
        $cakada = Cakada::all();
        $pekerjaan = Pekerjaan::all();
        $detect = new MobileDetect;

        // Cek jenis perangkat
        if ($detect->isMobile() || $detect->isTablet()) {
            return view('mobile.frontend.kanvasing.create', [
                'provinsi' => $provinsi,
                'tipe_cakada' => $tipe_cakada,
                'cakada' => $cakada,
                'pekerjaan' => $pekerjaan
            ]);
        } else {
            if (Auth::check()) {
                return view('desktop.kanvasing.create', [
                    'provinsi' => $provinsi,
                    'tipe_cakada' => $tipe_cakada,
                    'cakada' => $cakada,
                    'pekerjaan' => $pekerjaan
                ]);
            } else {
                return redirect('/'); // Arahkan ke halaman root jika user tidak login
            }
        }
    }



    public function getCakadaByFilters(Request $request)
    {
        $provinsiId = $request->input('provinsi');
        $kabupatenKotaId = $request->input('kabupaten_kota');
        $tipeCakadaId = $request->input('tipe_cakada_id');

        $cakada = Cakada::where('provinsi', $provinsiId)
            ->where('kabupaten_kota', $kabupatenKotaId)
            ->where('tipe_cakada_id', $tipeCakadaId)
            ->get();

        return response()->json($cakada);
    }

    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'user_id' => 'required|integer',
            'provinsi' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'rw' => 'required|string|max:10',
            'rt' => 'required|string|max:10',
            'tipe_cakada_id' => 'required|integer',
            'cakada_id' => 'required|integer',
            'nama_kk' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:20',
            'usia' => 'required|integer',
            'pekerjaan_id' => 'required|integer',
            'jum_pemilih' => 'required|integer',
            'elektabilitas' => 'required|in:1,2,3',
            'popularitas' => 'required|in:1,2',
            'stiker' => 'required|in:1,2',
            'jenis_kelamin' => 'required|in:1,2',
            'alasan' => 'nullable|string',
            'pesan' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:9000',
            'alamat' => 'required|string|max:255',
            'lat' => 'nullable|string',
            'lang' => 'nullable|string',
        ]);



        // Buat instance Kanvasing baru
        $kanvasing = new Kanvasing();

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploads/' . $fileName;
            $file->move(public_path('uploads'), $fileName);

            // Simpan URL path foto
            $kanvasing->foto = $filePath;
        }

        // Simpan data form lainnya
        $kanvasing->fill($request->except('foto'));

        // Simpan data ke database
        $kanvasing->save();

        // Redirect ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Kanvasing Berhasil Disimpan.');
    }
}
