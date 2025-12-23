<?= $this->extend('rektor/layouts/main') ?>

<?= $this->section('content') ?>

<div class="dashboard-card">

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

        <button type="submit" class="filter-btn">Filter</button>
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
                <?php foreach ($laporan as $l): ?>
                    <tr>
                        <td style="color: #64748b;"><?= date('d M Y', strtotime($l['created_at'])) ?></td>
                        <td style="font-weight: 500;"><?= esc($l['nama_pelapor']) ?></td>
                        <td>
                            <?= esc($l['nama_gedung']) ?> <br>
                            <small style="color: #94a3b8;"><?= esc($l['nama_ruangan']) ?> -
                                <?= esc($l['lokasi_spesifik']) ?></small>
                        </td>
                        <td><?= esc(substr($l['deskripsi'], 0, 50)) ?>...</td>
                        <td>
                            <?php
                            $pColor = match ($l['prioritas']) { 'high' => '#ef4444', 'medium' => '#f97316', 'low' => '#10b981', default => '#64748b'};
                            ?>
                            <span
                                style="color: <?= $pColor ?>; font-weight: 700; text-transform: uppercase; font-size: 12px;"><?= esc($l['prioritas']) ?></span>
                        </td>
                        <td>
                            <span
                                style="padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; background: #e2e8f0; color: #475569;">
                                <?= strtoupper($l['status']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        <?= $pager_links ?>
    </div>
</div>

<?= $this->endSection() ?>