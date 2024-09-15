<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipeCakada;

class TipeCakadaController extends Controller
{


    public function __construct()
    {
        // Membatasi akses dengan permission
        $this->middleware('can:tipe_cakada read')->only('index');
        $this->middleware('can:tipe_cakada create')->only(['create', 'store']);
        $this->middleware('can:tipe_cakada update')->only(['edit', 'update']);
        $this->middleware('can:tipe_cakada delete')->only('destroy');
    }

    // Menampilkan daftar tipe cakada dan form tambah/edit dalam satu halaman
    public function index()
    {
        $tipeCakada = TipeCakada::all();
        return view('tipe_cakada.index', compact('tipeCakada'));
    }

    // Menyimpan tipe cakada baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        TipeCakada::create([
            'name' => $request->name,
        ]);

        return redirect()->route('tipe_cakada.index')->with('success', 'Tipe Cakada berhasil ditambahkan!');
    }

    // Mengupdate tipe cakada di database
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tipeCakada = TipeCakada::findOrFail($id);
        $tipeCakada->update([
            'name' => $request->name,
        ]);

        return redirect()->route('tipe_cakada.index')->with('success', 'Tipe Cakada berhasil diupdate!');
    }

    // Menghapus tipe cakada dari database
    public function destroy($id)
    {
        $tipeCakada = TipeCakada::findOrFail($id);
        $tipeCakada->delete();

        return redirect()->route('tipe_cakada.index')->with('success', 'Tipe Cakada berhasil dihapus!');
    }
}
