@extends('layouts.admin')

@section('title', 'Detail Pengajuan Berita - SIPENA')

@push('styles')
    <style>
        /* Reset & Font Setup */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            color: #333;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background-color: #ffffff;
            border-right: 1px solid #e0e0e0;
            display: flex;
            flex-direction: column;
            padding-top: 40px;
            flex-shrink: 0;
        }

        .profile-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .profile-circle {
            width: 120px;
            height: 120px;
            background-color: #e0e0e0;
            border-radius: 50%;
            margin: 0 auto 15px auto;
        }

        .profile-name {
            font-size: 16px;
            color: #1a1a1a;
            font-weight: 500;
        }

        .menu-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .menu-item {
            padding: 15px 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            color: #333;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .menu-item i {
            font-size: 18px;
            width: 20px;
            text-align: center;
        }

        .menu-item.active {
            background-color: #ffcdd2;
            color: #1a1a1a;
            border-top-right-radius: 25px;
            border-bottom-right-radius: 25px;
            margin-right: 10px;
        }

        .menu-item:hover:not(.active) {
            background-color: #f5f5f5;
            border-top-right-radius: 25px;
            border-bottom-right-radius: 25px;
            margin-right: 10px;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
        }

        .topbar {
            background-color: #f5f5f5;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 25px;
            padding: 20px 40px;
        }

        .bell-icon {
            font-size: 24px;
            color: #333;
            cursor: pointer;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #e0e0e0;
            padding: 8px 15px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 18px;
        }

        .page-header {
            background-color: #f5f5f5;
            padding: 0 40px 20px 40px;
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 28px;
            color: #1a1a1a;
            font-weight: 600;
        }

        .form-container {
            padding: 0 40px 50px 40px;
            max-width: 1000px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            margin-top: 35px;
            color: #1a1a1a;
        }

        .form-label {
            display: block;
            font-size: 15px;
            margin-bottom: 8px;
            color: #1a1a1a;
            font-weight: 500;
        }

        .form-control-gray {
            width: 100%;
            padding: 14px 18px;
            background-color: #e3e3e3;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            color: #1a1a1a;
            font-family: inherit;
        }

        input[readonly],
        textarea[readonly] {
            cursor: default;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .date-range-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        textarea.form-control-gray {
            resize: none;
            min-height: 150px;
        }

        .link-preview-box {
            background-color: #e3e3e3;
            padding: 14px 18px;
            border-radius: 8px;
            font-size: 14px;
        }

        .link-preview-box a {
            color: #0066cc;
            text-decoration: none;
            font-weight: 500;
        }

        .link-preview-box a:hover {
            text-decoration: underline;
        }

        .btn-kembali {
            background-color: transparent;
            color: #1a1a1a;
            border: 2px solid #1a1a1a;
            padding: 10px 30px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 30px;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-kembali:hover {
            background-color: #f0f0f0;
        }
    </style>
@endpush

@section('content')
    <!-- Banner Judul Halaman -->
    <div class="page-header">
        <h1>Detail Pengajuan Berita</h1>
    </div>

    <!-- Formulir Read-Only Sesuai Desain Asli -->
    <div class="form-container">

        <!-- SECTION I: Informasi Pengguna -->
        <h3 class="section-title">I. Informasi Pengguna</h3>
        <div class="grid-3">
            <div>
                <label class="form-label">1. Nama</label>
                <input type="text" class="form-control-gray" value="{{ $pengajuan->user->nama_lengkap ?? '-' }}" readonly>
            </div>
            <div>
                <label class="form-label">2. NIM/NIK</label>
                <input type="text" class="form-control-gray" value="{{ $pengajuan->user->nim_nik ?? '-' }}" readonly>
            </div>
            <div>
                <label class="form-label">3. Prodi/Unit</label>
                <input type="text" class="form-control-gray" value="{{ $pengajuan->user->prodiUnit->nama_prodi_unit ?? '-' }}" readonly>
            </div>
        </div>

        <!-- SECTION II: Informasi Dasar Kegiatan -->
        <h3 class="section-title">II. Informasi Dasar Kegiatan</h3>
        <div style="margin-bottom: 20px;">
            <label class="form-label">1. Judul Berita atau Kegiatan</label>
            <input type="text" class="form-control-gray" value="{{ $pengajuan->judul_berita }}" readonly>
        </div>

        <div class="grid-2" style="margin-bottom: 20px;">
            <div>
                <label class="form-label">2. Kategori Berita</label>
                <input type="text" class="form-control-gray" value="{{ $pengajuan->kategori->nama_kategori ?? '-' }}" readonly>
            </div>
            <div>
                <label class="form-label">3. Tanggal Pelaksanaan</label>
                <div class="date-range-wrapper">
                    <input type="text" class="form-control-gray" value="{{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->format('d/m/Y') }}" readonly>
                    <span style="font-weight: bold;">-</span>
                    <input type="text" class="form-control-gray" value="{{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai)->format('d/m/Y') }}" readonly>
                </div>
            </div>
        </div>

        <!-- SECTION III: Narasi Berita -->
        <h3 class="section-title">III. Narasi Berita</h3>
        <div>
            <textarea class="form-control-gray" readonly>{{ $pengajuan->narasi_berita }}</textarea>
        </div>

        <!-- SECTION IV: Lampiran dan Kontak -->
        <h3 class="section-title">IV. Lampiran dan Kontak</h3>
        <div style="margin-bottom: 20px;">
            <label class="form-label">1. Link Dokumentasi (min. 3 Foto)</label>
            <div class="link-preview-box">
                <a href="{{ $pengajuan->link_dokumentasi }}" target="_blank">
                    <i class="fa-solid fa-link"></i> {{ $pengajuan->link_dokumentasi }}
                </a>
            </div>
        </div>
        <div>
            <label class="form-label">2. Kontak Person</label>
            <input type="text" class="form-control-gray" value="{{ $pengajuan->kontak_person }}" style="width: 50%;" readonly>
        </div>

        <!-- Tombol Kembali -->
        <a href="{{ route('admin.dashboard') }}" class="btn-kembali">Kembali</a>

    </div>
@endsection