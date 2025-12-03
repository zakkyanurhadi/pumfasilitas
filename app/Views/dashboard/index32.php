<?= $this->extend('layouts/user/main') ?>

<?= $this->section('content') ?>

<section class="welcome-section" id="home">
    <h1>Sistem Laporan Kerusakan Fasilitas Kampus</h1>
    <p>
        Selamat datang, <strong><?= esc($user['nama']) ?></strong>! Laporkan kerusakan fasilitas kampus dengan mudah dan cepat.
    </p>
</section>

<section class="stats-section" id="status">
    <h2 class="text-center mb-3">Statistik Laporan</h2>
    <div class="stats-grid">
        <div class="stat-card">
            <span class="number" id="totalLaporan"><?= esc($stats['total']) ?></span>
            <span class="label">Total Laporan</span>
        </div>
        <div class="stat-card">
            <span class="number text-warning" id="pending"><?= esc($stats['pending']) ?></span>
            <span class="label">Pending</span>
        </div>
        <div class="stat-card">
            <span class="number text-success" id="sedangDiproses"><?= esc($stats['diproses']) ?></span>
            <span class="label">Sedang Diproses</span>
        </div>
        <div class="stat-card">
            <span class="number text-danger" id="selesai"><?= esc($stats['selesai']) ?></span>
            <span class="label">Selesai</span>
        </div>
    </div>
</section>

<div class="menu-grid" id="laporan">
    <a href="<?= site_url('laporan') ?>" class="menu-card text-decoration-none text-dark">
        <div class="icon"><i class="fas fa-plus-circle"></i></div>
        <h3>Buat Laporan Baru</h3>
        <p>Laporkan kerusakan fasilitas kampus yang Anda temukan.</p>
        <span class="btn">Laporkan Sekarang</span>
    </a>

    <a href="<?= site_url('laporan/status') ?>" class="menu-card text-decoration-none text-dark">
        <div class="icon"><i class="fas fa-list-alt"></i></div>
        <h3>Lihat Status Laporan</h3>
        <p>Cek status perbaikan dari laporan yang telah Anda buat.</p>
        <span class="btn btn-secondary">Lihat Status</span>
    </a>

    <a href="<?= site_url('laporan/riwayat') ?>" class="menu-card text-decoration-none text-dark">
        <div class="icon"><i class="fas fa-history"></i></div>
        <h3>Riwayat Laporan</h3>
        <p>Lihat semua laporan yang pernah dibuat sebelumnya.</p>
        <span class="btn btn-secondary">Lihat Riwayat</span>
    </a>
</div>

<?= $this->endSection() ?>