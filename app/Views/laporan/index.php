<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <h3 class="mb-4"><?= esc($title) ?></h3>

    <!-- Flash Error -->
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('laporan/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- Lokasi Kerusakan -->
        <div class="mb-3">
            <label class="form-label">Lokasi Kerusakan</label>
            <input type="text" name="lokasi_kerusakan" class="form-control"
                value="<?= old('lokasi_kerusakan') ?>" required>
        </div>

        <!-- Lokasi Spesifik -->
        <div class="mb-3">
            <label class="form-label">Lokasi Spesifik</label>
            <input type="text" name="lokasi_spesifik" class="form-control"
                value="<?= old('lokasi_spesifik') ?>" required>
        </div>

        <!-- Gedung -->
        <div class="mb-3">
            <label class="form-label">Gedung</label>
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

        <!-- Ruangan -->
        <div class="mb-3">
            <label class="form-label">Ruangan</label>
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

        <!-- Kategori -->
        <div class="mb-3">
            <label class="form-label">Kategori Kerusakan</label>
            <input type="text" name="kategori" class="form-control"
                value="<?= old('kategori') ?>" required>
        </div>

        <!-- Prioritas -->
        <div class="mb-3">
            <label class="form-label">Prioritas</label>
            <select name="prioritas" class="form-select" required>
                <option value="">-- Pilih Prioritas --</option>
                <option value="low" <?= old('prioritas') == 'low' ? 'selected' : '' ?>>Low</option>
                <option value="medium" <?= old('prioritas') == 'medium' ? 'selected' : '' ?>>Medium</option>
                <option value="high" <?= old('prioritas') == 'high' ? 'selected' : '' ?>>High</option>
            </select>
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
            <label class="form-label">Deskripsi Kerusakan</label>
            <textarea name="deskripsi" rows="4" class="form-control" required><?= old('deskripsi') ?></textarea>
        </div>

        <!-- Foto -->
        <div class="mb-3">
            <label class="form-label">Foto (Opsional)</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
            <small class="text-muted">Max 2MB (JPG, JPEG, PNG)</small>
        </div>

        <!-- Submit -->
        <div class="d-flex justify-content-between">
            <a href="<?= site_url('dashboard') ?>" class="btn btn-secondary">
                Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                Kirim Laporan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>