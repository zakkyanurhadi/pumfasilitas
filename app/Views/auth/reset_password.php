<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - E-Fasilitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: "Poppins", sans-serif;
        }

        .card {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 450px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            /* Penting untuk posisi absolut */
        }

        .btn-back {
            color: #64748b;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-back:hover {
            color: #2c5ef3;
            transform: translateX(-3px);
            /* Efek gerak sedikit ke kiri */
        }

        .btn-primary {
            background: linear-gradient(135deg, #2c5ef3 0%, #0e3eb4 100%);
            border: none;
        }
    </style>
</head>

<body>

    <div class="card p-4 position-relative">

        <a href="<?= base_url('login') ?>" class="btn-back position-absolute top-0 start-0 m-4"
            title="Kembali ke Login">
            <i class="fas fa-arrow-left fa-lg"></i>
        </a>

        <div class="text-center mb-4 mt-3">
            <div class="mb-3">
                <i class="fas fa-shield-alt text-primary" style="font-size: 3rem;"></i>
            </div>
            <h4 class="fw-bold">Buat Password Baru</h4>
            <p class="text-muted small">Silakan masukkan password baru untuk akun Anda.</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger small rounded-3"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('auth/change_password') ?>" method="post">
            <?= csrf_field() ?>

            <input type="hidden" name="token" value="<?= esc($token) ?>">

            <div class="mb-3">
                <label class="form-label fw-bold small text-secondary">Password Baru</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                    <input type="password" name="password" class="form-control bg-light border-start-0"
                        placeholder="Minimal 6 karakter" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold small text-secondary">Ulangi Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i
                            class="fas fa-check-circle text-muted"></i></span>
                    <input type="password" name="conf_password" class="form-control bg-light border-start-0"
                        placeholder="Ketik ulang password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-bold shadow-sm">Simpan
                Password</button>
        </form>
    </div>

</body>

</html>