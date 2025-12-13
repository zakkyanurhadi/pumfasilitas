<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .report-table-container {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin: 2rem auto;
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
        text-align: left;
    }

    .report-table th {
        background-color: var(--gray-100);
        font-weight: 600;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-weight: 500;
        font-size: 0.8rem;
        color: var(--white);
        text-align: center;
    }

    .status-pending {
        background-color: red;
    }

    .status-diproses {
        background-color: orange;
    }

    .status-selesai {
        background-color: var(--success-color);
    }

    /* Pagination Container */
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
        padding: 0.30rem 0.5rem;
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

    .btn-small {
    padding: 0.35rem 0.75rem;
    font-size: 0.8rem;
}

</style>


<div class="report-table-container">
    <h2 class="text-center">Status Semua Laporan</h2>

    <table class="report-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Lokasi</th>
                <th>Kategori</th>
                <th>Tanggal Lapor</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php if(empty($laporan)): ?>
                <tr><td colspan="6" class="text-center">Belum ada laporan.</td></tr>
            <?php else: ?>
                <?php foreach($laporan as $i => $item): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= esc($item['lokasi_kerusakan']).' - '.esc($item['lokasi_spesifik']) ?></td>
                    <td><?= esc($item['kategori']) ?></td>
                    <td><?= date('d M Y, H:i', strtotime($item['created_at'])) ?></td>

                    <?php $statusClass = 'status-'.strtolower($item['status']); ?>

                    <td><span class="status-badge <?= $statusClass ?>"><?= ucfirst($item['status']) ?></span></td>

                    <td><a href="<?= site_url('lapor/detail/'.$item['id']) ?>" class="btn btn-small">Detail</a></td>
                </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>

    <div class="pagination-container">
        <?= $pager_links ?>
    </div>
</div>

<?= $this->endSection() ?>
