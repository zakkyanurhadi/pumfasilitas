<?php
$uri = service('uri')->getSegment(1) ? service('uri')->getSegment(1) : '';
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
            <li class="sidebar-title">Menu</li>

            <li>
                <a href="<?= site_url('dashboardadmin') ?>"
                    class="sidebar-item <?= $uri == 'dashboardadmin' ? 'active' : '' ?>">
                    <div class="icon-box"><i class="fa-solid fa-house"></i></div>
                    <span>Home</span>
                </a>
            </li>

            <li class="sidebar-dropdown
            <?= ($uri == 'laporanadmin' || $uri == 'laporanadminpending' || $uri == 'laporanadmindiproses' || $uri == 'riwayatadmin') ? 'active' : '' ?>">

                <a href="<?= site_url('laporanadmin') ?>"
                    class="sidebar-item <?= $uri == 'laporanadmin' ? 'active' : '' ?>">
                    <div class="icon-box"><i class="fa-solid fa-file-lines"></i></div>
                    <span>Laporan</span>
                    <i class="fa-solid fa-chevron-down dropdown-icon"></i>
                </a>

                <ul class="sidebar-submenu" style="<?= ($uri == 'laporanadmin' || $uri == 'laporanadminpending' || $uri == 'laporanadmindiproses' || $uri == 'riwayatadmin') ? 'max-height:500px' : '' ?>">

                    <li>
                        <a href="<?= site_url('laporanadminpending') ?>"
                            class="<?= $uri == 'laporanadminpending' ? 'active-submenu' : '' ?>">
                            <i class="fa-solid fa-clock"></i> Laporan Pending
                        </a>
                    </li>

                    <li>
                        <a href="<?= site_url('laporanadmindiproses') ?>"
                            class="<?= $uri == 'laporanadmindiproses' ? 'active-submenu' : '' ?>">
                            <i class="fa-solid fa-spinner"></i> Laporan Diproses
                        </a>
                    </li>

                    <li>
                        <a href="<?= site_url('riwayatadmin') ?>"
                            class="<?= $uri == 'riwayatadmin' ? 'active-submenu' : '' ?>">
                            <i class="fa-solid fa-check-circle"></i> Laporan Selesai
                        </a>
                    </li>

                </ul>
            </li>


            <li class="sidebar-dropdown 
            <?= ($uri == 'akunadmin' || $uri == 'akunuser') ? 'active' : '' ?>">

                <a href="<?= site_url('akunadmin') ?>" class="sidebar-item">
                    <div class="icon-box"><i class="fa-solid fa-user-gear"></i></div>
                    <span>Akun</span>
                    <i class="fa-solid fa-chevron-down dropdown-icon"></i>
                </a>

                <ul class="sidebar-submenu"
                    style="<?= ($uri == 'akunadmin' || $uri == 'akunuser') ? 'max-height:500px' : '' ?>">

                    <li>
                        <a href="<?= site_url('akunadmin') ?>"
                            class="<?= $uri == 'akunadmin' ? 'active-submenu' : '' ?>">
                            <i class="fa-solid fa-user-shield"></i> Akun Admin
                        </a>
                    </li>

                    <li>
                        <a href="<?= site_url('akunuser') ?>"
                            class="<?= $uri == 'akunuser' ? 'active-submenu' : '' ?>">
                            <i class="fa-solid fa-users"></i> Akun User
                        </a>
                    </li>

                </ul>
            </li>


            <li>
                <a href="<?= site_url('gedung') ?>"
                    class="sidebar-item <?= $uri == 'gedung' ? 'active' : '' ?>">
                    <div class="icon-box"><i class="fa-solid fa-clock-rotate-left"></i></div>
                    <span>Kelola Gedung</span>
                </a>
            </li>
        </ul>


        <ul class="sidebar-menu section-bottom">
            <li class="sidebar-title">Akun</li>

            <li>
                <a href="<?= site_url('profileadmin') ?>"
                    class="sidebar-item <?= $uri == 'profileadmin' ? 'active' : '' ?>">
                    <div class="icon-box"><i class="fa-solid fa-user"></i></div>
                    <span>My Profile</span>
                </a>
            </li>

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
            <div class="top-icon"><i class="fa-solid fa-gear"></i></div>

            <div class="user-box">
                <img src="default.png" alt="User">
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- isi halaman -->