@extends('layouts.user')

@section('title', 'Pengajuan Berita - SIPENA')

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
            background-color: #f0f0f0;
            padding: 20px 40px;
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

        .form-control {
            width: 100%;
            padding: 14px 18px;
            background-color: #e3e3e3;
            border: 2px solid transparent;
            border-radius: 8px;
            font-size: 14px;
            color: #333;
            font-family: inherit;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-control:focus {
            border: 2px solid #a0a0a0;
            background-color: white;
        }

        .form-control:valid {
            background-color: white;
            border: 2px solid #1a1a1a;
        }

        .form-control::placeholder {
            color: #666;
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

        .date-range {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 150px;
        }

        .btn-submit {
            background-color: #2ed573;
            color: white;
            border: none;
            padding: 12px 35px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 30px;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #27ae60;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
        }
    </style>
@endpush

@section('content')
    <!-- Banner Judul Halaman -->
    <div class="page-header">
        <h1>Pengajuan Berita</h1>
    </div>

    <!-- Formulir Pengajuan -->
    <div class="form-container">
        <form action="#" method="POST">
            @csrf

            <!-- SECTION I -->
            <h3 class="section-title">I. Informasi Pengguna</h3>
            <div class="grid-3">
                <div>
                    <label class="form-label">1. Nama</label>
                    <input type="text" class="form-control" placeholder="Masukan nama" required>
                </div>
                <div>
                    <label class="form-label">2. NIM/NIK</label>
                    <input type="text" class="form-control" placeholder="Masukan NIM/NIK" required>
                </div>
                <div>
                    <label class="form-label">3. Prodi/Unit</label>
                    <select class="form-control" required>
                        <option value="">Pilih Prodi/Unit</option>
                        <option value="S1 Teknik Informatika">S1 Teknik Informatika</option>
                        <option value="S1 Rekayasa Perangkat Lunak">S1 Rekayasa Perangkat Lunak</option>
                        <option value="S1 Sistem Informasi">S1 Sistem Informasi</option>
                    </select>
                </div>
            </div>

            <!-- SECTION II -->
            <h3 class="section-title">II. Informasi Dasar Kegiatan</h3>
            <div style="margin-bottom: 20px;">
                <label class="form-label">1. Judul Berita atau Kegiatan</label>
                <input type="text" class="form-control" placeholder="Masukkan judul berita atau kegiatan" required>
            </div>

            <div class="grid-2">
                <div>
                    <label class="form-label">2. Kategori Berita</label>
                    <select class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Riset Dosen">Riset Dosen</option>
                        <option value="Prestasi Mahasiswa">Prestasi Mahasiswa</option>
                        <option value="Pengabdian Masyarakat">Pengabdian Masyarakat</option>
                        <option value="Event Kampus">Event Kampus</option>
                        <option value="Kerjasama">Kerjasama</option>
                        <option value="ETC">ETC.</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">3. Tanggal Pelaksanaan</label>
                    <div class="date-range">
                        <input type="date" class="form-control" required title="Tanggal Mulai">
                        <span style="font-weight: bold;"> - </span>
                        <input type="date" class="form-control" required title="Tanggal Selesai">
                    </div>
                </div>
            </div>

            <!-- SECTION III -->
            <h3 class="section-title">III. Narasi Berita</h3>
            <div>
                <textarea class="form-control" placeholder="Jelaskan rincian kegiatan dan memuat unsur 5W+1H"
                    required></textarea>
            </div>

            <!-- SECTION IV -->
            <h3 class="section-title">IV. Lampiran dan Kontak</h3>
            <div style="margin-bottom: 20px;">
                <label class="form-label">1. Link Dokumentasi (min. 3 Foto)</label>
                <input type="url" class="form-control" placeholder="URL Drive" required>
            </div>
            <div>
                <label class="form-label">2. Kontak Person</label>
                <input type="text" class="form-control" placeholder="+628....." style="width: 50%;" required>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn-submit">Kirim</button>

        </form>
    </div>
@endsection