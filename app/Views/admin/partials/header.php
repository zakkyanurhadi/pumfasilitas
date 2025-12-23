<?php
$uri = service('uri')->getSegment(1) ? service('uri')->getSegment(1) : '';
?>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-logo">
            <img src="<?= base_url('assets/img/logopolinela.png') ?>" alt="Logo">
        </div>
        <span class="sidebar-title">E-Fasilitas</span>
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

        <!-- ... (sisa menu laporan, akun, dll) ... -->
        <li
            class="sidebar-dropdown <?= ($uri == 'laporanadmin' || $uri == 'laporanadminpending' || $uri == 'laporanadmindiproses' || $uri == 'riwayatadmin') ? 'active' : '' ?>">
            <a href="#" class="sidebar-item">
                <div class="icon-box"><i class="fa-solid fa-file-lines"></i></div>
                <span>Laporan</span>
                <i class="fa-solid fa-chevron-down dropdown-icon"></i>
            </a>
            <ul class="sidebar-submenu"
                style="<?= ($uri == 'laporanadmin' || $uri == 'laporanadminpending' || $uri == 'laporanadmindiproses' || $uri == 'riwayatadmin') ? 'max-height:500px' : '' ?>">
                <li><a href="<?= site_url('laporanadminpending') ?>"><i class="fa-solid fa-clock"></i> Laporan
                        Pending</a></li>
                <li><a href="<?= site_url('laporanadmindiproses') ?>"><i class="fa-solid fa-spinner"></i> Laporan
                        Diproses</a></li>
                <li><a href="<?= site_url('riwayatadmin') ?>"><i class="fa-solid fa-check-circle"></i> Laporan
                        Selesai</a></li>
            </ul>
        </li>

        <li class="sidebar-dropdown <?= ($uri == 'akunadmin' || $uri == 'akunuser') ? 'active' : '' ?>">
            <a href="#" class="sidebar-item">
                <div class="icon-box"><i class="fa-solid fa-user-gear"></i></div>
                <span>Akun</span>
                <i class="fa-solid fa-chevron-down dropdown-icon"></i>
            </a>
            <ul class="sidebar-submenu"
                style="<?= ($uri == 'akunadmin' || $uri == 'akunuser') ? 'max-height:500px' : '' ?>">
                <?php if (session()->get('role') === 'superadmin'): ?>
                    <li><a href="<?= site_url('akunadmin') ?>"><i class="fa-solid fa-user-shield"></i> Akun Admin</a></li>
                <?php endif; ?>
                <li><a href="<?= site_url('akunuser') ?>"><i class="fa-solid fa-users"></i> Akun User</a></li>
            </ul>
        </li>

        <?php if (session()->get('role') === 'superadmin'): ?>
            <li>
                <a href="<?= site_url('gedung') ?>" class="sidebar-item <?= $uri == 'gedung' ? 'active' : '' ?>">
                    <div class="icon-box"><i class="fa-solid fa-building"></i></div>
                    <span>Kelola Gedung</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>

    <ul class="sidebar-menu">
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
<div class="sidebar-toggle" id="sidebarToggle">
    <i class="fa-solid fa-bars toggle-icon"></i>
</div>

<!-- NAVBAR ATAS -->
<nav class="top-navbar">
    <div class="page-title" id="realtimeClock"
        style="display: flex; flex-direction: column; align-items: flex-start; gap: 2px;">
        <span id="clockTime" style="font-size: 18px; font-weight: 600; color: #1e293b;">--:--:--</span>
        <span id="clockDate" style="font-size: 12px; font-weight: 400; color: #64748b;">-- --- ----</span>
    </div>
    <div class="top-right">
        <a href="<?= site_url('admin/notifikasi') ?>" class="top-icon"
            style="position: relative; text-decoration: none; color: inherit;" id="adminNotifLink">
            <i class="fa-solid fa-bell"></i>
            <span id="adminNotifBadge"
                style="display: none; position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; font-size: 10px; padding: 2px 6px; border-radius: 10px; font-weight: 600;"></span>
        </a>

        <?php
        $imgSession = session('img');
        $namaFileGambar = ($imgSession && !empty($imgSession)) ? $imgSession : 'default.png';
        $avatarUrl = base_url('uploads/avatars/' . $namaFileGambar);
        ?>
        <div class="user-box">
            <img src="<?= $avatarUrl ?>" alt="User Avatar">
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