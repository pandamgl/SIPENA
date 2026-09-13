@extends('layouts.admin')

@section('title', 'Kelola Pengajuan - SIPENA')

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
            border-radius: 4px;
        }

        .page-btn.active {
            background-color: #e51b24;
            color: white;
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

        <div class="table-controls-top">
            <div class="time-range-group">
                <select class="control-select">
                    <option>Bulan</option>
                    <option>Januari</option>
                    <option>Februari</option>
                    <option>Maret</option>
                </select>
                <input type="date" class="control-input" title="Tanggal Mulai">
            </div>

            <div class="right-controls">
                <select class="control-select">
                    <option value="">Semua Kategori</option>
                    <option value="Riset Dosen">Riset Dosen</option>
                    <option value="Event Kampus">Event Kampus</option>
                </select>

                <select class="control-select">
                    <option value="">Semua Status</option>
                    <option value="In Review">In Review</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Publish">Publish</option>
                    <option value="Rejected">Rejected</option>
                </select>

                <button class="btn-add" id="btnTambahBerita">
                    <i class="fa-solid fa-plus"></i> Tambah Berita
                </button>
            </div>
        </div>

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
                    <td>12/09/2026</td>
                    <td><a href="{{ route('admin.pengajuan.show', 1) }}" class="btn-judul">Mahasiswa Ciptakan AI Pendeteksi
                            Hoaks</a></td>
                    <td>Riset Dosen</td>
                    <td>
                        <select class="status-select">
                            <option>In Review</option>
                            <option selected>In Progress</option>
                            <option>Publish</option>
                            <option>Rejected</option>
                        </select>
                    </td>
                    <td class="aksi-cell"><a href="{{ route('admin.pengajuan.show', 1) }}" class="action-link">Lihat /
                            Edit</a></td>
                </tr>
                <tr>
                    <td>S1 Sistem Informasi</td>
                    <td>11/09/2026</td>
                    <td><a href="{{ route('admin.pengajuan.show', 2) }}" class="btn-judul">Seminar Technopreneurship
                            2026</a></td>
                    <td>Event Kampus</td>
                    <td>
                        <select class="status-select">
                            <option>In Review</option>
                            <option>In Progress</option>
                            <option>Publish</option>
                            <option selected>Rejected</option>
                        </select>
                    </td>
                    <td class="aksi-cell"><a href="{{ route('admin.pengajuan.show', 2) }}" class="action-link">Lihat /
                            Edit</a></td>
                </tr>
            </tbody>
        </table>

        <div class="pagination">
            <button class="page-btn">Previous</button>
            <button class="page-btn active">1</button>
            <button class="page-btn">Next</button>
        </div>
    </div>

    <!-- OVERLAY TAMBAH BERITA ADMIN -->
    <div class="modal-overlay" id="modalTambahBerita">
        <div class="modal-content">
            <i class="fa-solid fa-xmark close-modal" id="closeModal"></i>
            <h2 class="modal-title">Tambah Berita Publikasi</h2>

            <form action="#" method="POST">
                @csrf
                <div class="form-group">
                    <label>Prodi/Unit Asal</label>
                    <select class="modal-input" required>
                        <option value="">Pilih Unit</option>
                        <option>Humas / Internal</option>
                        <option>S1 Teknik Informatika</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Judul Berita</label>
                    <input type="text" class="modal-input" placeholder="Masukkan judul" required>
                </div>
                <div class="form-group">
                    <label>Kategori Berita</label>
                    <select class="modal-input" required>
                        <option value="">Pilih Kategori</option>
                        <option>Info Kampus</option>
                        <option>Prestasi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tautan Gambar / Dokumentasi (Link Drive)</label>
                    <input type="url" class="modal-input" placeholder="https://drive.google.com/..." required>
                </div>
                <div class="form-group">
                    <label>Isi/Narasi Singkat</label>
                    <textarea class="modal-textarea" placeholder="Tuliskan berita..." required></textarea>
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

        const statusSelects = document.querySelectorAll('.status-select');

        function updateAksiCell(selectElement) {
            const tr = selectElement.closest('tr');
            const aksiCell = tr.querySelector('.aksi-cell');
            const status = selectElement.value;

            if (status === 'Publish') {
                aksiCell.innerHTML = `
                    <div class="aksi-input-group">
                        <input type="url" placeholder="Masukkan Link Drive" title="Link Drive">
                        <button class="btn-save-aksi" title="Simpan"><i class="fa-solid fa-check"></i></button>
                    </div>
                `;
            } else if (status === 'Rejected') {
                aksiCell.innerHTML = `
                    <div class="aksi-input-group">
                        <input type="text" placeholder="Masukkan Alasan" title="Alasan Penolakan">
                        <button class="btn-save-aksi" title="Simpan"><i class="fa-solid fa-check"></i></button>
                    </div>
                `;
            } else {
                aksiCell.innerHTML = '<a href="{{ route("admin.pengajuan.show", 1) }}" class="action-link">Lihat / Edit</a>';
            }
        }

        statusSelects.forEach(select => {
            select.addEventListener('change', function () {
                updateAksiCell(this);
            });
            updateAksiCell(select);
        });
    </script>
@endpush