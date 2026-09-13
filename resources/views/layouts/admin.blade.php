<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPENA Admin')</title>

    <!-- Memanggil Library Ikon dari FontAwesome & Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    @stack('styles')
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="profile-section">
            <div class="profile-circle"></div>
            <div class="profile-name">Admin Humas</div>
        </div>

        <ul class="menu-list">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i> Beranda
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pengajuan.index') }}"
                    class="menu-item {{ request()->routeIs('admin.pengajuan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-arrow-up"></i> Kelola Pengajuan
                </a>
            </li>
            <li>
                <a href="{{ route('admin.rekapitulasi') }}"
                    class="menu-item {{ request()->routeIs('admin.rekapitulasi') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i> Rekapitulasi
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