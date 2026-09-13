@extends('layouts.admin')

@section('title', 'Dashboard Admin - SIPENA')

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
            background-color: #f5f5f5;
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
            flex-shrink: 0;
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
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

        /* --- KANVAS UTAMA KANAN --- */
        .main-content {
            flex: 1;
            padding: 30px 40px;
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            border-radius: 12px;
            padding: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            background-color: #e51b24;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
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

        .table-card {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
        }

        .table-card h3 {
            font-size: 22px;
            margin-bottom: 20px;
            color: #1a1a1a;
        }

        .table-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .entries-control select,
        .search-control input {
            padding: 6px 12px;
            border-radius: 15px;
            border: 1px solid #ccc;
            outline: none;
        }

        .search-control input {
            margin-left: 10px;
            width: 200px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e0e0e0;
        }

        .data-table th,
        .data-table td {
            padding: 15px;
            text-align: left;
            font-size: 14px;
            border-bottom: 1px solid #e0e0e0;
        }

        .data-table th {
            background-color: #343a40;
            color: #ffffff;
            font-weight: 500;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .data-table tbody tr:hover {
            background-color: #f1f3f5;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            color: white;
            display: inline-block;
        }

        .badge-progress {
            background-color: #3498db;
        }

        .pagination {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
            gap: 5px;
        }

        .page-btn {
            padding: 6px 12px;
            border: none;
            background-color: #e0e0e0;
            color: #333;
            font-size: 12px;
            cursor: pointer;
        }

        .page-btn.active {
            background-color: #e51b24;
            color: white;
        }

        .page-btn:hover:not(.active) {
            background-color: #d5d5d5;
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

    <!-- Kartu Statistik -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h2>5</h2>
                <p>Antrean Pengajuan</p>
            </div>
            <i class="fa-regular fa-clock"></i>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h2>25</h2>
                <p>Publikasi Berita</p>
            </div>
            <i class="fa-regular fa-paper-plane"></i>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h2>35</h2>
                <p>Pengajuan Masuk</p>
            </div>
            <i class="fa-solid fa-inbox"></i>
        </div>
    </div>

    <!-- Tabel Antrean Pengajuan -->
    <div class="table-card">
        <h3>Antrean Pengajuan</h3>

        <div class="table-controls">
            <div class="entries-control">
                Shows
                <select>
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
                entries
            </div>
            <div class="search-control">
                Search: <input type="text">
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Judul Berita</th>
                    <th>Kategori Berita</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>dd/mm/yyyy</td>
                    <td>XXXXXXXXXXXXXXXXXX</td>
                    <td>Riset Dosen</td>
                    <td><span class="badge badge-progress">In Progress</span></td>
                    <td><a href="{{ route('admin.pengajuan.show', 1) }}" style="color: #0066cc;">Link</a></td>
                </tr>
                <tr>
                    <td>dd/mm/yyyy</td>
                    <td>XXXXXXXXXXXXXXXXXX</td>
                    <td>Event Kampus</td>
                    <td><span class="badge badge-progress">In Progress</span></td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>

        <div class="pagination">
            <button class="page-btn">Previous</button>
            <button class="page-btn active">1</button>
            <button class="page-btn">Next</button>
        </div>
    </div>
@endsection