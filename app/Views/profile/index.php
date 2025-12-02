<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Style tambahan khusus untuk halaman profil */
    .profile-card {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        max-width: 700px;
        margin: 2rem auto;
    }

    .profile-avatar {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 2rem;
    }

    .profile-avatar img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 1rem;
        border: 4px solid var(--gray-200);
    }

    .error-message {
        color: var(--danger-color);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .form-control[readonly] {
        background-color: var(--gray-100);
    }
</style>

<div class="profile-card">
    <h2 class="text-center mb-3">Edit Profil</h2>

    <form action="<?= site_url('profile/update') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="profile-avatar">
            <img src="<?= base_url('uploads/avatars/' . esc($user['img'] ?? 'default.jpg')) ?>" alt="User Avatar">
            <label for="avatar">Ubah Foto Profil</label>
            <input type="file" id="avatar" name="avatar" class="form-control mt-2" accept="image/png, image/jpeg, image/gif">
            <small class="text-secondary mt-2">Kosongkan jika tidak ingin merubah foto. (JPG, PNG, GIF | Max: 2MB)</small>
        </div>

        <div class="form-group">
            <label for="npm">NPM</label>
            <input type="text" id="npm" name="npm" class="form-control" value="<?= esc($user['npm']) ?>" readonly>
        </div>

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" class="form-control" value="<?= old('nama', esc($user['nama'])) ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= old('email', esc($user['email'])) ?>" required>
        </div>

        <hr class="mb-3 mt-3">
        <p class="text-secondary text-center">Kosongkan password jika tidak ingin mengubahnya.</p>

        <div class="form-group">
            <label for="password">Password Baru</label>
            <input type="password" id="password" name="password" class="form-control">
            <?php if (session('errors.password')) : ?>
                <div class="error-message"><?= session('errors.password') ?></div>
            <?php endif ?>
        </div>

        <div class="form-group">
            <label for="pass_confirm">Konfirmasi Password Baru</label>
            <input type="password" id="pass_confirm" name="pass_confirm" class="form-control">
            <?php if (session('errors.pass_confirm')) : ?>
                <div class="error-message"><?= session('errors.pass_confirm') ?></div>
            <?php endif ?>
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn" style="width: 100%;">Simpan Perubahan</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>