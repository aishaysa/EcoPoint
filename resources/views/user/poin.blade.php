<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EcoPoint — Poin Saya</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f0f7f2;
            color: #1a2e24;
            line-height: 1.6;
        }
        .container { max-width:1200px; margin:0 auto; padding:0 24px; }

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
        .logo i { color: #a8e6c1; margin-right:8px; }

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

        /* ===== CONTENT POIN ===== */
        .poin-page {
            padding: 60px 0;
            background: #f0f7f2;
            min-height: 70vh;
        }
        .poin-card {
            background: #ffffff;
            border-radius: 30px;
            border: 1px solid #d4e8db;
            box-shadow: 0 8px 30px rgba(15,23,42,0.06);
            padding: 40px 30px;
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }
        .poin-icon {
            font-size: 5rem;
            color: #f1c40f;
            margin-bottom: 10px;
        }
        .poin-number {
            font-size: 4rem;
            font-weight: 800;
            color: #2e7d5a;
        }
        .poin-label {
            font-size: 1.1rem;
            color: #4d7a63;
            margin-top: 4px;
        }
        .poin-actions {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }
        .btn-poin {
            display: inline-block;
            padding: 12px 32px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            transition: 0.2s;
            border: none;
            cursor: pointer;
        }
        .btn-poin-primary {
            background: #2e7d5a;
            color: white;
        }
        .btn-poin-primary:hover {
            background: #1a4532;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46,125,90,0.3);
        }
        .btn-poin-secondary {
            background: white;
            color: #2d5a43;
            border: 1px solid #d4e8db;
        }
        .btn-poin-secondary:hover {
            background: #f0f7f2;
            border-color: #6fcf97;
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
        .footer a { color: #6fcf97; text-decoration: none; }
        .footer .social {
            margin-top: 12px;
            display: flex;
            justify-content: center;
            gap: 20px;
            font-size: 22px;
        }
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
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 100%;
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

            .poin-page { padding: 40px 0; }
            .poin-card { padding: 30px 20px; }
            .poin-number { font-size: 3rem; }
            .poin-actions { flex-direction: column; align-items: stretch; }
            .btn-poin { text-align: center; }
        }

        @media (max-width: 480px) {
            .container { padding: 0 12px; }
            .logo { font-size: 22px; }
        }
    </style>
</head>
<body>

<!-- ===== NAVBAR RESPONSIVE ===== -->
<nav class="navbar">
    <div class="container">
        <a href="{{ route('user.dashboard') }}" class="logo"><i class="fas fa-leaf"></i> EcoPoint</a>

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

<!-- ===== CONTENT POIN ===== -->
<div class="poin-page">
    <div class="container">
        <div class="poin-card">
            <div class="poin-icon">
                <i class="fas fa-coins"></i>
            </div>
            <div class="poin-number">{{ $poin ?? 0 }}</div>
            <div class="poin-label">Total Poin Anda</div>

            <div class="poin-actions">
<a href="{{ route('user.withdraw') }}" class="btn-poin btn-poin-primary">
    <i class="fas fa-exchange-alt"></i> Tukar Poin
</a>
                <a href="{{ route('user.setoran') }}" class="btn-poin btn-poin-secondary">
                    <i class="fas fa-recycle"></i> Lihat Setoran
                </a>
            </div>
        </div>
    </div>
</div>

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
        const hamburger = document.getElementById('hamburgerBtn');
        const navLinks = document.getElementById('navLinks');
        if (hamburger && navLinks) {
            hamburger.addEventListener('click', function() {
                hamburger.classList.toggle('active');
                navLinks.classList.toggle('open');
            });
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