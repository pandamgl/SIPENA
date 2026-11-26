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
            font-family: 'Poppins', sans-serif;
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
            z-index: 10;
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
            background-color: #e51b24;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .btn-download-excel:hover {
            background-color: #c4151e;
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

        .action-link:hover {
            text-decoration: underline;
        }

        .btn-judul {
            color: #1a1a1a;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .btn-judul:hover {
            color: #e51b24;
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
        <a href="{{ route('admin.rekapitulasi.export', array_filter($filters)) }}" id="btnDownloadLaporan" class="btn-download-excel">
            <i class="fa-solid fa-file-excel"></i> Unduh Laporan
        </a>
    </div>

    <!-- Area Konten Utama -->
    <div class="table-panel">
        <h3 class="panel-title">Rentang Waktu</h3>

        <div class="table-controls-top">
            <div class="time-range-group">
                <select class="control-select" id="filterPeriode">
                    <option value="" {{ $filters['periode'] === '' ? 'selected' : '' }}>Semua Periode</option>
                    <option value="bulanan" {{ $filters['periode'] === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                    <option value="q1" {{ $filters['periode'] === 'q1' ? 'selected' : '' }}>Tri-wulan (Q1)</option>
                    <option value="q2" {{ $filters['periode'] === 'q2' ? 'selected' : '' }}>Tri-wulan (Q2)</option>
                    <option value="q3" {{ $filters['periode'] === 'q3' ? 'selected' : '' }}>Tri-wulan (Q3)</option>
                    <option value="q4" {{ $filters['periode'] === 'q4' ? 'selected' : '' }}>Tri-wulan (Q4)</option>
                </select>
                <input type="date" class="control-input" id="filterTanggal" value="{{ $filters['tanggal'] }}" title="Tanggal">
            </div>
            <div>
                <select class="control-select" id="filterKategori">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat->id }}" {{ (string) $filters['kategori_id'] === (string) $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
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
            <tbody id="rekapTableBody">
                @forelse($rekapRows as $row)
                    <tr>
                        <td>{{ $row['unit'] }}</td>
                        <td>{{ $row['tanggal'] }}</td>
                        <td>
                            <a href="{{ $row['show_url'] }}" class="btn-judul">{{ $row['judul_berita'] }}</a>
                        </td>
                        <td>{{ $row['kategori'] }}</td>
                        <td>{{ $row['status'] }}</td>
                        <td>
                            @if($row['status'] === 'Publish' && !empty($row['link_publikasi']))
                                <a href="{{ $row['link_publikasi'] }}" target="_blank" rel="noopener noreferrer" class="action-link">Link</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">Belum ada data pengajuan berita.</td>
                    </tr>
                @endforelse
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
        Chart.defaults.font.family = "'Poppins', sans-serif";

        const REKAP_DATA_URL = @json(route('admin.rekapitulasi'));
        const REKAP_EXPORT_URL = @json(route('admin.rekapitulasi.export'));
        const CHART_PALETTE = ['#ff0055', '#2ed573', '#1e90ff', '#feca57', '#ff6b6b', '#5f27cd', '#10ac84', '#ff9f43', '#54a0ff', '#ee5253'];

        function getPieColors(count) {
            if (count === 0) return ['#e0e0e0'];
            return Array.from({ length: count }, (_, i) => CHART_PALETTE[i % CHART_PALETTE.length]);
        }

        function buildPieDataset(pie) {
            const hasData = pie.labels && pie.labels.length > 0;
            return {
                labels: hasData ? pie.labels : ['Belum ada data'],
                data: hasData ? pie.data : [1],
                colors: hasData ? getPieColors(pie.labels.length) : ['#e0e0e0'],
            };
        }

        const initialPie = buildPieDataset(@json($pieChartData));
        const pieCtx = document.getElementById('kategoriPieChart').getContext('2d');
        const pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: initialPie.labels,
                datasets: [{
                    data: initialPie.data,
                    backgroundColor: initialPie.colors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { font: { family: 'Poppins' } }
                    }
                }
            }
        });

        const initialStatus = @json($statusCounts);
        const barCtx = document.getElementById('statusBarChart').getContext('2d');
        const barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Publish', 'Rejected'],
                datasets: [{
                    label: 'Jumlah Berita',
                    data: [initialStatus.publish ?? 0, initialStatus.rejected ?? 0],
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
                        ticks: { precision: 0 },
                        grid: { display: false }
                    },
                    y: {
                        grid: { display: false }
                    }
                }
            }
        });

        function escapeHtml(value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function isSafeHttpUrl(url) {
            return typeof url === 'string' && /^https?:\/\//i.test(url.trim());
        }

        function renderTableRows(rows) {
            const tbody = document.getElementById('rekapTableBody');
            if (!rows || rows.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">Belum ada data pengajuan berita.</td></tr>';
                return;
            }

            tbody.innerHTML = rows.map(row => {
                const aksiHtml = (row.status === 'Publish' && isSafeHttpUrl(row.link_publikasi))
                    ? `<a href="${escapeHtml(row.link_publikasi)}" target="_blank" rel="noopener noreferrer" class="action-link">Link</a>`
                    : '-';

                return `
                    <tr>
                        <td>${escapeHtml(row.unit)}</td>
                        <td>${escapeHtml(row.tanggal)}</td>
                        <td><a href="${escapeHtml(row.show_url)}" class="btn-judul">${escapeHtml(row.judul_berita)}</a></td>
                        <td>${escapeHtml(row.kategori)}</td>
                        <td>${escapeHtml(row.status)}</td>
                        <td>${aksiHtml}</td>
                    </tr>
                `;
            }).join('');
        }

        const filterPeriode = document.getElementById('filterPeriode');
        const filterTanggal = document.getElementById('filterTanggal');
        const filterKategori = document.getElementById('filterKategori');
        const btnDownloadLaporan = document.getElementById('btnDownloadLaporan');

        function buildFilterQuery() {
            const params = new URLSearchParams();
            if (filterPeriode.value) params.set('periode', filterPeriode.value);
            if (filterTanggal.value) params.set('tanggal', filterTanggal.value);
            if (filterKategori.value) params.set('kategori_id', filterKategori.value);
            return params.toString();
        }

        let isFetching = false;
        async function refreshRekapitulasi() {
            if (isFetching) return;
            isFetching = true;

            try {
                const query = buildFilterQuery();
                const exportUrl = query ? `${REKAP_EXPORT_URL}?${query}` : REKAP_EXPORT_URL;
                btnDownloadLaporan.setAttribute('href', exportUrl);

                const dataUrl = query ? `${REKAP_DATA_URL}?${query}` : REKAP_DATA_URL;
                const response = await fetch(dataUrl, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                if (!response.ok) return;
                const payload = await response.json();

                renderTableRows(payload.rows);

                const updatedPie = buildPieDataset(payload.pie || {});
                pieChart.data.labels = updatedPie.labels;
                pieChart.data.datasets[0].data = updatedPie.data;
                pieChart.data.datasets[0].backgroundColor = updatedPie.colors;
                pieChart.update();

                const statusData = payload.status || {};
                barChart.data.datasets[0].data = [statusData.publish ?? 0, statusData.rejected ?? 0];
                barChart.update();
            } catch (error) {
                console.error('Gagal memuat pembaruan rekapitulasi:', error);
            } finally {
                isFetching = false;
            }
        }

        filterPeriode.addEventListener('change', refreshRekapitulasi);
        filterTanggal.addEventListener('change', refreshRekapitulasi);
        filterKategori.addEventListener('change', refreshRekapitulasi);

        // Sinkronisasi otomatis dengan database setiap 10 detik saat tab aktif
        setInterval(() => {
            if (!document.hidden) {
                refreshRekapitulasi();
            }
        }, 10000);
    </script>
@endpush