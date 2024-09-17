<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use App\Models\Cakada;

class CakadaController extends Controller
{
    public function __construct()
    {
        // Membatasi akses dengan permission
        $this->middleware('can:cakada read')->only('index');
        $this->middleware('can:cakada create')->only(['store']);
        $this->middleware('can:cakada update')->only(['update']);
        $this->middleware('can:cakada delete')->only('destroy');
    }

    public function index()
    {
        $provinsiResponse = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        $provinsiData = $provinsiResponse->json();

        // Simpan provinsi dalam cache
        cache(['provinsi' => $provinsiData], 60); // Simpan selama 60 menit

        // Ambil data provinsi yang sudah disimpan
        $provinsi = cache('provinsi');

        $cakadas = Cakada::all();

        return view('desktop.cakada.index', compact('cakadas', 'provinsi'));
    }

    public function getRegencies($provinsiId)
    {
        $regenciesResponse = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$provinsiId}.json");
        return $regenciesResponse->json();
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'provinsi' => 'required|string',
            'kabupaten_kota' => 'required|string',
            'nama_calon_kepala' => 'required|string',
            'nama_calon_wakil' => 'required|string',
        ]);

        // Simpan data cakada baru
        Cakada::create($request->all());

        // Redirect kembali dengan pesan sukses
        return response()->json(['success' => 'Cakada berhasil dibuat.']);
    }

    public function edit($id)
    {
        // Mengambil data cakada berdasarkan ID
        $cakada = Cakada::find($id);

        // Mengirim data cakada untuk modal edit
        return response()->json($cakada);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'provinsi' => 'required|string',
            'kabupaten_kota' => 'required|string',
            'nama_calon_kepala' => 'required|string',
            'nama_calon_wakil' => 'required|string',
        ]);

        // Mengambil data cakada berdasarkan ID dan memperbarui
        $cakada = Cakada::findOrFail($id);
        $cakada->update($request->all());

        // Redirect kembali dengan pesan sukses
        return response()->json(['success' => 'Cakada berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        // Menghapus data cakada berdasarkan ID
        $cakada = Cakada::findOrFail($id);
        $cakada->delete();

        // Redirect kembali dengan pesan sukses
        return response()->json(['success' => 'Cakada berhasil dihapus.']);
    }
}
