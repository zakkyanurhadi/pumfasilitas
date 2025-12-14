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
        padding: 0.3rem 0.8rem;
        border-radius: 9999px;
        font-size: 0.8rem;
        font-weight: 500;
        color: #fff;
        display: inline-block;
    }

    .status-selesai {
        background-color: var(--success-color);
    }

    .pagination-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 1.5rem;
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
                            $no = 1 + ($pager->getCurrentPage() - 1) * $pager->getPerPage();
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
            <div class="pagination-container">
                <?= $pager->links() ?>
            </div>

        </div>

    </div>
</div>

<?= $this->endSection() ?>