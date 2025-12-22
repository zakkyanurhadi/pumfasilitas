<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FasilitasKampusKu - <?= esc($title ?? 'DashboardRektor') ?></title>
    <link rel="icon" href="<?= base_url('favicon.ico') ?>">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <link rel="stylesheet" href="<?= base_url('assets/css/rektor.css') ?>">
</head>

<body>
    <?= $this->include('rektor/partials/header') ?>

    <main class="main-content">
        <div class="container">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="notification success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <?= $this->include('rektor/partials/footer') ?>

    <script src="<?= base_url('assets/js/script.js') ?>"></script>
</body>

</html>