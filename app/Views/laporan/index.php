<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9">

            <!-- HEADER -->
            <div class="page-header mb-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-wrap">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div>
                        <h4 class="mb-0"><?= esc($title) ?></h4>
                        <small class="text-muted">
                            Laporkan kerusakan fasilitas untuk ditindaklanjuti
                        </small>
                    </div>
                </div>
            </div>

            <!-- ERROR -->
            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger small shadow-sm">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 ps-3 mt-2">
                        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- FORM CARD -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">

                    <form action="<?= site_url('laporan/store') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <!-- IDENTITAS -->
                        <div class="form-group">
                            <h6 class="form-title">Identitas Pelapor</h6>

                            <label class="form-label">Nama Pelapor <span>*</span></label>
                            <input type="text" name="nama_pelapor" class="form-control"
                                value="<?= old('nama_pelapor') ?>" required>
                        </div>

                        <!-- LOKASI -->
                        <div class="form-group">
                            <h6 class="form-title">Lokasi Kerusakan</h6>

                            <label class="form-label">Lokasi Umum <span>*</span></label>
                            <input type="text" name="lokasi_kerusakan" class="form-control"
                                value="<?= old('lokasi_kerusakan') ?>" required>

                            <label class="form-label mt-3">Lokasi Spesifik <span>*</span></label>
                            <input type="text" name="lokasi_spesifik" class="form-control"
                                value="<?= old('lokasi_spesifik') ?>" required>

                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <label class="form-label">Gedung <span>*</span></label>
                                    <select name="gedung_id" class="form-select" required>
                                        <option value="">Pilih Gedung</option>
                                        <?php foreach ($gedung as $g) : ?>
                                            <option value="<?= $g['id'] ?>" <?= old('gedung_id') == $g['id'] ? 'selected' : '' ?>>
                                                <?= esc($g['nama']) ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Ruangan <span>*</span></label>
                                    <select name="ruangan_id" class="form-select" required>
                                        <option value="">Pilih Ruangan</option>
                                        <?php foreach ($ruangan as $r) : ?>
                                            <option value="<?= $r['id'] ?>" <?= old('ruangan_id') == $r['id'] ? 'selected' : '' ?>>
                                                <?= esc($r['nama_ruangan']) ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- DETAIL -->
                        <div class="form-group">
                            <h6 class="form-title">Detail Kerusakan</h6>

                            <label class="form-label">Deskripsi <span>*</span></label>
                            <textarea name="deskripsi" rows="4" class="form-control" required><?= old('deskripsi') ?></textarea>

                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label class="form-label">Kategori <span>*</span></label>
                                    <input type="text" name="kategori" class="form-control"
                                        value="<?= old('kategori') ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Prioritas <span>*</span></label>
                                    <select name="prioritas" class="form-select" required>
                                        <option value="">Pilih Prioritas</option>
                                        <option value="low" <?= old('prioritas') == 'low' ? 'selected' : '' ?>>🟢 Low</option>
                                        <option value="medium" <?= old('prioritas') == 'medium' ? 'selected' : '' ?>>🟡 Medium</option>
                                        <option value="high" <?= old('prioritas') == 'high' ? 'selected' : '' ?>>🔴 High</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- FOTO -->
                        <div class="form-group">
                            <h6 class="form-title">Foto Pendukung</h6>

                            <input type="file" name="foto" class="form-control" id="fotoInput">

                            <div id="imagePreview" class="mt-3 d-none">
                                <img id="preview" class="img-thumbnail rounded-3" style="max-height:180px">
                            </div>
                        </div>

                        <!-- ACTION -->
                        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                            <a href="<?= site_url('dashboard') ?>" class="btn btn-light px-4">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-5">
                                Kirim Laporan
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.getElementById('fotoInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran maksimal 2MB');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            imagePreview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    });
</script>

<style>
    .page-header {
        padding: 1.2rem 1.5rem;
        background: #f8fafc;
        border-radius: 0.75rem;
    }

    .icon-wrap {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #0d6efd;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .form-group {
        margin-bottom: 3rem;
    }

    .form-title {
        font-weight: 600;
        margin-bottom: 1.2rem;
        color: #0f172a;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: .5rem;
    }

    .form-label {
        font-size: .875rem;
        font-weight: 500;
        margin-bottom: .4rem;
        color: #334155;
    }

    .form-label span {
        color: #ef4444;
    }

    .form-control,
    .form-select {
        height: 44px;
        border-radius: .55rem;
    }

    textarea.form-control {
        height: auto;
    }

    .form-control:focus,
    .form-select:focus {
        box-shadow: 0 0 0 .15rem rgba(13,110,253,.2);
    }
</style>

<?= $this->endSection() ?>
