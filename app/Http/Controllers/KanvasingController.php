<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kanvasing;
use App\Models\Cakada;
use App\Models\TipeCakada;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class KanvasingController extends Controller
{

    public function __construct()
    {
        // Membatasi akses dengan permission
        $this->middleware('can:kanvasing read')->only('index');
        $this->middleware('can:kanvasing create')->only(['store']);
        $this->middleware('can:kanvasing create')->only(['create']);
    }

    public function index()
    {
        $kanvasings = Cakada::all();
        $kanvasings = Kanvasing::all();
        return view('kanvasing.index', compact('kanvasings'));
    }

    public function create()
    {
        // Fetch the data from the API
        $provinsi = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')->json();
        $tipe_cakada = TipeCakada::all();
        $cakada = Cakada::all();

        // Pass the data to the view
        return view('mobile.frontend.kanvasing.create', [
            'provinsi' => $provinsi,
            'tipe_cakada' => $tipe_cakada,
            'cakada' => $cakada
        ]);
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
            'jum_pemilih' => 'required|integer',
            'elektabilitas' => 'required|in:1,2,3',
            'popularitas' => 'required|in:1,2',
            'stiker' => 'required|in:1,2',
            'alasan' => 'nullable|string',
            'pesan' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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
        return redirect()->route('dashboard')->with('success', 'Kanvasing entry created successfully.');
    }
}
