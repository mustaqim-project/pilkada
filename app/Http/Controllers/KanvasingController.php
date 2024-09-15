<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kanvasing;
use App\Models\Cakada;
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
        $cakada = Cakada::all();

        // Pass the data to the view
        return view('mobile.frontend.kanvasing.create', ['provinsi' => $provinsi]);
    }

    public function store(Request $request)
{
    $request->validate([
        'provinsi' => 'required|string|max:255',
        'kabupaten_kota' => 'required|string|max:255',
        'kecamatan' => 'required|string|max:255',
        'kelurahan' => 'required|string|max:255',
        'rw' => 'required|string|max:10',
        'rt' => 'required|string|max:10',
        'cakada_id' => 'required|integer',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'elektabilitas' => 'required|in:1,2,3', // Validasi pilihan 1, 2, 3
        'popularitas' => 'required|in:1,2,3',  // Validasi pilihan 1, 2, 3
        'stiker' => 'required|in:1,2,3',       // Validasi pilihan 1, 2, 3
        'alamat' => 'required|string|max:255',
        'nama_kk' => 'required|string|max:255',
        'nomor_hp' => 'required|string|max:20',
        'jum_pemilih' => 'required|integer',
        'lat' => 'nullable|numeric',
        'lang' => 'nullable|numeric', // Mengganti 'long' menjadi 'lang'
    ]);

    $kanvasing = new Kanvasing($request->except('foto', 'lat', 'lang'));

    // Upload foto jika ada
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $fileName);
        $kanvasing->foto = $fileName;
    }

    // Menyimpan koordinat
    $kanvasing->lat = $request->input('lat');
    $kanvasing->lang = $request->input('lang');

    $kanvasing->save();

    return redirect()->route('kanvasing.index')->with('success', 'Kanvasing entry created successfully.');
}


}
