@extends('layouts.user')

@section('title', 'Monitoring - SIPENA')

@push('styles')
    <style>
        .page-header {
            background-color: #f0f0f0;
            padding: 20px 40px;
        }

        .page-header h1 {
            font-size: 28px;
            color: #1a1a1a;
            font-weight: 600;
        }

        .table-panel {
            background-color: #ffffff;
            margin: 0;
            padding: 30px 40px;
            flex: 1;
        }

        .table-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .entries-control select {
            padding: 5px;
            border-radius: 15px;
            border: 1px solid #ccc;
            margin: 0 5px;
            outline: none;
        }

        .filters-control {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .filters-control label {
            font-weight: 600;
            color: #333;
        }

        .filter-select {
            padding: 8px 15px;
            border-radius: 20px;
            border: 1px solid #ccc;
            outline: none;
            background-color: #f9f9f9;
            font-size: 13px;
            cursor: pointer;
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

        .badge-review {
            background-color: #f39c12;
        }

        .badge-progress {
            background-color: #3498db;
        }

        .badge-publish {
            background-color: #2ecc71;
        }

        .badge-rejected {
            background-color: #e74c3c;
        }

        .btn-lihat-alasan {
            background-color: #fee2e2;
            color: #dc2626;
            border: 1px solid #ef4444;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .btn-lihat-alasan:hover {
            background-color: #dc2626;
            color: #ffffff;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .modal-box-custom {
            background: #ffffff;
            width: 90%;
            max-width: 500px;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: fadeIn 0.2s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
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
    <!-- Banner Judul Halaman -->
    <div class="page-header">
        <h1>Monitoring</h1>
    </div>

    <!-- Area Tabel Putih -->
    <div class="table-panel">

        <!-- Kontrol Tabel (Entries & Filter) -->
        <div class="table-controls">
            <div class="entries-control">
                Shows
                <select id="entriesSelect">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                entries
            </div>

            <div class="filters-control">
                <label>Filter:</label>
                <select class="filter-select" id="filterKategori">
                    <option value="">Semua Kategori</option>
                    <option value="Riset Dosen">Riset Dosen</option>
                    <option value="Prestasi Mahasiswa">Prestasi Mahasiswa</option>
                    <option value="Event Kampus">Event Kampus</option>
                </select>

                <select class="filter-select" id="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="In Review">In Review</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Publish">Publish</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </div>
        </div>

        <!-- Tabel Data -->
        <table class="data-table" id="monitoringTable">
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
                @forelse($pengajuan as $item)
                    <tr class="table-row-item" data-kategori="{{ $item->kategori->nama_kategori ?? '' }}" data-status="{{ $item->status }}">
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }}</td>
                        <td>{{ $item->judul_berita }}</td>
                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td>
                            @if($item->status == 'In Review')
                                <span class="badge badge-review">In Review</span>
                            @elseif($item->status == 'In Progress')
                                <span class="badge badge-progress">In Progress</span>
                            @elseif($item->status == 'Publish')
                                <span class="badge badge-publish">Publish</span>
                            @else
                                <span class="badge badge-rejected">Rejected</span>
                            @endif
                        </td>
                        <td>
                            @if($item->status == 'Rejected')
                                @php
                                    $alasan = $item->alasan_reject ?? ($item->logAksi->where('status_baru', 'Rejected')->last()->catatan ?? 'Tidak ada catatan penolakan dari admin.');
                                @endphp
                                <button type="button" class="btn-lihat-alasan" 
                                    data-judul="{{ $item->judul_berita }}" 
                                    data-alasan="{{ $alasan }}" 
                                    title="Alasan: {{ $alasan }}"
                                    onclick="bukaModalAlasan(this)">
                                    <i class="fa-solid fa-circle-exclamation"></i> Lihat Alasan
                                </button>
                            @elseif($item->link_publikasi)
                                <a href="{{ $item->link_publikasi }}" target="_blank" style="color: #0066cc; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Link
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">Belum ada data pengajuan berita.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            {{ $pengajuan->links() }}
        </div>

    </div>

    <!-- MODAL LIHAT ALASAN REJECT -->
    <div class="modal-overlay" id="modalAlasanReject">
        <div class="modal-box-custom">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px; border-bottom: 1px solid #f0f0f0; padding-bottom: 10px;">
                <h3 style="color: #e51b24; font-size: 18px; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-circle-exclamation"></i> Alasan Penolakan Pengajuan
                </h3>
                <i class="fa-solid fa-xmark" onclick="tutupModalAlasan()" style="cursor: pointer; font-size: 20px; color: #888;"></i>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="font-size: 12px; color: #777; font-weight: 600; display: block; margin-bottom: 4px;">Judul Berita:</label>
                <div id="modalJudulBerita" style="font-size: 14px; font-weight: 600; color: #1a1a1a; line-height: 1.4;"></div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-size: 12px; color: #777; font-weight: 600; display: block; margin-bottom: 4px;">Catatan / Alasan dari Admin Humas:</label>
                <div id="modalIsiAlasan" style="background-color: #fdf2f2; border: 1px solid #fbd5d5; color: #9b1c1c; padding: 12px 15px; border-radius: 8px; font-size: 14px; line-height: 1.6; white-space: pre-line;"></div>
            </div>

            <div style="text-align: right;">
                <button type="button" onclick="tutupModalAlasan()" style="background-color: #1a1a1a; color: white; border: none; padding: 9px 20px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer;">Tutup</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function bukaModalAlasan(btn) {
            const judul = btn.getAttribute('data-judul');
            const alasan = btn.getAttribute('data-alasan');
            document.getElementById('modalJudulBerita').textContent = judul;
            document.getElementById('modalIsiAlasan').textContent = alasan || 'Tidak ada catatan khusus dari admin.';
            document.getElementById('modalAlasanReject').style.display = 'flex';
        }

        function tutupModalAlasan() {
            document.getElementById('modalAlasanReject').style.display = 'none';
        }

        window.addEventListener('click', function (event) {
            const modal = document.getElementById('modalAlasanReject');
            if (event.target === modal) {
                tutupModalAlasan();
            }
        });

        // Filter Table Real-time
        const filterKategori = document.getElementById('filterKategori');
        const filterStatus = document.getElementById('filterStatus');
        const tableRows = document.querySelectorAll('.table-row-item');

        function filterTable() {
            const selectedKat = filterKategori.value.toLowerCase();
            const selectedStatus = filterStatus.value.toLowerCase();

            tableRows.forEach(row => {
                const rowKat = (row.getAttribute('data-kategori') || '').toLowerCase();
                const rowStatus = (row.getAttribute('data-status') || '').toLowerCase();

                const matchKat = !selectedKat || rowKat.includes(selectedKat);
                const matchStatus = !selectedStatus || rowStatus === selectedStatus;

                if (matchKat && matchStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        if (filterKategori) filterKategori.addEventListener('change', filterTable);
        if (filterStatus) filterStatus.addEventListener('change', filterTable);
    </script>
@endpush
