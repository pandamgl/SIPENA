@extends('layouts.user')

@section('title', 'Dashboard User - SIPENA')

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

        /* --- SIDEBAR KIRI --- */
        .sidebar {
            width: 260px;
            background-color: #ffffff;
            border-right: 1px solid #e0e0e0;
            display: flex;
            flex-direction: column;
            padding-top: 40px;
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

        /* Status Menu Aktif (Warna Pink/Merah Muda) */
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

        /* --- KANVAS UTAMA KANAN --- */
        .main-content {
            flex: 1;
            padding: 30px 40px;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 25px;
            margin-bottom: 30px;
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

        /* Banner Merah Utama */
        .banner-card {
            background-color: #e51b24;
            border-radius: 12px;
            display: flex;
            overflow: hidden;
            margin-bottom: 25px;
            height: 200px;
        }

        .banner-text {
            flex: 1;
            padding: 40px;
            display: flex;
            align-items: center;
        }

        .banner-text h1 {
            color: white;
            font-size: 36px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .banner-image {
            width: 35%;
            background-image: url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSC2w52KotG1m0AaK-WD3M4mwWKq3iivL_z56ckfjqG2vEyzfVxZz7QzhdM&s=10);
            background-size: cover;
            background-position: center;
        }

        /* Grid Kartu Statistik Bawah */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .stat-card {
            border-radius: 12px;
            padding: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        /* Kartu Merah (Pengajuan & Publikasi) */
        .card-red {
            background-color: #e51b24;
        }

        .stat-info h2 {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 5px;
            line-height: 1;
        }

        .stat-info p {
            font-size: 15px;
            font-weight: 500;
        }

        .stat-card i {
            font-size: 60px;
            opacity: 0.9;
        }

        /* Kartu Abu-abu (User Guide) */
        .card-gray {
            background-color: #e0e0e0;
            color: #1a1a1a;
        }

        .card-gray .stat-info h2 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .card-gray .stat-info p {
            font-size: 14px;
            font-weight: bold;
        }

        .card-gray i {
            color: #1a1a1a;
        }
    </style>
@endpush

@section('content')
    <!-- Banner Merah Logo & Gedung -->
    <div class="banner-card">
        <div class="banner-text">
            <h1>Logo</h1>
        </div>
        <div class="banner-image"></div>
    </div>

    <!-- Kartu Statistik & Dokumen -->
    <div class="stats-grid">
        <!-- Kartu 1: Pengajuan -->
        <div class="stat-card card-red">
            <div class="stat-info">
                <h2>2</h2>
                <p>Pengajuan</p>
            </div>
            <i class="fa-regular fa-clock"></i>
        </div>

        <!-- Kartu 2: Publikasi Berita -->
        <div class="stat-card card-red">
            <div class="stat-info">
                <h2>8</h2>
                <p>Publikasi Berita</p>
            </div>
            <i class="fa-regular fa-paper-plane"></i>
        </div>

        <!-- Kartu 3: User Guide -->
        <a href="{{ asset('manual_book.pdf') }}" download class="stat-card card-gray" style="text-decoration: none;">
            <div class="stat-info">
                <h2>User Guide</h2>
                <p>Download</p>
            </div>
            <i class="fa-regular fa-file-lines"></i>
        </a>
    </div>
@endsection