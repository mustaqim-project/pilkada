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
        $provinsi = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')->json();

        // Ambil data tipe Cakada (1 = provinsi, 2 = kab/kota) dari database
        $cakadas = Cakada::all();

        return view('desktop.cakada.index', compact('provinsi', 'cakadas'));
    }

    public function create()
    {
        return view('cakada.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'provinsi' => 'required|string',
            'kabupaten_kota' => 'required|string',
            'nama_calon_kepala' => 'required|string',
            'nama_calon_wakil' => 'required|string',
        ]);

        Cakada::create($request->all());

        return redirect()->route('cakada.index')->with('success', 'Cakada created successfully.');
    }

    public function edit(Cakada $cakada)
    {
        return view('cakada.edit', compact('cakada'));
    }

    public function update(Request $request, Cakada $cakada)
    {
        $request->validate([
            'provinsi' => 'required|string',
            'kabupaten_kota' => 'required|string',
            'nama_calon_kepala' => 'required|string',
            'nama_calon_wakil' => 'required|string',
        ]);

        $cakada->update($request->all());

        return redirect()->route('cakada.index')->with('success', 'Cakada updated successfully.');
    }

    public function destroy(Cakada $cakada)
    {
        $cakada->delete();

        return redirect()->route('cakada.index')->with('success', 'Cakada deleted successfully.');
    }
}
