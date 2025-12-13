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
