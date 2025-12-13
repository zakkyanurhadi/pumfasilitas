<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penjualan Sederhana</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('logo.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-container {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            transition: all 0.3s ease;
        }

        .auth-container:hover {
            box-shadow: 0 8px 40px rgba(31, 38, 135, 0.45);
            transform: translateY(-3px);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-header h1 {
            color: #ffffff;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .auth-header p {
            color: #ffffff;
            font-size: 0.95rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .form-tabs {
            display: flex;
            margin-bottom: 2rem;
            gap: 1rem;
        }

        .tab-btn {
            flex: 1;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .tab-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .tab-btn.active {
            background: rgba(18, 9, 181, 0.6);
            border-color: rgba(18, 9, 181, 0.8);
            box-shadow: 0 4px 15px rgba(18, 9, 181, 0.4);
        }

        .form-content {
            display: none;
        }

        .form-content.active {
            display: block;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #ffffff;
            font-weight: 500;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .input-wrapper {
            position: relative;
            width: 100%;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            padding-right: 45px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            color: #2d3748;
        }

        .form-group input::placeholder {
            color: #a0aec0;
        }

        .form-group input:focus {
            outline: none;
            border-color: rgba(18, 9, 181, 0.8);
            box-shadow: 0 0 0 3px rgba(18, 9, 181, 0.2);
            background: rgba(255, 255, 255, 1);
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            transition: all 0.3s ease;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            user-select: none;
        }

        .toggle-password:hover {
            opacity: 0.7;
        }

        .toggle-password:active {
            transform: translateY(-50%) scale(0.95);
        }

        .toggle-password svg {
            width: 22px;
            height: 22px;
            fill: #4a5568;
            transition: fill 0.3s ease;
        }

        .toggle-password:hover svg {
            fill: #1a202c;
        }

        .eye-icon {
            display: block;
        }

        .eye-slash-icon {
            display: none;
        }

        .toggle-password.showing .eye-icon {
            display: none;
        }

        .toggle-password.showing .eye-slash-icon {
            display: block;
        }

        .submit-btn {
            width: 100%;
            padding: 0.85rem;
            background: rgba(18, 9, 181, 0.7);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            box-shadow: 0 4px 15px rgba(18, 9, 181, 0.3);
        }

        .submit-btn:hover {
            background: rgba(18, 9, 181, 0.85);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(18, 9, 181, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .footer {
            text-align: center;
            margin-top: 2rem;
            color: #ffffff;
            font-size: 0.85rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .password-strength {
            margin-top: 0.5rem;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
            overflow: hidden;
            display: none;
        }

        .password-strength.show {
            display: block;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .password-strength-bar.weak {
            width: 33%;
            background: #f56565;
        }

        .password-strength-bar.medium {
            width: 66%;
            background: #ed8936;
        }

        .password-strength-bar.strong {
            width: 100%;
            background: #48bb78;
        }

        .password-hint {
            font-size: 0.75rem;
            color: #ffffff;
            margin-top: 0.3rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            display: none;
        }

        .password-hint.show {
            display: block;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .auth-container {
                padding: 1.5rem;
            }

            .auth-header h1 {
                font-size: 1.5rem;
            }

            .tab-btn {
                font-size: 0.9rem;
                padding: 0.6rem;
            }

            .form-group input {
                font-size: 0.95rem;
            }
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="auth-header">
            <h1>Toko Sederhana</h1>
            <p>Digital Catalog & Point of Sales</p>
        </div>

        <!-- Tabs -->
        <div class="form-tabs">
            <button class="tab-btn active" data-tab="login">Login</button>
            <button class="tab-btn" data-tab="register">Register</button>
        </div>

        <!-- Login Form -->
        <div id="login-form" class="form-content active">
            <form id="form-login">
                <div class="form-group">
                    <label for="login-email">Email</label>
                    <input type="email" id="login-email" name="email" required
                        placeholder="Masukkan email Anda">
                </div>

                <div class="form-group">
                    <label for="login-password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="login-password" name="password" required
                            placeholder="Masukkan password">
                        <button type="button" class="toggle-password" data-target="login-password">
                            <!-- Eye Icon (Visible) -->
                            <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                            </svg>
                            <!-- Eye Slash Icon (Hidden) -->
                            <svg class="eye-slash-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Login</button>
            </form>
        </div>

        <!-- Register Form -->
        <div id="register-form" class="form-content">
            <form id="form-register">
                <div class="form-group">
                    <label for="register-name">Full Name</label>
                    <input type="text" id="register-name" name="fullname" required
                        placeholder="Masukkan nama lengkap">
                </div>

                <div class="form-group">
                    <label for="register-email">Email</label>
                    <input type="email" id="register-email" name="email" required
                        placeholder="Masukkan email Anda">
                </div>

                <div class="form-group">
                    <label for="register-password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="register-password" name="password" required
                            placeholder="Buat password (min. 8 karakter)">
                        <button type="button" class="toggle-password" data-target="register-password">
                            <!-- Eye Icon (Visible) -->
                            <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                            </svg>
                            <!-- Eye Slash Icon (Hidden) -->
                            <svg class="eye-slash-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z" />
                            </svg>
                        </button>
                    </div>
                    <div class="password-strength" id="password-strength">
                        <div class="password-strength-bar" id="strength-bar"></div>
                    </div>
                    <div class="password-hint" id="password-hint"></div>
                </div>

                <button type="submit" class="submit-btn">Register</button>
            </form>
        </div>

        <div class="footer">
            <p>&copy; 2025 Point of Sales (POS) System</p>
        </div>
    </div>

    <script>
        // Switch between Login and Register tabs
        document.querySelectorAll('.tab-btn').forEach(button => {
            button.addEventListener('click', function() {
                const tab = this.getAttribute('data-tab');

                // Remove active class from all tabs and forms
                document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.form-content').forEach(form => form.classList.remove('active'));

                // Add active class to selected tab and form
                this.classList.add('active');
                document.getElementById(tab + '-form').classList.add('active');
            });
        });

        // Toggle password visibility on mouse hold
        document.querySelectorAll('.toggle-password').forEach(button => {
            const targetId = button.getAttribute('data-target');
            const input = document.getElementById(targetId);

            // Show password when mouse button is pressed
            button.addEventListener('mousedown', function(e) {
                e.preventDefault();
                input.type = 'text';
                this.classList.add('showing');
            });

            // Hide password when mouse button is released
            button.addEventListener('mouseup', function() {
                input.type = 'password';
                this.classList.remove('showing');
            });

            // Hide password when mouse leaves button (while holding)
            button.addEventListener('mouseleave', function() {
                input.type = 'password';
                this.classList.remove('showing');
            });

            // Support for touch devices
            button.addEventListener('touchstart', function(e) {
                e.preventDefault();
                input.type = 'text';
                this.classList.add('showing');
            });

            button.addEventListener('touchend', function() {
                input.type = 'password';
                this.classList.remove('showing');
            });
        });

        // Check password strength
        const registerPasswordInput = document.getElementById('register-password');
        registerPasswordInput.addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('strength-bar');
            const strengthContainer = document.getElementById('password-strength');
            const hintElement = document.getElementById('password-hint');

            if (password.length === 0) {
                strengthContainer.classList.remove('show');
                hintElement.classList.remove('show');
                return;
            }

            strengthContainer.classList.add('show');
            hintElement.classList.add('show');

            let strength = 0;
            let hint = '';

            // Check password criteria
            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/\d/.test(password)) strength++;
            if (/[^a-zA-Z\d]/.test(password)) strength++;

            // Remove all strength classes
            strengthBar.classList.remove('weak', 'medium', 'strong');

            // Set strength class and hint
            if (strength <= 2) {
                strengthBar.classList.add('weak');
                hint = 'Password lemah - Tambahkan huruf besar, angka, dan simbol';
            } else if (strength <= 4) {
                strengthBar.classList.add('medium');
                hint = 'Password cukup kuat - Pertimbangkan menambah panjang';
            } else {
                strengthBar.classList.add('strong');
                hint = 'Password kuat!';
            }

            hintElement.textContent = hint;
        });

        // Handle Login Form - DIPERBAIKI AGAR SESUAI DENGAN AUTH.PHP BARU
        document.getElementById('form-login').addEventListener('submit', function(event) {
            event.preventDefault();

            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;

            if (!email || !password) {
                alert('Email dan password harus diisi!');
                return false;
            }

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Logging in...';

            fetch('auth.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'login',
                        email: email,
                        password: password
                    })
                })
                .then(response => response.json()) // Parse JSON
                .then(data => {
                    if (data.success) {
                        // Ambil data user dari respon server (data.data)
                        const userData = data.data || {};
                        const fullname = userData.fullname || 'User';
                        const role = userData.role || 'pelanggan';

                        alert('Login berhasil! Selamat datang, ' + fullname + '!');

                        // Redirect sesuai Role
                        if (role === 'admin') {
                            window.location.href = 'admin/index.php';
                        } else {
                            window.location.href = 'dashboard/index.php';
                        }
                    } else {
                        alert('Login gagal: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan server. Cek console untuk detail.');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
        });
        // Handle register form submission
        // Handle Register Form
        document.getElementById('form-register').addEventListener('submit', function(event) {
            event.preventDefault();

            // 1. Ambil nilai langsung dari input form
            const fullname = document.getElementById('register-name').value;
            const email = document.getElementById('register-email').value;
            const password = document.getElementById('register-password').value;

            if (!fullname || !email || !password) {
                alert('Semua field harus diisi!');
                return false;
            }
            if (password.length < 6) {
                alert('Password minimal 6 karakter!');
                return false;
            }

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Registering...';

            fetch('auth.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        action: 'register',
                        fullname: fullname,
                        email: email,
                        password: password,
                        role: 'pelanggan'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // PERBAIKAN DI SINI:
                        // Gunakan variabel 'fullname' dari input form, JANGAN pakai data.data.fullname
                        alert('Registrasi berhasil! Selamat datang, ' + fullname + '!\n\nSilakan login.');

                        this.reset(); // Kosongkan form

                        // Sembunyikan indikator password
                        document.getElementById('password-strength').classList.remove('show');
                        document.getElementById('password-hint').classList.remove('show');

                        // Pindah ke tab login
                        document.querySelector('.tab-btn[data-tab="login"]').click();

                        // Isi otomatis email login pakai variabel 'email' dari input form
                        document.getElementById('login-email').value = email;
                    } else {
                        alert('Registrasi gagal: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan server.');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
        });
        // Enhanced form validation on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Add real-time email validation
            const emailInputs = document.querySelectorAll('input[type="email"]');
            emailInputs.forEach(input => {
                input.addEventListener('blur', function() {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (this.value && !emailRegex.test(this.value)) {
                        this.style.borderColor = '#f56565';
                        setTimeout(() => {
                            this.style.borderColor = '';
                        }, 2000);
                    }
                });
            });
        });
    </script>
</body>

</html>