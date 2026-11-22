<?php

namespace App\Http\Controllers;

use App\Models\KategoriBerita;
use Illuminate\Http\Request;

class KategoriBeritaController extends Controller
{
    // API list (JSON)
    public function index()
    {
        $kategoriList = KategoriBerita::all();
        return response()->json($kategoriList);
    }

    // View halaman Manajemen Kategori (Admin)
    public function adminIndex()
    {
        $kategoriList = KategoriBerita::all();
        return view('admin.kategori', compact('kategoriList'));
    }

    // Simpan Kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|unique:kategori_berita,nama_kategori|max:50',
        ]);

        KategoriBerita::create($request->all());
        return back()->with('success', 'Kategori berita berhasil ditambahkan!');
    }

    // Update Kategori
    public function update(Request $request, $id)
    {
        $kategori = KategoriBerita::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:kategori_berita,nama_kategori,' . $id,
        ]);

        $kategori->update($request->all());
        return back()->with('success', 'Kategori berita berhasil diperbarui!');
    }

    // Hapus Kategori
    public function destroy($id)
    {
        $kategori = KategoriBerita::findOrFail($id);
        $kategori->delete();

        return back()->with('success', 'Kategori berita berhasil dihapus!');
    }
}
