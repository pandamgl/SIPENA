@extends('layouts.admin')

@section('title', 'Rekapitulasi - SIPENA')

@push('styles')
    <style>
        /* Reset & Font Setup */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
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

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background-color: transparent;
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 40px 20px 40px;
        }

        .page-header h1 {
            font-size: 32px;
            color: #1a1a1a;
            font-weight: 600;
        }

        .btn-download-excel {
            background-color: #ff4d4f;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .btn-download-excel:hover {
            background-color: #d9363e;
        }

        .table-panel {
            background-color: #ffffff;
            margin: 0 40px 40px 40px;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            flex: 1;
        }

        .panel-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .table-controls-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .time-range-group {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .control-select,
        .control-input {
            padding: 8px 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
            font-family: inherit;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e0e0e0;
            margin-bottom: 20px;
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

        .action-link {
            color: #0066cc;
            text-decoration: none;
            font-weight: 500;
        }

        .charts-container {
            display: flex;
            gap: 40px;
            margin-top: 50px;
            padding-top: 30px;
            border-top: 2px dashed #e0e0e0;
        }

        .chart-box {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .chart-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1a1a1a;
            text-align: center;
        }

        .canvas-container-pie {
            width: 100%;
            max-width: 350px;
        }

        .canvas-container-bar {
            width: 100%;
            max-width: 500px;
        }
    </style>
@endpush

@section('content')
    <!-- Header Halaman & Tombol Unduh Laporan -->
    <div class="page-header">
        <h1>Rekapitulasi</h1>
        <a href="#" class="btn-download-excel">
            <i class="fa-solid fa-file-excel"></i> Unduh Laporan
        </a>
    </div>

    <!-- Area Konten Utama -->
    <div class="table-panel">
        <h3 class="panel-title">Rentang Waktu</h3>

        <div class="table-controls-top">
            <div class="time-range-group">
                <select class="control-select">
                    <option>Bulanan</option>
                    <option>Tri-wulan (Q1)</option>
                    <option>Tri-wulan (Q2)</option>
                    <option>Tri-wulan (Q3)</option>
                    <option>Tri-wulan (Q4)</option>
                </select>
                <input type="date" class="control-input" title="Tanggal">
            </div>
            <div>
                <select class="control-select">
                    <option value="">Filter Kategori</option>
                    <option value="Riset Dosen">Riset Dosen</option>
                    <option value="Event Kampus">Event Kampus</option>
                </select>
            </div>
        </div>

        <!-- Tabel Rekap Data -->
        <table class="data-table">
            <thead>
                <tr>
                    <th>Unit</th>
                    <th>Tanggal</th>
                    <th>Judul Berita</th>
                    <th>Kategori Berita</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>S1 Teknik Informatika</td>
                    <td>dd/mm/yyyy</td>
                    <td>XXXXXXXXXXXXXXXXXX</td>
                    <td>Riset Dosen</td>
                    <td>Publish</td>
                    <td><a href="#" class="action-link">Link</a></td>
                </tr>
                <tr>
                    <td>S1 Sistem Informasi</td>
                    <td>dd/mm/yyyy</td>
                    <td>XXXXXXXXXXXXXXXXXX</td>
                    <td>Event Kampus</td>
                    <td>Rejected</td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>

        <!-- AREA GRAFIK (CHART.JS) -->
        <div class="charts-container">
            <div class="chart-box">
                <h4 class="chart-title">Pie Chart Kategori & Unit</h4>
                <div class="canvas-container-pie">
                    <canvas id="kategoriPieChart"></canvas>
                </div>
            </div>

            <div class="chart-box">
                <h4 class="chart-title">Grafik Status (Publish vs Rejected)</h4>
                <div class="canvas-container-bar">
                    <canvas id="statusBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const pieCtx = document.getElementById('kategoriPieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Riset Dosen (Informatika)', 'Prestasi Mahasiswa', 'Event Kampus', 'Pengabdian Masyarakat'],
                datasets: [{
                    data: [35, 25, 20, 20],
                    backgroundColor: ['#ff0055', '#2ed573', '#1e90ff', '#feca57'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { font: { family: 'Segoe UI' } }
                    }
                }
            }
        });

        const barCtx = document.getElementById('statusBarChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Publish', 'Rejected'],
                datasets: [{
                    label: 'Jumlah Berita',
                    data: [65, 8],
                    backgroundColor: ['#ff4d4f', '#ff4d4f'],
                    borderRadius: 4
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { display: false }
                    },
                    y: {
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
@endpush