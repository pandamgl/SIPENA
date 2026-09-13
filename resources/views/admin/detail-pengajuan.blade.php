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
        }

        .form-control-bordered {
            width: 100%;
            padding: 14px 18px;
            background-color: #ffffff;
            border: 1px solid #1a1a1a;
            border-radius: 8px;
            font-size: 14px;
            color: #1a1a1a;
            font-family: inherit;
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

        textarea.form-control-gray {
            resize: none;
            min-height: 150px;
        }

        .upload-review-box {
            width: 100%;
            height: 250px;
            border: 2px dashed #1a1a1a;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 25px;
            background-color: #fafafa;
        }

        .btn-download-attachment {
            background-color: #ff4d4f;
            color: white;
            border: none;
            width: 80px;
            height: 80px;
            border-radius: 12px;
            font-size: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-download-attachment:hover {
            background-color: #d9363e;
            transform: scale(1.05);
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
        <h1>Pengajuan Berita</h1>
    </div>

    <!-- Formulir Read-Only untuk Admin -->
    <div class="form-container">

        <!-- SECTION I -->
        <h3 class="section-title">I. Informasi Pengaju</h3>
        <div class="grid-3">
            <div>
                <label class="form-label">1. Nama</label>
                <input type="text" class="form-control-bordered" value="AGAM YOGI PRASETYO" readonly>
            </div>
            <div>
                <label class="form-label">2. NIM</label>
                <input type="text" class="form-control-bordered" value="2211102281" readonly>
            </div>
            <div>
                <label class="form-label">3. Prodi</label>
                <input type="text" class="form-control-bordered" value="S1 Teknik Informatika" readonly>
            </div>
        </div>

        <!-- SECTION II -->
        <h3 class="section-title">II. Informasi Dasar Kegiatan</h3>
        <div style="margin-bottom: 20px;">
            <label class="form-label">1. Judul Berita atau Kegiatan</label>
            <input type="text" class="form-control-gray" value="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" readonly>
        </div>

        <div class="grid-2">
            <div>
                <label class="form-label">2. Kategori Berita</label>
                <input type="text" class="form-control-bordered" value="Riset Dosen" readonly>
            </div>
            <div>
                <label class="form-label">3. Tanggal Pelaksanaan</label>
                <input type="text" class="form-control-bordered" value="17/08/2025" readonly>
            </div>
        </div>

        <!-- SECTION III -->
        <h3 class="section-title">III. Narasi Utama</h3>
        <div>
            <textarea class="form-control-gray" readonly>XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
    XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX</textarea>
        </div>

        <!-- SECTION IV -->
        <h3 class="section-title">IV. Lampiran dan Kontak</h3>
        <div style="margin-bottom: 20px;">
            <label class="form-label">1. Upload Dokumentasi</label>
            <div class="upload-review-box">
                <a href="#" class="btn-download-attachment" title="Buka / Unduh Lampiran">
                    <i class="fa-solid fa-download"></i>
                </a>
            </div>
        </div>
        <div>
            <label class="form-label">2. Kontak Person</label>
            <input type="text" class="form-control-gray" value="+62 xxxxxxxxxxx" style="width: 50%;" readonly>
        </div>

        <!-- Tombol Kembali -->
        <a href="{{ route('admin.pengajuan.index') }}" class="btn-kembali">Kembali</a>

    </div>
@endsection