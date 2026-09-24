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
                <select>
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
                entries
            </div>

            <div class="filters-control">
                <label>Filter:</label>
                <select class="filter-select">
                    <option value="">Semua Kategori</option>
                    <option value="Riset Dosen">Riset Dosen</option>
                    <option value="Prestasi Mahasiswa">Prestasi Mahasiswa</option>
                    <option value="Event Kampus">Event Kampus</option>
                </select>

                <select class="filter-select">
                    <option value="">Semua Status</option>
                    <option value="In Review">In Review</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Publish">Publish</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </div>
        </div>

        <!-- Tabel Data -->
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
                @forelse($pengajuan as $item)
                    <tr>
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
                            @if($item->link_publikasi)
                                <a href="{{ $item->link_publikasi }}" target="_blank" style="color: #0066cc;">Link</a>
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
            <button class="page-btn">Previous</button>
            <button class="page-btn active">1</button>
            <button class="page-btn">Next</button>
        </div>

    </div>
@endsection