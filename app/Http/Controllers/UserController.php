<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProdiUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar pengguna (Halaman Manajemen Pengguna)
    public function index()
    {
        $users = User::with('prodiUnit')->latest()->get();
        $prodiList = ProdiUnit::all();

        return view('admin.users', compact('users', 'prodiList'));
    }

    // Menambah pengguna baru
    public function store(Request $request)
    {
        $request->merge(['email' => strtolower(trim($request->email))]);

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nim_nik' => 'required|string|max:30',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@([a-zA-Z0-9-]+\.)*telkomuniversity\.ac\.id$/i',
            ],
            'password' => 'required|string|min:6',
            'prodi_unit_id' => 'required|exists:prodi_unit,id',
        ], [
            'email.regex' => 'Email harus menggunakan domain resmi Telkom University (@...telkomuniversity.ac.id).',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nim_nik' => $request->nim_nik,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'plain_password' => $request->password,
            'prodi_unit_id' => $request->prodi_unit_id,
            'role' => $request->role ?? 'pengaju',
        ]);

        return back()->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    // Memperbarui data pengguna
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->merge(['email' => strtolower(trim($request->email))]);

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nim_nik' => 'required|string|max:30',
            'username' => 'required|string|max:50|unique:users,username,' . $id,
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $id,
                'regex:/^[a-zA-Z0-9._%+-]+@([a-zA-Z0-9-]+\.)*telkomuniversity\.ac\.id$/i',
            ],
            'password' => 'nullable|string|min:6',
            'prodi_unit_id' => 'required|exists:prodi_unit,id',
        ], [
            'email.regex' => 'Email harus menggunakan domain resmi Telkom University (@...telkomuniversity.ac.id).',
        ]);

        $updateData = [
            'nama_lengkap' => $request->nama_lengkap,
            'nim_nik' => $request->nim_nik,
            'username' => $request->username,
            'email' => $request->email,
            'prodi_unit_id' => $request->prodi_unit_id,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
            $updateData['plain_password'] = $request->password;
        }

        $user->update($updateData);

        return back()->with('success', 'Data pengguna berhasil diperbarui!');
    }

    // Menghapus pengguna
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus!');
    }
}
