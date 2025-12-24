<?= $this->extend('layouts/main') ?>


<title>Sistem Pengaduan Fasilitas - Polinela</title>

<?= $this->section('styles') ?>
<style>
    /* === HERO SECTION === */
    .hero-section {
        position: relative;
        height: 100vh;
        min-height: 600px;
        display: flex;
        align-items: center;
        color: white;
        /* Pastikan file Polinela.png ada di folder public/assets/ */
        background: url('<?= base_url("assets/polinela6.webp") ?>') no-repeat center center/cover;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(14, 62, 180, 0.9) 0%, rgba(0, 0, 0, 0.75) 100%);
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 1.5rem;
    }

    .hero-desc {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 2.5rem;
        max-width: 600px;
        font-weight: 300;
    }

    .btn-hero {
        padding: 1rem 2.5rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 12px;
        border: none;
        transition: 0.3s;
    }

    .btn-primary-custom {
        background: white;
        color: var(--primary-blue);
    }

    .btn-primary-custom:hover {
        background: rgba(9, 92, 162);
        transform: translateY(-3px);
    }

    .btn-outline-custom {
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        margin-left: 10px;
    }

    .btn-outline-custom:hover {
        border-color: white;
        background: rgba(255, 255, 255, 0.1);
    }

    /* === CARDS FITUR === */
    .info-cards {
        margin-top: -80px;
        position: relative;
        z-index: 3;
        padding-bottom: 4rem;
    }

    .feature-card {
        background: white;
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        border-bottom: 5px solid var(--primary-blue);
        transition: 0.3s;
        height: 100%;
    }

    .feature-card:hover {
        transform: translateY(-10px);
    }

    .icon-box {
        width: 60px;
        height: 60px;
        background: rgba(44, 94, 243, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-blue);
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }

    /* === BARU: ALUR LAPOR DENGAN GARIS === */
    .steps-section {
        padding: 6rem 0;
        background: white;
    }

    /* Wrapper untuk garis horizontal */
    .steps-timeline {
        position: relative;
        margin-top: 3rem;
    }

    /* Garis Horizontal di belakang ikon */
    .steps-timeline::before {
        content: '';
        position: absolute;
        top: 35px;
        /* Posisi vertikal garis (tengah ikon) */
        left: 15%;
        /* Mulai garis setelah ikon pertama */
        right: 15%;
        /* Berhenti sebelum ikon terakhir */
        height: 2px;
        background-color: #e2e8f0;
        /* Warna garis abu-abu terang */
        z-index: 0;
        /* Posisi di belakang ikon */
    }

    /* Item per langkah */
    .process-step {
        position: relative;
        text-align: center;
        z-index: 1;
        /* Pastikan ikon di atas garis */
        padding: 0 1rem;
    }

    /* Desain Ikon Bulat */
    .step-icon {
        width: 70px;
        height: 70px;
        background: var(--primary-blue);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem auto;
        font-size: 1.5rem;
        /* Efek border ganda agar terlihat seperti "mengambang" di atas garis */
        box-shadow: 0 0 0 5px white, 0 0 0 8px var(--primary-blue);
        transition: all 0.3s ease;
    }

    .process-step:hover .step-icon {
        transform: scale(1.05);
        box-shadow: 0 0 0 5px white, 0 0 0 10px var(--dark-blue);
        background: var(--dark-blue);
    }

    .step-title {
        font-weight: 700;
        margin-bottom: 0.8rem;
        font-size: 1.1rem;
    }

    .step-desc {
        color: var(--text-grey);
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* === STATISTIK === */
    .stats-section {
        padding: 5rem 0;
        background: var(--bg-light);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-blue);
    }

    .stat-label {
        color: var(--text-grey);
        font-weight: 500;
    }

    /* === FOOTER === */
    footer {
        background: #1a202c;
        color: white;
        padding: 4rem 0 2rem;
    }

    .footer-link {
        color: #a0aec0;
        text-decoration: none;
        margin-bottom: 10px;
        display: block;
    }

    .footer-link:hover {
        color: white;
    }

    /* === RESPONSIVE === */
    @media (max-width: 992px) {

        /* Sembunyikan garis horizontal di Tablet/HP agar tidak berantakan */
        .steps-timeline::before {
            display: none;
        }

        .process-step {
            margin-bottom: 3rem;
        }

        /* Tambah jarak vertikal */
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.2rem;
        }

        .info-cards {
            margin-top: 2rem;
        }

        .btn-hero {
            width: 100%;
            margin-bottom: 10px;
            margin-left: 0;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<body>

    <section class="hero-section" id="beranda">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="hero-title"><span id="typed-text"></span></h1>
                    <p class="hero-desc">
                        Wujudkan lingkungan belajar yang nyaman di Politeknik Negeri Lampung.
                        Laporkan kerusakan fasilitas kampus secara online, cepat, dan transparan.
                    </p>
                    <div class="d-flex flex-column flex-md-row gap-2">
                        <?php if (session()->get('isLoggedIn')): ?>
                            <div class="tooltip-wrap">
                                <a href="<?= site_url('laporan') ?>" class="btn btn-hero btn-primary-custom shadow">
                                    <i class="fas fa-plus-circle me-2"></i> Buat Laporan Baru
                                </a>
                                <span class="tooltip-text">Mulai membuat laporan</span>
                            </div>
                        <?php else: ?>

                            <div class="tooltip-wrap">
                                <a href="<?= site_url('login') ?>" class="btn btn-hero btn-primary-custom shadow">
                                    <i class="fas fa-paper-plane me-2"></i> Lapor Sekarang
                                </a>
                                <span class="tooltip-text">Mulai membuat laporan</span>
                            </div>
                        <?php endif; ?>
                        <div class="tooltip-wrap">
                            <a href="#alur" class="btn btn-hero btn-outline-custom">
                                <i class="fas fa-info-circle me-2"></i> Cara Kerja
                            </a>
                            <span class="tooltip-text">Klik untuk melihat cara kerja</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container info-cards">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon-box"><i class="fas fa-bolt"></i></div>
                    <h5>Respon Cepat</h5>
                    <p class="text-muted small">Laporan Anda langsung diteruskan ke unit pemeliharaan terkait untuk
                        segera ditindaklanjuti.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon-box"><i class="fas fa-search-location"></i></div>
                    <h5>Pelacakan Real-time</h5>
                    <p class="text-muted small">Pantau status pengerjaan laporan kerusakan Anda secara transparan
                        melalui dashboard.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="icon-box"><i class="fas fa-check-circle"></i></div>
                    <h5>Tuntas & Terukur</h5>
                    <p class="text-muted small">Setiap perbaikan didokumentasikan. Anda bisa memberikan feedback setelah
                        pengerjaan selesai.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="steps-section" id="alur">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="text-primary fw-bold text-uppercase ls-2">Alur Pengaduan</h6>
                <h2 class="fw-bold display-6">Bagaimana Cara Melapor?</h2>
            </div>

            <div class="steps-timeline">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="process-step">
                            <div class="step-icon">
                                <i class="fas fa-sign-in-alt"></i>
                            </div>
                            <h5 class="step-title">1. Login Akun</h5>
                            <p class="step-desc">Masuk menggunakan akun mahasiswa atau dosen Polinela Anda untuk
                                memulai.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="process-step">
                            <div class="step-icon">
                                <i class="fas fa-file-signature"></i>
                            </div>
                            <h5 class="step-title">2. Isi Laporan</h5>
                            <p class="step-desc">Foto kerusakan, pilih lokasi gedung, dan berikan deskripsi singkat.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="process-step">
                            <div class="step-icon">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <h5 class="step-title">3. Proses Verifikasi</h5>
                            <p class="step-desc">Admin memvalidasi laporan Anda dan menugaskan teknisi terkait.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="process-step">
                            <div class="step-icon">
                                <i class="fas fa-check-double"></i>
                            </div>
                            <h5 class="step-title">4. Selesai</h5>
                            <p class="step-desc">Fasilitas diperbaiki. Anda akan menerima notifikasi status laporan
                                selesai.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stats-section" id="statistik">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="stat-number"><?= esc($stats['total']) ?></div>
                    <div class="stat-label">Laporan Masuk</div>
                </div>
                <div class="col-md-4">
                    <div class="stat-number"><?= esc($stats['selesai']) ?></div>
                    <div class="stat-label">Selesai</div>
                </div>
                <div class="col-md-4">
                    <div class="stat-number">24 Jam</div>
                    <div class="stat-label">Rata-rata Respon</div>
                </div>
            </div>
        </div>
    </section>

</body>
<!-- JavaScript untuk efek typewriter -->
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
<script>
    // Typewriter effect untuk hero section
    function initTypewriter() {
        const typed = new Typed('#typed-text', {
            strings: [
                'Layanan Aspirasi!',
                'Pengaduan Fasilitas Kampus!',
                'Suarakan Kerusakan Fasilitas!',
                'Percepat Perbaikan Kampus!',
                'Jaga Lingkungan Bersama!',
                'Wujudkan Kampus Nyaman!',
                'Tumbuh Berkembang Bersama!'
            ],
            typeSpeed: 60,
            backSpeed: 40,
            backDelay: 2000,
            loop: true,
            showCursor: true,
            cursorChar: '|'
        });
    }

    // Inisialisasi efek typewriter saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function () {
        initTypewriter();
    });
</script>
<?= $this->endSection() ?>

</html>