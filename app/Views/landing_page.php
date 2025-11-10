<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kampusku - Landing Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            overflow-x: hidden;
            background: #ffffff;
        }

        /* Navbar Styles with Glassmorphism */
        .navbar {
            position: fixed;
            width: 100%;
            padding: 20px 0;
            z-index: 999;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        .navbar.sticky {
            padding: 15px 0;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .navbar .max-width {
            max-width: 1400px;
            padding: 0 80px;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar .logo a {
            color: #001f3f;
            font-size: 36px;
            font-weight: 800;
            text-decoration: none;
            letter-spacing: 1px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar .logo span {
            color: #0066cc;
        }

        .navbar .menu {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        .navbar .menu li a {
            color: #001f3f;
            font-size: 18px;
            font-weight: 600;
            text-decoration: none;
            padding: 10px 18px;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .navbar .menu li a:hover {
            background: rgba(0, 102, 204, 0.15);
            backdrop-filter: blur(10px);
            color: #0066cc;
        }

        .login-btn {
            padding: 10px 25px !important;
            background: rgba(0, 102, 204, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(0, 102, 204, 0.3);
            border-radius: 50px;
            color: #001f3f !important;
        }

        .login-btn:hover {
            background: rgba(0, 102, 204, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 102, 204, 0.3);
        }

        /* Mobile Menu Toggle */
        .menu-btn {
            color: #001f3f;
            font-size: 28px;
            cursor: pointer;
            display: none;
        }

        /* Home Section */
        .home {
            min-height: 100vh;
            background: url('images/bglapor.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            display: flex;
            align-items: center;
            padding-top: 110px;
        }

        .home .max-width {
            max-width: 1400px;
            padding: 0 80px;
            margin: auto;
            width: 100%;
            position: relative;
            z-index: 2;
        }

        .home-content {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .home-content .text-1 {
            font-size: 38px;
            color: #001f3f;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .home-content .text-2 {
            font-size: 75px;
            font-weight: 600;
            color: #001f3f;
            margin-bottom: 15px;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.1);
            line-height: 1.1;
        }

        .home-content .text-3 {
            font-size: 40px;
            color: #001f3f;
            margin-bottom: 40px;
            font-weight: 500;
        }

        .home-content .text-3 span {
            color: #0066cc;
            font-weight: 700;
        }

        .typing {
            border-right: 4px solid #0066cc;
            padding-right: 8px;
            animation: blink 0.7s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                border-color: transparent;
            }

            50% {
                border-color: #0066cc;
            }
        }

        .home-content a {
            display: inline-block;
            padding: 20px 50px;
            background: rgba(0, 102, 204, 0.15);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 3px solid rgba(0, 102, 204, 0.4);
            color: #001f3f;
            text-decoration: none;
            font-size: 24px;
            font-weight: 700;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 40px rgba(0, 102, 204, 0.2);
        }

        .home-content a:hover {
            background: rgba(0, 102, 204, 0.25);
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0, 102, 204, 0.4);
            border-color: #0066cc;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .home-content .text-2 {
                font-size: 60px;
            }

            .home-content .text-3 {
                font-size: 32px;
            }
        }

        @media (max-width: 947px) {
            .navbar .max-width {
                padding: 0 50px;
            }

            .navbar .menu {
                position: fixed;
                height: 100vh;
                width: 100%;
                left: -100%;
                top: 0;
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(20px);
                text-align: center;
                padding-top: 100px;
                transition: all 0.3s ease;
                flex-direction: column;
                border-right: 3px solid rgba(0, 102, 204, 0.3);
            }

            .navbar .menu.active {
                left: 0;
            }

            .navbar .menu li {
                margin: 25px 0;
            }

            .navbar .menu li a {
                font-size: 28px;
                display: block;
            }

            .menu-btn {
                display: block;
                z-index: 999;
            }

            .menu-btn i.active:before {
                content: "\f00d";
            }

            .home {
                padding-top: 90px;
            }

            .home .max-width {
                padding: 0 50px;
            }

            .home-content .text-1 {
                font-size: 32px;
            }

            .home-content .text-2 {
                font-size: 50px;
            }

            .home-content .text-3 {
                font-size: 30px;
            }

            .home-content a {
                font-size: 22px;
                padding: 18px 45px;
            }
        }

        @media (max-width: 690px) {
            .navbar .max-width {
                padding: 0 30px;
            }

            .navbar .logo a {
                font-size: 36px;
            }

            .home {
                padding-top: 80px;
            }

            .home .max-width {
                padding: 0 30px;
            }

            .home-content .text-1 {
                font-size: 26px;
            }

            .home-content .text-2 {
                font-size: 38px;
            }

            .home-content .text-3 {
                font-size: 24px;
            }

            .home-content a {
                font-size: 20px;
                padding: 16px 40px;
            }
        }

        @media (max-width: 500px) {
            .home-content .text-1 {
                font-size: 22px;
            }

            .home-content .text-2 {
                font-size: 30px;
            }

            .home-content .text-3 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="max-width">
            <div class="logo">
                <a href="/">Laporan<span>Kampusku</span></a>
            </div>
            <ul class="menu">
                <li><a href="/login" class="login-btn">Masuk</a></li>
                <li><a href="/register" class="login-btn">Daftar</a></li>
            </ul>
            <div class="menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <!-- Home Section -->
    <section class="home" id="home">
        <div class="max-width">
            <div class="home-content">
                <div class="text-1">Selamat Datang di</div>
                <div class="text-2">Laporan Kampusku</div>
                <div class="text-3">Platform untuk <span class="typing"></span></div>
                <a href="/register">Mulai Sekarang</a>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.12/typed.min.js"></script>
    <script>
        $(document).ready(function() {
            // Sticky navbar
            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $('.navbar').addClass('sticky');
                } else {
                    $('.navbar').removeClass('sticky');
                }
            });

            // Mobile menu toggle
            $('.menu-btn').click(function() {
                $('.navbar .menu').toggleClass('active');
                $('.menu-btn i').toggleClass('active');
            });

            // Typing animation
            var typed = new Typed(".typing", {
                strings: [
                    "Melaporkan Keluhan",
                    "Memberikan Aspirasi",
                    "Membangun Kampus",
                    "Bersama Berkembang"
                ],
                typeSpeed: 60,
                backSpeed: 40,
                loop: true,
                backDelay: 2000,
                showCursor: true
            });
        });
    </script>
</body>

</html>