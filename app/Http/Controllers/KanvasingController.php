<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kanvasing;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class KanvasingController extends Controller
{
    public function create()
    {
        // Fetch the data from the API
        $provinsi = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')->json();

        // Pass the data to the view
        return view('kanvasing.create', ['provinsi' => $provinsi]);
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
            'elektabilitas' => 'required|numeric',
            'popularitas' => 'required|numeric',
            'alamat' => 'required|string|max:255',
            'nama_kk' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:20',
            'jum_pemilih' => 'required|integer',
            'lat' => 'nullable|numeric',
            'long' => 'nullable|numeric',
        ]);

        $kanvasing = new Kanvasing($request->except('foto', 'lat', 'long'));

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);
            $kanvasing->foto = $fileName;
        }

        // Store coordinates
        if ($request->has('lat') && $request->has('long')) {
            $kanvasing->koordinat = $request->input('lat') . ',' . $request->input('long');
        }

        $kanvasing->save();

        return redirect()->route('kanvasing.index')->with('success', 'Kanvasing entry created successfully.');
    }

    public function index()
    {
        $kanvasings = Kanvasing::all();
        return view('kanvasing.index', compact('kanvasings'));
    }
}
