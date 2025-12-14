<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* ===== STAT CARD ===== */
    .stat-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
        background: #fff;
        height: 100%;
    }

    .stat-card.primary {
        border-left: 4px solid #0d6efd;
    }

    .stat-card.warning {
        border-left: 4px solid #ffc107;
    }

    .stat-card.info {
        border-left: 4px solid #0dcaf0;
    }

    .stat-card.success {
        border-left: 4px solid #198754;
    }

    .stat-card.danger {
        border-left: 4px solid #dc3545;
    }

    /* ===== TABLE ===== */
    .table-container {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, .05);
        padding: 1.5rem;
    }

    .badge-status {
        font-size: .8rem;
        padding: .45em .7em;
        border-radius: 6px;
    }

    /* ===== ACTION BUTTON ===== */
    .action-btn {
        width: 34px;
        height: 34px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
    }

    .action-btn i {
        font-size: .9rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1rem;
    }

    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* WRAPPER TENGAH */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 1.5rem;
    }

    /* LIST */
    .pagination {
        gap: 0.4rem;
    }

    /* ITEM */
    .page-item .page-link {
        width: 34px;
        /* ⬅ lebih kecil */
        height: 34px;
        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        background-color: #f1f5f9;
        /* abu terang */
        color: #2563eb;
        /* biru tema */
        border: 1px solid #e5e7eb;

        font-size: 0.85rem;
        font-weight: 600;

        transition: all 0.2s ease;
    }

    /* HOVER */
    .page-item .page-link:hover {
        background-color: #e0e7ff;
        /* biru muda */
        color: #1e40af;
    }

    /* ACTIVE */
    .page-item.active .page-link {
        background-color: #2563eb;
        /* biru utama */
        color: #ffffff;
        border-color: #2563eb;
    }

    /* DISABLED */
    .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Laporan Saya</h3>
        <small class="text-muted">
            Pantau status laporan kerusakan yang Anda kirim
        </small>
    </div>

    <!-- STATISTIK -->
    <div class="stats-grid mb-4">
        <?php
        $cards = [
            ['Total',    $stats['total']    ?? 0, 'file-earmark-text', 'primary'],
            ['Pending',  $stats['pending']  ?? 0, 'clock-history',     'warning'],
            ['Diproses', $stats['diproses'] ?? 0, 'arrow-repeat',      'info'],
            ['Selesai',  $stats['selesai']  ?? 0, 'check-circle',      'success'],
            ['Ditolak',  $stats['ditolak']  ?? 0, 'x-circle',          'danger'],
        ];
        foreach ($cards as [$label, $val, $icon, $color]):
        ?>
            <div class="card stat-card <?= $color ?>">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted"><?= $label ?></small>
                        <h4 class="fw-bold mb-0"><?= esc($val) ?></h4>
                    </div>
                    <i class="bi bi-<?= $icon ?> fs-3 text-<?= $color ?> opacity-75"></i>
                </div>
            </div>
        <?php endforeach ?>
    </div>


    <!-- TABLE -->
    <div class="table-container">

        <!-- FILTER -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h6 class="fw-bold mb-0">Riwayat Laporan</h6>

            <form method="get" class="d-flex gap-2">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="pending" <?= $status == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="diproses" <?= $status == 'diproses' ? 'selected' : '' ?>>Diproses</option>
                    <option value="selesai" <?= $status == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    <option value="ditolak" <?= $status == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                </select>

                <input type="text"
                    name="keyword"
                    class="form-control form-control-sm"
                    placeholder="Cari lokasi / kategori"
                    value="<?= esc($keyword) ?>">
            </form>
        </div>

        <!-- DATA TABLE -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light small">
                    <tr>
                        <th>#</th>
                        <th>Kerusakan</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Prioritas</th>
                        <th>Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (empty($laporan)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Belum ada laporan
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($laporan as $item): ?>
                        <?php
                        $statusMap = [
                            'pending'  => 'warning',
                            'diproses' => 'info',
                            'selesai'  => 'success',
                            'ditolak'  => 'danger'
                        ];
                        ?>
                        <tr>
                            <td><strong>#<?= esc($item['id']) ?></strong></td>

                            <td>
                                <div class="fw-semibold"><?= esc($item['lokasi_kerusakan']) ?></div>
                                <small class="text-muted d-block text-truncate" style="max-width:280px">
                                    <?= esc($item['deskripsi']) ?>
                                </small>
                            </td>

                            <td>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                    <?= esc($item['kategori'] ?? '-') ?>
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-<?= $statusMap[$item['status']] ?> badge-status">
                                    <?= ucfirst($item['status']) ?>
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-<?= $item['prioritas'] === 'high' ? 'danger' : 'primary' ?>">
                                    <?= ucfirst($item['prioritas']) ?>
                                </span>
                            </td>

                            <td class="small text-muted">
                                <?= date('d M Y, H:i', strtotime($item['created_at'])) ?>
                            </td>

                            <!-- AKSI (SESUAI CONTOH GAMBAR) -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">

                                    <!-- DETAIL -->
                                    <a href="<?= base_url('laporan/detail/' . $item['id']) ?>"
                                        class="btn btn-outline-primary action-btn"
                                        title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <?php if (in_array($item['status'], ['pending', 'ditolak'])): ?>
                                        <!-- EDIT -->
                                        <a href="<?= base_url('laporan/edit/' . $item['id']) ?>"
                                            class="btn btn-outline-success action-btn"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <!-- DELETE -->
                                        <a href="<?= base_url('laporan/delete/' . $item['id']) ?>"
                                            class="btn btn-outline-danger action-btn"
                                            onclick="return confirm('Hapus laporan ini?')"
                                            title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>

                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <?php if ($pager->getPageCount() > 1): ?>
            <div class="pagination-container mt-3">
                <?= $pager->links('default', 'circle') ?>
            </div>
        <?php endif; ?>



    </div>
</div>

<?= $this->endSection() ?>