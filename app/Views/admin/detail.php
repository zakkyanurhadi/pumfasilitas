<style>
    /* ================================
   DETAIL CARD (OPTIMIZED FOR BOTTOM LAYOUT)
================================ */

    .detail-card {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        font-size: 0.9rem;
        width: 100%;
    }

    /* Header */
    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--gray-200);
    }

    .detail-header h3 {
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
        color: var(--gray-800);
    }

    .detail-header .status-badge {
        font-size: 0.8rem;
        padding: 0.4rem 1rem;
    }

    /* Section titles */
    .detail-card h4 {
        font-size: 0.95rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 1rem;
        margin-top: 1.5rem;
        color: var(--primary-color);
        letter-spacing: 0.5px;
    }

    /* Grid informasi - 2 kolom untuk memanfaatkan space */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem 2rem;
        margin-bottom: 1rem;
    }

    .detail-grid-item {
        display: grid;
        grid-template-columns: 140px 1fr;
        gap: 0.5rem;
        align-items: start;
    }

    .detail-grid dt {
        font-weight: 600;
        color: var(--gray-600);
        font-size: 0.85rem;
    }

    .detail-grid dd {
        margin: 0;
        font-size: 0.9rem;
        color: var(--gray-800);
        font-weight: 500;
    }

    /* Deskripsi */
    .detail-card p {
        font-size: 0.95rem;
        line-height: 1.6;
        color: var(--gray-700);
        margin-bottom: 1rem;
    }

    /* Foto - lebih besar untuk layout bawah */
    .photo-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .photo-gallery img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: var(--border-radius);
        border: 2px solid var(--gray-200);
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .photo-gallery img:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border-color: var(--primary-color);
    }

    /* Buttons */
    .detail-card .btn {
        font-size: 0.9rem !important;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
    }

    .detail-card .btn-warning {
        color: #fff;
    }

    /* Responsive untuk detail card */
    @media (max-width: 768px) {
        .detail-card {
            padding: 1.25rem;
        }

        .detail-grid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .detail-grid-item {
            grid-template-columns: 120px 1fr;
        }

        .photo-gallery {
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        }

        .photo-gallery img {
            height: 100px;
        }

        .detail-header h3 {
            font-size: 1rem;
        }
    }
</style>

