<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body bg-primary bg-gradient text-white rounded">
                    <h3 class="mb-1">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?= esc($title) ?>
                    </h3>
                    <p class="mb-0 opacity-75">Laporkan kerusakan fasilitas untuk perbaikan segera</p>
                </div>
            </div>

            <!-- Flash Error -->
            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle-fill me-2"></i>
                    <strong>Terjadi Kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Form Card -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="<?= site_url('laporan/store') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <!-- 1. ID (auto increment - hidden) -->

                        <!-- 2. Nama Pelapor -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-person-fill text-primary me-2"></i>
                                Nama Pelapor <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_pelapor" class="form-control"
                                value="<?= old('nama_pelapor') ?>"
                                placeholder="Masukkan nama lengkap Anda" required>
                        </div>

                        <!-- 3. Lokasi Kerusakan -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                                Lokasi Kerusakan <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="lokasi_kerusakan" class="form-control"
                                value="<?= old('lokasi_kerusakan') ?>"
                                placeholder="Contoh: Lantai 2, Area Lobby" required>
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Lokasi umum terjadinya kerusakan
                            </small>
                        </div>

                        <!-- 4. Lokasi Spesifik -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-pin-map-fill text-primary me-2"></i>
                                Lokasi Spesifik <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="lokasi_spesifik" class="form-control"
                                value="<?= old('lokasi_spesifik') ?>"
                                placeholder="Contoh: Pojok kiri dekat jendela, Samping pintu masuk" required>
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Detail posisi kerusakan secara spesifik
                            </small>
                        </div>

                        <!-- 5. Deskripsi -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-file-text-fill text-primary me-2"></i>
                                Deskripsi Kerusakan <span class="text-danger">*</span>
                            </label>
                            <textarea name="deskripsi" rows="5" class="form-control"
                                placeholder="Jelaskan secara detail kondisi kerusakan yang terjadi, kapan terjadi, dan dampaknya..."
                                required><?= old('deskripsi') ?></textarea>
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Berikan penjelasan sejelas dan selengkap mungkin
                            </small>
                        </div>

                        <!-- 6. Foto -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-camera-fill text-primary me-2"></i>
                                Foto Kerusakan
                            </label>
                            <input type="file" name="foto" class="form-control" accept="image/*"
                                id="fotoInput">
                            <small class="text-muted d-block mt-1">
                                <i class="bi bi-image me-1"></i>
                                Format: JPG, JPEG, PNG (Maksimal 2MB) - Opsional
                            </small>

                            <!-- Preview Image -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <img id="preview" src="" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        </div>

                        <!-- 7. Status (auto set to 'pending' - hidden) -->

                        <!-- 8. User ID (from session - hidden) -->

                        <!-- 9. Gedung ID -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-building text-primary me-2"></i>
                                Gedung <span class="text-danger">*</span>
                            </label>
                            <select name="gedung_id" class="form-select" required>
                                <option value="">-- Pilih Gedung --</option>
                                <?php foreach ($gedung as $g) : ?>
                                    <option value="<?= $g['id'] ?>"
                                        <?= old('gedung_id') == $g['id'] ? 'selected' : '' ?>>
                                        <?= esc($g['nama']) ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <!-- 10. Ruangan ID -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-door-closed text-primary me-2"></i>
                                Ruangan <span class="text-danger">*</span>
                            </label>
                            <select name="ruangan_id" class="form-select" required>
                                <option value="">-- Pilih Ruangan --</option>
                                <?php foreach ($ruangan as $r) : ?>
                                    <option value="<?= $r['id'] ?>"
                                        <?= old('ruangan_id') == $r['id'] ? 'selected' : '' ?>>
                                        <?= esc($r['nama_ruangan']) ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <!-- 11. Prioritas -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-flag-fill text-primary me-2"></i>
                                Prioritas <span class="text-danger">*</span>
                            </label>
                            <select name="prioritas" class="form-select" required>
                                <option value="">-- Pilih Tingkat Prioritas --</option>
                                <option value="low" <?= old('prioritas') == 'low' ? 'selected' : '' ?>>
                                    🟢 Low - Tidak Mendesak
                                </option>
                                <option value="medium" <?= old('prioritas') == 'medium' ? 'selected' : '' ?>>
                                    🟡 Medium - Perlu Perhatian
                                </option>
                                <option value="high" <?= old('prioritas') == 'high' ? 'selected' : '' ?>>
                                    🔴 High - Sangat Mendesak
                                </option>
                            </select>
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Tentukan tingkat urgensi perbaikan
                            </small>
                        </div>

                        <!-- 12. Kategori -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-tags-fill text-primary me-2"></i>
                                Kategori Kerusakan <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kategori" class="form-control"
                                value="<?= old('kategori') ?>"
                                placeholder="Contoh: Listrik, AC, Plafon, Pintu, Jendela, dll" required>
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Jenis atau kategori kerusakan yang terjadi
                            </small>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between pt-4 border-top mt-4">
                            <div class="d-flex gap-3">
                                <div class="tooltip-wrap">
                                    <a href="<?= site_url('dashboard') ?>" class="btn btn-outline-secondary btn-lg">
                                        <i class="bi bi-arrow-left me-2"></i>Kembali
                                    </a>
                                    <span class="tooltip-text">Kembali ke dashboard</span>
                                </div>
                            </div>
                            <div class="tooltip-wrap">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="bi bi-send-fill me-2"></i>Kirim Laporan
                                </button>
                                <span class="tooltip-text">Kirim laporan Anda</span>
                            </div>
                    </form>
                </div>
            </div>

            <!-- Info Box -->
            <div class="card border-0 bg-light mt-3">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-info-circle-fill text-primary me-2 mt-1"></i>
                        <div>
                            <strong>Informasi:</strong>
                            <ul class="mb-0 mt-2 small">
                                <li>Laporan Anda akan diproses oleh tim maintenance</li>
                                <li>Status laporan dapat dipantau di dashboard</li>
                                <li>Field bertanda <span class="text-danger">*</span> wajib diisi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk Preview Gambar -->
<script>
    document.getElementById('fotoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validasi ukuran file (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            document.getElementById('imagePreview').style.display = 'none';
        }
    });
</script>

<style>
    .form-label {
        margin-bottom: 0.5rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    #imagePreview {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<?= $this->endSection() ?>