<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Akun - FasilitasKampusKu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;600&display=swap"
    rel="stylesheet" />

  <style>
    /* === RESET & BASE STYLES === */
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
    }

    /* === CARD STYLE === */
    .register-card {
      width: 100%;
      max-width: 1250px;
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

    /* === BAGIAN KIRI (SLIDESHOW) === */
    .register-left {
      flex: 1;
      /* Background image dihapus, diganti elemen img slideshow */
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 3rem;
      color: white;
      background-color: #2c5ef3;
      /* Fallback color */
      overflow: hidden;
    }

    /* Container untuk gambar slideshow */
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

    /* === OVERLAY === */
    .register-left::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.85) 100%);
      z-index: 1;
      /* Di atas gambar, di bawah teks */
    }

    .left-content {
      position: relative;
      z-index: 2;
      /* Paling atas */
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    /* === BAGIAN KANAN (FORM) === */
    .register-right {
      flex: 1;
      padding: 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: #fff;
    }

    /* === FORM ELEMENTS === */
    .logo-header {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .logo-img {
      width: 70px;
      margin-bottom: 0.8rem;
    }

    h2 {
      font-weight: 700;
      color: #1a202c;
      margin-bottom: 0.3rem;
      font-size: 1.5rem;
    }

    .subtitle {
      color: #718096;
      font-size: 0.85rem;
      margin-bottom: 0;
    }

    .form-label {
      font-weight: 600;
      color: #2d3748;
      font-size: 0.8rem;
      margin-bottom: 0.3rem;
    }

    .form-control {
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      padding: 0.6rem 1rem;
      font-size: 0.9rem;
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

    .btn-register {
      background: linear-gradient(135deg, #2c5ef3 0%, #0e3eb4 100%);
      border: none;
      border-radius: 12px;
      padding: 0.8rem;
      font-size: 1rem;
      font-weight: 600;
      color: white;
      width: 100%;
      margin-top: 1rem;
      transition: all 0.3s ease;
      box-shadow: 0 10px 25px rgba(44, 94, 243, 0.2);
    }

    .btn-register:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 35px rgba(44, 94, 243, 0.3);
    }

    .login-link {
      color: #2c5ef3;
      font-size: 0.85rem;
      text-decoration: none;
      font-weight: 600;
    }

    .login-link:hover {
      text-decoration: underline;
    }

    .error-message {
      font-size: 0.75rem;
      color: #e53e3e;
      margin-top: 0.2rem;
      display: block;
    }

    @media (max-width: 992px) {
      .register-card {
        flex-direction: column;
        max-width: 500px;
        margin: 1rem auto;
        min-height: auto;
      }

      .register-left {
        width: 100%;
        height: 200px;
        padding: 2rem;
        flex: none;
      }

      /* Reset style img untuk mobile jika perlu, tapi object-fit: cover sudah aman */

      .register-left::after {
        top: 0;
        background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.85) 100%);
      }

      .left-content h3 {
        font-size: 1.5rem;
      }

      .register-right {
        width: 100%;
        padding: 2rem;
      }
    }
  </style>
</head>

<body>

  <div class="register-card">
    <div class="register-left">

      <div class="slideshow-wrapper">
        <img src="<?= base_url('assets/polinela2.webp') ?>" class="slideshow-img active" alt="Slide 1"
          fetchpriority="high">
        <img src="<?= base_url('assets/polinela1.webp') ?>" class="slideshow-img" alt="Slide 2" fetchpriority="high">
        <img src="<?= base_url('assets/polinela3.webp') ?>" class="slideshow-img" alt="Slide 3" fetchpriority="high">
        <img src="<?= base_url('assets/polinela4.webp') ?>" class="slideshow-img" alt="Slide 4" fetchpriority="high">
        <img src="<?= base_url('assets/polinela5.webp') ?>" class="slideshow-img" alt="Slide 5" fetchpriority="high">
        <img src="<?= base_url('assets/polinela6.webp') ?>" class="slideshow-img" alt="Slide 6 " fetchpriority="high">
      </div>

      <div class="left-content">
        <h3 class="fw-bold">Bergabunglah Bersama Kami</h3>
        <p class="mb-0 text-white-50">Buat akun untuk mulai melaporkan fasilitas kampus Polinela.</p>
      </div>
    </div>

    <div class="register-right">
      <div class="logo-header">
        <img src="<?= base_url('assets/logo.png') ?>" alt="Logo" class="logo-img">
        <h2>Buat Akun Baru</h2>
        <p class="subtitle">Lengkapi data diri Anda di bawah ini</p>
      </div>

      <div id="alert-container"></div>

      <form id="registerForm" novalidate>
        <?= csrf_field() ?>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="fullname" placeholder="Contoh: Damar Arif" required>
            <span class="error-message" id="error-fullname"></span>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Username / NPM</label>
            <input type="text" class="form-control" name="username" placeholder="Contoh: 20753028" required>
            <span class="error-message" id="error-username"></span>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Alamat Email</label>
          <input type="email" class="form-control" name="email" placeholder="nama@polinela.ac.id" required>
          <span class="error-message" id="error-email"></span>
        </div>

        <div class="row mb-2">
          <div class="col-md-6 mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="reg_password" name="password" placeholder="password"
                required>
              <span class="input-group-text" onclick="toggleRegPassword('reg_password', 'icon1')"><i class="fas fa-eye"
                  id="icon1"></i></span>
            </div>
            <span class="error-message" id="error-password"></span>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Ulangi Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="conf_password" name="conf_password" placeholder="password"
                required>
              <span class="input-group-text" onclick="toggleRegPassword('conf_password', 'icon2')"><i class="fas fa-eye"
                  id="icon2"></i></span>
            </div>
            <span class="error-message" id="error-conf_password"></span>
          </div>
        </div>

        <button type="submit" class="btn-register"><span>Daftar Sekarang</span></button>

        <div class="text-center mt-3">
          <span class="text-muted small">Sudah punya akun? </span>
          <a href="<?= site_url('login') ?>" class="login-link small">Masuk di sini</a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleRegPassword(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
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

          // Pindah ke index berikutnya
          currentIndex = (currentIndex + 1) % images.length;

          // Tambahkan class active ke gambar baru
          images[currentIndex].classList.add('active');
        }, 5000); // Ganti setiap 5 detik
      }
      // ================================

      $('input').on('input', function () {
        $(this).removeClass('is-invalid');
        const name = $(this).attr('name');
        $('#error-' + name).text('');
      });

      $('#registerForm').on('submit', function (e) {
        e.preventDefault();
        $('.error-message').text('');
        $('.form-control').removeClass('is-invalid');

        const btn = $(this).find('button[type="submit"]');
        const originalText = btn.html();

        btn.html('<span class="spinner-border spinner-border-sm me-2"></span>Memproses...').prop('disabled', true);

        $.ajax({
          url: "<?= site_url('register/process') ?>",
          type: "POST",
          data: $(this).serialize(),
          dataType: "json",
          success: function (response) {
            if (response.success) {
              $("#alert-container").html(`<div class="alert alert-success small" style="border-radius:12px;">${response.message}</div>`);
              setTimeout(() => {
                window.location.href = response.redirect;
              }, 1500);
            } else {
              if (response.errors) {
                $.each(response.errors, function (key, val) {
                  $('[name="' + key + '"]').addClass('is-invalid');
                  $('#error-' + key).text(val);
                });
              } else {
                $("#alert-container").html(`<div class="alert alert-danger small" style="border-radius:12px;">${response.message}</div>`);
              }
              btn.html(originalText).prop('disabled', false);
            }
          },
          error: function () {
            $("#alert-container").html(`<div class="alert alert-danger small" style="border-radius:12px;">Gagal terhubung ke server.</div>`);
            btn.html(originalText).prop('disabled', false);
          }
        });
      });
    });
  </script>
</body>

</html>