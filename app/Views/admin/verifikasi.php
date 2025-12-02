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
    <p class="text-secondary text-center mb-3">
        Silakan isi form di bawah ini dengan detail kerusakan yang Anda temukan.
    </p>

    <form action="<?= site_url('lapor') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="nama">Nama Pelapor *</label>
            <input type="text" id="nama" name="nama" class="form-control" value="<?= esc(session('nama')) ?>" required readonly />
        </div>

        <div class="form-group">
            <label for="npm">NPM *</label>
            <input type="text" id="npm" name="npm" class="form-control" value="<?= esc(session('npm')) ?>" required readonly />
        </div>

        <div class="form-group">
            <label for="lokasi">Lokasi Kerusakan *</label>
            <select id="lokasi" name="lokasi" class="form-control" required>
                <option value="">Pilih Lokasi</option>
                <option value="gedung-a" <?= old('lokasi') == 'gedung-a' ? 'selected' : '' ?>>Gedung A</option>
                <option value="gedung-b" <?= old('lokasi') == 'gedung-b' ? 'selected' : '' ?>>Gedung B</option>
                <option value="laboratorium" <?= old('lokasi') == 'laboratorium' ? 'selected' : '' ?>>Laboratorium</option>
                <option value="perpustakaan" <?= old('lokasi') == 'perpustakaan' ? 'selected' : '' ?>>Perpustakaan</option>
                <option value="lainnya" <?= old('lokasi') == 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
            </select>
        </div>

        <div class="form-group">
            <label for="lokasiSpesifik">Lokasi Spesifik *</label>
            <input type="text" id="lokasiSpesifik" name="lokasiSpesifik" class="form-control" placeholder="Contoh: Ruang 101, Lantai 2, dekat jendela" value="<?= old('lokasiSpesifik') ?>" required />
        </div>

        <div class="form-group">
            <label for="kategori">Kategori Kerusakan *</label>
            <select id="kategori" name="kategori" class="form-control" required>
                <option value="">Pilih Kategori</option>
                <option value="listrik" <?= old('kategori') == 'listrik' ? 'selected' : '' ?>>Kelistrikan (Lampu, Stop Kontak)</option>
                <option value="air" <?= old('kategori') == 'air' ? 'selected' : '' ?>>Air/Plumbing (Keran, Toilet)</option>
                <option value="ac" <?= old('kategori') == 'ac' ? 'selected' : '' ?>>AC/Ventilasi</option>
                <option value="furniture" <?= old('kategori') == 'furniture' ? 'selected' : '' ?>>Furniture (Meja, Kursi)</option>
                <option value="bangunan" <?= old('kategori') == 'bangunan' ? 'selected' : '' ?>>Struktur Bangunan (Dinding, Atap)</option>
                <option value="lainnya" <?= old('kategori') == 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
            </select>
        </div>

        <div class="form-group">
            <label for="prioritas">Tingkat Prioritas *</label>
            <select id="prioritas" name="prioritas" class="form-control" required>
                <option value="">Pilih Prioritas</option>
                <option value="Rendah" <?= old('prioritas') == 'Rendah' ? 'selected' : '' ?>>Rendah - Tidak mengganggu</option>
                <option value="Sedang" <?= old('prioritas') == 'Sedang' ? 'selected' : '' ?>>Sedang - Sedikit mengganggu</option>
                <option value="Tinggi" <?= old('prioritas') == 'Tinggi' ? 'selected' : '' ?>>Tinggi - Sangat mengganggu/Berbahaya</option>
            </select>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi Kerusakan *</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control" placeholder="Jelaskan secara detail kerusakan yang ditemukan..." required rows="5"><?= old('deskripsi') ?></textarea>
        </div>

        <div class="form-group">
            <label for="foto">Foto Kerusakan (Opsional, max: 2MB per file)</label>
            <input type="file" class="form-control" id="foto" name="foto[]" accept="image/*" multiple />
        </div>

        <div class="form-group">
            <button type="submit" class="btn" style="width: 100%">Kirim Laporan</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>