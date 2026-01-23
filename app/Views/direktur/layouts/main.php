<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-Fasilitas - <?= esc($title ?? 'Dashboard Direktur') ?></title>
    <link rel="icon" href="<?= base_url('favicon.ico') ?>">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <link rel="stylesheet" href="<?= base_url('assets/css/direktur.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?= $this->include('direktur/partials/header') ?>

    <main class="main-content">
        <div class="container">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="notification success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="notification error"
                    style="background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #fecaca;">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="notification errors"
                    style="background: #fff7ed; color: #9a3412; padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #ffedd5;">
                    <ul style="margin: 0; padding-left: 20px;">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <?= $this->include('direktur/partials/footer') ?>

    <script src="<?= base_url('assets/js/direktur.js') ?>"></script>
</body>

</html>