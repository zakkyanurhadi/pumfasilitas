<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    .detail-card {
        background: #fff;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, .06);
        margin: 2rem auto;
        max-width: 900px;
    }

    .detail-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .status-badge {
        padding: .35rem 1rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: .85rem;
        text-transform: capitalize;
        color: #fff;
    }

    .status-pending {
        background: #dc3545;
    }

    .status-diproses {
        background: #fd7e14;
    }

    .status-selesai {
        background: #198754;
    }

    .meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .meta-item {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 10px;
        border-left: 4px solid #0d6efd;
    }

    .meta-label {
        font-size: .75rem;
        text-transform: uppercase;
        color: #6c757d;
        font-weight: 600;
        margin-bottom: .25rem;
    }

    .meta-value {
        font-weight: 600;
        color: #212529;
    }

    .photo-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .photo-gallery img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        border-radius: 10px;
        transition: transform .2s, box-shadow .2s;
        border: 1px solid #dee2e6;
    }

    .photo-gallery img:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 16px rgba(0, 0, 0, .15);
    }

    .section-title {
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: .75rem;
    }
</style>

<div class="detail-card">

    <!-- HEADER -->
    <div class="detail-header">
        <div>
            <h3 class="fw-bold mb-1">Detail Laporan #<?= esc($laporan['id']) ?></h3>
            <small class="text-muted">
                Dilaporkan pada
                <?= date('d F Y, H:i', strtotime($laporan['created_at'])) ?> WIB
            </small>
        </div>

        <?php
        $statusClass = match (strtolower($laporan['status'])) {
            'pending' => 'status-pending',
            'diproses' => 'status-diproses',
            'selesai' => 'status-selesai',
            default => 'status-pending',
        };
        ?>
        <span class="status-badge <?= $statusClass ?>">
            <?= esc($laporan['status']) ?>
        </span>
    </div>

    <!-- INFO GRID -->
    <div class="meta-grid">
        <div class="meta-item">
            <div class="meta-label">Nama Pelapor</div>
            <div class="meta-value"><?= esc($laporan['nama_pelapor']) ?></div>
        </div>

        <div class="meta-item">
            <div class="meta-label">Gedung</div>
            <div class="meta-value"><?= esc($laporan['nama_gedung'] ?? '-') ?></div>
        </div>

        <div class="meta-item">
            <div class="meta-label">Kategori</div>
            <div class="meta-value"><?= esc($laporan['kategori']) ?></div>
        </div>

        <div class="meta-item">
            <div class="meta-label">Prioritas</div>
            <div class="meta-value text-capitalize"><?= esc($laporan['prioritas']) ?></div>
        </div>

        <div class="meta-item">
            <div class="meta-label">Lokasi Kerusakan</div>
            <div class="meta-value">
                <?= esc($laporan['lokasi_kerusakan']) ?><br>
                <small class="text-muted"><?= esc($laporan['lokasi_spesifik']) ?></small>
            </div>
        </div>
    </div>

    <!-- DESKRIPSI -->
    <h5 class="section-title">Deskripsi Kerusakan</h5>
    <p class="text-muted" style="white-space: pre-line;">
        <?= esc($laporan['deskripsi']) ?>
    </p>

    <!-- FOTO -->
    <h5 class="section-title">Foto Kerusakan</h5>
    <?php if (!empty($laporan['foto'])): ?>
        <div class="photo-gallery">
            <a href="<?= base_url('uploads/laporan/' . $laporan['foto']) ?>" target="_blank">
                <img src="<?= base_url('uploads/laporan/' . $laporan['foto']) ?>" alt="Foto Kerusakan">
            </a>
        </div>
    <?php else: ?>
        <p class="text-muted">Tidak ada foto yang dilampirkan.</p>
    <?php endif; ?>

    <!-- ACTION -->
    <div class="text-center mt-4">
        <a href="<?= site_url('laporan/saya') ?>" class="btn btn-outline-secondary px-4">
            ← Kembali ke Daftar Laporan
        </a>
    </div>

</div>

<?= $this->endSection() ?>