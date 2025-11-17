<header class="header">
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <a href="<?= site_url('dashboardadmin') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-tools"></i>
                    <span>FasilitasKampusKu - Admin</span>
                </a>
            </div>

            <nav class="nav-center">
                <ul class="nav-menu">
                    <li><a href="<?= site_url('dashboardadmin') ?>">Home</a></li>
                    <li><a href="<?= site_url('laporanadmin') ?>">Laporan</a></li>
                    <li><a href="<?= site_url('riwayatadmin') ?>">Riwayat Laporan</a></li>
                </ul>
            </nav>

            <div class="user-profile">
                <div class="profile-info" onclick="toggleDropdown()">
                    <?php
                    // Logika untuk menentukan URL gambar
                    $avatarUrl = (session('img') && session('img') !== 'default.jpg')
                        ? base_url('uploads/avatars/' . session('img'))
                        : "https://ui-avatars.com/api/?name=" . urlencode(session('nama') ?? 'User') . "&background=random";
                    ?>
                    <img src="<?= $avatarUrl ?>" alt="Profile" class="profile-pic" />
                    <span class="username"><?= esc(session('nama') ?? 'Guest') ?></span>
                </div>
                <div class="dropdown" id="profileDropdown">
                    <div class="profile-header">
                        <img src="<?= $avatarUrl ?>" alt="Profile" class="profile-pic-large" />
                        <div>
                            <div class="username"><?= esc(session('nama')) ?></div>
                            <div class="role"><?= esc(session('npm')) ?></div>
                        </div>
                    </div>
                    <ul>
                        <li><a href="<?= site_url('profileadmin') ?>"><i class="fas fa-user-circle" style="margin-right: 8px"></i>My Profile</a></li>
                        <li><a href="<?= site_url('logout') ?>"><i class="fas fa-sign-out-alt" style="margin-right: 8px"></i>Keluar</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>