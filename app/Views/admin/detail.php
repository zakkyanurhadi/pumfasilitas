<style>
 /* ================================
   DETAIL CARD (RAPI & KONSISTEN)
================================ */

.detail-card {
    background: var(--white);
    padding: 1.6rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    font-size: 0.9rem;
}

/* Header */
.detail-header h3 {
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
}

.detail-header .status-badge {
    font-size: 0.75rem;
}

/* Section titles */
.detail-card h4 {
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 0.6rem;
    color: var(--gray-700);
}

/* Grid informasi */
.detail-grid {
    display: grid;
    grid-template-columns: 1fr 1.8fr;
    gap: 0.3rem 1rem;
    margin-bottom: 0.8rem;
}

.detail-grid dt {
    font-weight: 600;
    color: var(--gray-600);
    font-size: 0.85rem;
}

.detail-grid dd {
    margin: 0;
    font-size: 0.9rem;
    color: var(--gray-700);
}

/* Deskripsi */
.detail-card p {
    font-size: 0.9rem;
    line-height: 1.5;
    color: var(--gray-700);
}

/* Foto */
.photo-gallery {
    display: flex;
    flex-wrap: wrap;
    gap: 0.8rem;
    margin-top: 0.4rem;
}

.photo-gallery img {
    width: 115px;
    height: 115px;
    object-fit: cover;
    border-radius: var(--border-radius);
    border: 1px solid var(--gray-200);
    cursor: pointer;
}

/* Buttons */
.detail-card .btn {
    font-size: 0.85rem !important;
    padding: 0.45rem 0.75rem;
    border-radius: 6px;
}

.detail-card .btn-warning {
    color: #fff;
}

</style>

<div class="detail-card">
    <div class="d-flex justify-content-between align-items-center mb-3 detail-header">
        <h3>Detail Laporan #<?= esc($detail['id']) ?></h3>
        <?php
        $statusClass = '';
        if ($detail['status'] == 'Pending') $statusClass = 'status-pending';
        if ($detail['status'] == 'Diproses') $statusClass = 'status-diproses';
        if ($detail['status'] == 'Selesai') $statusClass = 'status-selesai';
        ?>
        <span class="status-badge <?= $statusClass ?>"><?= esc($detail['status']) ?></span>
    </div>

    <hr>

    <h4>Informasi Umum</h4>
    <dl class="detail-grid">
        <dt>Nama Pelapor</dt>
        <dd><?= esc($detail['nama_pelapor'] ?? 'N/A') ?></dd>

        <dt>NPM</dt>
        <dd><?= esc($detail['npm'] ?? 'N/A') ?></dd>

        <dt>No. Telp</dt>
        <dd><?= esc($detail['no_telp'] ?? 'N/A') ?></dd>

        <dt>Tanggal Lapor</dt>
        <dd><?= date('d F Y, H:i', strtotime($detail['created_at'])) ?> WIB</dd>
    </dl>

    <hr>

    <h4>Detail Kerusakan</h4>
    <dl class="detail-grid">
        <dt>Lokasi</dt>
        <dd><?= esc($detail['lokasi_kerusakan']) ?></dd>

        <dt>Spesifik</dt>
        <dd><?= esc($detail['lokasi_spesifik'] ?? 'N/A') ?></dd>

        <dt>Kategori</dt>
        <dd><?= esc($detail['kategori']) ?></dd>

        <dt>Prioritas</dt>
        <dd><?= esc($detail['tingkat_prioritas'] ?? 'Normal') ?></dd>
    </dl>

    <hr>

    <h4>Deskripsi Kerusakan</h4>
    <p><?= nl2br(esc($detail['deskripsi'])) ?></p>

    <?php 
    // Handle both JSON array and single string for foto_kerusakan
    $foto_data = $detail['foto'];
    if (is_string($foto_data)) {
        // Attempt to decode as JSON array
        $foto = json_decode($foto_data, true);
        // If decoding failed or result is not an array, treat it as a single file string
        if (!is_array($foto)) {
            $foto = [$foto_data];
        }
    } else {
        $foto = (array)$foto_data;
    }
    ?>

    <?php if (count(array_filter($foto)) > 0): ?>
        <h4>Foto Kerusakan</h4>
        <div class="photo-gallery">
            <?php foreach (array_filter($foto) as $img): ?>
                <?php $path = 'uploads/laporan/'.$img; ?>
                <img src="<?= strpos($img, 'http') === 0 ? esc($img) : base_url($path) ?>" 
                    alt="Foto Kerusakan" 
                    title="Klik untuk melihat lebih besar">
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($detail['keterangan_verifikasi'])): ?>
        <hr>
        <h4>Informasi Verifikasi</h4>
        <dl class="detail-grid">
            <dt>Status Verifikasi</dt>
            <dd><?= esc($detail['status']) ?></dd>
            <dt>Tanggal Verifikasi</dt>
            <dd><?= date('d F Y, H:i', strtotime($detail['tanggal_verifikasi'] ?? $detail['updated_at'])) ?> WIB</dd>
            <dt>Verifikator</dt>
            <dd><?= esc($detail['verifikator'] ?? 'Admin') ?></dd>
            <dt>Keterangan</dt>
            <dd><?= nl2br(esc($detail['keterangan_verifikasi'])) ?></dd>
        </dl>
    <?php endif; ?>

    <hr>
    
    <div class="d-flex gap-2 mt-3">
        <a href="<?= current_url() . '?keyword=' . esc($keyword ?? '') . '&status_filter=' . esc($statusFilter ?? '') . '&page=' . esc($currentPage ?? 1) ?>" class="btn btn-secondary flex-grow-1">Tutup</a>
        <a href="#" onclick="openReportModalAdmin(<?= esc($detail['id']) ?>)" class="btn btn-warning flex-grow-1">Verifikasi</a>
    </div>
</div>