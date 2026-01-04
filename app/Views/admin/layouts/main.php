<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-Fasilitas - <?= esc($title ?? 'Dashboard Admin') ?></title>
    <link rel="icon" href="<?= base_url('favicon.ico') ?>">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">

    <!-- SweetAlert2 CSS (LOKAL) -->
    <link rel="stylesheet" href="<?= base_url('assets/css/sweetalert2.css') ?>">
</head>

<body>

    <!-- Panggil Header (Sidebar & Top Navbar) -->
    <?= $this->include('admin/partials/header') ?>

    <!-- ISI KONTEN UTAMA -->
    <main class="main-content">
        <div class="container">
            <!-- Di sinilah konten halaman spesifik akan dimuat -->
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <!-- Panggil Footer -->
    <?= $this->include('admin/partials/footer') ?>

    <!-- SweetAlert2 JS (LOKAL) -->
    <script src="<?= base_url('assets/js/sweetalert2.all.js') ?>"></script>

    <!-- Flash Messages dengan SweetAlert2 -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            <?php if (session()->getFlashdata('success') || session()->getFlashdata('error')): ?>
                // Langsung eksekusi tanpa delay untuk respon lebih cepat
                <?php if (session()->getFlashdata('success')): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '<?= addslashes(session()->getFlashdata('success')) ?>',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer);
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        }
                    });
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: '<?= addslashes(session()->getFlashdata('error')) ?>',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer);
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        }
                    });
                <?php endif; ?>
            <?php endif; ?>
        });
    </script>


    <!-- Script Notifikasi Admin Hybrid (Audio + Desktop + Toast) -->
    <script>
        let lastUnreadCount = -1;
        let audioContextUnlocked = false;

        // Setup Audio Player (Volume Max)
        const notifSound = new Audio('<?= base_url("assets/audio/text_message.mp3") ?>');
        notifSound.volume = 1.0;

        // Unlock Audio pada interaksi pertama
        document.body.addEventListener('click', function () {
            if (!audioContextUnlocked) {
                notifSound.play().then(() => {
                    notifSound.pause();
                    notifSound.currentTime = 0;
                    audioContextUnlocked = true;
                }).catch(e => { });
            }
        }, { once: true });

        // Request Izin Notifikasi Desktop
        document.addEventListener('DOMContentLoaded', function () {
            if ("Notification" in window) {
                if (Notification.permission !== "granted" && Notification.permission !== "denied") {
                    Notification.requestPermission();
                }
            }
            // Mulai polling
            updateAdminNotificationBadge();
            // Interval dipercepat menjadi 2 detik untuk respon lebih smooth
            setInterval(updateAdminNotificationBadge, 2000);
        });

        function updateAdminNotificationBadge() {
            fetch('<?= site_url('admin/notifikasi/unread-count') ?>')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('adminNotifBadge');
                    const currentCount = parseInt(data.count) || 0;

                    if (badge) {
                        if (currentCount > 0) {
                            badge.textContent = currentCount > 99 ? '99+' : currentCount;
                            badge.style.display = 'block';
                            // Tambahkan animasi pulse saat ada notif
                            badge.style.animation = 'pulse 1s infinite';
                        } else {
                            badge.style.display = 'none';
                            badge.style.animation = 'none';
                        }
                    }

                    // Logika Deteksi Notifikasi Baru
                    if (lastUnreadCount !== -1 && currentCount > lastUnreadCount) {
                        const selisih = currentCount - lastUnreadCount;

                        // 1. MAINKAN SUARA
                        notifSound.currentTime = 0;
                        notifSound.play().catch(error => {
                            console.log("Audio autoplay restricted");
                        });

                        // 2. DESKTOP NOTIFICATION
                        if ("Notification" in window && Notification.permission === "granted") {
                            const notification = new Notification("Laporan Baru Masuk!", {
                                body: `Ada ${selisih} laporan baru yang perlu ditinjau.`,
                                icon: '<?= base_url("favicon.ico") ?>',
                                tag: 'laporan-baru'
                            });

                            notification.onclick = function () {
                                window.focus();
                                window.location.href = '<?= site_url("admin/notifikasi") ?>';
                                this.close();
                            };
                        }

                        // 3. TOAST IN-APP
                        Swal.fire({
                            icon: 'info',
                            title: 'Laporan Baru Masuk!',
                            text: `Ada ${selisih} laporan baru yang perlu ditinjau.`,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            background: '#ffffff',
                            iconColor: '#3b82f6',
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer);
                                toast.addEventListener('mouseleave', Swal.resumeTimer);
                                toast.addEventListener('click', () => { window.location.href = '<?= site_url("admin/notifikasi") ?>'; });
                            }
                        });
                    }

                    lastUnreadCount = currentCount;
                })
                .catch(err => console.log('Check failed', err));
        }
    </script>

    <style>
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>

    <!-- Panggil JavaScript di akhir body -->
    <script src="<?= base_url('assets/js/script.js') ?>"></script>
</body>

</html>