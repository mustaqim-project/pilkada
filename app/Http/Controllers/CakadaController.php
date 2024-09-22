<?php

namespace App\Http\Controllers;

use Detection\MobileDetect;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Cakada;
use App\Models\TipeCakada;

class CakadaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:cakada read')->only('index');
        $this->middleware('can:cakada create')->only(['store']);
        $this->middleware('can:cakada update')->only(['update']);
        $this->middleware('can:cakada delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $detect = new MobileDetect;

        $provinsiResponse = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        $provinsiData = $provinsiResponse->json();

        cache(['provinsi' => $provinsiData], 60);

        $provinsi = cache('provinsi');

        $cakadas = Cakada::all();
        $tipe_cakada = TipeCakada::all();

        $viewPath = $detect->isMobile() || $detect->isTablet()
            ? 'mobile.cakada.index'
            : 'desktop.cakada.index';

        return view($viewPath, compact('cakadas', 'tipe_cakada', 'provinsi'));
    }

    public function create(Request $request)
    {
        $detect = new MobileDetect;

        $provinsiResponse = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        $provinsiData = $provinsiResponse->json();

        cache(['provinsi' => $provinsiData], 60);

        $provinsi = cache('provinsi');

        $cakadas = Cakada::all();
        $tipe_cakada = TipeCakada::all();

        $viewPath = $detect->isMobile() || $detect->isTablet()
            ? 'mobile.cakada.create'
            : 'desktop.cakada.create';

        return view($viewPath, compact('cakadas', 'tipe_cakada', 'provinsi'));
    }

    public function getRegencies($provinsiId)
    {
        $regenciesResponse = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$provinsiId}.json");
        return $regenciesResponse->json();
    }


    public function store(Request $request)
    {
        $request->validate([
            'provinsi' => 'required|string',
            'kabupaten_kota' => 'required|string',
            'tipe_cakada_id' => 'required|integer',
            'nama_calon_kepala' => 'required|string',
            'nama_calon_wakil' => 'required|string',
        ]);

        Cakada::create($request->all());

        return redirect()->route('cakada.index')->with('success', 'Cakada berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $detect = new MobileDetect;

        $cakada = Cakada::findOrFail($id);
        $provinsiResponse = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        $provinsiData = $provinsiResponse->json();
        $tipe_cakada = TipeCakada::all();

        $viewPath = $detect->isMobile() || $detect->isTablet()
            ? 'mobile.cakada.edit'
            : 'desktop.cakada.edit';

        return view($viewPath, compact('cakadas', 'tipe_cakada', 'provinsi'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'provinsi' => 'required|string',
            'kabupaten_kota' => 'required|string',
            'tipe_cakada_id' => 'required|integer',
            'nama_calon_kepala' => 'required|string',
            'nama_calon_wakil' => 'required|string',
        ]);

        $cakada = Cakada::findOrFail($id);
        $cakada->update($request->all());

        return redirect()->route('cakada.index')->with('success', 'Cakada berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $cakada = Cakada::findOrFail($id);
        $cakada->delete();

        return redirect()->route('cakada.index')->with('success', 'Cakada berhasil dihapus!');
    }
}
