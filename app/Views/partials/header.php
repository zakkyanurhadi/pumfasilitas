<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= site_url('dashboard') ?>">
            <img src="<?= base_url('assets/logo.webp') ?>" alt="Logo" priority="high">
            <div>
                <span class="d-block fw-bold text-dark" style="font-size: 1rem; line-height: 1;">E-Fasilitas</span>
                <span class="d-block text-muted small" style="font-size: 0.75rem;">Politeknik Negeri Lampung</span>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="<?= site_url('dashboard') ?>">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= site_url('dashboard') ?>#alur">Alur Laporan</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= site_url('dashboard') ?>#statistik">Statistik</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="<?= site_url('laporan') ?>">Buat Laporan</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= site_url('laporan/saya') ?>">Laporan Saya</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= site_url('laporan/riwayat') ?>">Riwayat Laporan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link position-relative me-4" href="<?= site_url('notifikasi') ?>" title="Notifikasi"
                        id="notifNavLink">
                        <i class="fas fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            id="notifBadge" style="display: none; font-size: 0.65rem; padding: 0.25rem 0.45rem;">
                            <span id="notifCount">0</span>
                            <span class="visually-hidden">notifikasi belum dibaca</span>
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <div class="profile-info" onclick="toggleDropdown()">
                        <?php

                        $imgSession = session('img');

                        $namaFileGambar = ($imgSession && !empty($imgSession)) ? $imgSession : 'default.png';

                        $avatarUrl = base_url('uploads/avatars/' . $namaFileGambar);
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
                            <li>
                                <a href="<?= site_url('laporan/saya') ?>">Laporan Saya</a>
                            </li>
                            <hr class="dropdown-divider">
                            <li>
                                <a href="<?= site_url('profile') ?>">Ubah Profil</a>
                            </li>
                            <li>
                                <a href="<?= site_url('notifikasi') ?>">Notifikasi</a>
                            </li>
                            <li>
                                <a href="<?= site_url('password') ?>">Ubah Password</a>
                            </li>
                            <hr class="dropdown-divider">
                            <li>
                                <a href="<?= site_url('logout') ?>" class="text-danger">Logout</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>