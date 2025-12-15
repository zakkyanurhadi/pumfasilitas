<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<style>
.table-container {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    margin: 2rem;
}

.search-group {
    display: flex;
    gap: 0.7rem;
    align-items: center;
}

.search-group input {
    width: 260px;   /* → atur panjang search bar */
}

.table-gedung {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1.5rem;
}

.table-gedung th,
.table-gedung td {
    padding: 0.75rem 1rem;
    border-bottom: 1px solid var(--gray-200);
    text-align: left;
}

.table-gedung th {
    background-color: var(--gray-100);
    font-weight: 600;
}

    .report-table td {
        font-size: 0.9rem;
    }

/* Buttons */
.btn-sm {
    padding: 0.5rem 0.6rem;
    font-size: 0.7rem;
    white-space: nowrap;
}

.btn-add {
    background-color: var(--success-color);
    color: white;
    padding: 6px 14px;
    border: none;
    border-radius: 8px;
    font-size: 0.85rem;
    cursor: pointer;
    transition: 0.2s ease;
}

.btn-add:hover {
    background-color: #0d8c32;
}

.btn-warning {
    background-color: #f97316;
    color: white;
}

.btn-warning:hover {
    background-color: #ea580c;
}

.btn-danger {
    background-color: #dc2626;
    color: white;
}

.btn-danger:hover {
    background-color: #b91c1c;
}

/* Search button */
.btn-search {
    background-color: var(--primary-color);
    color: white;
    padding: 6px 14px;
    border-radius: 8px;
    border: none;
    font-size: 0.85rem;
    cursor: pointer;
    transition: 0.2s ease;
}

.btn-search:hover {
    background-color: #150696ff;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    justify-content: center;
    align-items: center;
    z-index: 2000;
}

.modal-content {
    background: var(--white);
    padding: 2rem;
    width: 400px;
    border-radius: 10px;
    position: relative;
    animation: fadeIn .3s ease;
}

.close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 22px;
    cursor: pointer;
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

.tooltip-wrap {
    position: relative;
    display: inline-block; /* penting! */
}

