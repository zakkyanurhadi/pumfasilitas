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
        <div class="page-title" id="realtimeClock">
            <i class="fa-regular fa-clock" style="margin-right: 8px;"></i>
            <span id="clockTime">--:--:--</span>
            <span id="clockDate" style="font-size: 14px; font-weight: 400; color: #64748b; margin-left: 12px;">-- ---
                ----</span>
        </div>
        <div class="top-left"></div>


        <div class="top-right">


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
    <script>
        function updateRealtimeClock() {
            const now = new Date();

            // Format waktu: HH:MM:SS
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;

            // Format tanggal: Senin, 23 Des 2024
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            const dayName = days[now.getDay()];
            const date = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            const dateString = `${dayName}, ${date} ${month} ${year}`;

            // Update DOM
            document.getElementById('clockTime').textContent = timeString;
            document.getElementById('clockDate').textContent = dateString;
        }

        // Update setiap detik
        setInterval(updateRealtimeClock, 1000);

        // Update langsung saat halaman dimuat
        document.addEventListener('DOMContentLoaded', updateRealtimeClock);
    </script>