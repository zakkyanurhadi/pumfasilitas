<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* ===== PROFILE CARD ===== */
    .profile-card {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        max-width: 700px;
        margin: 0 auto;
        /* Horizontal center only */
    }

    /* ===== AVATAR ===== */
    .profile-avatar {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .profile-avatar img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 0.8rem;
        border: 4px solid var(--gray-200);
    }

    /* ===== ACCORDION ===== */
    .accordion-item {
        border: 1px solid var(--gray-200);
        border-radius: 10px;
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .accordion-header {
        padding: 14px 18px;
        background: var(--gray-100);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
    }

    .accordion-header i {
        transition: 0.3s ease;
    }

    .accordion-body {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.35s ease;
        padding: 0 18px;
    }

    .accordion-item.active .accordion-body {
        max-height: 1000px;
        padding: 18px;
    }

    .accordion-item.active .accordion-header i {
        transform: rotate(180deg);
    }

    /* ===== READONLY ===== */
    .form-control[readonly] {
        background-color: var(--gray-100);
        cursor: not-allowed;
    }
</style>

<div class="profile-card">
    <h2 class="text-center mb-3">Pengaturan Akun</h2>

    <form action="<?= site_url('admin/profile/update') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- === PROFIL SAYA === -->
        <div class="accordion-item active">
            <div class="accordion-header" onclick="toggleAccordion(this)">
                <span>Profil Saya</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>

            <div class="accordion-body">
                <div class="profile-avatar">
                    <img src="<?= base_url('uploads/avatars/' . esc($user['img'] ?? 'default.jpg')) ?>" alt="Avatar">
                    <label for="avatar">Ubah Foto Profil</label>
                    <input type="file" id="avatar" name="avatar" class="form-control mt-2"
                        accept="image/png, image/jpeg, image/gif">
                    <small class="text-secondary mt-2">
                        Kosongkan jika tidak ingin mengubah foto (JPG, PNG, GIF | Max 2MB)
                    </small>
                </div>

                <div class="form-group">
                    <label>NPM</label>
                    <input type="text" class="form-control" value="<?= esc($user['npm']) ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?= old('nama', esc($user['nama'])) ?>"
                        required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                        value="<?= old('email', esc($user['email'])) ?>" required>
                </div>
            </div>
        </div>

        <!-- === UBAH PASSWORD === -->
        <div class="accordion-item">
            <div class="accordion-header" onclick="toggleAccordion(this)">
                <span>Ubah Kata Sandi</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>

            <div class="accordion-body">
                <p class="text-secondary text-center mb-2">
                    Kosongkan jika tidak ingin mengubah password
                </p>

                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="pass_confirm" class="form-control">
                </div>
            </div>
        </div>

        <button type="submit" class="btn w-100 mt-3">
            Simpan Perubahan
        </button>
    </form>
</div>

<script>
    function toggleAccordion(header) {
        const item = header.parentElement;
        item.classList.toggle('active');
    }
</script>

<?= $this->endSection() ?>