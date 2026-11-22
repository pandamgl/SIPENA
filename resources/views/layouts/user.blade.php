<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPENA User')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
<<<<<<< HEAD
        /* Reset & Font Setup */
=======
>>>>>>> f2fdcd59f9033ff6ce48fabe332a3e780814c4b0
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
<<<<<<< HEAD
            background-color: #ffffff;
=======
            background-color: #f8f9fa;
>>>>>>> f2fdcd59f9033ff6ce48fabe332a3e780814c4b0
            color: #333;
            display: flex;
            min-height: 100vh;
        }

<<<<<<< HEAD
        /* --- SIDEBAR KIRI --- */
=======
>>>>>>> f2fdcd59f9033ff6ce48fabe332a3e780814c4b0
        .sidebar {
            width: 260px;
            background-color: #ffffff;
            border-right: 1px solid #e0e0e0;
            display: flex;
            flex-direction: column;
            padding-top: 40px;
<<<<<<< HEAD
            flex-shrink: 0;
=======
>>>>>>> f2fdcd59f9033ff6ce48fabe332a3e780814c4b0
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
<<<<<<< HEAD
=======
            font-weight: 500;
>>>>>>> f2fdcd59f9033ff6ce48fabe332a3e780814c4b0
        }

        .menu-item:hover:not(.active) {
            background-color: #f5f5f5;
            border-top-right-radius: 25px;
            border-bottom-right-radius: 25px;
            margin-right: 10px;
        }

<<<<<<< HEAD
        /* --- KANVAS UTAMA KANAN --- */
