<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    .report-card {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        max-width: 800px;
        margin: 2rem auto;
    }
</style>

<div class="report-card">
    <h2 class="mb-3 text-center">Form Laporan Kerusakan Fasilitas</h2>

    <form action="<?= site_url('lapor/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- Nama Pelapor -->
        <div class="form-group">
            <label>Nama Pelapor *</label>
            <input type="text" name="nama_pelapor" class="form-control"
                   value="<?= esc(session('nama_pelapor')) ?>" required readonly />
        </div>

        <!-- Lokasi Kerusakan -->
        <div class="form-group">
            <label for="lokasi">Lokasi Kerusakan *</label>
            <select id="lokasi" name="lokasi_kerusakan" class="form-control" required>
                <option value="">Pilih Lokasi</option>
                <option value="Gedung A">Gedung A</option>
                <option value="Gedung B">Gedung B</option>
                <option value="Perpustakaan">Perpustakaan</option>
                <option value="Laboratorium">Laboratorium</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>

        <!-- Lokasi Spesifik -->
        <div class="form-group">
            <label>Lokasi Spesifik *</label>
            <input type="text" name="lokasi_spesifik" class="form-control"
                   placeholder="Contoh: Ruang 101, Lantai 2" required />
        </div>

        <!-- Kategori Kerusakan -->
        <div class="form-group">
            <label>Kategori Kerusakan *</label>
            <select name="kategori_kerusakan" class="form-control" required>
                <option value="">Pilih Kategori</option>
                <option value="listrik">Kelistrikan</option>
                <option value="air">Air / Plumbing</option>
                <option value="ac">AC / Ventilasi</option>
                <option value="furniture">Furniture</option>
                <option value="bangunan">Bangunan</option>
                <option value="lainnya">Lainnya</option>
            </select>
        </div>

        <!-- Tingkat Prioritas -->
        <div class="form-group">
            <label>Tingkat Prioritas *</label>
            <select name="tingkat_prioritas" class="form-control" required>
                <option value="">Pilih Prioritas</option>
                <option value="Rendah">Rendah</option>
                <option value="Sedang">Sedang</option>
                <option value="Tinggi">Tinggi</option>
            </select>
        </div>

        <!-- Deskripsi -->
        <div class="form-group">
            <label>Deskripsi Kerusakan *</label>
            <textarea name="deskripsi_kerusakan" class="form-control" rows="5" required></textarea>
        </div>

        <!-- Upload Foto -->
        <div class="form-group">
            <label>Foto Kerusakan (bisa lebih dari 1)</label>
            <input type="file" name="foto[]" class="form-control" accept="image/*" multiple />
        </div>

        <button type="submit" class="btn" style="width: 100%">Kirim Laporan</button>
    </form>
</div>

<?= $this->endSection() ?>
