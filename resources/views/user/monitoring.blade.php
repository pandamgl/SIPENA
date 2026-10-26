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

        /* Penyesuaian Pagination Laravel */
        .pagination-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }
        
        .pagination {
            display: flex;
            gap: 5px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li a, .pagination li span {
            padding: 6px 12px;
            border: none;
            background-color: #e0e0e0;
            color: #333;
            font-size: 12px;
            text-decoration: none;
            border-radius: 4px;
        }

        .pagination li.active span {
            background-color: #e51b24;
            color: white;
        }

        .pagination li a:hover {
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

        <!-- Form Kontrol Tabel (Entries & Filter) -->
        <form method="GET" action="{{ route('user.monitoring') }}" id="filterForm">
            <div class="table-controls">
                <div class="entries-control">
                    Shows
                    <select name="perPage" onchange="document.getElementById('filterForm').submit()">
                        <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                    entries
                </div>

                <div class="filters-control">
                    <label>Filter:</label>
                    <!-- Filter Kategori Dinamis dari Database -->
                    <select name="kategori" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="">Semua Kategori</option>
                        @isset($kategoriList)
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        @endisset
                    </select>

                    <!-- Filter Status -->
                    <select name="status" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="">Semua Status</option>
                        <option value="In Review" {{ request('status') == 'In Review' ? 'selected' : '' }}>In Review</option>
                        <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Publish" {{ request('status') == 'Publish' ? 'selected' : '' }}>Publish</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
            </div>
        </form>

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
                        <td colspan="5" style="text-align: center;">Belum ada data pengajuan berita yang sesuai.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination-container">
            {{ $pengajuan->appends(request()->query())->links() }}
        </div>

    </div>
@endsection