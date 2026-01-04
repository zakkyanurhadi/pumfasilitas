<?= $this->extend('rektor/layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-block;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-diproses {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-selesai {
        background: #dcfce7;
        color: #14532d;
    }

    .status-ditolak {
        background: #fee2e2;
        color: #991b1b;
    }

    .priority-badge {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 8px;
    }

    .priority-high {
        background: #fee2e2;
        color: #ef4444;
    }

    .priority-medium {
        background: #ffedd5;
        color: #f97316;
    }

    .priority-low {
        background: #dcfce7;
        color: #10b981;
    }
</style>

<div class="dashboard-card">
    <h3 class="card-header-title" style="margin-bottom: 24px;">
        Daftar Laporan Pengaduan
    </h3>

    <!-- FILTER -->
    <form method="get" action="" class="filter-container">
        <input type="text" name="keyword" placeholder="Cari deskripsi/pelapor..."
            value="<?= esc($filters['keyword']) ?>" class="filter-input">

        <select name="status" class="filter-select">
            <option value="">Semua Status</option>
            <option value="pending" <?= $filters['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="diproses" <?= $filters['status'] == 'diproses' ? 'selected' : '' ?>>Diproses</option>
            <option value="selesai" <?= $filters['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
            <option value="ditolak" <?= $filters['status'] == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
        </select>

        <select name="gedung" class="filter-select">
            <option value="">Semua Gedung</option>
            <?php foreach ($listGedung as $g): ?>
                <option value="<?= $g['id'] ?>" <?= $filters['gedung'] == $g['id'] ? 'selected' : '' ?>><?= esc($g['nama']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="prioritas" class="filter-select">
            <option value="">Semua Prioritas</option>
            <option value="high" <?= $filters['prioritas'] == 'high' ? 'selected' : '' ?>>High</option>
            <option value="medium" <?= $filters['prioritas'] == 'medium' ? 'selected' : '' ?>>Medium</option>
            <option value="low" <?= $filters['prioritas'] == 'low' ? 'selected' : '' ?>>Low</option>
        </select>

        <button type="submit" class="filter-btn">
            <i class="fas fa-search" style="margin-right: 6px;"></i>Filter
        </button>
    </form>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pelapor</th>
                    <th>Lokasi</th>
                    <th>Masalah</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($laporan)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">
                            <i class="fas fa-inbox" style="font-size: 32px; margin-bottom: 10px; display: block;"></i>
                            Tidak ada data laporan
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($laporan as $l): ?>
                        <tr>
                            <td style="color: #64748b;"><?= date('d M Y', strtotime($l['created_at'])) ?></td>
                            <td style="font-weight: 500;"><?= esc($l['nama_pelapor']) ?></td>
                            <td>
                                <strong><?= esc($l['nama_gedung']) ?></strong><br>
                                <small style="color: #94a3b8;"><?= esc($l['lokasi_kerusakan']) ?>
                                    <?= !empty($l['lokasi_spesifik']) ? ' - ' . esc($l['lokasi_spesifik']) : '' ?></small>
                            </td>
                            <td style="max-width: 200px;">
                                <?= esc(strlen($l['deskripsi']) > 50 ? substr($l['deskripsi'], 0, 50) . '...' : $l['deskripsi']) ?>
                            </td>
                            <td>
                                <span class="priority-badge priority-<?= esc($l['prioritas']) ?>">
                                    <?= strtoupper($l['prioritas']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-<?= esc($l['status']) ?>">
                                    <?= strtoupper($l['status']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        <?= $pager_links ?>
    </div>
</div>

<?= $this->endSection() ?>