<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Kadaluarsa - E-Fasilitas Polinela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #1e3a8a;
            --primary-light: #3b82f6;
            --danger: #ef4444;
            --danger-light: #fef2f2;
        }
        
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #f0f9ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .error-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            padding: 50px 40px;
            text-align: center;
            max-width: 450px;
            animation: fadeInUp 0.6s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .error-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--danger-light), #fecaca);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
        }
        
        .error-icon i {
            font-size: 48px;
            color: var(--danger);
        }
        
        h1 {
            color: #1e293b;
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .message {
            color: #64748b;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border: none;
            padding: 14px 35px;
            font-weight: 600;
            border-radius: 12px;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(30, 58, 138, 0.3);
            color: white;
        }
        
        .back-link {
            margin-top: 20px;
        }
        
        .back-link a {
            color: var(--primary-light);
            text-decoration: none;
        }
        
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-icon">
            <i class="fas fa-clock"></i>
        </div>
        
        <h1>Link Kadaluarsa</h1>
        
        <p class="message">
            <?= esc($message ?? 'Link reset password tidak valid atau sudah kedaluwarsa.') ?>
        </p>
        
        <a href="<?= base_url('login') ?>" class="btn-primary-custom">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Login
        </a>
        
        <div class="back-link">
            <p class="text-muted mb-0">Butuh bantuan? <a href="#">Hubungi Support</a></p>
        </div>
    </div>
</body>
</html>
