<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? esc($title) . ' - ' : '' ?>Sistem Pengaduan Fasilitas - Polinela</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/user-style.css') ?>">

    <!-- Render section 'styles' dari view yang memanggil layout ini -->
    <?= $this->renderSection('styles') ?>
</head>

<body>

    <!-- Render section 'navbar' -->
    <?= $this->include('layouts/user/navbar') ?>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="notification success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Render section 'content' -->
    <?= $this->renderSection('content') ?>

    <?php if (session()->has('errors')) : ?>
        <div class="notification alert-danger">
            <ul>
                <?php foreach (session('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Render section 'footer' -->
    <?= $this->include('layouts/user/footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('shadow');
            } else {
                document.querySelector('.navbar').classList.remove('shadow');
            }
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
        window.addEventListener('click', function(event) {
            const profileInfo = document.querySelector('.profile-info');
            const dropdown = document.getElementById('profileDropdown');

            // Periksa apakah yang diklik bukanlah area profile-info atau dropdown itu sendiri
            if (!profileInfo.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });

        // Mencegah event klik di dalam dropdown menutup dropdown itu sendiri
        document.getElementById('profileDropdown').addEventListener('click', function(event) {
            event.stopPropagation();
        });
    </script>
</body>