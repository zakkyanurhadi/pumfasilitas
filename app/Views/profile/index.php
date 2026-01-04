<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Tema putih – biru */
    .profile-card {
        border-radius: 1rem;
        border: none;
        box-shadow: 0 8px 24px rgba(13, 110, 253, .08);
    }

    .profile-avatar img {
        width: 130px;
        height: 130px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #e7f1ff;
        box-shadow: 0 4px 12px rgba(13, 110, 253, .2);
    }

    .profile-avatar label {
        cursor: pointer;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .25);
    }

    .divider-text {
        font-size: .85rem;
        color: #6c757d;
    }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <div class="card profile-card">
                <div class="card-body p-4 p-md-5">

                    <!-- Header -->
                    <div class="text-center mb-4">
                        <h3 class="fw-semibold text-primary mb-1">Edit Profil</h3>
                        <p class="text-muted mb-0">Perbarui informasi akun Anda</p>
                    </div>

                    <form action="<?= site_url('profile/update') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <!-- Avatar -->
                        <div class="profile-avatar text-center mb-4">
                            <img id="avatarPreview"
                                src="<?= base_url('uploads/avatars/' . esc($user['img'] ?? 'default.webp')) ?>"
                                alt="Avatar">

                            <div class="mt-3">
                                <label for="avatar" class="btn btn-outline-primary btn-sm">
                                    Ubah Foto Profil
                                </label>
                                <input type="file" id="avatar" name="avatar" class="d-none"
                                    accept="image/png, image/jpeg, image/gif, image/webp">
                            </div>

                            <small class="text-muted d-block mt-2">
                                JPG / PNG / GIF / WEBP — Maks 2MB
                            </small>
                        </div>


                        <!-- NPM -->
                        <div class="mb-3">
                            <label class="form-label fw-medium">NPM</label>
                            <input type="text" class="form-control" value="<?= esc($user['npm']) ?>" readonly>
                        </div>

                        <!-- Nama -->
                        <div class="mb-3">
                            <label class="form-label fw-medium">Nama</label>
                            <input type="text" name="nama" class="form-control"
                                value="<?= old('nama', esc($user['nama'])) ?>" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label fw-medium">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="<?= old('email', esc($user['email'])) ?>" required>
                        </div>

                        <!-- Divider -->
                        <div class="text-center my-4 divider-text">
                            Kosongkan password jika tidak ingin mengubahnya
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label fw-medium">Password Baru</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <!-- Konfirmasi -->
                        <div class="mb-4">
                            <label class="form-label fw-medium">Konfirmasi Password Baru</label>
                            <input type="password" name="pass_confirm" class="form-control">
                        </div>

                        <!-- Submit -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatarPreview');

    avatarInput.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) return;

        // Validasi tipe file
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format gambar tidak didukung!');
            this.value = '';
            return;
        }

        // Validasi ukuran (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran gambar maksimal 2MB!');
            this.value = '';
            return;
        }

        // Preview image
        const reader = new FileReader();
        reader.onload = function (e) {
            avatarPreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
</script>


<?= $this->endSection() ?>