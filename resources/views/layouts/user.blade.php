<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPENA User')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    @stack('styles')
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="profile-section">
            <div class="profile-circle"></div>
            <div class="profile-name">Pengaju Berita</div>
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
                <i class="fa-regular fa-circle-user"></i>
                <i class="fa-solid fa-chevron-down" style="font-size: 14px;"></i>
            </div>
        </div>

        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>