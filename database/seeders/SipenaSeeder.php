<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\ProdiUnit;
use App\Models\KategoriBerita;
use App\Models\User;

class SipenaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Prodi Unit
        $prodi1 = ProdiUnit::create(['nama_prodi_unit' => 'S1 Teknik Informatika']);
        $prodi2 = ProdiUnit::create(['nama_prodi_unit' => 'S1 Sistem Informasi']);
        $prodi3 = ProdiUnit::create(['nama_prodi_unit' => 'Humas / Internal']);

        // 2. Kategori Berita
        KategoriBerita::create(['nama_kategori' => 'Riset Dosen']);
        KategoriBerita::create(['nama_kategori' => 'Prestasi Mahasiswa']);
        KategoriBerita::create(['nama_kategori' => 'Event Kampus']);

        // 3. Akun Admin
        User::create([
            'username' => 'admin',
            'password' => Hash::make('password123'),
            'nama_lengkap' => 'Admin Humas',
            'nim_nik' => '19900101',
            'prodi_unit_id' => $prodi3->id,
            'role' => 'admin',
        ]);

        // 4. Akun User (Pengaju)
        User::create([
            'username' => '2211102281',
            'password' => Hash::make('password123'),
            'nama_lengkap' => 'AGAM YOGI PRASETYO',
            'nim_nik' => '2211102281',
            'prodi_unit_id' => $prodi1->id,
            'role' => 'pengaju',
        ]);
    }
}