<div class="detail-card">
    <div class="d-flex justify-content-between align-items-center mb-3 detail-header">
        <h3>Detail Laporan #<?= esc($detail['id']) ?></h3>
        <?php
        $statusClass = '';
        if ($detail['status'] == 'Pending')
            $statusClass = 'status-pending';
        if ($detail['status'] == 'Diproses')
            $statusClass = 'status-diproses';
        if ($detail['status'] == 'Selesai')
            $statusClass = 'status-selesai';
        if ($detail['status'] == 'Ditolak')
            $statusClass = 'status-ditolak';
        ?>
        <span class="status-badge <?= $statusClass ?>"><?= esc($detail['status']) ?></span>
    </div>

    <h4>Informasi Umum</h4>
    <dl class="detail-grid">
        <dt>Nama Pelapor</dt>
        <dd><?= esc($detail['nama_pelapor'] ?? 'N/A') ?></dd>

        <dt>Username</dt>
        <dd><?= esc($detail['username'] ?? 'N/A') ?></dd>


        <dt>Tanggal Lapor</dt>
        <dd><?= date('d F Y, H:i', strtotime($detail['created_at'])) ?> WIB</dd>
    </dl>

    <h4>Detail Kerusakan</h4>
    <dl class="detail-grid">
        <dt>Gedung</dt>
        <dd><?= esc($detail['nama_gedung'] ?? 'N/A') ?></dd>

        <dt>Ruangan</dt>
        <dd><?= esc($detail['nama_ruangan'] ?? 'N/A') ?></dd>

        <dt>Lokasi Spesifik</dt>
        <dd><?= esc($detail['lokasi_spesifik'] ?? 'N/A') ?></dd>

        <dt>Kategori</dt>
        <dd><?= esc($detail['kategori']) ?></dd>

        <dt>Prioritas</dt>
        <dd><?= esc($detail['prioritas'] ?? 'Normal') ?></dd>
    </dl>

    <h4>Deskripsi Kerusakan</h4>
    <p><?= nl2br(esc($detail['deskripsi'])) ?></p>

    <?php
    // Handle both JSON array and single string for foto_kerusakan
    $foto_data = $detail['foto'];
    if (is_string($foto_data)) {
        // Attempt to decode as JSON array
        $foto = json_decode($foto_data, true);
        // If decoding failed or result is not an array, treat it as a single file string
        if (!is_array($foto)) {
            $foto = [$foto_data];
        }
    } else {
        $foto = (array) $foto_data;
    }
    ?>

    <?php if (count(array_filter($foto)) > 0): ?>
        <h4>Foto Kerusakan</h4>
        <div class="photo-gallery">
            <?php foreach (array_filter($foto) as $img): ?>
                <?php $path = 'uploads/laporan/' . $img; ?>
                <?php $imgUrl = strpos($img, 'http') === 0 ? esc($img) : base_url($path); ?>
                <img src="<?= $imgUrl ?>" alt="Foto Kerusakan" title="Klik untuk melihat lebih besar"
                    onclick="openLightbox('<?= $imgUrl ?>')">
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($detail['keterangan_verifikasi'])): ?>
        <h4>Informasi Verifikasi</h4>
        <dl class="detail-grid">
            <dt>Status Verifikasi</dt>
            <dd><?= esc($detail['status']) ?></dd>
            <dt>Tanggal Verifikasi</dt>
            <dd><?= date('d F Y, H:i', strtotime($detail['tanggal_verifikasi'] ?? $detail['updated_at'])) ?> WIB</dd>
            <dt>Verifikator</dt>
            <dd><?= esc($detail['verifikator'] ?? 'Admin') ?></dd>
            <dt>Keterangan</dt>
            <dd><?= nl2br(esc($detail['keterangan_verifikasi'])) ?></dd>
        </dl>
    <?php endif; ?>

    <div style="display: flex; gap: 1rem; margin-top: 2rem; justify-content: flex-end;">
        <a href="<?= current_url() . '?keyword=' . esc($keyword ?? '') . '&status_filter=' . esc($statusFilter ?? '') . '&page=' . esc($currentPage ?? 1) ?>"
            class="btn btn-secondary">Tutup</a>
        <a href="#" onclick="openReportModalAdmin(<?= esc($detail['id']) ?>)" class="btn btn-warning">Verifikasi</a>
    </div>
</div>

<!-- Lightbox Modal for Photo -->
<div id="photoLightbox" class="photo-lightbox" onclick="closeLightbox(event)">
    <span class="lightbox-close" onclick="closeLightbox(event)">&times;</span>
    <img id="lightboxImage" src="" alt="Foto Kerusakan">
    <div class="lightbox-caption">Klik di luar gambar untuk menutup</div>
</div>

<style>
    /* Lightbox Modal Styles */
    .photo-lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 10000;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        padding: 20px;
        box-sizing: border-box;
    }

    .photo-lightbox.active {
        display: flex;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .photo-lightbox img {
        max-width: 90%;
        max-height: 85vh;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 10px 50px rgba(0, 0, 0, 0.5);
        animation: zoomIn 0.3s ease;
    }

    @keyframes zoomIn {
        from {
            transform: scale(0.8);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 40px;
        color: #fff;
        cursor: pointer;
        z-index: 10001;
        transition: color 0.2s ease, transform 0.2s ease;
        line-height: 1;
    }

    .lightbox-close:hover {
        color: #ff6b6b;
        transform: scale(1.1);
    }

    .lightbox-caption {
        color: rgba(255, 255, 255, 0.7);
        margin-top: 15px;
        font-size: 14px;
    }

    /* Photo gallery cursor update */
    .photo-gallery img {
        cursor: zoom-in;
    }
</style>

<script>
    function openLightbox(imageSrc) {
        const lightbox = document.getElementById('photoLightbox');
        const lightboxImage = document.getElementById('lightboxImage');

        lightboxImage.src = imageSrc;
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closeLightbox(event) {
        // Only close if clicking on the background or close button, not the image
        if (event.target.id === 'photoLightbox' || event.target.classList.contains('lightbox-close')) {
            const lightbox = document.getElementById('photoLightbox');
            lightbox.classList.remove('active');
            document.body.style.overflow = ''; // Restore scrolling
        }
    }

    // Close lightbox with Escape key
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            const lightbox = document.getElementById('photoLightbox');
            if (lightbox.classList.contains('active')) {
                lightbox.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    });
</script>