<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .detail-card {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin: 2rem auto;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 1rem 2rem;
    }

    .detail-grid dt {
        /* dt = description term (label) */
        font-weight: 600;
        color: var(--secondary-color);
    }

    .detail-grid dd {
        /* dd = description details (value) */
        margin-left: 0;
    }

    .photo-gallery {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 1rem;
    }

    .photo-gallery img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: var(--border-radius);
        border: 2px solid var(--gray-200);
        cursor: pointer;
        transition: transform 0.2s;
    }

    .photo-gallery img:hover {
        transform: scale(1.05);
    }

    /* Status badge styles bisa dipindahkan ke style.css jika belum */
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-weight: 500;
        font-size: 1rem;
        color: var(--white);
    }

    .status-pending {
        background-color: red;
    }

    .status-diproses {
        background-color: orange;
    }

    .status-selesai {
        background-color: var(--success-color);
    }

    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="detail-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Detail Laporan #<?= esc($laporan['id']) ?></h2>
        <?php
        $statusClass = '';
        if ($laporan['status'] == 'Pending') $statusClass = 'status-pending';
        if ($laporan['status'] == 'Diproses') $statusClass = 'status-diproses';
        if ($laporan['status'] == 'Selesai') $statusClass = 'status-selesai';
        ?>
        <span class="status-badge <?= $statusClass ?>"><?= esc($laporan['status']) ?></span>
    </div>

    <hr class="mb-3">

    <dl class="detail-grid">
        <dt>Nama Pelapor</dt>
        <dd><?= esc($laporan['nama']) ?></dd>

        <dt>NPM</dt>
        <dd><?= esc($laporan['npm']) ?></dd>

        <dt>Tanggal Lapor</dt>
        <dd><?= date('d F Y, H:i', strtotime($laporan['created_at'])) ?> WIB</dd>

        <dt>Lokasi</dt>
        <dd><?= esc($laporan['lokasi_kerusakan']) ?> - <?= esc($laporan['lokasi_spesifik']) ?></dd>

        <dt>Kategori</dt>
        <dd><?= esc($laporan['kategori_kerusakan']) ?></dd>

        <dt>Prioritas</dt>
        <dd><?= esc($laporan['tingkat_prioritas']) ?></dd>
    </dl>

    <hr class="my-3">

    <h4>Deskripsi Kerusakan</h4>
    <p><?= nl2br(esc($laporan['deskripsi_kerusakan'])) ?></p>

    <h4 class="mt-3">Foto Kerusakan</h4>
    <div class="photo-gallery">
        <?php
        $foto_files = json_decode($laporan['foto_kerusakan'], true);
        if (!empty($foto_files)):
            foreach ($foto_files as $foto):
        ?>
                <a href="<?= base_url('uploads/laporan/' . esc($foto)) ?>" target="_blank">
                    <img src="<?= base_url('uploads/laporan/' . esc($foto)) ?>" alt="Foto Kerusakan">
                </a>
            <?php
            endforeach;
        else:
            ?>
            <p class="text-secondary">Tidak ada foto yang dilampirkan.</p>
        <?php endif; ?>
    </div>

    <div class="mt-4 text-center">
        <a href="<?= site_url('laporan/status') ?>" class="btn btn-secondary">Kembali ke Daftar Laporan</a>
    </div>
</div>

<?= $this->endSection() ?>