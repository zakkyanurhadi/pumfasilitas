<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body bg-warning bg-gradient text-white rounded">
                    <h3 class="mb-1">
                        <i class="bi bi-pencil-square me-2"></i>
                        <?= esc($title) ?>
                    </h3>
                    <p class="mb-0 opacity-75">Edit informasi laporan kerusakan Anda</p>
                </div>
            </div>

            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-x-circle-fill me-2"></i>
                    <strong>Terjadi Kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Form Card -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="<?= site_url('laporan/update/' . $laporan['id']) ?>" method="post"
                        enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <!-- Nama Pelapor -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-person-fill text-primary me-2"></i>
                                Nama Pelapor <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_pelapor" class="form-control"
                                value="<?= old('nama_pelapor', $laporan['nama_pelapor']) ?>"
                                placeholder="Masukkan nama lengkap Anda" required>
                        </div>

                        <!-- Lokasi Kerusakan -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                                Lokasi Kerusakan <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="lokasi_kerusakan" class="form-control"
                                value="<?= old('lokasi_kerusakan', $laporan['lokasi_kerusakan']) ?>"
                                placeholder="Contoh: Lantai 2, Area Lobby" required>
                        </div>

                        <!-- Lokasi Spesifik -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-pin-map-fill text-primary me-2"></i>
                                Lokasi Spesifik (Opsional)
                            </label>
                            <input type="text" name="lokasi_spesifik" class="form-control"
                                value="<?= old('lokasi_spesifik', $laporan['lokasi_spesifik']) ?>"
                                placeholder="Contoh: Pojok kiri dekat jendela">
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-file-text-fill text-primary me-2"></i>
                                Deskripsi Kerusakan <span class="text-danger">*</span>
                            </label>
                            <textarea name="deskripsi" rows="5" class="form-control"
                                placeholder="Jelaskan secara detail kondisi kerusakan..."
                                required><?= old('deskripsi', $laporan['deskripsi']) ?></textarea>
                        </div>

                        <!-- Foto -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-camera-fill text-primary me-2"></i>
                                Foto Kerusakan
                            </label>

                            <?php if ($laporan['foto']): ?>
                                <div class="mb-2">
                                    <img src="<?= base_url('uploads/laporan/' . $laporan['foto']) ?>" class="img-thumbnail"
                                        style="max-height: 200px;">
                                    <p class="small text-muted mb-0">Foto saat ini</p>
                                </div>
                            <?php endif; ?>

                            <input type="file" name="foto" class="form-control" accept="image/*" id="fotoInput">
                            <small class="text-muted d-block mt-1">
                                <i class="bi bi-info-circle me-1"></i>
                                Upload foto baru jika ingin mengganti (Max 2MB)
                            </small>

                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <img id="preview" src="" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        </div>

                        <!-- Gedung -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-building text-primary me-2"></i>
                                Gedung <span class="text-danger">*</span>
                            </label>
                            <select name="gedung_id" class="form-select" required>
                                <option value="">-- Pilih Gedung --</option>
                                <?php foreach ($gedung as $g): ?>
                                    <option value="<?= $g['id'] ?>" <?= old('gedung_id', $laporan['gedung_id']) == $g['id'] ? 'selected' : '' ?>>
                                        <?= esc($g['kode']) ?> - <?= esc($g['nama']) ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <!-- Prioritas -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-flag-fill text-primary me-2"></i>
                                Prioritas <span class="text-danger">*</span>
                            </label>
                            <select name="prioritas" class="form-select" required>
                                <option value="">-- Pilih Tingkat Prioritas --</option>
                                <option value="low" <?= old('prioritas', $laporan['prioritas']) == 'low' ? 'selected' : '' ?>>
                                    🟢 Low - Tidak Mendesak
                                </option>
                                <option value="medium" <?= old('prioritas', $laporan['prioritas']) == 'medium' ? 'selected' : '' ?>>
                                    🟡 Medium - Perlu Perhatian
                                </option>
                                <option value="high" <?= old('prioritas', $laporan['prioritas']) == 'high' ? 'selected' : '' ?>>
                                    🔴 High - Sangat Mendesak
                                </option>
                            </select>
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-tags-fill text-primary me-2"></i>
                                Kategori Kerusakan <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kategori" class="form-control"
                                value="<?= old('kategori', $laporan['kategori']) ?>"
                                placeholder="Contoh: Listrik, AC, Plafon, dll" required>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between pt-4 border-top mt-4">
                            <a href="<?= site_url('laporan/saya') ?>" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-warning btn-lg px-5 text-white">
                                <i class="bi bi-check-circle-fill me-2"></i>Update Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('fotoInput').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>

<?= $this->endSection() ?>