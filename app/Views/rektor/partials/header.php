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
        <i class="fa-solid fa-bars toggle-icon"></i>
    </div>


    <!-- NAVBAR ATAS -->
    <nav class="top-navbar">
        <div class="page-title" id="realtimeClock"
            style="display: flex; flex-direction: column; align-items: flex-start; gap: 0; line-height: 1.2;">
            <span id="clockTime" style="font-size: 18px; font-weight: 600; color: #1e293b;"></span>
            <span id="clockDate" style="font-size: 12px; font-weight: 400; color: #64748b;"></span>
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

            <div class="user-dropdown-wrapper" style="position: relative;">
                <div class="user-box" onclick="toggleUserDropdown()" style="cursor: pointer;">
                    <img src="<?= $avatarUrl ?>" alt="User">
                    <i class="fa-solid fa-chevron-down" style="font-size: 10px; color: #64748b; margin-left: 4px;"></i>
                </div>

                <!-- Dropdown Menu -->
                <div id="userDropdownMenu" class="user-dropdown-menu" style="display: none;">
                    <div class="dropdown-header">
                        <img src="<?= $avatarUrl ?>" alt="Avatar">
                        <div>
                            <div class="dropdown-name"><?= esc(session('nama') ?? 'Rektor') ?></div>
                            <div class="dropdown-role">Rektor</div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="<?= site_url('logout') ?>" class="dropdown-item logout-item">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Keluar</span>
                    </a>
                </div>
            </div>

        </div>
    </nav>

    <style>
        .user-dropdown-wrapper {
            position: relative;
        }

        .user-box {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .user-dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            min-width: 220px;
            z-index: 9999;
            overflow: hidden;
            animation: dropdownFadeIn 0.2s ease;
        }

        @keyframes dropdownFadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: #ffffff;
            color: #1e293b;
            border-bottom: 1px solid #e2e8f0;
        }

        .dropdown-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #e2e8f0;
            object-fit: cover;
        }

        .dropdown-name {
            font-weight: 600;
            font-size: 14px;
            color: #1e293b;
        }

        .dropdown-role {
            font-size: 11px;
            color: #64748b;
        }

        .dropdown-divider {
            height: 1px;
            background: #e2e8f0;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #475569;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .dropdown-item i {
            width: 18px;
            text-align: center;
            font-size: 14px;
        }

        .dropdown-item.logout-item {
            color: #dc2626;
        }

        .dropdown-item.logout-item:hover {
            background: #fef2f2;
            color: #b91c1c;
        }
    </style>

    <script>
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdownMenu');
            if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                dropdown.style.display = 'block';
            } else {
                dropdown.style.display = 'none';
            }
        }

        // Tutup dropdown saat klik di luar
        document.addEventListener('click', function (event) {
            const dropdown = document.getElementById('userDropdownMenu');
            const wrapper = document.querySelector('.user-dropdown-wrapper');
            if (wrapper && !wrapper.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });

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