.tooltip-text {
    visibility: hidden;
    opacity: 0;

    position: absolute;
    bottom: 120%;        /* tampil di atas tombol */
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
   RESPONSIVE – KELOLA GEDUNG
===================================================== */
@media (max-width: 768px) {

    /* ===== CONTAINER ===== */
    .table-container {
        margin: 0.75rem;
        padding: 1.2rem 1rem;
        border-radius: 16px;
    }

    .table-container h2 {
        font-size: 1.05rem;
        margin-bottom: 1rem;
    }

    /* ===== FILTER BAR ===== */
    .table-container > div:first-of-type {
        flex-direction: column;
        align-items: stretch;
        gap: 0.6rem;
    }

    .search-group {
        width: 100%;
    }

    .search-group input {
        width: 100%;
        height: 38px;
        font-size: 0.8rem;
        border-radius: 12px;
    }

    .btn-search {
        height: 38px;
        font-size: 0.8rem;
        border-radius: 12px;
        font-weight: 600;
    }

    /* tombol tambah */
    .table-container > div:first-of-type > div:last-child {
        align-self: flex-end;
    }

    .table-container > div:first-of-type button {
        font-size: 0.75rem;
        padding: 0.45rem 0.8rem;
        border-radius: 10px;
    }

    /* ===== TABLE WRAPPER ===== */
    .table-container > div[style*="overflow-x"] {
        margin-top: 0.8rem;
        border-radius: 14px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* ===== TABLE ===== */
    .table-gedung {
        min-width: 720px;
        font-size: 0.75rem;
    }

    .table-gedung th {
        font-size: 0.7rem;
        padding: 0.55rem 0.6rem;
        position: sticky;
        top: 0;
        background: var(--gray-100);
        z-index: 1;
    }

    .table-gedung td {
        padding: 0.55rem 0.6rem;
        white-space: nowrap;
    }

    /* ===== AKSI BUTTON ===== */
    .table-gedung td:last-child {
        gap: 0.35rem;
    }

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
        font-size: 0.65rem;
        padding: 0.25rem 0.45rem;
    }

    /* ===== TOOLTIP (DISABLE HOVER DI MOBILE) ===== */
    .tooltip-text {
        display: none;
    }

    /* ===== MODAL ===== */
    .modal-content {
        width: 92%;
        max-width: 420px;
        padding: 1.4rem 1.2rem;
        border-radius: 18px;
    }

    .modal-content h3 {
        font-size: 1rem;
        text-align: center;
        margin-bottom: 1rem;
    }

    .modal-content input,
    .modal-content textarea {
        font-size: 0.85rem;
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

    .table-container {
        margin: 0.5rem;
        padding: 1rem 0.9rem;
    }

    .table-container h2 {
        font-size: 0.95rem;
    }

    .table-gedung {
        min-width: 680px;
    }
}


</style>

<div class="table-container">
    <h2 class="text-center mb-3">Kelola Gedung</h2>

    <!-- Filter + Tambah -->
    <div style="display:flex; justify-content:space-between; align-items:center;">

        <!-- Search -->
        <form method="get">
            <div class="search-group">
                <input type="text" name="keyword" class="form-control"
                    placeholder="Cari gedung..."
                    value="<?= esc($keyword ?? '') ?>">
                    <div class="tooltip-wrap">
                <button class="btn-search">Cari</button>
                        <span class="tooltip-text">Cari Data Gedung</span>
                    </div>
            </div>
        </form>

        <!-- Tambah Gedung -->
        <div class="tooltip-wrap">
            <button class="btn btn-sm" onclick="openAdd()">+ Tambah Gedung</button>
            <span class="tooltip-text">Tambah Data Gedung</span>
        </div>
    </div>

    <!-- Tabel -->
    <div style="overflow-x:auto;">
        <table class="table-gedung">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($gedung)): ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data gedung.</td>
                </tr>
                <?php else: ?>
                <?php $start = ($currentPage - 1) * $perPage; ?>
                <?php foreach($gedung as $i => $g): ?>
                <tr>
                    <td><?= $start + $i + 1 ?></td>
                    <td><?= esc($g['kode']) ?></td>
                    <td><?= esc($g['nama']) ?></td>
                    <td><?= esc($g['deskripsi']) ?></td>
                    <td style="display:flex; gap:0.5rem;">
                        <div class="tooltip-wrap">
                        <a class="btn btn-sm btn-warning" onclick="openEdit(<?= $g['id'] ?>,'<?= esc($g['kode']) ?>','<?= esc($g['nama']) ?>','<?= esc($g['deskripsi']) ?>')">Edit</a>
                            <span class="tooltip-text">Edit Data Gedung</span>
                        </div>
                        <div class="tooltip-wrap">
                            <a href="<?= site_url('gedung/delete/'.$g['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus gedung ini?')">Hapus</a>
                            <span class="tooltip-text">Hapus Data Gedung</span>
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

<!-- Modal Tambah/Edit -->
<div id="gedungModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3 id="modalTitle">Tambah Gedung</h3>

        <form id="gedungForm" method="post" action="<?= site_url('gedung/create') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="gedung_id">

            <label>Kode Gedung *</label>
            <input type="text" class="form-control mb-2" id="kode" name="kode" required>

            <label>Nama Gedung *</label>
            <input type="text" class="form-control mb-2" id="nama" name="nama" required>

            <label>Deskripsi</label>
            <textarea class="form-control mb-3" id="deskripsi" name="deskripsi"></textarea>

            <button type="submit" class="btn btn-primary w-100">Simpan</button>
            <button type="button" class="btn btn-secondary w-100 mt-2" onclick="closeModal()">Batal</button>
        </form>
    </div>
</div>

<script>
function openAdd(){
    document.getElementById("gedungModal").style.display = "flex";
    document.getElementById("modalTitle").innerText = "Tambah Gedung";
    document.getElementById("gedungForm").action = "<?= site_url('gedung/create') ?>";
    document.getElementById("gedungForm").reset();
    document.getElementById("gedung_id").value = '';
}

function openEdit(id,kode,nama,deskripsi){
    document.getElementById("gedungModal").style.display = "flex";
    document.getElementById("modalTitle").innerText = "Edit Gedung";
    document.getElementById("gedungForm").action = "<?= site_url('gedung/update') ?>";
    document.getElementById("gedung_id").value = id;
    document.getElementById("kode").value = kode;
    document.getElementById("nama").value = nama;
    document.getElementById("deskripsi").value = deskripsi;
}

function closeModal(){
    document.getElementById("gedungModal").style.display = "none";
}
</script>

<?= $this->endSection() ?>
