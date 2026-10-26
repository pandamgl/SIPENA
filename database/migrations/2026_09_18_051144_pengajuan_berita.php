<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuan_berita', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('judul_berita', 255);
            $table->foreignId('kategori_id')->constrained('kategori_berita');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->text('narasi_berita');
            $table->text('link_dokumentasi');
            $table->string('kontak_person', 15);
            $table->enum('status', ['In Review', 'In Progress', 'Publish', 'Rejected'])->default('In Review');
            $table->text('link_publikasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_berita');
    }
};
