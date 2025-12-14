<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<style>
    .grid-riwayat {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1rem;
        margin-top: 2rem;
        align-items: start;
    }
    @media(max-width: 992px) {
        .grid-riwayat {
            grid-template-columns: 1fr;
        }
    }

    /* Style bawaan list */
    .report-table-container {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }
    .report-table { width: 100%; border-collapse: collapse; margin-top: 1.5rem; }
    .report-table th, .report-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--gray-200);
        text-align: left;
    }
    .report-table th {
        background: var(--gray-100);
        font-weight: 600;
    }
    .status-selesai {
        background: var(--success-color);
        padding: .25rem .75rem;
        border-radius: 50px;
        color: white;
        font-size: .75rem;
    }

        .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
        white-space: nowrap;
    }

        .pagination-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 1.3rem;
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
        padding: 0.30rem 0.6rem;
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

</style>

<div class="grid-riwayat">

    <!-- ==========================
            LIST RIWAYAT (KIRI)
    =========================== -->
    <div>
        <div class="report-table-container">
            <h2 class="text-center">Riwayat Laporan Selesai</h2>

            <form method="get" class="filter-form mt-3">
                <div style="flex-grow:1;">
                    <input type="text" name="keyword" class="form-control"
                        placeholder="Cari laporan..."
                        value="<?= esc($keyword) ?>"><button class="btn btn-sm btn-info text-white">Cari</button>
                </div>
            </form>

            <table class="report-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Lokasi</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (empty($laporan)): ?>
                    <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
                <?php else: ?>
                    <?php $start = ($currentPage - 1) * $perPage; ?>
                    <?php foreach ($laporan as $i => $item): ?>
                        <tr>
                            <td><?= $start + $i + 1 ?></td>
                            <td><?= esc($item['lokasi_kerusakan']) ?></td>
                            <td><?= esc($item['kategori']) ?></td>
                            <td><?= date('d M Y, H:i', strtotime($item['updated_at'])) ?></td>
                            <td><span class="status-selesai">Selesai</span></td>

                            <td>
                                <a href="?detail=<?= $item['id'] ?>" class="btn btn-sm btn-info text-white">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>

            <div class="pagination-container">
                <?= $pager_links ?>
            </div>
        </div>
    </div>

    <!-- ==========================
            DETAIL (KANAN)
    =========================== -->
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

<?= $this->endSection() ?>
