<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= base_url('favicon.ico') ?>">

    <title><?= isset($title) ? esc($title) . ' - ' : '' ?>Sistem Pengaduan Fasilitas - Polinela</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Animate.css (buat SweetAlert smooth) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet"
        href="<?= base_url('assets/css/user-style.css?v=' . filemtime(FCPATH . 'assets/css/user-style.css')) ?>">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




    <!-- Render section 'styles' dari view yang memanggil layout ini -->
    <?= $this->renderSection('styles') ?>
</head>

<body class="d-flex flex-column min-vh-100">


    <!-- Navbar -->
    <?= $this->include('partials/header') ?>

    <!-- Content -->
    <main class="flex-fill">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <?= $this->include('partials/footer') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>






    <script>
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('shadow');
            } else {
                document.querySelector('.navbar').classList.remove('shadow');
            }
        });

        // Notifikasi Badge - Polling setiap 30 detik
        function updateNotificationBadge() {
            fetch('<?= site_url('notifikasi/unread-count') ?>')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notifBadge');
                    const count = document.getElementById('notifCount');
                    if (badge && count) {
                        if (data.count > 0) {
                            count.textContent = data.count > 99 ? '99+' : data.count;
                            badge.style.display = 'block';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                })
                .catch(err => console.log('Notification check failed'));
        }

        // Initial check
        document.addEventListener('DOMContentLoaded', function () {
            updateNotificationBadge();
            // Poll every 30 seconds
            setInterval(updateNotificationBadge, 30000);
        });
    </script>
    <!-- Render section 'scripts' dari view yang memanggil layout ini -->
    <?= $this->renderSection('scripts') ?>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById("profileDropdown");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        }

        // Tutup dropdown jika pengguna mengklik di luar area dropdown
        window.addEventListener('click', function (event) {
            const profileInfo = document.querySelector('.profile-info');
            const dropdown = document.getElementById('profileDropdown');

            // Periksa apakah yang diklik bukanlah area profile-info atau dropdown itu sendiri
            if (!profileInfo.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });

        // Mencegah event klik di dalam dropdown menutup dropdown itu sendiri
        document.getElementById('profileDropdown').addEventListener('click', function (event) {
            event.stopPropagation();
        });
    </script>
    <!-- SweetAlert SUCCESS -->
    <?php if ($success = session()->getFlashdata('success')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                setTimeout(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: '<?= esc($success) ?>',
                        showConfirmButton: false,
                        timer: 2500,
                        backdrop: 'rgba(0,0,0,0.35)',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown animate__faster'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp animate__faster'
                        },
                        confirmButtonColor: '#0d6efd'
                    });
                }, 300);
            });
        </script>
    <?php endif; ?>

    <!-- SweetAlert ERROR -->
    <?php if ($errors = session()->getFlashdata('errors')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                setTimeout(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        html: `
                            <ul class="text-start mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        `,
                        confirmButtonColor: '#dc3545',
                        backdrop: 'rgba(0,0,0,0.4)',
                        showClass: {
                            popup: 'animate__animated animate__shakeX'
                        }
                    });
                }, 300);
            });
        </script>
    <?php endif; ?>

    <!-- Scripts tambahan dari view -->
    <?= $this->renderSection('scripts') ?>

</body>

</html>