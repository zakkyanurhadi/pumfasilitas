<!-- SIDEBAR -->
<aside class="sidebar">
    <ul class="sidebar-menu">
        <li class="sidebar-title">Menu</li>

        <li><a href="<?= site_url('dashboardadmin') ?>">
            <i class="fas fa-home"></i> <span>Home</span>
        </a></li>

        <li><a href="<?= site_url('laporanadmin') ?>">
            <i class="fas fa-file-alt"></i> <span>Laporan</span>
        </a></li>

        <li><a href="<?= site_url('riwayatadmin') ?>">
            <i class="fas fa-history"></i> <span>Riwayat Laporan</span>
        </a></li>
    </ul>

    <ul class="sidebar-menu section-bottom">
        <li class="sidebar-title">Akun</li>

        <li><a href="<?= site_url('profileadmin') ?>">
            <i class="fas fa-user-circle"></i> <span>My Profile</span>
        </a></li>

        <li><a href="<?= site_url('logout') ?>">
            <i class="fas fa-sign-out-alt"></i> <span>Keluar</span>
        </a></li>
    </ul>
</aside>
