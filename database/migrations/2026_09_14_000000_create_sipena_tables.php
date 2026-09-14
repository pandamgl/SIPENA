<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel prodi_unit
        Schema::create('prodi_unit', function (Blueprint $table) {
            $table->id();
            $table->string('nama_prodi_unit', 100)->unique();
        });

        // 2. Tabel kategori_berita
        Schema::create('kategori_berita', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori', 50)->unique();
        });

        // 3. Tabel users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->string('nama_lengkap', 100);
            $table->string('nim_nik', 30);
            $table->foreignId('prodi_unit_id')->constrained('prodi_unit');
            $table->enum('role', ['pengaju', 'admin']);
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });

        // 4. Tabel pengajuan_berita
        Schema::create('pengajuan_berita', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('judul_berita', 255);
            $table->foreignId('kategori_id')->constrained('kategori_berita');
            $table->date('tanggal_Mulai');
            $table->date('tanggal_selesai');
            $table->text('narasi_berita');
            $table->text('link_dokumentasi');
            $table->string('kontak_person', 15);
            $table->enum('status', ['Pending', 'Approved', 'Rejected']);
            $table->text('link_publikasi')->nullable();
            $table->timestamps();
        });

        // 5. Tabel log_aksi_admin
        Schema::create('log_aksi_admin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan_berita')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->string('status_sebelumnya', 20);
            $table->string('status_baru', 20);
            $table->text('catatan')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_aksi_admin');
        Schema::dropIfExists('pengajuan_berita');
        Schema::dropIfExists('users');
        Schema::dropIfExists('kategori_berita');
        Schema::dropIfExists('prodi_unit');
    }
};
