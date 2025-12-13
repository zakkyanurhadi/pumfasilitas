<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FacilityReport - Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background-color: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1rem
        }

        .login-container {
            width: 100%;
            max-width: 380px
        }

        .login-box {
            background-color: #fff;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .1)
        }

        .form-label {
            font-weight: 500
        }

        .forgot-link {
            font-size: .875rem;
            text-decoration: none
        }
    </style>
</head>

<body>
    <main class="login-container">
        <div class="text-center mb-4">
            <i class="fas fa-tools fa-3x text-primary"></i>
        </div>
        <h1 class="h4 text-center mb-3 fw-normal text-dark">Masuk ke FacilityReport</h1>
        <div class="login-box">
            <div id="alert-container"></div>
            <form id="loginForm" novalidate>
                <?= csrf_field() ?> <div class="mb-3">
                    <label for="login_identifier" class="form-label text-dark">NPM atau Email</label>
                    <input type="text" class="form-control" id="login_identifier" placeholder="Masukkan NPM atau Email" name="login_identifier" required autofocus />
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label for="password" class="form-label text-dark">Password</label>
                        <a href="#" class="forgot-link" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Lupa Password?</a>
                    </div>
                    <input type="password" class="form-control" id="password" placeholder="Masukkan password Anda" name="password" required />
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mt-2">Masuk</button>
            </form>
        </div>
    </main>

    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Masukkan email yang terdaftar untuk menerima link reset.</p>
                    <form id="resetPasswordForm">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="resetEmail" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" id="resetEmail" name="email" placeholder="contoh@gmail.com" required />
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Kirim Link Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            function showAlert(message, type) {
                const alertType = type === 'success' ? 'success' : 'danger';
                const alertHtml = `<div class="alert alert-${alertType} alert-dismissible fade show p-2 mb-3" role="alert" style="font-size: 0.875rem;">${message}<button type="button" class="btn-close p-2" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
                $("#alert-container").html(alertHtml);
            }

            // Handler untuk form login
            $("#loginForm").on("submit", function(e) {
                e.preventDefault();
                const submitButton = $(this).find('button[type="submit"]');
                submitButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>').prop('disabled', true);

                $.ajax({
                    url: "<?= site_url('login') ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            showAlert(response.message, 'success');
                            setTimeout(() => {
                                window.location.href = "<?= site_url('dashboard') ?>";
                            }, 1000);
                        } else {
                            showAlert(response.message, 'error');
                            submitButton.html('Masuk').prop('disabled', false);
                        }
                    },
                    error: function() {
                        showAlert('Terjadi kesalahan koneksi.', 'error');
                        submitButton.html('Masuk').prop('disabled', false);
                    }
                });
            });

            // Handler untuk form reset password
            $("#resetPasswordForm").on("submit", function(e) {
                e.preventDefault();
                $.ajax({
                    url: "<?= site_url('forgot-password') ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        $("#forgotPasswordModal").modal("hide");
                        // Tampilkan pesan di kontainer alert halaman utama
                        showAlert(response.message, response.success ? 'success' : 'error');
                    },
                    error: function() {
                        showAlert('Gagal mengirim permintaan.', 'error');
                    }
                });
            });
        });
    </script>
</body>

</html>