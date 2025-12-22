<?= $this->extend('rektor/layouts/main') ?>

<?= $this->section('content') ?>

<div class="dashboard-card">
    <h3 class="card-header-title">Riwayat Aktivitas Sistem</h3>

    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>User (Admin)</th>
                    <th>Aktivitas</th>
                    <th>ID Laporan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td style="color: #64748b; font-size: 13px;">
                            <?= date('d M Y H:i', strtotime($log['waktu'])) ?>
                        </td>
                        <td style="font-weight: 600;">
                            <?= esc($log['nama_user'] ?? 'Sistem') ?>
                        </td>
                        <td>
                            <?= esc($log['aktivitas']) ?>
                        </td>
                        <td style="color: #3b82f6;">
                            #<?= esc($log['laporan_id']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="4" style="padding: 20px; text-align: center;">Belum ada log aktivitas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        <?= $pager_links ?>
    </div>
</div>

<?= $this->endSection() ?>