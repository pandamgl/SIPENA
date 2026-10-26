<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kategori - SIPENA</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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
        .logout-btn {
            background: none;
            border: none;
            color: #e51b24;
            cursor: pointer;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            width: 100%;
            text-align: left;
            transition: background 0.2s;
        }

        .logout-btn:hover {
            background-color: #ffe6e6;
            border-radius: 6px;
        }

        .page-header {
            padding: 0 40px 10px 40px;
        }

        .page-header h1 {
            font-size: 32px;
            color: #1a1a1a;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .tabs-container {
            display: flex;
            gap: 30px;
            border-bottom: 2px solid transparent;
        }

        .tab-link {
            font-size: 18px;
            font-weight: 600;
            color: #a0a0a0;
            text-decoration: none;
            padding-bottom: 10px;
            transition: color 0.3s ease;
        }

        .tab-link:hover {
            color: #666;
        }

        .tab-link.active {
            color: #1a1a1a;
            border-bottom: 3px solid #1a1a1a;
        }

        .table-panel {
            background-color: #ffffff;
            margin: 0 40px 40px 40px;
            padding: 30px 40px;
            border-radius: 15px;
            border-top-left-radius: 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            flex: 1;
        }

        .table-controls {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn-add {
            background-color: #ff4d4f;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s;
        }

        .btn-add:hover {
            background-color: #d9363e;
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
            background-color: #2c3036;
            color: #ffffff;
            font-weight: 500;
        }

        .data-table th:last-child,
        .data-table td:last-child {
            width: 150px;
            text-align: center;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .data-table tbody tr:hover {
            background-color: #f1f3f5;
        }

        .action-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
            align-items: center;
        }

        .action-icons i, .action-icons button {
            color: #333;
            font-size: 16px;
            cursor: pointer;
            background: none;
            border: none;
            transition: color 0.3s;
        }

        .action-icons i:hover, .action-icons button:hover {
            color: #e51b24;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 25px 30px;
            border-radius: 8px;
            width: 400px;
            max-width: 90%;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 20px;
            cursor: pointer;
            color: #666;
            transition: 0.3s;
        }

        .close-modal:hover {
            color: #1a1a1a;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1a1a1a;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
            color: #1a1a1a;
        }

        .modal-input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }

        .modal-input:focus {
            border-color: #1a1a1a;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
        }

        .btn-simpan {
            background-color: #ff4d4f;
            color: white;
            border: none;
            padding: 8px 25px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-simpan:hover {
            background-color: #d9363e;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="profile-section">
            <div class="profile-circle"></div>
            <div class="profile-name">{{ Auth::user()->nama_lengkap ?? 'Admin Humas' }}</div>
        </div>

        <ul class="menu-list">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="menu-item">
                    <i class="fa-solid fa-house"></i> Beranda
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pengajuan.index') }}" class="menu-item">
                    <i class="fa-solid fa-file-arrow-up"></i> Kelola Pengajuan
                </a>
            </li>
            <li>
                <a href="{{ route('admin.rekapitulasi') }}" class="menu-item">
                    <i class="fa-solid fa-chart-pie"></i> Rekapitulasi
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="menu-item active">
                    <i class="fa-solid fa-users-cog"></i> User Management
                </a>
            </li>
        </ul>
    </aside>

    <!-- KANVAS UTAMA -->
    <main class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <i class="fa-regular fa-bell bell-icon"></i>
            <div class="user-dropdown" style="position: relative;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn" title="Keluar dari sistem">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Header Halaman & Navigasi Tab -->
        <div class="page-header">
            <h1>User Management</h1>
            <div class="tabs-container">
                <a href="{{ route('admin.users.index') }}" class="tab-link">Daftar Pengguna</a>
                <a href="{{ route('admin.kategori.index') }}" class="tab-link active">Kategori Berita</a>
                <a href="{{ route('admin.prodi.index') }}" class="tab-link">Program Studi/Unit</a>
            </div>
        </div>

        <!-- Area Tabel Putih -->
        <div class="table-panel">
            <div class="table-controls">
                <button class="btn-add" id="btnTambahKategori">
                    <i class="fa-solid fa-plus"></i> Tambah Kategori Baru
                </button>
            </div>

            <!-- Tabel Data Kategori -->
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $kat)
                        <tr>
                            <td>{{ $kat->nama_kategori }}</td>
                            <td>
                                <div class="action-icons">
                                    <!-- Tombol Edit Kategori -->
                                    <i class="fa-solid fa-pen" title="Edit" onclick="openEditModal('{{ $kat->id }}', '{{ $kat->nama_kategori }}')"></i>

                                    <!-- Tombol Hapus Kategori -->
                                    <form action="{{ route('admin.kategori.destroy', $kat->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus"><i class="fa-regular fa-trash-can"></i></button>
                                    </form>

                                    <i class="fa-solid fa-lock" title="Kunci Kategori"></i>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="text-align: center;">Belum ada kategori berita.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <!-- ================= OVERLAY MODAL KATEGORI ================= -->
    <div class="modal-overlay" id="modalKategori">
        <div class="modal-content">
            <i class="fa-solid fa-xmark close-modal" id="closeModal"></i>

            <h2 class="modal-title" id="modalTitle">Tambah Kategori Baru</h2>

            <form id="formKategori" action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div id="methodContainer"></div>

                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" id="inputNamaKategori" name="nama_kategori" class="modal-input" required>
                </div>

                <div class="modal-actions">
                    <button type="submit" class="btn-simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Logika Overlay & Dinamis Edit/Tambah -->
    <script>
        const modal = document.getElementById("modalKategori");
        const btnTambah = document.getElementById("btnTambahKategori");
        const btnClose = document.getElementById("closeModal");
        const inputKategori = document.getElementById("inputNamaKategori");
        const formKategori = document.getElementById("formKategori");
        const modalTitle = document.getElementById("modalTitle");
        const methodContainer = document.getElementById("methodContainer");

        btnTambah.onclick = function () {
            modalTitle.textContent = "Tambah Kategori Baru";
            formKategori.action = "{{ route('admin.kategori.store') }}";
            methodContainer.innerHTML = "";
            inputKategori.value = "";
            modal.style.display = "flex";
        }

        function openEditModal(id, namaKategori) {
            modalTitle.textContent = "Edit Kategori Berita";
            formKategori.action = "/admin/kategori/" + id;
            methodContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            inputKategori.value = namaKategori;
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
</body>

</html>