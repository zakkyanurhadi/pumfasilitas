<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* OFFSET karena navbar fixed-top */
    .page-wrapper {
        padding-top: 90px;
        /* sesuaikan tinggi navbar */
    }

    .report-table-container {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
        overflow: visible !important;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1.5rem;
    }

    .report-table th,
    .report-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--gray-200);
        vertical-align: middle;
        text-align: left;
    }

    .report-table th {
        background-color: var(--gray-100);
        font-weight: 600;
    }

    .filter-form {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .filter-form input {
        flex: 1;
        min-width: 220px;
    }

    .status-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-align: center;
        white-space: nowrap;
    }

    .status-selesai {
        background-color: #3db158ff;
        color: #ffffff;
        letter-spacing: 0.3px;
    }



    /* WRAPPER TENGAH */
    /* .pagination-container {
        overflow: visible;
        display: flex;
        justify-content: center;
        margin-top: 1.5rem;
    } */

    /* LIST */
    .pagination {
        gap: 0.4rem;
    }

    .page-item .page-link {
        width: 34px;
        height: 34px;
        padding: 0;
        /* ⬅ WAJIB */
        line-height: 1;
        /* ⬅ WAJIB */

        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;

        background-color: #f1f5f9;
        color: #2563eb;
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



    .empty-state {
        text-align: center;
        padding: 2rem;
        color: var(--gray-500);
        font-style: italic;
    }
</style>

<div class="page-wrapper">
    <div class="container">

        <div class="report-table-container">

            <h2 class="text-center mb-3">Riwayat Laporan Selesai</h2>

            <!-- SEARCH -->
            <form method="get" action="<?= site_url('laporan/riwayat') ?>" class="filter-form">
                <input
                    type="text"
                    name="keyword"
                    class="form-control"
                    placeholder="Cari lokasi, kategori, atau nama pelapor..."
                    value="<?= esc($keyword ?? '') ?>">
                <button type="submit" class="btn btn-primary">
                    Cari
                </button>
            </form>

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Pelapor</th>
                            <th>Lokasi Kerusakan</th>
                            <th>Kategori</th>
                            <th width="20%">Tanggal Selesai</th>
                            <th width="10%">Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($laporan)): ?>
                            <tr>
                                <td colspan="7" class="empty-state">
                                    Tidak ada riwayat laporan selesai.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $no = 1;
                            if (isset($pager)) {
                                $no = 1 + ($pager->getCurrentPage() - 1) * $pager->getPerPage();
                            }
                            ?>

                            <?php foreach ($laporan as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($item['nama_pelapor'] ?? '-') ?></td>
                                    <td><?= esc($item['lokasi_kerusakan'] ?? '-') ?></td>
                                    <td><?= esc($item['kategori'] ?? '-') ?></td>
                                    <td>
                                        <?= !empty($item['updated_at'])
                                            ? date('d M Y, H:i', strtotime($item['updated_at']))
                                            : '-' ?>
                                    </td>
                                    <td>
                                        <span class="status-badge status-selesai">
                                            Selesai
                                        </span>
                                    </td>
                                    <td>
                                        <a
                                            href="<?= site_url('laporan/detail/' . $item['id']) ?>"
                                            class="btn btn-sm btn-outline-primary">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <?php if ($pager->getPageCount() > 1): ?>
                <div class="pagination-container">
                    <?= $pager->links('default', 'circle') ?>
                </div>
            <?php endif ?>


        </div>
    </div>
</div>

<?= $this->endSection() ?>