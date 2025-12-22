<?php
$uri = service('uri')->getSegment(2) ?: 'dashboard';
?>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-logo">
                <img src="/assets/img/logopolinela.png" alt="Logo">
            </div>
            <span class="sidebar-title-up">E-Fasilitas</span>
        </div>

        <ul class="sidebar-menu">
            <li class="sidebar-title">Menu Rektor</li>

            <li>
                <a href="<?= site_url('rektor/dashboard') ?>"
                    class="sidebar-item <?= $uri == 'dashboard' ? 'active' : '' ?>">
                    <div class="icon-box"><i class="fa-solid fa-chart-line"></i></div>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="<?= site_url('rektor/laporan') ?>"
                    class="sidebar-item <?= $uri == 'laporan' ? 'active' : '' ?>">
                    <div class="icon-box"><i class="fa-solid fa-file-contract"></i></div>
                    <span>Daftar Laporan</span>
                </a>
            </li>

            <li>
                <a href="<?= site_url('rektor/statistik') ?>"
                    class="sidebar-item <?= $uri == 'statistik' ? 'active' : '' ?>">
                    <div class="icon-box"><i class="fa-solid fa-chart-pie"></i></div>
                    <span>Statistik Pengaduan</span>
                </a>
            </li>

            <li>
                <a href="<?= site_url('rektor/audit-log') ?>"
                    class="sidebar-item <?= $uri == 'audit-log' ? 'active' : '' ?>">
                    <div class="icon-box"><i class="fa-solid fa-history"></i></div>
                    <span>Audit Log</span>
                </a>
            </li>
        </ul>


        <ul class="sidebar-menu section-bottom">
            <li class="sidebar-title">Akun</li>

            <li>
                <a href="<?= site_url('logout') ?>" class="sidebar-item">
                    <div class="icon-box"><i class="fa-solid fa-right-from-bracket"></i></div>
                    <span>Keluar</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- TOGGLE BUTTON -->
    <div class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()">
        <div class="tooltip-wrap">
            <span class="toggle-icon">❮</span>
            <span class="tooltip-text">Geser</span>
        </div>
    </div>


    <!-- NAVBAR ATAS -->
    <nav class="top-navbar">
        <div class="top-left"></div>

        <div class="top-right">
            <div class="top-icon"><i class="fa-solid fa-bell"></i></div>

            <?php
            $imgSession = session('img');

            $namaFileGambar = ($imgSession && !empty($imgSession))
                ? $imgSession
                : 'default.png';

            $avatarUrl = base_url('uploads/avatars/' . $namaFileGambar);
            ?>

            <div class="user-box">
                <img src="<?= $avatarUrl ?>" alt="User">
            </div>

        </div>
    </nav>