=======
>>>>>>> f2fdcd59f9033ff6ce48fabe332a3e780814c4b0
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
        }

        .topbar {
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
<<<<<<< HEAD
=======
            transition: color 0.2s;
        }

        .bell-icon:hover {
            color: #e51b24;
        }

        .notif-badge {
            position: absolute;
            top: -2px;
            right: -4px;
            background-color: #e51b24;
            color: #ffffff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 10px;
            border: 2px solid #ffffff;
            line-height: 1;
        }

        .notif-dropdown {
            display: none;
            position: absolute;
            top: 45px;
            right: -60px;
            width: 350px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border: 1px solid #eaeaea;
            z-index: 1000;
            overflow: hidden;
        }

        .notif-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background: #f8f9fa;
            border-bottom: 1px solid #eaeaea;
        }

        .notif-header h4 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-mark-read {
            background: none;
            border: none;
            color: #0066cc;
            font-size: 12px;
            cursor: pointer;
            font-weight: 500;
            padding: 2px 5px;
        }

        .btn-mark-read:hover {
            text-decoration: underline;
        }

        .notif-list {
            max-height: 360px;
            overflow-y: auto;
        }

        .notif-item {
            display: flex;
            gap: 12px;
            padding: 12px 16px;
            border-bottom: 1px solid #f0f0f0;
            text-decoration: none;
            color: inherit;
            transition: background 0.2s;
        }

        .notif-item:hover {
            background: #fdf2f2;
        }

        .notif-item.unread {
            background: #fff8f8;
            border-left: 3px solid #e51b24;
        }

        .notif-icon-box {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .icon-publish {
            background: #e8f8f0;
            color: #2ecc71;
        }

        .icon-reject {
            background: #fde8e8;
            color: #e51b24;
        }

        .icon-progress {
            background: #e8f4fd;
            color: #3498db;
        }

        .icon-review {
            background: #fef5e7;
            color: #f39c12;
        }

        .notif-content {
            flex: 1;
            font-size: 12px;
        }

        .notif-title {
            font-size: 13px;
            color: #1a1a1a;
            margin-bottom: 2px;
        }

        .notif-desc {
            color: #555;
            line-height: 1.4;
            margin-bottom: 4px;
        }

        .notif-alasan {
            color: #e51b24;
            font-size: 11px;
            font-weight: 500;
            display: block;
            margin-top: 2px;
        }

        .notif-time {
            color: #999;
            font-size: 11px;
        }

        .notif-empty {
            padding: 30px 16px;
            text-align: center;
            color: #888;
            font-size: 13px;
        }

        .notif-empty i {
            font-size: 32px;
            margin-bottom: 8px;
            color: #bbb;
            display: block;
        }

        .notif-footer {
            padding: 10px 16px;
            background: #f8f9fa;
            text-align: center;
            border-top: 1px solid #eaeaea;
        }

        .notif-footer a {
            color: #e51b24;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
        }

        .notif-footer a:hover {
            text-decoration: underline;
>>>>>>> f2fdcd59f9033ff6ce48fabe332a3e780814c4b0
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
            color: #333;
            cursor: pointer;
            font-family: inherit;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="profile-section">
            <div class="profile-circle"></div>
            <div class="profile-name">{{ Auth::user()->nama_lengkap ?? 'Pengaju Berita' }}</div>
        </div>

        <ul class="menu-list">
            <li>
                <a href="{{ route('user.dashboard') }}"
                    class="menu-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i> Beranda
                </a>
            </li>
            <li>
                <a href="{{ route('user.pengajuan') }}"
                    class="menu-item {{ request()->routeIs('user.pengajuan') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-arrow-up"></i> Pengajuan Berita
                </a>
            </li>
            <li>
                <a href="{{ route('user.monitoring') }}"
                    class="menu-item {{ request()->routeIs('user.monitoring') ? 'active' : '' }}">
                    <i class="fa-solid fa-desktop"></i> Monitoring
                </a>
            </li>
        </ul>
    </aside>

    <!-- KANVAS UTAMA -->
    <main class="main-content">
        <!-- Topbar Kanan Atas -->
        <div class="topbar">
<<<<<<< HEAD
            <i class="fa-regular fa-bell bell-icon"></i>
            <div class="user-dropdown">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
=======
            <!-- Dropdown Notifikasi -->
            <div class="notif-wrapper" style="position: relative;">
                <div class="bell-container" id="bellBtn" title="Notifikasi Status" style="position: relative; cursor: pointer; padding: 5px;">
                    <i class="fa-regular fa-bell bell-icon"></i>
                    <span id="notifBadge" class="notif-badge" style="display: none;">0</span>
                </div>

                <!-- Popup Dropdown Notifikasi -->
                <div class="notif-dropdown" id="notifDropdown">
                    <div class="notif-header">
                        <h4><i class="fa-solid fa-bell"></i> Notifikasi</h4>
                        <button type="button" id="btnMarkRead" class="btn-mark-read">Tandai Dibaca</button>
                    </div>
                    <div class="notif-list" id="notifList">
                        @if(isset($userNotifications) && $userNotifications->count() > 0)
                            @foreach($userNotifications as $notif)
                                <a href="{{ route('user.monitoring') }}" class="notif-item" data-notif-id="{{ $notif->id }}">
                                    <div class="notif-icon-box 
                                        @if($notif->status_baru == 'Publish') icon-publish
                                        @elseif($notif->status_baru == 'Rejected') icon-reject
                                        @elseif($notif->status_baru == 'In Progress') icon-progress
                                        @else icon-review @endif">
                                        @if($notif->status_baru == 'Publish')
                                            <i class="fa-solid fa-check"></i>
                                        @elseif($notif->status_baru == 'Rejected')
                                            <i class="fa-solid fa-xmark"></i>
                                        @elseif($notif->status_baru == 'In Progress')
                                            <i class="fa-solid fa-spinner"></i>
                                        @else
                                            <i class="fa-solid fa-clock"></i>
                                        @endif
                                    </div>
                                    <div class="notif-content">
                                        <div class="notif-title">
                                            Status: <strong>{{ $notif->status_baru }}</strong>
                                        </div>
                                        <div class="notif-desc">
                                            Pengajuan: <em>"{{ Str::limit($notif->pengajuan->judul_berita ?? 'Berita', 40) }}"</em>
                                            @if($notif->status_baru == 'Rejected' && $notif->catatan)
                                                <span class="notif-alasan"><i class="fa-solid fa-circle-exclamation"></i> Alasan: {{ Str::limit($notif->catatan, 55) }}</span>
                                            @endif
                                        </div>
                                        <div class="notif-time">
                                            {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="notif-empty">
                                <i class="fa-regular fa-bell-slash"></i>
                                <p>Belum ada notifikasi perubahan status.</p>
                            </div>
                        @endif
                    </div>
                    <div class="notif-footer">
                        <a href="{{ route('user.monitoring') }}">Buka Halaman Monitoring &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="user-dropdown">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: flex; align-items: center;">
>>>>>>> f2fdcd59f9033ff6ce48fabe332a3e780814c4b0
                    @csrf
                    <button type="submit" class="logout-btn" title="Logout">
                        <i class="fa-regular fa-circle-user"></i>
                        <i class="fa-solid fa-right-from-bracket" style="font-size: 14px; color: #e51b24;"></i>
                    </button>
                </form>
            </div>
        </div>

        @yield('content')
    </main>

<<<<<<< HEAD
    @stack('scripts')
</body>

</html>
=======
    <script>
        // Logika Notifikasi Dropdown & Unread Tracking dengan LocalStorage
        document.addEventListener('DOMContentLoaded', function () {
            const bellBtn = document.getElementById('bellBtn');
            const notifDropdown = document.getElementById('notifDropdown');
            const notifBadge = document.getElementById('notifBadge');
            const btnMarkRead = document.getElementById('btnMarkRead');
            const notifItems = document.querySelectorAll('.notif-item');

            function updateNotifBadge() {
                const readIds = JSON.parse(localStorage.getItem('sipena_read_notifs') || '[]');
                let unreadCount = 0;

                notifItems.forEach(item => {
                    const id = item.getAttribute('data-notif-id');
                    if (!readIds.includes(id)) {
                        unreadCount++;
                        item.classList.add('unread');
                    } else {
                        item.classList.remove('unread');
                    }
                });

                if (notifBadge) {
                    if (unreadCount > 0) {
                        notifBadge.textContent = unreadCount > 99 ? '99+' : unreadCount;
                        notifBadge.style.display = 'block';
                    } else {
                        notifBadge.style.display = 'none';
                    }
                }
            }

            if (bellBtn && notifDropdown) {
                bellBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const isOpen = notifDropdown.style.display === 'block';
                    notifDropdown.style.display = isOpen ? 'none' : 'block';
                });

                document.addEventListener('click', function (e) {
                    if (!notifDropdown.contains(e.target) && !bellBtn.contains(e.target)) {
                        notifDropdown.style.display = 'none';
                    }
                });
            }

            if (btnMarkRead) {
                btnMarkRead.addEventListener('click', function () {
                    const allIds = Array.from(notifItems).map(item => item.getAttribute('data-notif-id'));
                    localStorage.setItem('sipena_read_notifs', JSON.stringify(allIds));
                    updateNotifBadge();
                });
            }

            notifItems.forEach(item => {
                item.addEventListener('click', function () {
                    const id = this.getAttribute('data-notif-id');
                    const readIds = JSON.parse(localStorage.getItem('sipena_read_notifs') || '[]');
                    if (!readIds.includes(id)) {
                        readIds.push(id);
                        localStorage.setItem('sipena_read_notifs', JSON.stringify(readIds));
                    }
                });
            });

            updateNotifBadge();
        });
    </script>

    @stack('scripts')
</body>

</html>
>>>>>>> f2fdcd59f9033ff6ce48fabe332a3e780814c4b0
