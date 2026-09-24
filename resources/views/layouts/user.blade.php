<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPENA User')</title>

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
            background-color: #ffffff;
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

        /* --- KANVAS UTAMA KANAN --- */
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
            <i class="fa-regular fa-bell bell-icon"></i>
            <div class="user-dropdown">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
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

    @stack('scripts')
</body>

</html>