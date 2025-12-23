<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<style>
    .table-container {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin: 0;
        /* Remove margin - main-content handles gap */
    }

    .grid-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1rem;
        margin: 0;
        /* Remove margin - main-content handles gap */
        align-items: start;
    }

    .search-group {
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }

    .search-group input {
        width: 260px;
    }

    .btn-search {
        height: 38px;
        /* samakan tinggi input */
        padding: 0 16px;
        border-radius: 8px;
        cursor: pointer;
    }


    @media (max-width: 992px) {
        .grid-container {
            grid-template-columns: 1fr;
        }
    }

    /* Mobile alignment fix */
    @media (max-width: 768px) {

        .table-container,
        .grid-container,
        .report-table-container {
            margin: 0 !important;
            padding: 1.25rem;
            border-radius: 16px;
        }
    }

    .report-table-container {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .table-users {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1.5rem;
    }

    .table-users th,
    .table-users td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--gray-200);
        text-align: left;
    }

    .table-users th {
        background-color: var(--gray-100);
        font-weight: 600;
    }

    .report-table td {
        font-size: 0.9rem;
    }

    /* Status badge */
    .status-active {
        background: #16a34a;
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        text-transform: capitalize;
    }

    .status-suspended {
        background: #dc2626;
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        text-transform: capitalize;
    }

    /* Buttons */
    .btn-sm {
        padding: 0.5rem 0.6rem;
        font-size: 0.7rem;
        white-space: nowrap;
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
        background: rgba(0, 0, 0, 0.45);
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
   ULTIMATE MOBILE REFINEMENT (APP-LIKE)
===================================================== */
    @media (max-width: 768px) {

        body {
            background: #f4f6fb;
        }

        /* ================= MAIN CARD ================= */
        .table-container {
            margin: 0.6rem;
            padding: 0.9rem;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .08);
        }

        .table-container h2 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            padding-left: 0.3rem;
        }

        /* ================= FILTER BAR ================= */
        .search-group {
            flex: 1;
            display: flex;
            gap: 0.35rem;
        }

        .search-group input {
            width: 100%;
            height: 38px;
            font-size: 0.78rem;
            border-radius: 12px;
        }

        .btn-search,
        .btn-add {
            height: 38px;
            font-size: 0.72rem;
            padding: 0 14px;
            border-radius: 12px;
            white-space: nowrap;
        }

        /* 🔥 HILANGKAN PUSH */
        .add-wrap {
            margin-left: 0;
        }

        /* ================= TABLE WRAPPER ================= */
        .table-container>div[style*="overflow-x"] {
            margin-top: 0.6rem;
            border-radius: 14px;
            background: #fff;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* ================= TABLE ================= */
        .table-users {
            min-width: 720px;
            font-size: 0.75rem;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-users thead th {
            position: sticky;
            top: 0;
            background: #f1f5f9;
            font-size: 0.72rem;
            padding: 0.55rem 0.6rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            z-index: 2;
        }

        .table-users tbody tr {
            transition: background 0.15s ease;
        }

        .table-users tbody tr:active {
            background: #f8fafc;
        }

        .table-users td {
            padding: 0.55rem 0.6rem;
            vertical-align: middle;
            white-space: nowrap;
        }

        /* ================= STATUS ================= */
        .status-active {
            background: #22c55e;
            font-size: 0.6rem;
            padding: 3px 9px;
            font-weight: 600;
        }

        .status-suspended {
            background: #ef4444;
            font-size: 0.6rem;
            padding: 3px 9px;
            font-weight: 600;
        }

        /* ================= ACTION BUTTON ================= */
        .btn-sm {
            font-size: 0.6rem;
            padding: 0.35rem 0.5rem;
            border-radius: 8px;
        }

        /* ================= PAGINATION ================= */
        .pagination-container {
            justify-content: center;
            margin-top: 1rem;
        }

        .pagination {
            border-radius: 12px;
        }

        .pagination li a {
            font-size: 0.68rem;
            padding: 0.3rem 0.55rem;
        }

        /* ================= MODAL ================= */
        .modal-content {
            width: 92%;
            max-width: 420px;
            border-radius: 20px;
            padding: 1.3rem 1.2rem;
        }

        .modal-content h3 {
            font-size: 1rem;
            margin-bottom: 0.7rem;
            text-align: center;
        }

        .modal-content input,
        .modal-content select {
            height: 38px;
            font-size: 0.8rem;
            border-radius: 12px;
        }

        .modal-content button {
            height: 40px;
            font-size: 0.85rem;
            border-radius: 12px;
        }
    }

    /* ================= EXTRA SMALL DEVICE ================= */
    @media (max-width: 480px) {

        .table-container>div[style*="display:flex"] {
            gap: 0.4rem;
            align-items: stretch;
        }

        /* FORM FULL */
        .table-container>div[style*="display:flex"] form {
            flex: 1;
            width: 100%;
        }

        /* SEARCH GROUP */
        .search-group {
            width: 100%;
            display: flex;
            gap: 0.3rem;
        }

        /* INPUT */
        .search-group input {
            flex: 1;
            width: 100%;
            height: 36px;
            font-size: 0.72rem;
            border-radius: 10px;
            padding: 0 10px;
        }

        /* BUTTON */
        .btn-search,
        .btn-add {
            height: 36px;
            font-size: 0.68rem;
            padding: 0 12px;
            border-radius: 10px;
            white-space: nowrap;
        }

        /* TOOLTIP AMAN */
        .tooltip-wrap {
            display: flex;
            align-items: center;
        }

        .table-container {
            margin: 0.4rem;
            padding: 0.8rem;
        }

        .table-container h2 {
            font-size: 0.92rem;
        }

        .table-users {
            min-width: 680px;
        }

        .btn-add {
            font-size: 0.78rem;
        }
    }
</style>

<div class="table-container">

    <h2 class="text-center mb-3">
        <?= ($roleFilter == 'admin') ? "Daftar Akun Admin" : "Daftar Akun User" ?>
    </h2>

    <!-- FILTER + ADD USER -->
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;">

        <!-- SEARCH (kiri) -->

        <form method="get">
            <div class="search-group">
                <input type="text" name="keyword" class="form-control" placeholder="Cari nama, email, atau NPM..."
                    value="<?= esc($keyword ?? '') ?>">

                <div class="tooltip-wrap">
                    <button type="submit" class="btn-search">Cari</button>
                    <span class="tooltip-text">Cari Data</span>
                </div>
            </div>
        </form>


        <!-- TOMBOL TAMBAH (kanan) -->
        <div>
            <div class="tooltip-wrap">
                <button class="btn-add" onclick="openAdd()">
                    + Tambah User
                </button>
                <span class="tooltip-text">Tambah Akun</span>
            </div>
        </div>

    </div>

    <!-- TABEL -->
    <div style="overflow-x: auto;">
        <table class="table-users">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NPM</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada akun.</td>
                    </tr>
                <?php else: ?>
                    <?php $start = ($currentPage - 1) * $perPage; ?>
                    <?php foreach ($users as $i => $u): ?>
                        <tr>
                            <td><?= $start + $i + 1 ?></td>
                            <td><?= esc($u['npm']) ?></td>
                            <td><?= esc($u['nama']) ?></td>
                            <td><?= esc($u['email']) ?></td>
                            <td><?= esc($u['role']) ?></td>

                            <td>
                                <span class="status-<?= esc($u['status']) ?>">
                                    <?= esc($u['status']) ?>
                                </span>
                            </td>

                            <td>
                                <div style="display:flex;gap:0.4rem;">
                                    <div class="tooltip-wrap">
                                        <a onclick="openEdit(<?= $u['id'] ?>,'<?= $u['nama'] ?>','<?= $u['email'] ?>','<?= $u['status'] ?>')"
                                            class="btn btn-sm btn-info text-white">Edit</a>
                                        <span class="tooltip-text">Edit Data Akun</span>
                                    </div>
                                    <div class="tooltip-wrap">
                                        <a href="<?= site_url('akun/delete/' . $u['id']) ?>" class="btn btn-sm btn-warning"
                                            onclick="return confirm('Hapus akun ini?')">Hapus</a>
                                        <span class="tooltip-text">Hapus Akun?</span>
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

<!-- ============= MODAL EDIT ============= -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEdit()">&times;</span>

        <h3>Edit Akun</h3>

        <form method="post" action="<?= site_url('akun/update') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="edit_id">

            <label>Nama</label>
            <input class="form-control mb-2" type="text" id="edit_nama" name="nama">

            <label>Email</label>
            <input class="form-control mb-2" type="email" id="edit_email" name="email">

            <label>Status</label>
            <select class="form-control mb-3" id="edit_status" name="status">
                <option value="active">Active</option>
                <option value="suspended">Suspended</option>
            </select>

            <button class="btn btn-primary w-100">Simpan</button>
        </form>

        <button class="btn btn-secondary w-100 mt-2" onclick="closeEdit()">Batal</button>
    </div>
</div>

<!-- ============= MODAL TAMBAH USER ============= -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAdd()">&times;</span>

        <h3>Tambah User Baru</h3>

        <form method="post" action="<?= site_url('akun/store') ?>">
            <?= csrf_field() ?>

            <label>NPM</label>
            <input class="form-control mb-2" type="text" name="npm" required>

            <label>Nama</label>
            <input class="form-control mb-2" type="text" name="nama" required>

            <label>Email</label>
            <input class="form-control mb-2" type="email" name="email" required>

            <label>Password</label>
            <input class="form-control mb-2" type="password" name="password" required>

            <label>Role</label>
            <select class="form-control mb-2" name="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>

            <label>Status</label>
            <select class="form-control mb-3" name="status">
                <option value="active">Active</option>
                <option value="suspended">Suspended</option>
            </select>

            <button class="btn btn-primary w-100">Simpan</button>
        </form>

        <button class="btn btn-secondary w-100 mt-2" onclick="closeAdd()">Batal</button>
    </div>
</div>


<script>
    function openEdit(id, nama, email, status) {
        document.getElementById("editModal").style.display = "flex";
        document.getElementById("edit_id").value = id;
        document.getElementById("edit_nama").value = nama;
        document.getElementById("edit_email").value = email;
        document.getElementById("edit_status").value = status;
    }

    function closeEdit() {
        document.getElementById("editModal").style.display = "none";
    }

    function openAdd() {
        document.getElementById("addModal").style.display = "flex";
    }
    function closeAdd() {
        document.getElementById("addModal").style.display = "none";
    }
</script>

<?= $this->endSection() ?>