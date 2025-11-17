<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="welcome-section" id="home">
    <h1>Sistem Laporan Kerusakan Fasilitas Kampus jelek</h1>
    <p>
        Selamat datang, <strong><?= esc($user['nama']) ?></strong>! Laporkan kerusakan fasilitas kampus dengan mudah dan cepat.
    </p>
</section>

<section class="stats-section" id="status">
    <h2 class="text-center mb-3">Statistik Laporan</h2>
    <div class="stats-grid">
        <div class="stat-card">
            <span class="number" id="totalLaporan"><?= esc($stats['total']) ?></span>
            <span class="label">Total Laporan</span>
        </div>
        <div class="stat-card">
            <span class="number text-warning" id="pending"><?= esc($stats['pending']) ?></span>
            <span class="label">Pending</span>
        </div>
        <div class="stat-card">
            <span class="number text-success" id="sedangDiproses"><?= esc($stats['diproses']) ?></span>
            <span class="label">Sedang Diproses</span>
        </div>
        <div class="stat-card">
            <span class="number text-danger" id="selesai"><?= esc($stats['selesai']) ?></span>
            <span class="label">Selesai</span>
        </div>
    </div>
</section>

<div class="menu-grid" id="laporan">
    <div class="menu-card" onclick="openReportModal()">
        <div class="icon"><i class="fas fa-plus-circle"></i></div>
        <h3>Buat Laporan Baru</h3>
        <p>Laporkan kerusakan fasilitas kampus yang Anda temukan.</p>
        <button class="btn">Laporkan Sekarang</button>
    </div>
    <div class="menu-card" onclick="showReportsList()">
        <div class="icon"><i class="fas fa-list-alt"></i></div>
        <h3>Lihat Status Laporan</h3>
        <p>Cek status perbaikan dari laporan yang telah Anda buat.</p>
        <button class="btn btn-secondary">Lihat Status</button>
    </div>
    <div class="menu-card" onclick="showHistory()">
        <div class="icon"><i class="fas fa-history"></i></div>
        <h3>Riwayat Laporan</h3>
        <p>Lihat semua laporan yang pernah dibuat sebelumnya.</p>
        <button class="btn btn-secondary">Lihat Riwayat</button>
    </div>
</div>

<div id="reportModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeReportModal()">&times;</span>
        <h2 class="mb-3">Laporan Kerusakan Fasilitas</h2>

        <form id="reportForm" action="<?= site_url('lapor/store') ?>" method="post" enctype="multipart/form-data">
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
                    <option value="lainnya" <?= old('lokasi') == 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
                </select>
            </div>

            <div class="form-group">
                <label for="lokasiSpesifik">Lokasi Spesifik *</label>
                <input type="text" id="lokasiSpesifik" name="lokasiSpesifik" class="form-control" placeholder="Contoh: Ruang 101, Lantai 2" value="<?= old('lokasiSpesifik') ?>" required />
            </div>

            <div class="form-group">
                <label for="kategori">Kategori Kerusakan *</label>
                <select id="kategori" name="kategori" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    <option value="listrik" <?= old('kategori') == 'listrik' ? 'selected' : '' ?>>Kelistrikan</option>
                    <option value="air" <?= old('kategori') == 'air' ? 'selected' : '' ?>>Air/Plumbing</option>
                    <option value="lainnya" <?= old('kategori') == 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
                </select>
            </div>

            <div class="form-group">
                <label for="prioritas">Tingkat Prioritas *</label>
                <select id="prioritas" name="prioritas" class="form-control" required>
                    <option value="">Pilih Prioritas</option>
                    <option value="rendah" <?= old('prioritas') == 'rendah' ? 'selected' : '' ?>>Rendah - Tidak mengganggu</option>
                    <option value="sedang" <?= old('prioritas') == 'sedang' ? 'selected' : '' ?>>Sedang - Sedikit mengganggu</option>
                    <option value="tinggi" <?= old('prioritas') == 'tinggi' ? 'selected' : '' ?>>Tinggi - Mengganggu aktivitas</option>
                </select>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi Kerusakan *</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" placeholder="Jelaskan secara detail..." required><?= old('deskripsi') ?></textarea>
            </div>

            <div class="form-group">
                <label for="foto">Foto Kerusakan (Opsional, max: 2MB)</label>
                <div class="file-input">
                    <input type="file" id="foto" name="foto[]" accept="image/*" multiple />
                    <label for="foto" class="file-input-label"><i class="fas fa-camera"></i> Pilih Foto</label>
                    <span id="fileName" class="text-secondary"></span>
                </div>
                <div id="imagePreviewContainer" class="image-preview-container"></div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn" style="width: 100%">Kirim Laporan</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>