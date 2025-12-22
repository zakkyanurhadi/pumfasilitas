<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<style>
    .grid-container {
        display: grid;
        grid-template-columns: 3.5fr 1fr;
        gap: 1rem;
        align-items: start;
        width: 100%;
    }

    .search-group {
        display: flex;
        gap: 0.7rem;
        align-items: center;
    }

    .search-group input {
        width: 260px;
        /* → atur panjang search bar */
    }

    @media (max-width: 992px) {
        .grid-container {
            grid-template-columns: 1fr;
        }
    }

    .report-table-container {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        width: 100%;
        max-width: 100%;
        margin-top: 1.10rem;
    }

    .report-table {
        width: 100%;
        min-width: 600px;
        /* Minimum width to trigger scroll if needed */
        border-collapse: collapse;
    }

    .report-table th,
    .report-table td {
        padding: 0.70rem 1rem;
        border-bottom: 1px solid var(--gray-200);
        text-align: left;
    }

    .report-table th {
        background-color: var(--gray-100);
        font-weight: 600;
    }

    .report-table td {
        font-size: 0.9rem;
    }

    /* ======================
       STATUS BADGE FINAL
       ====================== */
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 0.65rem;
        color: var(--white);
        text-align: center;
        display: inline-block;
        min-width: 70px;
        box-sizing: border-box;
        text-transform: capitalize;
    }

    .status-pending {
        background-color: #ef4444;
    }

    .status-diproses {
        background-color: #f97316;
    }

    .status-selesai {
        background-color: var(--success-color);
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 1.5rem;
    }

    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    .pagination li a {
        display: block;
        padding: 0.2rem 0.6rem;
        color: var(--primary-color);
        text-decoration: none;
        background: var(--white);
        border-right: 1px solid var(--gray-200);
        transition: background-color 0.2s ease;
    }

    .pagination li:last-child a {
        border-right: none;
    }

    .pagination li a:hover {
        background-color: var(--gray-100);
    }

    .pagination li.active a {
        background-color: var(--primary-color);
        color: var(--white);
        font-weight: 600;
    }

    .btn-sm {
        padding: 0.4rem 0.6rem;
        font-size: 0.7rem;
        white-space: nowrap;
    }

    .btn-search {
        background-color: var(--primary-color);
        /* info biru */
        color: white;
        padding: 6px 14px;
        /* ukuran kecil tapi bukan btn-sm */
        border: none;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .btn-search:hover {
        background-color: #3a068dff;
    }

    .btn-warning {
        background-color: #f97316;
        color: white;
    }

    .btn-warning:hover {
        background-color: #ea580c;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        justify-content: center;
        align-items: center;
        z-index: 2000;
    }

    .modal-content {
        background: var(--white);
        padding: 2rem;
        width: 500px;
        border-radius: 10px;
        position: relative;
        animation: fadeIn .3s ease;
    }

    .close {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 24px;
        cursor: pointer;
    }

    .tooltip-wrap {
        position: relative;
        display: inline-block;
        /* penting! */
    }

    .tooltip-text {
        visibility: hidden;
        opacity: 0;

        position: absolute;
        bottom: 120%;
        /* tampil di atas tombol */
        left: 50%;
        transform: translateX(-50%);

        background: #000;
        color: #fff;
        padding: 4px 8px;
        font-size: 9.5px;
        border-radius: 6px;
        white-space: nowrap;

        transition: opacity 0.2s ease;
        z-index: 9999;
    }

    .tooltip-wrap:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }

    /* =====================================================
   RESPONSIVE MOBILE – STATUS LAPORAN (FINAL)
===================================================== */
    @media (max-width: 768px) {

        /* ===== GRID ===== */
        .grid-container {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        /* ===== CARD TABEL ===== */
        .report-table-container {
            padding: 1rem 0.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 28px rgba(15, 23, 42, .08);
        }

        .report-table-container h2 {
            font-size: 1rem;
            margin-bottom: 0.6rem;
            text-align: left;
            padding-left: 0.25rem;
        }

        /* ===== FILTER ===== */
        .report-table-container>div:first-of-type {
            flex-direction: column;
            align-items: stretch;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .search-group {
            width: 100%;
            gap: 0.4rem;
        }

        .search-group input {
            width: 100%;
            height: 38px;
            font-size: 0.8rem;
            border-radius: 12px;
        }

        .btn-search {
            height: 38px;
            font-size: 0.78rem;
            padding: 0 14px;
            border-radius: 12px;
            font-weight: 600;
        }

        /* ===== TABLE WRAPPER ===== */
        .table-wrapper {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            width: 100% !important;
            max-width: 100vw !important;
            margin-top: 0.6rem;
            border-radius: 14px;
        }

        .report-table-container>div[style*="overflow-x"] {
            margin-top: 0.6rem;
            border-radius: 14px;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
        }

        /* ===== TABLE ===== */
        .report-table {
            min-width: 720px !important;
            font-size: 0.75rem;
            border-collapse: separate;
            border-spacing: 0;
        }

        .report-table th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: var(--gray-100);
            font-size: 0.72rem;
            padding: 0.55rem 0.6rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .report-table td {
            padding: 0.55rem 0.6rem;
            white-space: nowrap;
            vertical-align: middle;
        }

        .report-table tbody tr:active {
            background: #f8fafc;
        }

        /* ===== STATUS ===== */
        .status-badge {
            font-size: 0.6rem;
            padding: 3px 9px;
            min-width: unset;
            font-weight: 600;
        }

        /* ===== AKSI ===== */
        .btn-sm {
            font-size: 0.6rem;
            padding: 0.35rem 0.55rem;
            border-radius: 8px;
        }

        /* ===== PAGINATION ===== */
        .pagination-container {
            justify-content: center;
            margin-top: 1rem;
        }

        .pagination li a {
            font-size: 0.68rem;
            padding: 0.25rem 0.5rem;
        }

        /* ===== PANEL DETAIL ===== */
        .detail-card,
        .detail-card * {
            font-size: 0.85rem;
        }

        .detail-card {
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 10px 28px rgba(15, 23, 42, .08);
        }

        /* ===== MODAL ===== */
        .modal-content {
            width: 92%;
            max-width: 420px;
            padding: 1.3rem 1.2rem;
            border-radius: 18px;
        }

        .modal-content h2 {
            font-size: 1rem;
            text-align: center;
            margin-bottom: 0.8rem;
        }

        .modal-content input,
        .modal-content textarea,
        .modal-content select {
            font-size: 0.8rem;
            border-radius: 12px;
        }

        .modal-content button {
            height: 40px;
            font-size: 0.85rem;
            border-radius: 12px;
        }
    }

    /* ===== EXTRA SMALL DEVICE ===== */
    @media (max-width: 480px) {

        .grid-container {
            margin: 0.5rem;
        }

        .report-table-container {
            padding: 0.85rem;
        }

        .report-table-container h2 {
            font-size: 0.92rem;
        }

        .report-table {
            min-width: 680px;
        }
    }
</style>

<div class="container">
    <div class="grid-container">
        <div>
            <div class="report-table-container">
                <h2 class="text-center">Status Semua Laporan</h2>

                <!-- FILTER -->
                <div style="display:flex; justify-content:space-between; align-items:center;">

                    <!-- Search -->
                    <form method="get">
                        <div class="search-group">
                            <input type="text" name="keyword" class="form-control" placeholder="Cari Laporan..."
                                value="<?= esc($keyword ?? '') ?>">
                            <div class="tooltip-wrap">
                                <button class="btn-search">Cari</button>
                                <span class="tooltip-text">Cari Data laporan</span>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- TABEL -->
                <div class="table-wrapper" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Lokasi</th>
                                <th>Kategori</th>
                                <th>Tanggal Lapor</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($laporan)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada laporan.</td>
                                </tr>
                            <?php else: ?>
                                <?php $start = ($currentPage - 1) * $perPage; ?>
                                <?php foreach ($laporan as $i => $item): ?>
                                    <?php
                                    $status = strtolower($item['status']);
                                    $statusClass = "status-" . $status;
                                    ?>
                                    <tr>
                                        <td><?= $start + $i + 1 ?></td>
                                        <td><?= esc($item['lokasi_kerusakan']) ?><?= !empty($item['lokasi_spesifik']) ? ' - ' . esc($item['lokasi_spesifik']) : '' ?>
                                        </td>
                                        <td><?= esc($item['kategori']) ?></td>
                                        <td><?= date('d M Y, H:i', strtotime($item['created_at'])) ?></td>

                                        <td>
                                            <span class="status-badge <?= $statusClass ?>">
                                                <?= ucfirst($status) ?>
                                            </span>
                                        </td>

                                        <td>
                                            <div style="display:flex; gap:0.5rem;">

                                                <!-- DETAIL -->
                                                <div class="tooltip-wrap">
                                                    <a href="?detail=<?= $item['id'] ?>&keyword=<?= esc($keyword ?? '') ?>&status_filter=<?= esc($statusFilter ?? '') ?>&page=<?= esc($currentPage) ?>"
                                                        class="btn btn-sm btn-info text-white">
                                                        Detail
                                                    </a>
                                                    <span class="tooltip-text">Lihat detail laporan</span>
                                                </div>

                                                <!-- VERIFIKASI -->
                                                <div class="tooltip-wrap">
                                                    <a onclick="openReportModalAdmin(<?= $item['id'] ?>)"
                                                        class="btn btn-sm btn-warning" style="cursor:pointer;">
                                                        Verifikasi
                                                    </a>
                                                    <span class="tooltip-text">Verifikasi laporan ini</span>
                                                </div>

                                            </div>


                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="pagination-container">
                    <?= $pager_links ?>
                </div>
            </div>
        </div>

        <!-- PANEL DETAIL -->
        <div>
            <?php if ($detail): ?>
                <?= $this->include('admin/detail') ?>
            <?php else: ?>
                <div class="detail-card" style="padding:2rem; text-align:center; opacity:.6;">
                    <h4>Pilih laporan untuk melihat detail</h4>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ============= MODAL VERIFIKASI ============= -->
<div id="reportModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeReportModalAdmin()">&times;</span>
        <h2 class="mb-3">Verifikasi Kerusakan Fasilitas</h2>

        <form id="reportForm" action="<?= site_url('admin/laporan/verifikasi') ?>" method="post">
            <?= csrf_field() ?>

            <input type="hidden" name="laporan_id" id="laporan_id">
            <input type="hidden" name="admin_id" value="<?= esc(session('id')) ?>">

            <div class="form-group mb-2">
                <label>Nama Admin</label>
                <input type="text" class="form-control" value="<?= esc(session('nama')) ?>" readonly>
            </div>

            <div class="form-group mb-2">
                <label>Status *</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="pending">Pending</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Keterangan Verifikasi *</label>
                <textarea id="keterangan_verifikasi" name="keterangan_verifikasi" class="form-control"
                    required></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Simpan Verifikasi</button>
        </form>
    </div>
</div>

<script>
    function openReportModalAdmin(id) {
        document.getElementById("reportModal").style.display = "flex";
        document.getElementById("laporan_id").value = id;
    }

    function closeReportModalAdmin() {
        document.getElementById("reportModal").style.display = "none";
    }
</script>

<?= $this->endSection() ?>