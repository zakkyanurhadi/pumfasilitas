<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Masuk - FasilitasKampusKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;600&display=swap"
        rel="stylesheet" />

    <style>
        /* === RESET & GAYA DASAR === */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Poppins", sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            overflow-x: hidden;
        }

        /* === PEMBUNGKUS UTAMA === */
        .login-wrapper {
            position: relative;
            width: 100%;
            max-width: 1100px;
        }

        /* === TOMBOL KEMBALI === */
        .btn-back-home {
            position: absolute;
            top: -60px;
            left: 0;
            width: 45px;
            height: 45px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2c5ef3;
            text-decoration: none;
            font-size: 1.2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 2px solid #e2e8f0;
            z-index: 10;
        }

        .btn-back-home:hover {
            background: #2c5ef3;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(44, 94, 243, 0.3);
            border-color: #2c5ef3;
        }

        /* === KARTU LOGIN === */
        .login-card {
            width: 100%;
            background: #fff;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.05);
            border-radius: 24px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            display: flex;
            min-height: 500px;
            animation: slideIn 0.6s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* === BAGIAN KIRI (BACKGROUND SLIDESHOW) === */
        .login-left {
            width: 50%;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 3rem;
            color: white;
            background-color: #2c5ef3;
            /* Warna cadangan */
            overflow: hidden;
            /* Penting agar gambar tidak keluar */
        }

        /* Wadah untuk gambar slideshow */
        .slideshow-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            /* Paling bawah */
        }

        .slideshow-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            /* Default sembunyi */
            transition: opacity 1.5s ease-in-out;
            /* Efek halus */
        }

        .slideshow-img.active {
            opacity: 1;
            /* Munculkan yang aktif */
        }

        /* Lapisan Gradasi Gelap - Di atas gambar tapi di bawah teks */
        .login-left::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 40%, rgba(0, 0, 0, 0.85) 100%);
            z-index: 1;
        }

        .left-content {
            position: relative;
            z-index: 2;
            /* Paling atas */
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* === BAGIAN KANAN (FORM) === */
        .login-right {
            width: 50%;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #fff;
        }

        /* === ELEMEN FORM === */
        .logo-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-img {
            width: 80px;
            height: auto;
            margin-bottom: 1rem;
        }

        h2 {
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0.5rem;
            font-size: 1.8rem;
        }

        .subtitle {
            color: #718096;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #2d3748;
            font-size: 0.85rem;
            margin-bottom: 0.4rem;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.7rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-control:focus {
            border-color: #2c5ef3;
            box-shadow: 0 0 0 4px rgba(44, 94, 243, 0.1);
            background: #fff;
        }

        .input-group-text {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-left: none;
            border-radius: 0 12px 12px 0;
            cursor: pointer;
        }

        .input-group .form-control {
            border-right: none;
            border-radius: 12px 0 0 12px;
        }

        .btn-login {
            background: linear-gradient(135deg, #2c5ef3 0%, #0e3eb4 100%);
            border: none;
            border-radius: 12px;
            padding: 0.9rem;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(44, 94, 243, 0.2);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(44, 94, 243, 0.3);
        }

        .forgot-link,
        .register-link {
            color: #2c5ef3;
            font-size: 0.85rem;
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-link:hover,
        .register-link:hover {
            text-decoration: underline;
        }

        .error-message {
            font-size: 0.75rem;
            color: #e53e3e;
            margin-top: 0.2rem;
            display: block;
        }

        @media (max-width: 992px) {
            .login-card {
                flex-direction: column;
                max-width: 500px;
                margin-top: 0;
            }

            .login-left {
                width: 100%;
                height: 200px;
                padding: 1.5rem;
                flex: none;
            }

            .left-content {
                display: none;
            }

            .login-right {
                width: 100%;
                padding: 2rem;
            }

            .login-wrapper {
                margin-top: 3rem;
                max-width: 500px;
            }

            .btn-back-home {
                top: -50px;
                left: 0;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <a href="<?= base_url('/') ?>" class="btn-back-home" title="Kembali ke Beranda">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div class="login-card">
            <div class="login-left">

                <div class="slideshow-wrapper">
                    <img src="<?= base_url('assets/polinelaa.jpeg') ?>" class="slideshow-img active" alt="Slide 1"
                        fetchpriority="high">
                    <img src="<?= base_url('assets/polinela.jpeg') ?>" class="slideshow-img" alt="Slide 2"
                        fetchpriority="high">
                    <img src="<?= base_url('assets/polinelaaa.jpeg') ?>" class="slideshow-img" alt="Slide 3"
                        fetchpriority="high">
                    <img src="<?= base_url('assets/polinelaaaa.jpeg') ?>" class="slideshow-img" alt="Slide 4"
                        fetchpriority="high">
                    <img src="<?= base_url('assets/polinelaaaaa.jpeg') ?>" class="slideshow-img" alt="Slide 5"
                        fetchpriority="high">
                    <img src="<?= base_url('assets/polinela.png') ?>" class="slideshow-img" alt="Slide 6"
                        fetchpriority="high">
                </div>

                <div class="left-content">
                    <h3 class="fw-bold">Sistem Pelaporan</h3>
                    <p class="mb-0">Kelola fasilitas kampus Politeknik Negeri Lampung dengan mudah dan cepat.</p>
                </div>
            </div>

            <div class="login-right">
                <div class="logo-header">
                    <img src="<?= base_url('assets/logo.png') ?>" alt="Logo Polinela" class="logo-img">
                    <h2>Selamat Datang</h2>
                    <p class="subtitle">Silakan login ke akun Anda</p>
                </div>

                <div id="alert-container"></div>

                <form id="loginForm" novalidate>
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="login_identifier" class="form-label">Username atau Email</label>
                        <input type="text" class="form-control" id="login_identifier" name="login_identifier"
                            placeholder="Contoh: 20753028" value="<?= old('login_identifier') ?>" required autofocus />
                        <span class="error-message" id="error-identifier"></span>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password" class="form-label mb-0">Password</label>
                            <a href="#" class="forgot-link" data-bs-toggle="modal"
                                data-bs-target="#forgotPasswordModal">Lupa Password?</a>
                        </div>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Masukkan password" required />
                            <span class="input-group-text" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </span>
                        </div>
                        <span class="error-message" id="error-password"></span>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember" />
                        <label class="form-check-label text-muted small" for="remember">
                            Ingat saya di perangkat ini
                        </label>
                    </div>

                    <button type="submit" class="btn-login"><span>Masuk Sekarang</span></button>

                    <div class="text-center mt-4">
                        <span class="text-muted small">Belum punya akun? </span>
                        <a href="<?= site_url('register') ?>" class="register-link small">Daftar di sini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-bottom-0 p-4">
                    <h5 class="modal-title fw-bold">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-0">
                    <p class="text-muted small mb-4">Masukkan email yang terdaftar untuk menerima link reset password.
                    </p>
                    <form id="resetPasswordForm">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="resetEmail" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" id="resetEmail" name="email"
                                placeholder="contoh@gmail.com" required />
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-3"
                            style="background: linear-gradient(135deg, #2c5ef3 0%, #0e3eb4 100%); border:none;">Kirim
                            Link Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        $(document).ready(function () {
            // === LOGIKA SLIDESHOW GAMBAR ===
            const images = document.querySelectorAll('.slideshow-img');
            if (images.length > 1) {
                let currentIndex = 0;
                setInterval(() => {
                    // Hilangkan class active dari gambar sekarang
                    images[currentIndex].classList.remove('active');

                    // Pindah ke index berikutnya (looping)
                    currentIndex = (currentIndex + 1) % images.length;

                    // Tambahkan class active ke gambar baru
                    images[currentIndex].classList.add('active');
                }, 5000); // Ganti gambar setiap 5 detik
            }
            // ================================

            // Hapus error saat user mulai mengetik
            $('#login_identifier, #password').on('input', function () {
                $(this).removeClass('is-invalid');
                const errorId = '#error-' + (this.id === 'login_identifier' ? 'identifier' : 'password');
                $(errorId).text('');
            });

            // === FUNGSI TAMPILKAN ALERT ===
            function showAlert(message, type) {
                const alertType = type === 'success' ? 'success' : 'danger';

                // KITA HAPUS setTimeout DI SINI AGAR ALERT TIDAK HILANG OTOMATIS
                // (Penting agar user punya waktu klik link simulasi)
                $("#alert-container").html(`<div class="alert alert-${alertType} alert-dismissible fade show small shadow-sm" role="alert" style="border-radius: 12px;">${message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`);
            }

            // === PROSES LOGIN ===
            $("#loginForm").on("submit", function (e) {
                e.preventDefault();
                $('.error-message').text('');
                $('.form-control').removeClass('is-invalid');
                const btn = $(this).find('button[type="submit"]');
                const originalText = btn.html();
                btn.html('<span class="spinner-border spinner-border-sm me-2"></span>Memproses...').prop('disabled', true);

                $.ajax({
                    url: "<?= site_url('login') ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            if ($('#remember').is(':checked')) {
                                localStorage.setItem('rememberMe', 'true');
                                localStorage.setItem('savedIdentifier', $('#login_identifier').val());
                            } else {
                                localStorage.removeItem('rememberMe');
                                localStorage.removeItem('savedIdentifier');
                            }
                            showAlert(response.message, 'success');
                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 1000);
                        } else {
                            showAlert(response.message, 'error');
                            if (response.errors) {
                                $.each(response.errors, function (key, val) {
                                    $(`#${key === 'login_identifier' ? 'login_identifier' : 'password'}`).addClass('is-invalid');
                                    $(`#error-${key === 'login_identifier' ? 'identifier' : 'password'}`).text(val);
                                });
                            }
                            btn.html(originalText).prop('disabled', false);
                        }
                    },
                    error: function (xhr) {
                        let msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan koneksi.';
                        showAlert(msg, 'error');
                        btn.html(originalText).prop('disabled', false);
                    }
                });
            });

            // === PROSES LUPA PASSWORD ===
            $("#resetPasswordForm").on("submit", function (e) {
                e.preventDefault();
                const btn = $(this).find('button[type="submit"]');
                const originalText = btn.text();
                btn.html('<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...').prop('disabled', true);

                $.ajax({
                    // Pastikan URL ini sesuai dengan routes di AuthController
                    url: "<?= base_url('auth/forgot_process') ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {
                        $("#forgotPasswordModal").modal("hide");
                        showAlert(response.message, response.success ? 'success' : 'error');

                        // Scroll ke atas agar notifikasi terlihat
                        if (response.success) {
                            $('#resetEmail').val('');
                            $('html, body').animate({ scrollTop: 0 }, 'fast');
                        }

                        btn.text(originalText).prop('disabled', false);
                    },
                    error: function () {
                        $("#forgotPasswordModal").modal("hide");
                        showAlert('Gagal mengirim permintaan.', 'error');
                        btn.text(originalText).prop('disabled', false);
                    }
                });
            });

            // === CEK INGAT SAYA ===
            if (localStorage.getItem('rememberMe') === 'true') {
                const savedId = localStorage.getItem('savedIdentifier');
                if (savedId) {
                    $('#login_identifier').val(savedId);
                    $('#remember').prop('checked', true);
                }
            }
        });
    </script>
</body>

</html>