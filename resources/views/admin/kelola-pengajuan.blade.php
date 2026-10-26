@extends('layouts.admin')

@section('title', 'Kelola Pengajuan - SIPENA')

@push('styles')
    <style>
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
            padding: 0 40px 20px 40px;
        }

        .page-header h1 {
            font-size: 32px;
            color: #1a1a1a;
            font-weight: 600;
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
            background-color: #fff;
        }

        .right-controls {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .btn-add {
            background-color: #e51b24;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }

        .btn-add:hover {
            background-color: #c4151e;
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

        .status-select {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            background-color: white;
            outline: none;
            font-weight: 500;
            width: 100%;
            cursor: pointer;
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

        .aksi-input-group {
            display: flex;
            gap: 5px;
        }

        .aksi-input-group input {
            flex: 1;
            padding: 6px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 12px;
            outline: none;
        }

        .btn-save-aksi {
            background-color: #2ed573;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            width: 600px;
            max-width: 90%;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }

        .modal-title {
            font-size: 22px;
            margin-bottom: 25px;
            color: #1a1a1a;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
        }

        .modal-input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-family: inherit;
        }

        .modal-textarea {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-family: inherit;
            min-height: 100px;
            resize: vertical;
        }

        .btn-submit-modal {
            background-color: #2ed573;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 15px;
            width: 100%;
        }
    </style>
@endpush

@section('content')
    <!-- Banner Judul Halaman -->
    <div class="page-header">
        <h1>Kelola Pengajuan</h1>
    </div>

    <!-- Area Tabel Putih -->
    <div class="table-panel">
        <h3 class="panel-title">Rentang Waktu</h3>

        <!-- FORM FILTER / SORTING -->
        <form method="GET" action="{{ route('admin.pengajuan.index') }}" id="filterForm">
            <div class="table-controls-top">
                <div class="time-range-group">
                    <select name="bulan" class="control-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="">Bulan</option>
                        <option value="1" {{ request('bulan') == '1' ? 'selected' : '' }}>Januari</option>
                        <option value="2" {{ request('bulan') == '2' ? 'selected' : '' }}>Februari</option>
                        <option value="3" {{ request('bulan') == '3' ? 'selected' : '' }}>Maret</option>
                        <option value="4" {{ request('bulan') == '4' ? 'selected' : '' }}>April</option>
                        <option value="5" {{ request('bulan') == '5' ? 'selected' : '' }}>Mei</option>
                        <option value="6" {{ request('bulan') == '6' ? 'selected' : '' }}>Juni</option>
                        <option value="7" {{ request('bulan') == '7' ? 'selected' : '' }}>Juli</option>
                        <option value="8" {{ request('bulan') == '8' ? 'selected' : '' }}>Agustus</option>
                        <option value="9" {{ request('bulan') == '9' ? 'selected' : '' }}>September</option>
                        <option value="10" {{ request('bulan') == '10' ? 'selected' : '' }}>Oktober</option>
                        <option value="11" {{ request('bulan') == '11' ? 'selected' : '' }}>November</option>
                        <option value="12" {{ request('bulan') == '12' ? 'selected' : '' }}>Desember</option>
                    </select>

                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="control-input" title="Tanggal Mulai" onchange="document.getElementById('filterForm').submit()">
                </div>

                <div class="right-controls">
                    <select name="kategori" class="control-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="">Semua Kategori</option>
                        @isset($kategoriList)
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        @endisset
                    </select>

                    <select name="status" class="control-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="">Semua Status</option>
                        <option value="In Review" {{ request('status') == 'In Review' ? 'selected' : '' }}>In Review</option>
                        <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Publish" {{ request('status') == 'Publish' ? 'selected' : '' }}>Publish</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>

                    @if(request()->anyFilled(['bulan', 'tanggal', 'kategori', 'status']))
                        <a href="{{ route('admin.pengajuan.index') }}" style="color: #e51b24; text-decoration: none; font-size: 13px; font-weight: 600; white-space: nowrap;">Reset</a>
                    @endif

                    <button type="button" class="btn-add" id="btnTambahBerita">
                        <i class="fa-solid fa-plus"></i> Tambah Berita
                    </button>
                </div>
            </div>
        </form>

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
                @forelse($pengajuanList as $item)
                    <tr>
                        <td>{{ $item->user->prodiUnit->nama_prodi_unit ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }}</td>
                        <td><a href="{{ route('admin.pengajuan.show', $item->id) }}" class="btn-judul">{{ $item->judul_berita }}</a></td>
                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td>
                            <form action="{{ route('admin.pengajuan.updateStatus', $item->id) }}" method="POST" class="status-form">
                                @csrf
                                @method('PUT')
                                <select name="status" class="status-select" onchange="this.form.submit()">
                                    <option value="In Review" {{ $item->status == 'In Review' ? 'selected' : '' }}>In Review</option>
                                    <option value="In Progress" {{ $item->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Publish" {{ $item->status == 'Publish' ? 'selected' : '' }}>Publish</option>
                                    <option value="Rejected" {{ $item->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </form>
                        </td>
                        <td class="aksi-cell">
                            @if($item->status == 'Publish')
                                <form action="{{ route('admin.pengajuan.updateStatus', $item->id) }}" method="POST" class="aksi-input-group">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Publish">
                                    <input type="url" name="link_publikasi" value="{{ $item->link_publikasi }}" placeholder="Masukkan Link Drive" title="Link Drive" required>
                                    <button type="submit" class="btn-save-aksi" title="Simpan"><i class="fa-solid fa-check"></i></button>
                                </form>
                            @elseif($item->status == 'Rejected')
                                <form action="{{ route('admin.pengajuan.updateStatus', $item->id) }}" method="POST" class="aksi-input-group">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Rejected">
                                    <input type="text" name="catatan" placeholder="Masukkan Alasan" title="Alasan Penolakan" required>
                                    <button type="submit" class="btn-save-aksi" title="Simpan"><i class="fa-solid fa-check"></i></button>
                                </form>
                            @else
                                <a href="{{ route('admin.pengajuan.show', $item->id) }}" class="action-link">Lihat / Edit</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">Belum ada pengajuan berita dari user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $pengajuanList->links() }}
        </div>
    </div>

    <!-- OVERLAY TAMBAH BERITA ADMIN (LANGSUNG PUBLISH) -->
    <div class="modal-overlay" id="modalTambahBerita">
        <div class="modal-content">
            <i class="fa-solid fa-xmark close-modal" id="closeModal"></i>
            <h2 class="modal-title">Tambah Berita Publikasi</h2>

            <form action="{{ route('admin.pengajuan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Judul Berita</label>
                    <input type="text" name="judul_berita" class="modal-input" placeholder="Masukkan judul" required>
                </div>
                <div class="form-group">
                    <label>Kategori Berita</label>
                    <select name="kategori_id" class="modal-input" required>
                        <option value="">Pilih Kategori</option>
                        @isset($kategoriList)
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="modal-input" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="modal-input" required>
                </div>
                <div class="form-group">
                    <label>Tautan Dokumentasi / Link Drive</label>
                    <input type="url" name="link_dokumentasi" class="modal-input" placeholder="https://drive.google.com/..." required>
                </div>
                <div class="form-group">
                    <label>Kontak Person</label>
                    <input type="text" name="kontak_person" class="modal-input" placeholder="No HP / WhatsApp" required>
                </div>
                <div class="form-group">
                    <label>Isi/Narasi Singkat</label>
                    <textarea name="narasi_berita" class="modal-textarea" placeholder="Tuliskan berita..." required></textarea>
                </div>
                <button type="submit" class="btn-submit-modal">Langsung Publish</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const modal = document.getElementById("modalTambahBerita");
        const btnTambah = document.getElementById("btnTambahBerita");
        const btnClose = document.getElementById("closeModal");

        btnTambah.onclick = function () {
            modal.style.display = "flex";
        }

        btnClose.onclick = function () {
            modal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
@endpush