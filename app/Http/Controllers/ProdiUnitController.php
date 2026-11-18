<?php

namespace App\Http\Controllers;

use App\Models\ProdiUnit;
use Illuminate\Http\Request;

class ProdiUnitController extends Controller
{
    // API list (JSON)
    public function index()
    {
        $prodiList = ProdiUnit::all();
        return response()->json($prodiList);
    }

    // View halaman Manajemen Prodi / Unit (Admin)
    public function adminIndex()
    {
        $prodiList = ProdiUnit::all();
        return view('admin.prodi', compact('prodiList'));
    }

    // Simpan Prodi/Unit baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_prodi_unit' => 'required|string|unique:prodi_unit,nama_prodi_unit|max:100',
        ]);

        ProdiUnit::create($request->all());
        return back()->with('success', 'Prodi/Unit berhasil ditambahkan!');
    }

    // Update Prodi/Unit
    public function update(Request $request, $id)
    {
        $prodi = ProdiUnit::findOrFail($id);

        $request->validate([
            'nama_prodi_unit' => 'required|string|max:100|unique:prodi_unit,nama_prodi_unit,' . $id,
        ]);

        $prodi->update($request->all());
        return back()->with('success', 'Program Studi/Unit berhasil diperbarui!');
    }

    // Hapus Prodi/Unit
    public function destroy($id)
    {
        $prodi = ProdiUnit::findOrFail($id);
        $prodi->delete();

        return back()->with('success', 'Program Studi/Unit berhasil dihapus!');
    }
}
