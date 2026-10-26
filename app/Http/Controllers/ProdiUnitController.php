<?php

namespace App\Http\Controllers;

use App\Models\ProdiUnit;
use Illuminate\Http\Request;

class ProdiUnitController extends Controller
{
    public function index()
    {
        $prodiList = ProdiUnit::all();
        return response()->json($prodiList);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_prodi_unit' => 'required|string|unique:prodi_unit,nama_prodi_unit|max:100',
        ]);

        $prodi = ProdiUnit::create($request->all());
        return back()->with('success', 'Prodi/Unit berhasil ditambahkan!');
    }
}