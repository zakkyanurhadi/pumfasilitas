<?= $this->extend('admin/layouts/main') ?>

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



<?= $this->endSection() ?>