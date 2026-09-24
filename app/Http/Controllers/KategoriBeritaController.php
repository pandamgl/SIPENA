<?php

namespace App\Http\Controllers;

use App\Models\KategoriBerita;
use Illuminate\Http\Request;

class KategoriBeritaController extends Controller
{
    public function index()
    {
        $kategoriList = KategoriBerita::all();
        return response()->json($kategoriList);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|unique:kategori_berita,nama_kategori|max:50',
        ]);

        KategoriBerita::create($request->all());
        return back()->with('success', 'Kategori berita berhasil ditambahkan!');
    }
}