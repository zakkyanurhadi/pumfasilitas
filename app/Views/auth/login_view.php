<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FacilityReport - Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Poppins", sans-serif;
            overflow: hidden;
            height: 100vh;
            position: relative;
        }

        /* Animated Gradient Background */
        .gradient-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(-45deg, #667eea, #3434ffff, #fcfcfcff, #4facfe);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            z-index: 0;
        }

        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.2) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.15) 0%, transparent 50%);
            animation: floatBubbles 20s ease-in-out infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes floatBubbles {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        /* Main Container */
        .login-wrapper {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            width: 100%;
            padding: 2rem;
        }



        .login-container {
            width: 100%;
            max-width: 450px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 3rem;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.2);
            animation: slideIn 0.8s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-icon {
            font-size: 4rem;
            background: linear-gradient(135deg, #667eea 0%, #000000ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: logoSpin 10s linear infinite;
        }

        @keyframes logoSpin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: #718096;
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background: #fff;
        }

        .forgot-link {
            color: #667eea;
            font-size: 0.875rem;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .forgot-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        /* WOW Button Effect */
        .btn-login {
            background: linear-gradient(135deg, #1f48ffff 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            margin-top: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-login:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .btn-login span {
            position: relative;
            z-index: 1;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            border-bottom: 1px solid #e2e8f0;
            padding: 1.5rem;
        }

        .modal-title {
            font-weight: 600;
            color: #2d3748;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #2c0d4bff 100%);
            border: none;
            border-radius: 12px;
            padding: 0.875rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-container {
                padding: 2rem;
                max-width: 100%;
            }

            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Gradient Background -->
    <div class="gradient-bg"></div>

    <!-- Main Wrapper -->
    <div class="login-wrapper">
        <!-- Login Form -->
        <div class="login-container">
                <div class="logo-container">
                    <i class="fas fa-tools logo-icon"></i>
                    <h1>FasilitasKampusKu</h1>
                    <p class="subtitle">Kelola fasilitas kampus dengan mudah</p>
                </div>

                <div id="alert-container"></div>

                <form id="loginForm" novalidate>
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label for="login_identifier" class="form-label">NPM atau Email</label>
                        <input type="text" class="form-control" id="login_identifier" 
                               placeholder="Masukkan NPM atau Email" name="login_identifier" 
                               required autofocus />
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label for="password" class="form-label mb-0">Password</label>
                            <a href="#" class="forgot-link" data-bs-toggle="modal" 
                               data-bs-target="#forgotPasswordModal">Lupa Password?</a>
                        </div>
                        <input type="password" class="form-control" id="password" 
                               placeholder="Masukkan password Anda" name="password" required />
                    </div>

                    <button type="submit" class="btn-login">
                        <span>Masuk</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
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
                            <input type="email" class="form-control" id="resetEmail" name="email" 
                                   placeholder="contoh@gmail.com" required />
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
                const alertHtml = `<div class="alert alert-${alertType} alert-dismissible fade show" role="alert" style="border-radius: 12px;">${message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
                $("#alert-container").html(alertHtml);
            }

            // Handler untuk form login
            $("#loginForm").on("submit", function(e) {
                e.preventDefault();
                const submitButton = $(this).find('button[type="submit"]');
                submitButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...').prop('disabled', true);

                $.ajax({
                    url: "<?= site_url('login') ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            showAlert(response.message, 'success');
                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 1000);
                        } else {
                            showAlert(response.message, 'error');
                            submitButton.html('<span>Masuk</span>').prop('disabled', false);
                        }
                    },
                    error: function() {
                        showAlert('Terjadi kesalahan koneksi.', 'error');
                        submitButton.html('<span>Masuk</span>').prop('disabled', false);
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