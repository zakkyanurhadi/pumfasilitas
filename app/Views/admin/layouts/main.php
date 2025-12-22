<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FasilitasKampusKu - <?= esc($title ?? 'Dashboard Admin') ?></title>
    <link rel="icon" href="<?= base_url('favicon.ico') ?>">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
</head>

<body>

    <!-- Panggil Header (Sidebar & Top Navbar) -->
    <?= $this->include('admin/partials/header') ?>

    <!-- ISI KONTEN UTAMA -->
    <main class="main-content">
        <div class="container">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="notification success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <!-- Di sinilah konten halaman spesifik akan dimuat -->
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <!-- Panggil Footer -->
    <?= $this->include('admin/partials/footer') ?>

    <!-- Panggil JavaScript di akhir body -->
    <script src="<?= base_url('assets/js/script.js') ?>"></script>
</body>

</html>