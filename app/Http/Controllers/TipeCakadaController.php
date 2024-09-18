<?php

namespace App\Http\Controllers;

use Detection\MobileDetect;
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

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $detect = new MobileDetect;
        $tipeCakada = TipeCakada::all();
        $viewPath = $detect->isMobile() || $detect->isTablet()
            ? 'mobile.tipe_cakada.index'
            : 'desktop.tipe_cakada.index';

        return view($viewPath, compact('tipeCakada'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tipeCakada = TipeCakada::findOrFail($id);
        $tipeCakada->delete();

        return redirect()->route('tipe_cakada.index')->with('success', 'Tipe Cakada berhasil dihapus!');
    }
}
