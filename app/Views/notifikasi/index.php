<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* OFFSET karena navbar fixed-top */
    .page-wrapper {
        padding-top: 90px;
    }

    .notification-container {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
        overflow: visible !important;
    }

    /* Header Section */
    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .notification-header h2 {
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .notification-header h2 i {
        color: #2563eb;
        font-size: 1.5rem;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    /* Stats Cards */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: #6366f1;
        border-radius: 12px;
        padding: 1.25rem;
        color: white;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(99, 102, 241, 0.35);
    }

    .stat-card.unread {
        background: #ec4899;
    }

    .stat-card.read {
        background: #06b6d4;
    }

    .stat-card .icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-card .info h4 {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 700;
    }

    .stat-card .info p {
        margin: 0;
        font-size: 0.85rem;
        opacity: 0.9;
    }

    /* Filter Tabs */
    .filter-tabs {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-tab {
        padding: 0.65rem 1.25rem;
        border-radius: 25px;
        text-decoration: none;
        color: #64748b;
        background: #f1f5f9;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
        border: 2px solid transparent;
    }

    .filter-tab:hover {
        background: #e2e8f0;
        color: #475569;
        transform: translateY(-1px);
    }

    .filter-tab.active {
        background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
        color: white;
        border-color: #1d4ed8;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .filter-tab .count {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.2rem 0.6rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        min-width: 24px;
        text-align: center;
    }

    .filter-tab.active .count {
        background: rgba(255, 255, 255, 0.35);
        font-weight: 700;
    }

    .filter-tab i {
        font-size: 0.9rem;
    }

    /* Notification List */
    .notification-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .notification-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.25rem;
        background: #f8fafc;
        border-radius: 12px;
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
        position: relative;
    }

    .notification-item:hover {
        background: #f1f5f9;
        transform: translateX(4px);
    }

    .notification-item.unread {
        background: linear-gradient(to right, #eff6ff, #f8fafc);
        border-left-color: #2563eb;
    }

    .notification-item.unread::before {
        content: '';
        position: absolute;
        top: 1.35rem;
        left: 1rem;
        width: 8px;
        height: 8px;
        background: #2563eb;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.5;
            transform: scale(1.2);
        }
    }

    .notification-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
        margin-left: 1rem;
    }

    .notification-icon.status-selesai {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .notification-icon.status-diproses {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }

    .notification-icon.status-ditolak {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .notification-icon.status-pending {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: white;
    }

    .notification-icon.status-default {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        color: white;
    }

    .notification-content {
        flex: 1;
        min-width: 0;
    }

    .notification-content .pesan {
        font-size: 0.95rem;
        color: #1e293b;
        margin-bottom: 0.5rem;
        line-height: 1.5;
    }

    .notification-item.unread .notification-content .pesan {
        font-weight: 600;
    }

    .notification-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .notification-meta .time {
        font-size: 0.8rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .notification-meta .category {
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        background: #e2e8f0;
        color: #475569;
    }

    .notification-meta .lokasi {
        font-size: 0.8rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .notification-actions {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        flex-shrink: 0;
    }

    .notification-actions .btn {
        padding: 0.4rem 0.75rem;
        font-size: 0.8rem;
        border-radius: 8px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--gray-500);
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        color: #64748b;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #94a3b8;
    }

    /* Status Badge */
    .status-badge {
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .status-selesai {
        background: #dcfce7;
        color: #166534;
    }

    .status-diproses {
        background: #fef3c7;
        color: #92400e;
    }

    .status-ditolak {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-pending {
        background: #e0e7ff;
        color: #3730a3;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .notification-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-actions {
            width: 100%;
        }

        .header-actions .btn {
            flex: 1;
        }

        .notification-item {
            flex-direction: column;
        }

        .notification-icon {
            margin-left: 0;
        }

        .notification-actions {
            flex-direction: row;
            width: 100%;
        }

        .notification-actions .btn {
            flex: 1;
        }
    }
</style>

<div class="page-wrapper">
    <div class="container">
        <div class="notification-container">
            <!-- Header -->
            <div class="notification-header">
                <h2>
                    <i class="fas fa-bell"></i>
                    Notifikasi
                </h2>
                <div class="header-actions">
                    <?php if (!empty($notifikasi)): ?>
                        <a href="<?= site_url('notifikasi/mark-all-read') ?>" class="btn btn-outline-primary btn-sm"
                            id="markAllReadBtn">
                            <i class="fas fa-check-double me-1"></i> Tandai Semua Terbaca
                        </a>
                        <a href="<?= site_url('notifikasi/delete-all') ?>" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('Hapus semua notifikasi?')">
                            <i class="fas fa-trash me-1"></i> Hapus Semua
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="stats-row">
                <div class="stat-card">
                    <div class="icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="info">
                        <h4><?= $stats['total'] ?? 0 ?></h4>
                        <p>Total Notifikasi</p>
                    </div>
                </div>
                <div class="stat-card unread">
                    <div class="icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info">
                        <h4><?= $stats['belum_dibaca'] ?? 0 ?></h4>
                        <p>Belum Dibaca</p>
                    </div>
                </div>
                <div class="stat-card read">
                    <div class="icon">
                        <i class="fas fa-envelope-open"></i>
                    </div>
                    <div class="info">
                        <h4><?= $stats['sudah_dibaca'] ?? 0 ?></h4>
                        <p>Sudah Dibaca</p>
                    </div>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="filter-tabs">
                <a href="<?= site_url('notifikasi') ?>" class="filter-tab <?= $filter === 'semua' ? 'active' : '' ?>">
                    <i class="fas fa-inbox"></i> Semua
                    <span class="count"><?= $stats['total'] ?? 0 ?></span>
                </a>
                <a href="<?= site_url('notifikasi?filter=belum') ?>"
                    class="filter-tab <?= $filter === 'belum' ? 'active' : '' ?>">
                    <i class="fas fa-envelope"></i> Belum Dibaca
                    <span class="count"><?= $stats['belum_dibaca'] ?? 0 ?></span>
                </a>
                <a href="<?= site_url('notifikasi?filter=sudah') ?>"
                    class="filter-tab <?= $filter === 'sudah' ? 'active' : '' ?>">
                    <i class="fas fa-envelope-open"></i> Sudah Dibaca
                    <span class="count"><?= $stats['sudah_dibaca'] ?? 0 ?></span>
                </a>
            </div>

            <!-- Notification List -->
            <div class="notification-list">
                <?php if (empty($notifikasi)): ?>
                    <div class="empty-state">
                        <i class="fas fa-bell-slash"></i>
                        <h3>Tidak Ada Notifikasi</h3>
                        <p>
                            <?php if ($filter === 'belum'): ?>
                                Semua notifikasi sudah dibaca
                            <?php elseif ($filter === 'sudah'): ?>
                                Belum ada notifikasi yang sudah dibaca
                            <?php else: ?>
                                Anda belum memiliki notifikasi
                            <?php endif; ?>
                        </p>
                    </div>
                <?php else: ?>
                    <?php foreach ($notifikasi as $item): ?>
                        <?php
                        // Determine icon class based on status
                        $statusLaporan = $item['status_laporan'] ?? 'default';
                        $iconClass = 'status-' . $statusLaporan;

                        // Determine icon
                        $icon = 'fa-bell';
                        if ($statusLaporan === 'selesai')
                            $icon = 'fa-check-circle';
                        elseif ($statusLaporan === 'diproses')
                            $icon = 'fa-clock';
                        elseif ($statusLaporan === 'ditolak')
                            $icon = 'fa-times-circle';
                        elseif ($statusLaporan === 'pending')
                            $icon = 'fa-hourglass-half';
                        ?>
                        <div class="notification-item <?= $item['terbaca'] == 0 ? 'unread' : '' ?>">
                            <div class="notification-icon <?= $iconClass ?>">
                                <i class="fas <?= $icon ?>"></i>
                            </div>
                            <div class="notification-content">
                                <div class="pesan"><?= esc($item['pesan']) ?></div>
                                <div class="notification-meta">
                                    <span class="time">
                                        <i class="fas fa-clock"></i>
                                        <?= !empty($item['created_at']) ? date('d M Y, H:i', strtotime($item['created_at'])) : '-' ?>
                                    </span>
                                    <?php if (!empty($item['kategori'])): ?>
                                        <span class="category"><?= esc($item['kategori']) ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($item['lokasi_kerusakan'])): ?>
                                        <span class="lokasi">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <?= esc($item['lokasi_kerusakan']) ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if (!empty($item['status_laporan'])): ?>
                                        <span class="status-badge status-<?= $item['status_laporan'] ?>">
                                            <?= ucfirst($item['status_laporan']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="notification-actions">
                                <?php if (!empty($item['laporan_id'])): ?>
                                    <a href="<?= site_url('notifikasi/view/' . $item['id']) ?>" class="btn btn-sm btn-primary"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if ($item['terbaca'] == 0): ?>
                                    <a href="<?= site_url('notifikasi/mark-read/' . $item['id']) ?>"
                                        class="btn btn-sm btn-outline-success" title="Tandai Terbaca">
                                        <i class="fas fa-check"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="<?= site_url('notifikasi/delete/' . $item['id']) ?>"
                                    class="btn btn-sm btn-outline-danger" title="Hapus"
                                    onclick="return confirm('Hapus notifikasi ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>