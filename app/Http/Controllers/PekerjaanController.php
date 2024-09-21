<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{
    /**
     * Menampilkan daftar semua pekerjaan.
     */
    public function index()
    {
        $pekerjaans = Pekerjaan::all(); // Mengambil semua data pekerjaan
        return view('pekerjaan.index', compact('pekerjaans'));
    }

    /**
     * Menampilkan form untuk menambahkan pekerjaan baru.
     */
    public function create()
    {
        return view('pekerjaan.create');
    }

    /**
     * Menyimpan data pekerjaan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pekerjaan' => 'required|string|max:255',
        ]);

        Pekerjaan::create([
            'nama_pekerjaan' => $request->nama_pekerjaan,
        ]);

        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil ditambahkan.');
    }

    /**
     * Menampilkan data pekerjaan secara detail.
     */
    public function show(Pekerjaan $pekerjaan)
    {
        return view('pekerjaan.show', compact('pekerjaan'));
    }

    /**
     * Menampilkan form untuk mengedit data pekerjaan.
     */
    public function edit(Pekerjaan $pekerjaan)
    {
        return view('pekerjaan.edit', compact('pekerjaan'));
    }

    /**
     * Mengupdate data pekerjaan yang sudah ada.
     */
    public function update(Request $request, Pekerjaan $pekerjaan)
    {
        $request->validate([
            'nama_pekerjaan' => 'required|string|max:255',
        ]);

        $pekerjaan->update([
            'nama_pekerjaan' => $request->nama_pekerjaan,
        ]);

        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil diperbarui.');
    }

    /**
     * Menghapus data pekerjaan.
     */
    public function destroy(Pekerjaan $pekerjaan)
    {
        $pekerjaan->delete();

        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil dihapus.');
    }
}
