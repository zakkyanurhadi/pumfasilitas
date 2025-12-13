<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FacilityReport - Laporan Kerusakan Fasilitas Kampus</title>
    <style>
        :root {
            --primary-color: #3b82f6;
            --primary-dark: #2563eb;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --light-bg: #f8fafc;
            --white: #ffffff;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-600: #475569;
            --gray-800: #1e293b;
            --border-radius: 8px;
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
        }

        .hero-container {
            max-width: 1200px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 60px;
        }

        .hero-content {
            z-index: 2;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 1.5rem;
            line-height: 1.2;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            animation: fadeInUp 0.8s ease-out;
        }

        .hero-content .subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            line-height: 1.6;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .hero-content p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 3rem;
            line-height: 1.7;
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        .cta-buttons {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }

        .btn {
            padding: 16px 32px;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background: var(--white);
            color: var(--primary-color);
            border: 2px solid transparent;
        }

        .btn-primary:hover {
            background: var(--primary-color);
            color: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: var(--white);
            border: 2px solid var(--white);
        }

        .btn-secondary:hover {
            background: var(--white);
            color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
        }

        .hero-image {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: fadeInRight 0.8s ease-out 0.3s both;
        }

        .hero-image::before {
            content: "";
            position: absolute;
            width: 400px;
            height: 400px;
            background: linear-gradient(45deg,
                    rgba(255, 255, 255, 0.1),
                    rgba(255, 255, 255, 0.05));
            border-radius: 50%;
            animation: pulse 4s ease-in-out infinite;
        }

        .hero-illustration {
            width: 350px;
            height: 350px;
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .illustration-content {
            text-align: center;
            padding: 40px;
        }

        .illustration-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg,
                    var(--primary-color),
                    var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
        }

        .illustration-icon svg {
            width: 60px;
            height: 60px;
            fill: white;
        }

        .illustration-content h3 {
            color: var(--gray-800);
            font-size: 1.5rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .illustration-content p {
            color: var(--secondary-color);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 40px;
            animation: fadeInUp 0.8s ease-out 0.8s both;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: var(--border-radius);
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-card .icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .feature-card h4 {
            color: var(--white);
            font-size: 1rem;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .feature-card p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 80%;
            left: 20%;
            animation-delay: 4s;
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

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @media (max-width: 768px) {
            .hero-container {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .hero-content .subtitle {
                font-size: 1.1rem;
            }

            .cta-buttons {
                justify-content: center;
            }

            .btn {
                padding: 14px 28px;
                font-size: 1rem;
            }

            .hero-illustration {
                width: 280px;
                height: 280px;
            }

            .illustration-icon {
                width: 80px;
                height: 80px;
            }

            .illustration-icon svg {
                width: 40px;
                height: 40px;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <h1>FasilitasKampusKu</h1>
                <p class="subtitle">Laporan Kerusakan Fasilitas Kampus</p>
                <p>
                    Kelola dan pantau semua laporan kerusakan fasilitas kampus dengan
                    mudah, cepat, dan efisien. Sistem terintegrasi yang membantu
                    mengoptimalkan proses perbaikan dan maintenance fasilitas
                    pendidikan.
                </p>

                <div class="cta-buttons">
                    <button class="btn btn-primary" onclick="redirectToLogin()">
                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
                        </svg>
                        Masuk ke Sistem
                    </button>
                </div>

                <div class="features-grid">
                    <div class="feature-card">
                        <div class="icon">⚡</div>
                        <h4>Cepat & Responsif</h4>
                        <p>Laporan dapat diproses dalam hitungan menit</p>
                    </div>
                    <div class="feature-card">
                        <div class="icon">📊</div>
                        <h4>Dashboard Analitik</h4>
                        <p>Visualisasi data yang mudah dipahami</p>
                    </div>
                    <div class="feature-card">
                        <div class="icon">🔔</div>
                        <h4>Notifikasi Real-time</h4>
                        <p>Update status langsung ke pelapor</p>
                    </div>
                </div>
            </div>

            <div class="hero-image">
                <div class="hero-illustration">
                    <div class="illustration-content">
                        <div class="illustration-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l-8 8h6v8h4v-8h6l-8-8z" />
                                <circle cx="12" cy="12" r="2" />
                                <path d="M4 14l4 4 4-4" />
                                <path d="M16 10l4 4-4 4" />
                            </svg>
                        </div>
                        <h3>Manajemen Terpusat</h3>
                        <p>
                            Kelola semua laporan kerusakan dari satu dashboard yang
                            terintegrasi dengan sistem tracking otomatis.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function redirectToLogin() {
            // Opsi 1: Redirect ke halaman login
            window.location.href = "login";

            // Opsi 2: Jika ingin membuat halaman login dalam satu file yang sama
            // showLoginForm();
        }

        // Animasi hover pada feature cards
        const featureCards = document.querySelectorAll(".feature-card");
        featureCards.forEach((card) => {
            card.addEventListener("mouseenter", function() {
                this.style.background = "rgba(255, 255, 255, 0.15)";
            });

            card.addEventListener("mouseleave", function() {
                this.style.background = "rgba(255, 255, 255, 0.1)";
            });
        });

        // Parallax effect untuk floating shapes
        window.addEventListener("scroll", () => {
            const shapes = document.querySelectorAll(".shape");
            const scrolled = window.pageYOffset;

            shapes.forEach((shape, index) => {
                const speed = (index + 1) * 0.3;
                shape.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });

        // CSS untuk animasi spin
        const style = document.createElement("style");
        style.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>