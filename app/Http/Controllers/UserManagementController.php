<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\KategoriBerita;
use App\Models\ProdiUnit;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    // 1. Menampilkan Daftar Pengguna
    public function indexUsers()
    {
        $users = User::with('prodiUnit')->get();
        $prodiList = ProdiUnit::all(); // Diperlukan untuk form edit
        return view('admin.users', compact('users', 'prodiList')); 
    }

    // 2. Menyimpan Pengguna Baru dari Menu User Management (Diperbaiki dengan Hash::make)
    public function storeUser(Request $request)
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'nim_nik' => ['required', 'string', 'max:30'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
            'prodi_unit_id' => ['required', 'exists:prodi_unit,id'],
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            // WAJIB menggunakan Hash::make agar terbaca oleh algoritma Bcrypt Laravel
            'password' => Hash::make($request->password),
            'plain_password' => $request->password, 
            'nama_lengkap' => $request->nama_lengkap,
            'nim_nik' => $request->nim_nik,
            'prodi_unit_id' => $request->prodi_unit_id,
            'role' => 'pengaju',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    // 2.1 Memperbarui Data Pengguna (Diperbaiki dengan Hash::make)
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'nim_nik' => ['required', 'string', 'max:30'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username,' . $id],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:6'],
            'prodi_unit_id' => ['required', 'exists:prodi_unit,id'],
        ]);

        $updateData = [
            'nama_lengkap' => $request->nama_lengkap,
            'nim_nik' => $request->nim_nik,
            'username' => $request->username,
            'email' => $request->email,
            'prodi_unit_id' => $request->prodi_unit_id,
        ];

        // Jika password diisi, enkripsi dengan Hash::make dan simpan juga plain_password
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
            $updateData['plain_password'] = $request->password;
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    // 2.2 Menghapus Pengguna
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    // 3. Menampilkan Tab Kategori Berita
    public function indexKategori()
    {
        $kategori = KategoriBerita::all();
        return view('admin.kategori', compact('kategori')); 
    }

    // 3.1 Menyimpan Kategori Berita Baru
    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', 'unique:kategori_berita,nama_kategori'],
        ]);

        KategoriBerita::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berita berhasil ditambahkan.');
    }

    // 3.2 Memperbarui Kategori Berita
    public function updateKategori(Request $request, $id)
    {
        $kategori = KategoriBerita::findOrFail($id);

        $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', 'unique:kategori_berita,nama_kategori,' . $id],
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berita berhasil diperbarui.');
    }

    // 3.3 Menghapus Kategori Berita
    public function destroyKategori($id)
    {
        $kategori = KategoriBerita::findOrFail($id);
        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berita berhasil dihapus.');
    }

    // 4. Menampilkan Tab Program Studi / Unit
    public function indexProdi()
    {
        $prodi = ProdiUnit::all();
        return view('admin.prodi', compact('prodi')); 
    }

    // 4.1 Menyimpan Program Studi / Unit Baru
    public function storeProdi(Request $request)
    {
        $request->validate([
            'nama_prodi_unit' => ['required', 'string', 'max:100', 'unique:prodi_unit,nama_prodi_unit'],
        ]);

        ProdiUnit::create([
            'nama_prodi_unit' => $request->nama_prodi_unit,
        ]);

        return redirect()->route('admin.prodi.index')->with('success', 'Program Studi/Unit berhasil ditambahkan.');
    }

    // 4.2 Memperbarui Program Studi / Unit
    public function updateProdi(Request $request, $id)
    {
        $prodi = ProdiUnit::findOrFail($id);

        $request->validate([
            'nama_prodi_unit' => ['required', 'string', 'max:100', 'unique:prodi_unit,nama_prodi_unit,' . $id],
        ]);

        $prodi->update([
            'nama_prodi_unit' => $request->nama_prodi_unit,
        ]);

        return redirect()->route('admin.prodi.index')->with('success', 'Program Studi/Unit berhasil diperbarui.');
    }

    // 4.3 Menghapus Program Studi / Unit
    public function destroyProdi($id)
    {
        $prodi = ProdiUnit::findOrFail($id);
        $prodi->delete();

        return redirect()->route('admin.prodi.index')->with('success', 'Program Studi/Unit berhasil dihapus.');
    }
}