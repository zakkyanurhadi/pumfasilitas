<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="welcome-section" id="home">
    <h1>Sistem Laporan Kerusakan Fasilitas Kampus</h1>
    <p>
        Selamat datang, <strong><?= esc($user['nama']) ?></strong>! Laporkan kerusakan fasilitas kampus dengan mudah dan cepat.
    </p>
</section>

<section class="stats-section" id="status">
    <h2 class="text-center mb-3">Statistik Laporan</h2>
    <div class="stats-grid">
        <div class="stat-card">
            <span class="number"><?= esc($stats['total']) ?></span>
            <span class="label">Total Laporan</span>
        </div>
        <div class="stat-card">
            <span class="number text-warning"><?= esc($stats['pending']) ?></span>
            <span class="label">Pending</span>
        </div>
        <div class="stat-card">
            <span class="number text-success"><?= esc($stats['diproses']) ?></span>
            <span class="label">Sedang Diproses</span>
        </div>
        <div class="stat-card">
            <span class="number text-danger"><?= esc($stats['selesai']) ?></span>
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
        <p>Cek status laporan yang telah Anda buat.</p>
        <button class="btn btn-secondary">Lihat Status</button>
    </div>
    <div class="menu-card" onclick="showHistory()">
        <div class="icon"><i class="fas fa-history"></i></div>
        <h3>Riwayat Laporan</h3>
        <p>Lihat laporan sebelumnya.</p>
        <button class="btn btn-secondary">Lihat Riwayat</button>
    </div>
</div>

<div id="reportModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeReportModal()">&times;</span>
        <h2 class="mb-3">Laporan Kerusakan Fasilitas</h2>

            <form action="<?= site_url('lapor/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <!-- Nama Pelapor -->
                <div class="form-group">
                    <label>Nama Pelapor *</label>
                    <input type="text" name="nama_pelapor" class="form-control"
                        value="<?= esc(session('nama')) ?>" readonly required>
                </div>

                <!-- Gedung -->
                <div class="form-group">
                    <label>Gedung *</label>
                    <select name="gedung_id" class="form-control" required>
                        <option value="">Pilih Gedung</option>
                        <?php foreach ($gedung as $g): ?>
                            <option value="<?= $g['id_gedung'] ?>">
                                <?= esc($g['nama_gedung']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Ruangan -->
                <div class="form-group">
                    <label>Ruangan *</label>
                    <select name="ruangan_id" class="form-control" required>
                        <option value="">Pilih Ruangan</option>
                        <?php foreach ($ruangan as $r): ?>
                            <option value="<?= $r['id_ruangan'] ?>">
                                <?= esc($r['nama_ruangan']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Lokasi Kerusakan -->
                <div class="form-group">
                    <label>Lokasi Kerusakan *</label>
                    <input type="text" class="form-control" name="lokasi_kerusakan" required>
                </div>

                <!-- Lokasi Spesifik -->
                <div class="form-group">
                    <label>Lokasi Spesifik *</label>
                    <input type="text" name="lokasi_spesifik" class="form-control" required>
                </div>

                <!-- Kategori -->
                <div class="form-group">
                    <label>Kategori *</label>
                    <select name="kategori" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        <option value="listrik">Listrik</option>
                        <option value="air">Air / Plumbing</option>
                        <option value="ac">AC / Ventilasi</option>
                        <option value="furniture">Furniture</option>
                        <option value="bangunan">Bangunan</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <!-- Prioritas -->
                <div class="form-group">
                    <label>Prioritas *</label>
                    <select name="prioritas" class="form-control" required>
                        <option value="Rendah">Rendah</option>
                        <option value="Sedang">Sedang</option>
                        <option value="Tinggi">Tinggi</option>
                    </select>
                </div>

                <!-- Deskripsi -->
                <div class="form-group">
                    <label>Deskripsi *</label>
                    <textarea name="deskripsi" class="form-control" required></textarea>
                </div>

                <!-- Foto -->
                <div class="form-group">
                    <label>Foto Kerusakan</label>
                    <input type="file" name="foto[]" accept="image/*" multiple class="form-control">
                </div>

                <button type="submit" class="btn" style="width:100%">Kirim Laporan</button>
            </form>

    </div>
</div>

<?= $this->endSection() ?>
