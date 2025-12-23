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

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Flash Messages dengan SweetAlert2 -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            <?php if (session()->getFlashdata('success') || session()->getFlashdata('error')): ?>
                // Hanya delay jika ada flash message
                setTimeout(() => {
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
                }, 100); // Delay dikurangi menjadi 100ms
            <?php endif; ?>
        });
    </script>


    <!-- Script Notifikasi Admin -->
    <script>
        function updateAdminNotificationBadge() {
            fetch('<?= site_url('admin/notifikasi/unread-count') ?>')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('adminNotifBadge');
                    if (badge) {
                        if (data.count > 0) {
                            badge.textContent = data.count > 99 ? '99+' : data.count;
                            badge.style.display = 'block';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                })
                .catch(err => console.log('Admin notification check failed'));
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateAdminNotificationBadge();
            setInterval(updateAdminNotificationBadge, 30000);
        });
    </script>

    <!-- Panggil JavaScript di akhir body -->
    <script src="<?= base_url('assets/js/script.js') ?>"></script>
</body>

</html>