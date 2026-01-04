<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= base_url('favicon.ico') ?>">
    <title><?= isset($title) ? esc($title) . ' - ' : '' ?>E-Fasilitas - Polinela</title>

    <!-- CSS Core -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Hanya gunakan satu versi Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Custom CSS (Versioned) -->
    <link rel="stylesheet"
        href="<?= base_url('assets/css/user-style.css?v=' . filemtime(FCPATH . 'assets/css/user-style.css')) ?>">

    <!-- SweetAlert2 Local CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/sweetalert2.css') ?>">

    <style>
        /* Optimasi Toast Position */
        body.swal2-toast-shown .swal2-container.swal2-top-end,
        body.swal2-toast-shown .swal2-container.swal2-top-right {
            top: 75px !important;
            right: 20px !important;
        }

        /* Toast Lebih Ringan (Tanpa Shadow Berat & Animasi Kompleks) */
        .swal2-popup.swal2-toast {
            font-family: 'Poppins', sans-serif !important;
            padding: 0.5rem 1rem !important;
            border-radius: 8px !important;
            /* Radius lebih sederhana */
            font-size: 0.9rem !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
            /* Shadow ringan */
        }

        .swal2-title {
            font-weight: 500 !important;
            color: #333 !important;
        }

        /* Pulse Animation: Hanya Sekali (0.5s) agar tidak makan CPU */
        @keyframes pulse-once {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1);
            }
        }

        .badge-pulse {
            animation: pulse-once 0.5s ease-out;
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>

<body class="d-flex flex-column min-vh-100">

    <?= $this->include('partials/header') ?>

    <main class="flex-fill">
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->include('partials/footer') ?>

    <!-- Script ditaruh di bawah agar rendering HTML diprioritaskan -->
    <script src="<?= base_url('assets/js/sweetalert2.all.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Navbar Shadow on Scroll
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('.navbar');
            if (nav) nav.classList.toggle('shadow', window.scrollY > 50);
        }, { passive: true }); // Passive listener untuk performa scroll

        // === NOTIFIKASI SYSTEM OPTIMIZED ===
        let lastUnreadCount = -1;
        let audioContextUnlocked = false;

        const notifSound = new Audio('<?= base_url("assets/audio/text_message.mp3") ?>');

        // Unlock Audio
        document.body.addEventListener('click', () => {
            if (!audioContextUnlocked) {
                notifSound.play().then(() => {
                    notifSound.pause();
                    notifSound.currentTime = 0;
                    audioContextUnlocked = true;
                }).catch(() => { });
            }
        }, { once: true });

        // Request Permission
        if ("Notification" in window && Notification.permission !== "granted" && Notification.permission !== "denied") {
            Notification.requestPermission();
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateNotificationBadge();
            // Polling diperlambat ke 15 Detik (Sangat mengurangi beban CPU)
            setInterval(updateNotificationBadge, 15000);
        });

        // Definisi Toast Global Ringan (Tanpa Progress Bar)
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: false, // MATIKAN Progress Bar (Penyebab lag animasi)
            showClass: { popup: '' }, // Matikan animasi zoom in/out Swal yang berat
            hideClass: { popup: '' }  // Matikan animasi fade out Swal yang berat
        });

        function updateNotificationBadge() {
            fetch('<?= site_url('notifikasi/unread-count') ?>')
                .then(r => r.json())
                .then(data => {
                    const badge = document.getElementById('notifBadge');
                    const count = document.getElementById('notifCount');
                    const currentCount = parseInt(data.count) || 0;

                    if (badge && count) {
                        if (currentCount > 0) {
                            count.textContent = currentCount > 99 ? '99+' : currentCount;
                            badge.style.display = 'block';

                            // Animasi Pulse hanya jika jumlah berubah (Hemat CPU)
                            if (currentCount !== lastUnreadCount && lastUnreadCount !== -1) {
                                badge.classList.remove('badge-pulse');
                                void badge.offsetWidth; // Trigger reflow
                                badge.classList.add('badge-pulse');
                            }
                        } else {
                            badge.style.display = 'none';
                        }
                    }

                    if (lastUnreadCount !== -1 && currentCount > lastUnreadCount) {
                        const selisih = currentCount - lastUnreadCount;

                        // Audio
                        notifSound.currentTime = 0;
                        notifSound.play().catch(() => { });

                        // Desktop Notif
                        if ("Notification" in window && Notification.permission === "granted") {
                            const n = new Notification("Update Laporan", {
                                body: "Status laporan Anda telah diperbarui.",
                                icon: '<?= base_url("favicon.ico") ?>',
                                tag: 'notif-user'
                            });
                            n.onclick = () => { window.focus(); window.location.href = '<?= site_url("notifikasi") ?>'; this.close(); };
                        }

                        // Simple Toast
                        Toast.fire({
                            icon: 'info',
                            title: 'Status laporan diperbarui'
                        });
                    }
                    lastUnreadCount = currentCount;
                })
                .catch(() => { }); // Silent catch agar tidak flood console
        }

        // Dropdown Handling
        function toggleDropdown() {
            const d = document.getElementById("profileDropdown");
            if (d) d.style.display = d.style.display === "block" ? "none" : "block";
        }

        window.addEventListener('click', (e) => {
            const d = document.getElementById('profileDropdown');
            const p = document.querySelector('.profile-info');
            if (p && d && !p.contains(e.target) && !d.contains(e.target)) {
                d.style.display = 'none';
            }
        });

        // Mencegah klik di dalam menutup dropdown
        const dropdownElement = document.getElementById('profileDropdown');
        if (dropdownElement) {
            dropdownElement.addEventListener('click', function (event) {
                event.stopPropagation();
            });
        }
    </script>

    <!-- Flash Messages (Simple & Fast) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            <?php if (session()->getFlashdata('success')): ?>
                Toast.fire({ icon: 'success', title: '<?= addslashes(session()->getFlashdata('success')) ?>' });
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                Toast.fire({ icon: 'error', title: '<?= addslashes(session()->getFlashdata('error')) ?>' });
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                Toast.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    // Gunakan text biasa jika HTML bikin berat
                    text: 'Mohon periksa data kembali.'
                });
            <?php endif; ?>
        });
    </script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>