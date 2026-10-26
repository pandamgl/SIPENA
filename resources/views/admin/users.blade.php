<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - SIPENA</title>

    <!-- Memanggil Library Ikon dari FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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

        /* Status Menu Aktif di User Management */
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
            display: flex;
            flex-direction: column;
        }

        /* Topbar */
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

        /* Header Halaman & Tabs */
        .page-header {
            padding: 0 40px 10px 40px;
        }

        .page-header h1 {
            font-size: 32px;
            color: #1a1a1a;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* Navigasi Tabs */
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

        /* --- AREA PANEL PUTIH --- */
        .table-panel {
            background-color: #ffffff;
            margin: 0 40px 40px 40px;
            padding: 30px 40px;
            border-radius: 15px;
            border-top-left-radius: 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            flex: 1;
        }

        /* Kontrol Tabel (Search & Tambah) */
        .table-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-input {
            padding: 8px 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
            font-family: inherit;
            width: 250px;
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

        /* Tabel Data */
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

        .data-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .data-table tbody tr:hover {
            background-color: #f1f3f5;
        }

        .email-link {
            color: #00bcd4;
            text-decoration: none;
        }

        .email-link:hover {
            text-decoration: underline;
        }

        .action-icons {
            display: flex;
            gap: 15px;
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

        /* Modal Styling */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 500px;
            max-width: 90%;
            position: relative;
        }
        .modal-close {
            position: absolute;
            top: 15px; right: 20px;
            font-size: 20px;
            cursor: pointer;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            font-size: 14px;
        }
        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-family: inherit;
        }
        .btn-submit {
            background-color: #2ed573;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
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
        <!-- Topbar Kanan Atas -->
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
                <a href="{{ route('admin.users.index') }}" class="tab-link active">Daftar Pengguna</a>
                <a href="{{ route('admin.kategori.index') }}" class="tab-link">Kategori Berita</a>
                <a href="{{ route('admin.prodi.index') }}" class="tab-link">Program Studi/Unit</a>
            </div>
        </div>

        <!-- Area Tabel Putih -->
        <div class="table-panel">

            <!-- Kontrol Tabel (Search & Tombol Tambah) -->
            <div class="table-controls">
                <!-- Diberikan id="searchInput" -->
                <input type="text" id="searchInput" class="search-input" placeholder="Cari pengguna...">

                <button class="btn-add" id="btnTambahUser">
                    <i class="fa-solid fa-plus"></i> Tambah Pengguna Baru
                </button>
            </div>

            <!-- Tabel Data Pengguna -->
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama Pengguna</th>
                        <th>NIM/NIK</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Prodi/Unit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    @forelse($users as $user)
                        <tr class="searchable-row">
                            <td>{{ $user->nama_lengkap }}</td>
                            <td>{{ $user->nim_nik }}</td>
                            <td><a href="mailto:{{ $user->email }}" class="email-link">{{ $user->email }}</a></td>
                            <td>
                                <!-- Fitur Lihat/Sembunyikan Password -->
                                <span id="pass-{{ $user->id }}" data-password="{{ $user->plain_password ?? $user->password }}">••••••••</span>
                                <i class="fa-solid fa-eye toggle-password" data-id="{{ $user->id }}" style="cursor: pointer; margin-left: 8px; color: #666;" title="Lihat Password"></i>
                            </td>
                            <td>{{ $user->prodiUnit->nama_prodi_unit ?? '-' }}</td>
                            <td>
                                <div class="action-icons">
                                    <!-- Tombol Edit (Memicu Modal Edit) -->
                                    <i class="fa-solid fa-pen btn-edit" title="Edit" 
                                       data-id="{{ $user->id }}"
                                       data-nama="{{ $user->nama_lengkap }}"
                                       data-nim="{{ $user->nim_nik }}"
                                       data-username="{{ $user->username }}"
                                       data-email="{{ $user->email }}"
                                       data-prodi="{{ $user->prodi_unit_id }}"></i>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus"><i class="fa-regular fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center;">Belum ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <!-- MODAL TAMBAH PENGGUNA -->
    <div class="modal-overlay" id="modalTambah">
        <div class="modal-box">
            <i class="fa-solid fa-xmark modal-close" id="closeTambah"></i>
            <h2 style="margin-bottom: 20px;">Tambah Pengguna Baru</h2>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>NIM / NIK</label>
                    <input type="text" name="nim_nik" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Program Studi / Unit</label>
                    <select name="prodi_unit_id" class="form-control" required>
                        <option value="">Pilih Prodi/Unit</option>
                        @isset($prodiList)
                            @foreach($prodiList as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_prodi_unit }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <button type="submit" class="btn-submit">Simpan Pengguna</button>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT PENGGUNA -->
    <div class="modal-overlay" id="modalEdit">
        <div class="modal-box">
            <i class="fa-solid fa-xmark modal-close" id="closeEdit"></i>
            <h2 style="margin-bottom: 20px;">Edit Pengguna</h2>
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="edit_nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>NIM / NIK</label>
                    <input type="text" name="nim_nik" id="edit_nim" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" id="edit_username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="edit_email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password Baru (Opsional)</label>
                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                </div>
                <div class="form-group">
                    <label>Program Studi / Unit</label>
                    <select name="prodi_unit_id" id="edit_prodi" class="form-control" required>
                        <option value="">Pilih Prodi/Unit</option>
                        @isset($prodiList)
                            @foreach($prodiList as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_prodi_unit }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <button type="submit" class="btn-submit">Perbarui Pengguna</button>
            </form>
        </div>
    </div>

    <!-- SCRIPT INTERAKTIF (SEARCH, MODAL, & TOGGLE PASSWORD) -->
    <script>
        // Fitur Live Search Bar
        const searchInput = document.getElementById('searchInput');
        const rows = document.getElementsByClassName('searchable-row');

        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase().trim();

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const textContent = row.textContent || row.innerText;

                if (textContent.toLowerCase().indexOf(filter) > -1) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        });

        // Modal Tambah
        const modalTambah = document.getElementById('modalTambah');
        document.getElementById('btnTambahUser').onclick = () => modalTambah.style.display = 'flex';
        document.getElementById('closeTambah').onclick = () => modalTambah.style.display = 'none';

        // Modal Edit
        const modalEdit = document.getElementById('modalEdit');
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.onclick = function() {
                const id = this.getAttribute('data-id');
                document.getElementById('formEdit').action = "/admin/users/" + id;
                document.getElementById('edit_nama').value = this.getAttribute('data-nama');
                document.getElementById('edit_nim').value = this.getAttribute('data-nim');
                document.getElementById('edit_username').value = this.getAttribute('data-username');
                document.getElementById('edit_email').value = this.getAttribute('data-email');
                document.getElementById('edit_prodi').value = this.getAttribute('data-prodi');
                modalEdit.style.display = 'flex';
            }
        });
        document.getElementById('closeEdit').onclick = () => modalEdit.style.display = 'none';

        // Tutup modal jika klik di luar box
        window.onclick = (e) => {
            if (e.target == modalTambah) modalTambah.style.display = 'none';
            if (e.target == modalEdit) modalEdit.style.display = 'none';
        }

        // Fitur Lihat / Sembunyikan Password
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.onclick = function() {
                const userId = this.getAttribute('data-id');
                const span = document.getElementById('pass-' + userId);
                const realPass = span.getAttribute('data-password');

                if (span.textContent === '••••••••') {
                    span.textContent = realPass;
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    span.textContent = '••••••••';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            }
        });
    </script>
</body>

</html>