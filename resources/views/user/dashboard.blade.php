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
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f0f7f2;
            color: #1a2e24;
            line-height: 1.6;
        }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

        /* ===== NAVBAR RESPONSIVE ===== */
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
            gap: 15px;
        }
        .logo {
            color: #6fcf97;
            font-size: 26px;
            font-weight: 800;
            text-decoration: none;
            letter-spacing: -0.5px;
            order: 1;
        }
        .logo i { color: #a8e6c1; margin-right: 8px; }

        /* Hamburger (Garis 3) */
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            order: 3;
            z-index: 10;
        }
        .hamburger span {
            display: block;
            width: 26px;
            height: 3px;
            background: #cde8d6;
            border-radius: 4px;
            transition: 0.3s;
        }
        .hamburger.active span:nth-child(1) { transform: rotate(45deg) translate(6px, 6px); }
        .hamburger.active span:nth-child(2) { opacity: 0; }
        .hamburger.active span:nth-child(3) { transform: rotate(-45deg) translate(6px, -6px); }

        /* Menu Navigasi */
        .nav-links {
            display: flex;
            gap: 28px;
            align-items: center;
            order: 2;
        }
        .nav-links a {
            color: #cde8d6;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
        }
        .nav-links a:hover { color: #6fcf97; }

        /* Elemen Kanan (Nama User) - Desktop */
        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
            order: 3;
        }
        .nav-right .btn-account {
            background: transparent;
            color: #cde8d6;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 8px;
            transition: 0.2s;
            white-space: nowrap;
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .nav-right .btn-account:hover { color: #6fcf97; background: rgba(255,255,255,0.05); }

        /* Elemen Mobile */
        .mobile-divider, .mobile-actions { display: none; }

        /* ===== HERO ===== */
        .hero {
            padding: 80px 0 60px;
            background: linear-gradient(145deg, #e8f5e9 0%, #c8e6c9 100%);
            text-align: center;
            border-bottom: 4px solid #6fcf97;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: -50px; left: -50px;
            width: 200px; height: 200px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
        }
        .hero::after {
            content: '';
            position: absolute;
            bottom: -50px; right: -50px;
            width: 250px; height: 250px;
            background: rgba(46,125,90,0.1);
            border-radius: 50%;
        }
        .hero .container { position: relative; z-index: 1; }
        .hero .badge {
            display: inline-block;
            background: #0d2b1f;
            color: #6fcf97;
            padding: 8px 24px;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(13,43,31,0.2);
        }
        .hero h1 {
            font-size: 50px;
            font-weight: 800;
            line-height: 1.2;
            color: #0d2b1f;
            margin-bottom: 16px;
        }
        .hero h1 i { color: #2e7d5a; }
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
        .hero .hero-stats {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 40px;
            flex-wrap: wrap;
        }
        .hero .stat-box { text-align: center; }
        .hero .stat-box strong { display: block; font-size: 2rem; color: #0d2b1f; }
        .hero .stat-box span { font-size: 0.85rem; color: #2d5a43; }

        /* ===== FITUR ===== */
        .features { padding: 60px 0; }
        .section-title { text-align: center; font-size: 34px; font-weight: 800; color: #0d2b1f; margin-bottom: 8px; }
        .section-sub { text-align: center; font-size: 18px; color: #2d5a43; margin-bottom: 40px; }
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 30px; }
        .feature-item {
            background: white;
            padding: 40px 25px;
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
            transform: translateY(-8px);
            box-shadow: 0 12px 36px rgba(0,30,10,0.12);
            border-color: #6fcf97;
        }
        .feature-item .icon-box {
            font-size: 48px;
            color: #2e7d5a;
            margin-bottom: 16px;
            background: #e8f5e9;
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }
        .feature-item h3 { font-size: 22px; color: #0d2b1f; font-weight: 700; margin-bottom: 8px; }
        .feature-item p { font-size: 0.9rem; color: #4d7a63; }

        /* ===== CARA KERJA ===== */
        .how-it-works { padding: 60px 0; background: #ffffff; border-top: 1px solid #e0ece5; border-bottom: 1px solid #e0ece5; }
        .steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; text-align: center; }
        .step-item { position: relative; padding: 0 20px; }
        .step-number {
            background: #0d2b1f;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.2rem;
            margin: 0 auto 16px;
        }
        .step-item h3 { font-size: 1.2rem; font-weight: 700; margin-bottom: 8px; }
        .step-item p { font-size: 0.9rem; color: #4d7a63; }

        /* ===== FOOTER ===== */
        .footer { background: #071a12; padding: 30px 0; text-align: center; color: #8baa99; font-size: 14px; border-top: 1px solid #1e4533; }
        .footer a { color: #6fcf97; text-decoration: none; }
        .footer .social { margin-top: 12px; display: flex; justify-content: center; gap: 20px; font-size: 22px; }
        .footer .social a { color: #8baa99; transition: 0.2s; }
        .footer .social a:hover { color: #6fcf97; }

        /* ===== RESPONSIVE MOBILE ===== */
        @media (max-width: 768px) {
            .hamburger { display: flex; }

            .nav-links {
                display: none;
                flex-direction: column;
                width: 100%;
                gap: 16px;
                padding: 15px 0;
                border-top: 1px solid #1e4533;
                margin-top: 10px;
                order: 4;
            }
            .nav-links.open { display: flex; }
            .nav-links a { font-size: 16px; width: 100%; text-align: center; padding: 8px 0; }

            .nav-right { display: none; }

            .mobile-divider { display: block; height: 1px; background: #1e4533; width: 100%; margin: 8px 0; }
            
            .mobile-actions { 
                display: flex; 
                flex-direction: column; 
                width: 100%; 
                gap: 0; 
                align-items: stretch; 
            }
            .mobile-actions .btn-account,
            .mobile-actions form { width: 100%; margin: 0; display: flex; align-items: center; justify-content: center; }
            .mobile-actions .btn-account {
                background: transparent;
                color: #cde8d6;
                font-weight: 600;
                font-size: 16px;
                text-decoration: none;
                padding: 12px 0;
            }
            .mobile-actions form button {
                background: transparent;
                border: none;
                color: #cde8d6;
                font-weight: 600;
                font-size: 16px;
                width: 100%;
                padding: 12px 0;
                cursor: pointer;
            }

            .hero { padding: 50px 0 40px; }
            .hero h1 { font-size: 32px; }
            .hero p { font-size: 16px; padding: 0 15px; }
            .hero .btn-hero { padding: 14px 32px; font-size: 16px; }
            .hero .hero-stats { gap: 20px; margin-top: 30px; }
            
            .section-title { font-size: 28px; }
            .features-grid { grid-template-columns: 1fr; }
            
            .steps-grid { grid-template-columns: 1fr; gap: 40px; }
            .step-item { padding: 0; }
        }
    </style>
</head>
<body>

<!-- ===== NAVBAR RESPONSIVE ===== -->
<nav class="navbar">
    <div class="container">
        <a href="{{ route('user.dashboard') }}" class="logo">
            <i class="fas fa-leaf"></i> EcoPoint
        </a>

        <button class="hamburger" id="hamburgerBtn" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>

        <div class="nav-links" id="navLinks">
            <a href="{{ route('user.dashboard') }}">Beranda</a>
            <a href="{{ route('user.setoran') }}">Setoran</a>
            <a href="{{ route('user.poin') }}">Poin</a>
            
            <div class="mobile-divider"></div>

            @auth
                <div class="mobile-actions">
                    <a href="{{ route('user.profile') }}" class="btn-account">
                        <i class="fas fa-user"></i> {{ Auth::user()->name }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="mobile-actions">
                    <a href="{{ route('login') }}" style="color:#6fcf97; font-weight:600;">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn-nav">Daftar</a>
                </div>
            @endauth
        </div>

        <div class="nav-right">
            @auth
                <a href="{{ route('user.profile') }}" class="btn-account">
                    <i class="fas fa-user"></i> {{ Auth::user()->name }}
                </a>
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
                <i class="fas fa-hand-peace"></i> Selamat datang, {{ Auth::user()->name }}!
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
            <a href="{{ route('user.transaksi.create') }}" class="btn-hero">
                <i class="fas fa-recycle"></i> Mulai Setor Sekarang
            </a>
        @else
            <a href="{{ route('register') }}" class="btn-hero">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </a>
        @endauth

        @auth
        <div class="hero-stats">
            <div class="stat-box">
                <strong>{{ number_format($totalPoin ?? 0) }}</strong>
                <span>Total Poin Kamu</span>
            </div>
            <div class="stat-box">
                <strong>{{ number_format($totalSetoran ?? 0) }}</strong>
                <span>Total Setoran</span>
            </div>
            <div class="stat-box">
                <strong>{{ number_format($totalBerat ?? 0, 1) }} kg</strong>
                <span>Sampah Terkumpul</span>
            </div>
        </div>
        @endauth
    </div>
</section>

<!-- ===== FITUR ===== -->
<section class="features" id="fitur">
    <div class="container">
        <h2 class="section-title">Fitur Unggulan</h2>
        <p class="section-sub">Semua kemudahan ada di sini</p>
        <div class="features-grid">
            <a href="{{ route('user.transaksi.create') }}" class="feature-item">
                <div class="icon-box"><i class="fas fa-recycle"></i></div>
                <h3>Setor Sampah</h3>
                <p>Ajukan setoran sampah daur ulang dengan metode jemput atau antar ke titik kumpul.</p>
            </a>
            <a href="{{ route('user.setoran') }}" class="feature-item">
                <div class="icon-box"><i class="fas fa-history"></i></div>
                <h3>Riwayat Setoran</h3>
                <p>Lihat semua transaksi setoran, status, dan total sampah yang sudah kamu kumpulkan.</p>
            </a>
            <a href="{{ route('user.poin') }}" class="feature-item">
                <div class="icon-box"><i class="fas fa-coins"></i></div>
                <h3>Poin Saya</h3>
                <p>Pantau saldo poin kamu dan tukarkan dengan uang!</p>
            </a>
        </div>
    </div>
</section>

<!-- ===== CARA KERJA ===== -->
<section class="how-it-works">
    <div class="container">
        <h2 class="section-title">Cara Kerjanya</h2>
        <p class="section-sub">Hanya 3 langkah mudah untuk mulai berkontribusi!</p>
        
        <div class="steps-grid">
            <div class="step-item">
                <div class="step-number">1</div>
                <h3>Pilih Metode</h3>
                <p>Pilih apakah ingin sampah dijemput atau diantar ke titik kumpul terdekat.</p>
            </div>
            <div class="step-item">
                <div class="step-number">2</div>
                <h3>Timbang & Setor</h3>
                <p>Petugas menimbang sampahmu atau kamu menimbang sendiri di titik kumpul.</p>
            </div>
            <div class="step-item">
                <div class="step-number">3</div>
                <h3>Raih Poin</h3>
                <p>Poin otomatis masuk ke akunmu dan bisa langsung ditukar dengan uang!</p>
            </div>
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
        // Hamburger toggle (Menu Mobile)
        const hamburger = document.getElementById('hamburgerBtn');
        const navLinks = document.getElementById('navLinks');
        if (hamburger && navLinks) {
            hamburger.addEventListener('click', function() {
                hamburger.classList.toggle('active');
                navLinks.classList.toggle('open');
            });
            // Tutup menu saat link diklik
            navLinks.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    hamburger.classList.remove('active');
                    navLinks.classList.remove('open');
                });
            });
        }
    });
</script>

</body>
</html>