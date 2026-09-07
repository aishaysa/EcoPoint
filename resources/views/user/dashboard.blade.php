<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EcoPoint — Hidup Berkelanjutan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: #f0f7f2;
            color: #1a2e24;
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ===== NAVBAR SEDERHANA ===== */
        .navbar {
            background: #0d2b1f;
            padding: 14px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .logo {
            color: #6fcf97;
            font-size: 26px;
            font-weight: 800;
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        .logo i {
            color: #a8e6c1;
            margin-right: 8px;
        }

        /* Elemen auth di kanan */
        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .nav-right .btn-nav {
            background: #6fcf97;
            color: #0d2b1f;
            padding: 8px 20px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            transition: 0.2s;
        }
        .nav-right .btn-nav:hover {
            background: #84dba5;
            color: #0d2b1f;
        }
        .nav-right a {
            color: #cde8d6;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
        }
        .nav-right a:hover {
            color: #6fcf97;
        }

        /* ===== DROPDOWN PROFILE ===== */
        .profile-dropdown {
            position: relative;
            display: inline-block;
        }
        .profile-dropdown .avatar {
            background: #2e7d5a;
            color: white;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            border: 2px solid #6fcf97;
            transition: 0.2s;
        }
        .profile-dropdown .avatar:hover {
            background: #6fcf97;
            color: #0d2b1f;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 44px;
            background: white;
            min-width: 180px;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            border: 1px solid #d4e8db;
            overflow: hidden;
            z-index: 10;
        }
        .dropdown-menu.show {
            display: block;
        }
        .dropdown-menu a,
        .dropdown-menu button {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: #1a2e24;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            transition: 0.15s;
        }
        .dropdown-menu a:hover,
        .dropdown-menu button:hover {
            background: #e8f5e9;
        }
        .dropdown-menu .divider {
            height: 1px;
            background: #d4e8db;
            margin: 4px 0;
        }

        /* ===== HERO ===== */
        .hero {
            padding: 80px 0 60px;
            background: linear-gradient(145deg, #e8f5e9 0%, #c8e6c9 100%);
            text-align: center;
            border-bottom: 4px solid #6fcf97;
        }
        .hero .badge {
            display: inline-block;
            background: #0d2b1f;
            color: #6fcf97;
            padding: 6px 20px;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .hero h1 {
            font-size: 52px;
            font-weight: 800;
            line-height: 1.2;
            color: #0d2b1f;
            margin-bottom: 16px;
        }
        .hero h1 i {
            color: #2e7d5a;
        }
        .hero p {
            font-size: 20px;
            color: #1f4232;
            max-width: 600px;
            margin: 0 auto 30px;
        }
        .hero .btn-hero {
            background: #0d2b1f;
            color: white;
            border: none;
            padding: 16px 48px;
            border-radius: 60px;
            font-weight: 700;
            font-size: 18px;
            cursor: pointer;
            transition: 0.25s;
            box-shadow: 0 8px 28px rgba(13,43,31,0.3);
            text-decoration: none;
            display: inline-block;
        }
        .hero .btn-hero:hover {
            background: #1a4532;
            transform: translateY(-4px);
        }

        /* ===== FITUR ===== */
        .features {
            padding: 60px 0;
        }
        .section-title {
            text-align: center;
            font-size: 34px;
            font-weight: 800;
            color: #0d2b1f;
            margin-bottom: 8px;
        }
        .section-sub {
            text-align: center;
            font-size: 18px;
            color: #2d5a43;
            margin-bottom: 40px;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 30px;
        }
        .feature-item {
            background: white;
            padding: 40px 20px;
            border-radius: 24px;
            text-align: center;
            box-shadow: 0 6px 24px rgba(0,30,10,0.06);
            border: 1px solid #d4e8db;
            transition: 0.3s;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .feature-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 36px rgba(0,30,10,0.12);
        }
        .feature-item .icon-box {
            font-size: 48px;
            color: #2e7d5a;
            margin-bottom: 16px;
        }
        .feature-item h3 {
            font-size: 22px;
            color: #0d2b1f;
            font-weight: 700;
        }

        /* ===== FOOTER ===== */
        .footer {
            background: #071a12;
            padding: 30px 0;
            text-align: center;
            color: #8baa99;
            font-size: 14px;
            border-top: 1px solid #1e4533;
        }
        .footer a {
            color: #6fcf97;
            text-decoration: none;
        }
        .footer .social {
            margin-top: 12px;
            display: flex;
            justify-content: center;
            gap: 20px;
            font-size: 22px;
        }
        .footer .social a {
            color: #8baa99;
            transition: 0.2s;
        }
        .footer .social a:hover {
            color: #6fcf97;
        }

        @media (max-width: 700px) {
            .hero h1 {
                font-size: 32px;
            }
            .navbar .container {
                flex-direction: column;
                gap: 10px;
            }
            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<!-- ===== NAVBAR SEDERHANA ===== -->
<nav class="navbar">
    <div class="container">
        <a href="{{ route('home') }}" class="logo">
            <i class="fas fa-leaf"></i> EcoPoint
        </a>

        <div class="nav-right">
            @auth
                <a href="{{ route('user.setoran') }}" class="btn-nav">Setor</a>
                <div class="profile-dropdown" id="profileDropdown">
                    <div class="avatar" id="avatarBtn">
                        {{ strtoupper(substr(Auth::user()->first_name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="{{ route('user.profile') }}">
                            <i class="fas fa-user-edit"></i> Edit Profile
                        </a>
                        <div class="divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" style="color:#6fcf97; font-weight:600;">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="{{ route('register') }}" class="btn-nav">Daftar</a>
            @endauth
        </div>
    </div>
</nav>

<!-- ===== HERO ===== -->
<section class="hero">
    <div class="container">
        <div class="badge">
            @auth
                <i class="fas fa-hand-peace"></i> Selamat datang, {{ Auth::user()->first_name ?? 'Pecinta Bumi' }}!
            @else
                <i class="fas fa-recycle"></i> #HidupBerkelanjutan
            @endauth
        </div>

        <h1><i class="fas fa-seedling"></i> Bersama EcoPoint, Bumi Lebih Hijau</h1>
        <p>
            Setor sampah daur ulang, kumpulkan poin, dan tukarkan dengan uang tunai.
            Mulai langkah kecilmu sekarang.
        </p>
        @auth
            <a href="{{ route('user.setoran') }}" class="btn-hero">
                <i class="fas fa-recycle"></i> Setor Sekarang
            </a>
        @else
            <a href="{{ route('register') }}" class="btn-hero">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </a>
        @endauth
    </div>
</section>

<!-- ===== FITUR ===== -->
<section class="features" id="fitur">
    <div class="container">
        <h2 class="section-title">Fitur Unggulan</h2>
        <p class="section-sub">Semua kemudahan ada di sini</p>
        <div class="features-grid">
            <a href="{{ route('user.poin') }}" class="feature-item">
                <div class="icon-box"><i class="fas fa-coins"></i></div>
                <h3>Tukar Poin Jadi Uang</h3>
            </a>
            <a href="{{ route('user.setoran') }}" class="feature-item">
                <div class="icon-box"><i class="fas fa-truck-fast"></i></div>
                <h3>Jemput Sampah</h3>
            </a>
            <a href="#" class="feature-item">
                <div class="icon-box"><i class="fas fa-chart-line"></i></div>
                <h3>Pantau Dampak</h3>
            </a>
        </div>
    </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div class="container">
        <p>&copy; {{ date('Y') }} <strong>EcoPoint</strong> — Gerakan Hijau untuk Masa Depan.</p>
        <div class="social">
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
            <a href="#"><i class="fab fa-linkedin"></i></a>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const avatarBtn = document.getElementById('avatarBtn');
        const dropdownMenu = document.getElementById('dropdownMenu');
        if (avatarBtn && dropdownMenu) {
            avatarBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownMenu.classList.toggle('show');
            });
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.profile-dropdown')) {
                    dropdownMenu.classList.remove('show');
                }
            });
        }
    });
</script>

</body>
</html>