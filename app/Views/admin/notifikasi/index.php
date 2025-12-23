<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<style>
    .notification-container {
        background: #ffffff;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

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
        color: #1e293b;
    }

    .notification-header h2 i {
        color: #6366f1;
        font-size: 1.5rem;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-outline-primary {
        border: 2px solid #2563eb;
        color: #2563eb;
        background: transparent;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background: #2563eb;
        color: white;
    }

    .btn-outline-danger {
        border: 2px solid #dc2626;
        color: #dc2626;
        background: transparent;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-outline-danger:hover {
        background: #dc2626;
        color: white;
    }

    /* Stats Cards - Warna Solid */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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

    .stat-card.pending {
        background: #f59e0b;
    }

    .stat-card.diproses {
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
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 0.5rem 1.25rem;
        border-radius: 25px;
        text-decoration: none;
        color: #64748b;
        background: #f1f5f9;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-tab:hover {
        background: #e2e8f0;
        color: #475569;
    }

    .filter-tab.active {
        background: #6366f1;
        color: white;
    }

    .filter-tab .count {
        background: rgba(255, 255, 255, 0.25);
        padding: 0.15rem 0.5rem;
        border-radius: 10px;
        font-size: 0.75rem;
    }

    .filter-tab.active .count {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Notification List */
    .notification-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .notification-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.25rem;
        background: #f8fafc;
        border-radius: 10px;
        border-left: 4px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .notification-item:hover {
        background: #f1f5f9;
        transform: translateX(4px);
    }

    .notification-item.priority-high {
        border-left-color: #ef4444;
    }

    .notification-item.priority-medium {
        border-left-color: #f59e0b;
    }

    .notification-item.priority-low {
        border-left-color: #22c55e;
    }

    .notification-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .notification-icon.pending {
        background: #fef3c7;
        color: #d97706;
    }

    .notification-icon.diproses {
        background: #cffafe;
        color: #0891b2;
    }

    .notification-icon.selesai {
        background: #dcfce7;
        color: #16a34a;
    }

    .notification-content {
        flex: 1;
        min-width: 0;
    }

    .notification-content .title {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }

    .notification-content .meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        font-size: 0.8rem;
        color: #64748b;
    }

    .notification-content .meta span {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .notification-actions {
        display: flex;
        gap: 0.5rem;
        flex-shrink: 0;
    }

    .notification-actions .btn {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .notification-actions .btn-view {
        background: #2563eb;
        color: white;
        min-width: 100px;
    }

    .notification-actions .btn-view:hover {
        background: #1d4ed8;
    }

    .notification-actions .btn-delete {
        border: 2px solid #dc2626;
        color: #dc2626;
        background: transparent;
        min-width: 50px;
    }

    .notification-actions .btn-delete:hover {
        background: #dc2626;
        color: white;
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

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-diproses {
        background: #cffafe;
        color: #0e7490;
    }

    .status-selesai {
        background: #dcfce7;
        color: #166534;
    }

    .status-ditolak {
        background: #fee2e2;
        color: #991b1b;
    }

    .priority-badge {
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .priority-high {
        background: #fee2e2;
        color: #dc2626;
    }

    .priority-medium {
        background: #fef3c7;
        color: #d97706;
    }

    .priority-low {
        background: #dcfce7;
        color: #16a34a;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #94a3b8;
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

    /* ==========================================
       RESPONSIVE STYLES
    ========================================== */

    /* Tablet */
    @media (max-width: 992px) {
        .notification-container {
            padding: 1.5rem;
        }

        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }

        .stat-card .info h4 {
            font-size: 1.5rem;
        }

        .stat-card .info p {
            font-size: 0.8rem;
        }
    }

    /* Mobile */
    @media (max-width: 768px) {
        .notification-container {
            padding: 1rem;
            border-radius: 8px;
        }

        .notification-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .notification-header h2 {
            font-size: 1.25rem;
        }

        .header-actions {
            width: 100%;
        }

        .header-actions .btn-outline-primary {
            width: 100%;
            justify-content: center;
        }

        .stats-row {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .stat-card {
            padding: 1rem;
        }

        .stat-card .icon {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }

        .stat-card .info h4 {
            font-size: 1.35rem;
        }

        .filter-tabs {
            width: 100%;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            flex-wrap: nowrap;
        }

        .filter-tab {
            padding: 0.4rem 1rem;
            font-size: 0.8rem;
            white-space: nowrap;
        }

        .notification-item {
            flex-direction: column;
            align-items: flex-start;
            padding: 1rem;
            gap: 0.75rem;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .notification-content {
            width: 100%;
        }

        .notification-content .title {
            font-size: 0.95rem;
        }

        .notification-content .meta {
            gap: 0.5rem;
            font-size: 0.75rem;
        }

        .notification-actions {
            width: 100%;
            justify-content: flex-end;
        }

        .notification-actions .btn {
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
        }

        .notification-actions .btn-view {
            min-width: auto;
            flex: 1;
        }

        .notification-actions .btn-delete {
            min-width: auto;
        }

        .empty-state {
            padding: 2rem 1rem;
        }

        .empty-state i {
            font-size: 3rem;
        }

        .empty-state h3 {
            font-size: 1.1rem;
        }
    }

    /* Small Mobile */
    @media (max-width: 480px) {
        .notification-container {
            padding: 0.75rem;
            margin: 0.5rem;
            border-radius: 8px;
        }

        .notification-header h2 {
            font-size: 1.1rem;
        }

        .notification-header h2 i {
            font-size: 1.2rem;
        }

        .stat-card {
            padding: 0.85rem;
            gap: 0.75rem;
        }

        .stat-card .icon {
            width: 36px;
            height: 36px;
            font-size: 1rem;
            border-radius: 8px;
        }

        .stat-card .info h4 {
            font-size: 1.2rem;
        }

        .stat-card .info p {
            font-size: 0.7rem;
        }

        .filter-tab {
            padding: 0.35rem 0.75rem;
            font-size: 0.75rem;
        }

        .filter-tab .count {
            padding: 0.1rem 0.35rem;
            font-size: 0.65rem;
        }

        .notification-content .meta {
            flex-direction: column;
            gap: 0.35rem;
        }

        .status-badge,
        .priority-badge {
            font-size: 0.6rem;
            padding: 0.15rem 0.4rem;
        }
    }
</style>

<div class="notification-container">
    <!-- Header -->
    <div class="notification-header">
        <h2>
            <i class="fas fa-bell"></i>
            Notifikasi Laporan
        </h2>
        <div class="header-actions">
            <?php if (!empty($laporan)): ?>
                <a href="<?= site_url('admin/notifikasi/mark-all-read') ?>" class="btn-outline-primary">
                    <i class="fas fa-check-double"></i> Tandai Semua Terbaca
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="info">
                <h4><?= $stats['total'] ?? 0 ?></h4>
                <p>Total Laporan</p>
            </div>
        </div>
        <div class="stat-card pending">
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="info">
                <h4><?= $stats['pending'] ?? 0 ?></h4>
                <p>Menunggu Verifikasi</p>
            </div>
        </div>
        <div class="stat-card diproses">
            <div class="icon">
                <i class="fas fa-spinner"></i>
            </div>
            <div class="info">
                <h4><?= $stats['diproses'] ?? 0 ?></h4>
                <p>Sedang Diproses</p>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <a href="<?= site_url('admin/notifikasi') ?>" class="filter-tab <?= $filter === 'semua' ? 'active' : '' ?>">
            <i class="fas fa-inbox"></i> Semua
            <span class="count"><?= $stats['total'] ?? 0 ?></span>
        </a>
        <a href="<?= site_url('admin/notifikasi?filter=pending') ?>"
            class="filter-tab <?= $filter === 'pending' ? 'active' : '' ?>">
            <i class="fas fa-clock"></i> Pending
            <span class="count"><?= $stats['pending'] ?? 0 ?></span>
        </a>
        <a href="<?= site_url('admin/notifikasi?filter=diproses') ?>"
            class="filter-tab <?= $filter === 'diproses' ? 'active' : '' ?>">
            <i class="fas fa-spinner"></i> Diproses
            <span class="count"><?= $stats['diproses'] ?? 0 ?></span>
        </a>
    </div>

    <!-- Notification List -->
    <div class="notification-list">
        <?php if (empty($laporan)): ?>
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>Tidak Ada Laporan</h3>
                <p>Belum ada laporan yang masuk</p>
            </div>
        <?php else: ?>
            <?php foreach ($laporan as $index => $item): ?>
                <div class="notification-wrapper">
                    <div class="notification-item priority-<?= $item['prioritas'] ?? 'medium' ?>"
                        onclick="toggleDetail(<?= $index ?>)">
                        <div class="notification-icon <?= $item['status'] ?>">
                            <?php if ($item['status'] === 'pending'): ?>
                                <i class="fas fa-clock"></i>
                            <?php elseif ($item['status'] === 'diproses'): ?>
                                <i class="fas fa-spinner"></i>
                            <?php else: ?>
                                <i class="fas fa-file-alt"></i>
                            <?php endif; ?>
                        </div>
                        <div class="notification-content">
                            <div class="title">
                                Laporan dari <?= esc($item['nama_pelapor'] ?? 'Unknown') ?>
                            </div>
                            <div class="meta">
                                <span><i class="fas fa-map-marker-alt"></i> <?= esc($item['lokasi_kerusakan'] ?? '-') ?></span>
                                <span><i class="fas fa-tag"></i> <?= esc($item['kategori'] ?? '-') ?></span>
                                <span><i class="fas fa-clock"></i>
                                    <?= date('d M Y, H:i', strtotime($item['created_at'])) ?></span>
                                <span class="status-badge status-<?= $item['status'] ?>"><?= ucfirst($item['status']) ?></span>
                                <span
                                    class="priority-badge priority-<?= $item['prioritas'] ?>"><?= ucfirst($item['prioritas']) ?></span>
                            </div>
                        </div>
                        <div class="notification-actions">
                            <button type="button" class="btn btn-view"
                                onclick="event.stopPropagation(); toggleDetail(<?= $index ?>)">
                                <i class="fas fa-eye" id="icon-<?= $index ?>"></i>
                            </button>
                            <a href="<?= site_url('adminverif/' . $item['id']) ?>" class="btn btn-delete"
                                style="background: #10b981; border-color: #10b981; color: white;"
                                onclick="event.stopPropagation();">
                                <i class="fas fa-check"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Detail Inline (Hidden by default) -->
                    <div class="detail-panel" id="detail-<?= $index ?>" style="display: none;">
                        <div class="detail-content">
                            <div class="detail-grid">
                                <div class="detail-section">
                                    <h4><i class="fas fa-user"></i> Pelapor</h4>
                                    <p><?= esc($item['nama_pelapor'] ?? '-') ?></p>
                                </div>
                                <div class="detail-section">
                                    <h4><i class="fas fa-building"></i> Gedung</h4>
                                    <p><?= esc($item['gedung_nama'] ?? $item['lokasi_kerusakan'] ?? '-') ?></p>
                                </div>
                                <div class="detail-section">
                                    <h4><i class="fas fa-map-marker-alt"></i> Lokasi Spesifik</h4>
                                    <p><?= esc($item['lokasi_spesifik'] ?? '-') ?></p>
                                </div>
                                <div class="detail-section">
                                    <h4><i class="fas fa-tag"></i> Kategori</h4>
                                    <p><?= esc($item['kategori'] ?? '-') ?></p>
                                </div>
                            </div>
                            <div class="detail-section full-width">
                                <h4><i class="fas fa-align-left"></i> Deskripsi</h4>
                                <p class="deskripsi-text"><?= esc($item['deskripsi'] ?? 'Tidak ada deskripsi') ?></p>
                            </div>
                            <?php if (!empty($item['foto'])): ?>
                                <?php $fotoUrl = base_url('uploads/laporan/' . $item['foto']); ?>
                                <div class="detail-section full-width">
                                    <h4><i class="fas fa-image"></i> Foto</h4>
                                    <img src="<?= $fotoUrl ?>" alt="Foto Laporan" class="detail-foto"
                                        onclick="openPhotoLightbox('<?= $fotoUrl ?>')" style="cursor: zoom-in;"
                                        title="Klik untuk memperbesar">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<style>
    /* Detail Panel Styles */
    .notification-wrapper {
        margin-bottom: 0.75rem;
    }

    .notification-item {
        cursor: pointer;
    }

    .detail-panel {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-top: none;
        border-radius: 0 0 12px 12px;
        margin-top: -8px;
        padding-top: 20px;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .detail-content {
        padding: 16px 20px 20px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 16px;
    }

    .detail-section {
        background: white;
        padding: 12px 16px;
        border-radius: 8px;
        border-left: 3px solid #6366f1;
    }

    .detail-section.full-width {
        grid-column: 1 / -1;
    }

    .detail-section h4 {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .detail-section h4 i {
        color: #6366f1;
    }

    .detail-section p {
        font-size: 14px;
        color: #1e293b;
        margin: 0;
        font-weight: 500;
    }

    .deskripsi-text {
        line-height: 1.6;
        white-space: pre-wrap;
    }

    .detail-foto {
        max-width: 100%;
        max-height: 300px;
        border-radius: 8px;
        object-fit: cover;
        margin-top: 8px;
    }

    .detail-actions {
        display: flex;
        gap: 12px;
        margin-top: 16px;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-verifikasi {
        background: #10b981;
        color: white;
    }

    .btn-verifikasi:hover {
        background: #059669;
    }

    .btn-detail {
        background: #6366f1;
        color: white;
    }

    .btn-detail:hover {
        background: #4f46e5;
    }

    /* Mobile responsive for detail */
    @media (max-width: 576px) {
        .detail-content {
            padding: 12px 14px 16px;
        }

        .detail-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .detail-section {
            padding: 10px 12px;
        }

        .detail-section h4 {
            font-size: 11px;
        }

        .detail-section p {
            font-size: 13px;
        }

        .detail-actions {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
    function toggleDetail(index) {
        const detailPanel = document.getElementById('detail-' + index);
        const icon = document.getElementById('icon-' + index);

        if (detailPanel.style.display === 'none') {
            // Close all other panels first
            document.querySelectorAll('.detail-panel').forEach(panel => {
                panel.style.display = 'none';
            });
            document.querySelectorAll('.notification-actions .btn-view i').forEach(i => {
                i.classList.remove('fa-eye-slash');
                i.classList.add('fa-eye');
            });

            // Open this panel
            detailPanel.style.display = 'block';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            detailPanel.style.display = 'none';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Lightbox functions for photo enlargement
    function openPhotoLightbox(imageSrc) {
        const lightbox = document.getElementById('notifPhotoLightbox');
        const lightboxImage = document.getElementById('notifLightboxImage');

        lightboxImage.src = imageSrc;
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closePhotoLightbox(event) {
        if (event.target.id === 'notifPhotoLightbox' || event.target.classList.contains('lightbox-close')) {
            const lightbox = document.getElementById('notifPhotoLightbox');
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            const lightbox = document.getElementById('notifPhotoLightbox');
            if (lightbox && lightbox.classList.contains('active')) {
                lightbox.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    });
</script>

<!-- Lightbox Modal for Photo -->
<div id="notifPhotoLightbox" class="photo-lightbox-modal" onclick="closePhotoLightbox(event)">
    <span class="lightbox-close" onclick="closePhotoLightbox(event)">&times;</span>
    <img id="notifLightboxImage" src="" alt="Foto Laporan">
    <div class="lightbox-caption">Klik di luar gambar atau tekan ESC untuk menutup</div>
</div>

<style>
    /* Lightbox Modal Styles */
    .photo-lightbox-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 10000;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        padding: 20px;
        box-sizing: border-box;
    }

    .photo-lightbox-modal.active {
        display: flex;
        animation: lightboxFadeIn 0.3s ease;
    }

    @keyframes lightboxFadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .photo-lightbox-modal img {
        max-width: 90%;
        max-height: 85vh;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 10px 50px rgba(0, 0, 0, 0.5);
        animation: lightboxZoomIn 0.3s ease;
    }

    @keyframes lightboxZoomIn {
        from {
            transform: scale(0.8);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .photo-lightbox-modal .lightbox-close {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 40px;
        color: #fff;
        cursor: pointer;
        z-index: 10001;
        transition: color 0.2s ease, transform 0.2s ease;
        line-height: 1;
    }

    .photo-lightbox-modal .lightbox-close:hover {
        color: #ff6b6b;
        transform: scale(1.1);
    }

    .photo-lightbox-modal .lightbox-caption {
        color: rgba(255, 255, 255, 0.7);
        margin-top: 15px;
        font-size: 14px;
    }
</style>

<?= $this->endSection() ?>