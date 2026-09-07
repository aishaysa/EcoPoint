<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EcoPoint — Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f0f7f2;
            color: #1a2e24;
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .container { max-width:1200px; margin:0 auto; padding:0 24px; }

        /* ===== NAVBAR ===== */
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
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .logo i { color: #a8e6c1; }

        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
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
        .hamburger.active span:nth-child(1) { transform: rotate(45deg) translate(6px,6px); }
        .hamburger.active span:nth-child(2) { opacity: 0; }
        .hamburger.active span:nth-child(3) { transform: rotate(-45deg) translate(6px,-6px); }

        .nav-links {
            display: flex;
            gap: 28px;
            align-items: center;
        }
        .nav-links a {
            color: #cde8d6;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: 0.2s;
            position: relative;
        }
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: #6fcf97;
            transition: 0.3s;
        }
        .nav-links a:hover { color: #6fcf97; }
        .nav-links a:hover::after { width: 100%; }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
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

        .mobile-divider, .mobile-actions { display: none; }

        /* ===== HERO ===== */
        .hero {
            background: linear-gradient(145deg, #0d2b1f, #1a4532);
            padding: 60px 0 70px;
            position: relative;
            overflow: hidden;
            border-radius: 0 0 40px 40px;
            margin-bottom: 0;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(111,207,151,0.06);
            border-radius: 50%;
        }
        .hero::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: -5%;
            width: 300px;
            height: 300px;
            background: rgba(111,207,151,0.04);
            border-radius: 50%;
        }
        .hero .container {
            position: relative;
            z-index: 1;
            text-align: center;
        }
        .hero .badge {
            display: inline-block;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(4px);
            color: #6fcf97;
            padding: 8px 24px;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 20px;
            border: 1px solid rgba(255,255,255,0.05);
        }
        .hero h1 {
            color: #fff;
            font-size: 44px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.5px;
            margin-bottom: 16px;
        }
        .hero h1 i { color: #6fcf97; }
        .hero p {
            color: rgba(255,255,255,0.8);
            font-size: 18px;
            max-width: 600px;
            margin: 0 auto 30px;
            line-height: 1.6;
        }
        .hero .btn-hero {
            background: #6fcf97;
            color: #0d2b1f;
            border: none;
            padding: 14px 40px;
            border-radius: 60px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: 0.25s ease;
            box-shadow: 0 8px 28px rgba(111,207,151,0.3);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .hero .btn-hero:hover {
            background: #5bbf85;
            transform: translateY(-3px);
            box-shadow: 0 12px 36px rgba(111,207,151,0.4);
        }

        /* ===== STATISTIK ===== */
        .stats-wrapper {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            max-width: 780px;
            margin: -32px auto 40px;
            padding: 0 16px;
            position: relative;
            z-index: 2;
        }
        .stat-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 14px 16px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.04);
            border: 1px solid #e0ece5;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: 0.2s ease;
        }
        .stat-card:hover {
            box-shadow: 0 6px 20px rgba(0,0,0,0.06);
            border-color: #b8d9c8;
        }
        .stat-card .icon {
            font-size: 22px;
            color: #2e7d5a;
            width: 36px;
            text-align: center;
            flex-shrink: 0;
        }
        .stat-card .info {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        .stat-card .number {
            font-size: 22px;
            font-weight: 700;
            color: #0d2b1f;
        }
        .stat-card .number small {
            font-size: 14px;
            font-weight: 600;
            color: #4d7a63;
        }
        .stat-card .label {
            font-size: 13px;
            color: #4d7a63;
            font-weight: 500;
        }

        /* ===== FITUR ===== */
        .features { padding: 10px 0 50px; }
        .section-title {
            text-align: center;
            font-size: 32px;
            font-weight: 800;
            color: #0d2b1f;
            margin-bottom: 6px;
        }
        .section-sub {
            text-align: center;
            font-size: 16px;
            color: #4d7a63;
            margin-bottom: 36px;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 28px;
            max-width: 900px;
            margin: 0 auto;
        }
        .feature-item {
            background: white;
            padding: 30px 22px;
            border-radius: 24px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            border: 1px solid #eaf1ed;
            transition: 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .feature-item:hover {
            transform: translateY(-6px);
            border-color: #6fcf97;
            box-shadow: 0 12px 36px rgba(0,0,0,0.04);
        }
        .feature-item .icon-box {
            font-size: 40px;
            color: #2e7d5a;
            background: #e8f5e9;
            width: 76px;
            height: 76px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
            transition: 0.3s;
        }
        .feature-item:hover .icon-box { background: #c8e6c9; }
        .feature-item h3 {
            font-size: 20px;
            font-weight: 700;
            color: #0d2b1f;
            margin-bottom: 6px;
        }
        .feature-item p {
            font-size: 14px;
            color: #4d7a63;
        }

        /* ===== CARA KERJA ===== */
        .how-it-works {
            padding: 50px 0;
            background: white;
            border-top: 1px solid #eaf1ed;
            border-bottom: 1px solid #eaf1ed;
        }
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            max-width: 860px;
            margin: 0 auto;
            text-align: center;
        }
        .step-item {
            position: relative;
            padding: 0 10px;
        }
        .step-number {
            background: #0d2b1f;
            color: white;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 22px;
            margin: 0 auto 14px;
            box-shadow: 0 4px 15px rgba(13,43,31,0.15);
        }
        .step-item h3 {
            font-size: 18px;
            font-weight: 700;
            color: #0d2b1f;
            margin-bottom: 6px;
        }
        .step-item p {
            font-size: 14px;
            color: #4d7a63;
        }

        /* ===== FOOTER ===== */
        .footer {
            background: #071a12;
            padding: 30px 0;
            text-align: center;
            color: #8baa99;
            font-size: 14px;
            border-top: 1px solid #1e4533;
            margin-top: auto;
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

        /* ===== RESPONSIVE ===== */
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
            }
            .nav-links.open { display: flex; }
            .nav-links a { font-size: 16px; width: 100%; text-align: center; padding: 8px 0; }
            .nav-links a::after { display: none; }
            .nav-right { display: none; }
            .mobile-divider {
                display: block;
                height: 1px;
                background: #1e4533;
                width: 100%;
                margin: 8px 0;
            }
            .mobile-actions {
                display: flex;
                flex-direction: column;
                width: 100%;
                gap: 0;
                align-items: stretch;
            }
            .mobile-actions .btn-account,
            .mobile-actions form {
                width: 100%;
                margin: 0;
                display: flex;
                align-items: center;
                justify-content: center;
            }
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

            .hero { padding: 40px 0 50px; border-radius: 0 0 30px 30px; }
            .hero h1 { font-size: 30px; }
            .hero p { font-size: 16px; padding: 0 10px; }

            .stats-wrapper {
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
                max-width: 100%;
                margin-top: -24px;
                padding: 0 12px;
            }
            .stat-card {
                padding: 10px 12px;
                gap: 8px;
                border-radius: 12px;
            }
            .stat-card .icon { font-size: 18px; width: 28px; }
            .stat-card .number { font-size: 18px; }
            .stat-card .number small { font-size: 12px; }
            .stat-card .label { font-size: 11px; }

            .section-title { font-size: 28px; }
            .features-grid { grid-template-columns: 1fr; }
            .steps-grid { grid-template-columns: 1fr; gap: 40px; }
        }

        @media (max-width: 480px) {
            .container { padding: 0 12px; }
            .logo { font-size: 22px; }
            .hero h1 { font-size: 26px; }
            .stats-wrapper {
                grid-template-columns: repeat(3, 1fr);
                gap: 6px;
                padding: 0 8px;
            }
            .stat-card {
                padding: 8px 8px;
                gap: 4px;
                flex-direction: column;
                text-align: center;
                border-radius: 10px;
            }
            .stat-card .icon { font-size: 16px; width: auto; }
            .stat-card .number { font-size: 16px; }
            .stat-card .number small { font-size: 10px; }
            .stat-card .label { font-size: 10px; }
        }

        /* ===== ANIMASI ===== */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .stat-card { animation: fadeUp 0.4s ease both; }
        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.1s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }
        .feature-item { animation: fadeUp 0.5s ease 0.2s both; }
        .step-item { animation: fadeUp 0.5s ease 0.25s both; }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar">
    <div class="container">
        <a href="{{ route('user.dashboard') }}" class="logo">
            <i class="fas fa-recycle"></i> EcoPoint
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

        <h1><i class="fas fa-leaf"></i> EcoPoint</h1>
        <p>Setor sampah daur ulang, kumpulkan poin, dan tukarkan dengan uang tunai. Mulai langkah kecilmu sekarang.</p>
        @auth
            <a href="{{ route('user.setoran.create') }}" class="btn-hero">
                <i class="fas fa-recycle"></i> Mulai Setor Sekarang
            </a>
        @else
            <a href="{{ route('register') }}" class="btn-hero">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </a>
        @endauth
    </div>
</section>

<!-- ===== STATISTIK ===== -->
@auth
    @php
        $user = Auth::user();
        $pelangganId = optional($user->pelanggan)->id ?? 0;

        // Total setoran (semua status)
        $totalSetoran = \App\Models\Setoran::where('pelanggan_id', $pelangganId)->count();

        // Total berat aktual (semua status)
        $totalBerat = \App\Models\Setoran::where('pelanggan_id', $pelangganId)->sum('berat_aktual');

        // ===== PERBAIKAN: Ambil poin dari kolom users.points =====
        // Pastikan kolom 'points' ada di tabel users dan sudah diisi oleh admin saat ACC setoran
        $totalPoin = $user->points ?? 0;

        // === ALTERNATIF (jika tidak pakai users.points):
        // Hitung langsung dari setoran yang sudah approved/completed (1 kg = 100 poin, sesuaikan)
        // $totalPoin = \App\Models\Setoran::where('pelanggan_id', $pelangganId)
        //               ->whereIn('status', ['approved', 'completed'])
        //               ->sum('berat_aktual') * 100;
    @endphp

    <div class="stats-wrapper">
        <div class="stat-card">
            <div class="info">
                <div class="number">{{ number_format($totalPoin) }}</div>
                <div class="label">Total Poin</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="info">
                <div class="number">{{ $totalSetoran }}</div>
                <div class="label">Total Setoran</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="info">
                <div class="number">{{ number_format($totalBerat, 1) }} <small>kg</small></div>
                <div class="label">Total Berat</div>
            </div>
        </div>
    </div>
@else
    <div class="stats-wrapper" style="margin-top: 0; padding-top: 20px;">
        <div class="stat-card">
            <span class="icon"><i class="fas fa-recycle"></i></span>
            <div class="info">
                <div class="number">Bergabunglah</div>
                <div class="label">Dapatkan poin Anda</div>
            </div>
        </div>
    </div>
@endauth

<!-- ===== FITUR ===== -->
<section class="features">
    <div class="container">
        <h2 class="section-title">Fitur Unggulan</h2>
        <p class="section-sub">Semua kemudahan ada di sini</p>
        <div class="features-grid">
            <a href="{{ route('user.setoran.create') }}" class="feature-item">
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
                <p>Pantau saldo poin kamu dan tukarkan dengan uang tunai!</p>
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
                <p>Pilih apakah sampah dijemput atau diantar ke titik kumpul terdekat.</p>
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