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
        /* ===== RESET & BASE ===== */
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

        /* ===== NAVBAR ===== */
        .navbar {
            background: #0d2b1f;
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
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
            letter-spacing: -0.5px;
            text-decoration: none;
        }

        .logo i {
            color: #a8e6c1;
            margin-right: 8px;
        }

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
        }

        .nav-links a:hover {
            color: #6fcf97;
        }

        /* ===== HERO (DUA KOLOM) ===== */
        .hero {
            padding: 60px 0 40px 0;
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            border-bottom: 4px solid #6fcf97;
        }

        .hero .container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
        }

        .hero-text {
            flex: 1 1 500px;
        }

        .hero-text .badge {
            display: inline-block;
            background: #0d2b1f;
            color: #6fcf97;
            padding: 6px 18px;
            border-radius: 40px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 16px;
        }

        .hero-text h1 {
            font-size: 48px;
            font-weight: 800;
            line-height: 1.2;
            color: #0d2b1f;
            margin-bottom: 16px;
        }

        .hero-text h1 i {
            color: #2e7d5a;
        }

        .hero-text p {
            font-size: 18px;
            color: #1f4232;
            max-width: 550px;
            margin-bottom: 24px;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            align-items: center;
        }

        .hero-actions .btn-primary {
            background: #0d2b1f;
            color: white;
            border: none;
            padding: 14px 36px;
            border-radius: 60px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: 0.25s;
            box-shadow: 0 6px 20px rgba(13, 43, 31, 0.25);
            text-decoration: none;
            display: inline-block;
        }

        .hero-actions .btn-primary:hover {
            background: #1a4532;
            transform: translateY(-3px);
            color: white;
        }

        .hero-actions .small-hint {
            display: block;
            width: 100%;
            font-size: 14px;
            color: #2d5a43;
            margin-top: 4px;
        }

        .hero-image {
            flex: 1 1 300px;
            text-align: center;
            font-size: 100px;
            color: #2e7d5a;
            background: rgba(255, 255, 255, 0.4);
            padding: 30px 20px;
            border-radius: 40px;
            backdrop-filter: blur(2px);
        }

        .hero-image span {
            font-size: 18px;
            display: block;
            font-weight: 600;
            color: #1a4532;
            margin-top: 8px;
        }

        /* ===== DIVIDER + TOMBOL LIHAT SELENGKAPNYA ===== */
        .section-divider {
            padding: 30px 0 10px 0;
            text-align: center;
        }

        .btn-reveal {
            background: #0d2b1f;
            color: white;
            border: none;
            padding: 16px 50px;
            border-radius: 60px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 8px 28px rgba(13, 43, 31, 0.3);
            letter-spacing: 0.5px;
        }

        .btn-reveal:hover {
            background: #1f4d38;
            transform: scale(1.02);
        }

        .btn-reveal i {
            margin-right: 12px;
        }

        /* ===== KONTEN BLUR (FITUR, CARA KERJA, TENTANG) ===== */
        .blur-wrapper {
            transition: all 0.4s ease;
        }

        .blur-wrapper.blurred .feature-card,
        .blur-wrapper.blurred .cara-kerja-item,
        .blur-wrapper.blurred .tentang-card {
            filter: blur(10px);
            opacity: 0.4;
            user-select: none;
            pointer-events: none;
            transform: scale(0.96);
        }

        .blur-wrapper.blurred .section-title,
        .blur-wrapper.blurred .section-sub {
            filter: blur(8px);
            opacity: 0.4;
            user-select: none;
        }

        /* ===== FITUR UNGGULAN ===== */
        .features-section {
            padding: 20px 0 40px 0;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        .feature-card {
            background: white;
            padding: 32px 24px;
            border-radius: 28px;
            text-align: center;
            box-shadow: 0 8px 30px rgba(0, 30, 10, 0.08);
            border: 1px solid #d4e8db;
            transition: filter 0.4s, opacity 0.4s, transform 0.3s;
        }

        .feature-card .icon {
            font-size: 48px;
            color: #2e7d5a;
            margin-bottom: 12px;
        }

        .feature-card h3 {
            font-size: 22px;
            color: #0d2b1f;
            margin-bottom: 8px;
        }

        .feature-card p {
            color: #2d4d3b;
            font-size: 15px;
        }

        /* ===== CARA KERJA ===== */
        .cara-kerja-section {
            padding: 40px 0;
        }

        .cara-kerja-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        .cara-kerja-item {
            text-align: center;
            padding: 20px;
            background: #f8fbf9;
            border-radius: 24px;
            border: 1px solid #d4e8db;
            transition: filter 0.4s, opacity 0.4s, transform 0.3s;
        }

        .cara-kerja-item .step-number {
            background: #0d2b1f;
            color: #6fcf97;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 800;
            margin: 0 auto 16px auto;
        }

        .cara-kerja-item h4 {
            font-size: 20px;
            color: #0d2b1f;
            margin-bottom: 8px;
        }

        .cara-kerja-item p {
            color: #2d4d3b;
            font-size: 15px;
        }

        /* ===== TENTANG ===== */
        .tentang-section {
            padding: 40px 0 20px 0;
        }

        .tentang-card {
            background: white;
            padding: 40px;
            border-radius: 28px;
            text-align: center;
            box-shadow: 0 8px 30px rgba(0, 30, 10, 0.08);
            border: 1px solid #d4e8db;
            transition: filter 0.4s, opacity 0.4s, transform 0.3s;
        }

        .tentang-card p {
            font-size: 18px;
            color: #2d4d3b;
            max-width: 700px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 32px;
            font-weight: 800;
            color: #0d2b1f;
            margin-bottom: 8px;
            transition: 0.4s;
        }

        .section-sub {
            text-align: center;
            font-size: 18px;
            color: #2d5a43;
            margin-bottom: 20px;
            transition: 0.4s;
        }

        /* ===== CTA ===== */
        .cta-section {
            background: linear-gradient(145deg, #0d2b1f 0%, #1a4532 100%);
            border-radius: 48px 48px 0 0;
            padding: 70px 30px 60px 30px;
            margin-top: 30px;
            color: white;
            text-align: center;
        }

        .cta-section h2 {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 14px;
            letter-spacing: -0.5px;
        }

        .cta-section h2 i {
            color: #6fcf97;
            margin-right: 12px;
        }

        .cta-section p {
            font-size: 18px;
            opacity: 0.85;
            max-width: 600px;
            margin: 0 auto 32px auto;
            line-height: 1.7;
        }

        .cta-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 18px;
        }

        .cta-buttons .btn-cta-primary {
            background: #6fcf97;
            color: #0d2b1f;
            border: none;
            padding: 16px 44px;
            border-radius: 60px;
            font-weight: 800;
            font-size: 18px;
            cursor: pointer;
            transition: 0.25s;
            box-shadow: 0 8px 24px rgba(111, 207, 151, 0.3);
            text-decoration: none;
            display: inline-block;
        }

        .cta-buttons .btn-cta-primary:hover {
            background: #84dba5;
            transform: translateY(-4px);
            color: #0d2b1f;
        }

        .cta-buttons .btn-cta-secondary {
            background: transparent;
            border: 2px solid #6fcf97;
            color: #cde8d6;
            padding: 16px 44px;
            border-radius: 60px;
            font-weight: 700;
            font-size: 18px;
            cursor: pointer;
            transition: 0.25s;
            text-decoration: none;
            display: inline-block;
        }

        .cta-buttons .btn-cta-secondary:hover {
            background: rgba(111, 207, 151, 0.12);
            border-color: #84dba5;
            color: #cde8d6;
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
            margin-top: 10px;
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

        /* ===== RESPONSIVE ===== */
        @media (max-width: 700px) {
            .hero-text h1 {
                font-size: 32px;
            }
            .cta-section h2 {
                font-size: 30px;
            }
            .nav-links {
                gap: 16px;
                flex-wrap: wrap;
                justify-content: center;
                margin-top: 10px;
            }
            .navbar .container {
                flex-direction: column;
            }
            .hero .container {
                flex-direction: column-reverse;
                text-align: center;
            }
            .hero-actions {
                justify-content: center;
            }
            .hero-text p {
                margin-left: auto;
                margin-right: auto;
            }
            .hero-image {
                font-size: 70px;
                padding: 20px;
            }
            .btn-reveal {
                padding: 14px 30px;
                font-size: 16px;
                width: 100%;
            }
            .cara-kerja-grid {
                grid-template-columns: 1fr;
            }
            .tentang-card {
                padding: 24px;
            }
        }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar">
    <div class="container">
        <a href="{{ route('home') }}" class="logo">
            <i class="fas fa-recycle"></i> EcoPoint
        </a>
        <div class="nav-links">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="#tentang">Tentang</a>
            <a href="#cara-kerja">Cara Kerja</a>
        </div>
    </div>
</nav>

<!-- ===== HERO ===== -->
<section class="hero">
    <div class="container">
        <div class="hero-text">
            <div class="badge"><i class="fas fa-recycle"></i> #HidupBerkelanjutan</div>
            <h1><i class="fas fa-seedling"></i> Hidup Berkelanjutan dengan EcoPoint</h1>
            <p>
                Setor sampah daur ulang, kumpulkan poin, dan tukarkan dengan uang tunai.
                Mudah, cepat, dan berdampak.
            </p>
            <div class="hero-actions">
                    <a href="{{ route('register') }}" class="btn-primary">
                        <i class="fas fa-user-plus"></i> Daftar Sekarang
                    </a>
                    <small class="small-hint">Belum punya akun? Daftar sekarang!</small>
            </div>
        </div>
        <div class="hero-image">
            <i class="fas fa-recycle"></i>
        </div>
    </div>
</section>

<!-- ===== TOMBOL LIHAT SELENGKAPNYA ===== -->
<div class="section-divider container">
    <button class="btn-reveal" id="toggleBtn">
        <i class="fas fa-chevron-down" id="toggleIcon"></i>
        <span id="toggleLabel">Lihat Selengkapnya</span>
    </button>
</div>

<!-- ===== KONTEN BLUR ===== -->
<div class="blur-wrapper blurred" id="blur-wrapper">
    <div class="container">

        <!-- FITUR UNGGULAN -->
        <section class="features-section">
            <h2 class="section-title">FITUR UNGGULAN</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="icon"><i class="fas fa-coins"></i></div>
                    <h3>Tukar Poin Jadi Uang</h3>
                    <p>Setiap 100 poin = Rp 1.000. Cairkan kapan saja ke dompet digital.</p>
                </div>
                <div class="feature-card">
                    <div class="icon"><i class="fas fa-truck-fast"></i></div>
                    <h3>Jemput Sampah</h3>
                    <p>Kami jemput langsung dari rumah Anda. Gratis dan terjadwal.</p>
                </div>
                <div class="feature-card">
                    <div class="icon"><i class="fas fa-chart-line"></i></div>
                    <h3>Pantau Dampak</h3>
                    <p>Lihat seberapa banyak emisi karbon yang sudah kamu kurangi.</p>
                </div>
            </div>
        </section>

        <!-- CARA KERJA -->
        <section class="cara-kerja-section" id="cara-kerja">
            <h2 class="section-title">Bagaimana Cara Kerjanya?</h2>
            <p class="section-sub">Ikuti 3 langkah mudah ini untuk mulai berkontribusi</p>
            <div class="cara-kerja-grid">
                <div class="cara-kerja-item">
                    <div class="step-number">1</div>
                    <h4>Daftar & Verifikasi</h4>
                    <p>Buat akun EcoPoint dan verifikasi data diri Anda.</p>
                </div>
                <div class="cara-kerja-item">
                    <div class="step-number">2</div>
                    <h4>Setor Sampah</h4>
                    <p>Pilih jenis sampah, timbang, dan kirimkan ke titik kumpul terdekat.</p>
                </div>
                <div class="cara-kerja-item">
                    <div class="step-number">3</div>
                    <h4>Kumpulkan Poin & Tukar</h4>
                    <p>Dapatkan poin dari setiap setoran, lalu tukarkan dengan uang tunai.</p>
                </div>
            </div>
        </section>

        <!-- TENTANG -->
        <section class="tentang-section" id="tentang">
            <h2 class="section-title">Tentang EcoPoint</h2>
            <div class="tentang-card">
                <p>
                    EcoPoint adalah platform yang menghubungkan masyarakat dengan sistem daur ulang.
                    Kami percaya bahwa setiap tindakan kecil dapat membawa dampak besar bagi lingkungan.
                    Dengan mengumpulkan dan mendaur ulang sampah, kita tidak hanya mengurangi limbah,
                    tetapi juga menciptakan nilai ekonomi bagi semua pihak.
                </p>
            </div>
        </section>

    </div>
</div>

<!-- ===== CTA ===== -->
<section class="cta-section">
    <div class="container">
        <h2><i class="fas fa-hand-holding-heart"></i> Siap berkontribusi untuk bumi?</h2>
        <p>
            Mulai langkah kecilmu sekarang. Setorkan sampah daur ulang,
            kumpulkan poin, dan rasakan dampak nyata bagi lingkungan.
        </p>
        <div class="cta-buttons">
                <a href="{{ route('register') }}" class="btn-cta-primary">
                    <i class="fas fa-rocket"></i> Daftar Sekarang
                </a>
            <a href="#blur-wrapper" class="btn-cta-secondary">
                <i class="fas fa-book-open"></i> Pelajari Lebih Lanjut
            </a>
        </div>
    </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div class="container">
        <p>&copy; 2026 <strong>EcoPoint</strong> — Gerakan Hijau untuk Masa Depan.</p>
        <div class="social">
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
            <a href="#"><i class="fab fa-linkedin"></i></a>
        </div>
    </div>
</footer>

<!-- ===== JAVASCRIPT ===== -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggleBtn');
        const toggleLabel = document.getElementById('toggleLabel');
        const toggleIcon = document.getElementById('toggleIcon');
        const blurWrapper = document.getElementById('blur-wrapper');

        let isRevealed = false;

        toggleBtn.addEventListener('click', function () {
            isRevealed = !isRevealed;

            if (isRevealed) {
                blurWrapper.classList.remove('blurred');
                blurWrapper.classList.add('revealed');
                toggleLabel.textContent = 'Sembunyikan';
                toggleIcon.className = 'fas fa-chevron-up';
            } else {
                blurWrapper.classList.remove('revealed');
                blurWrapper.classList.add('blurred');
                toggleLabel.textContent = 'Lihat Selengkapnya';
                toggleIcon.className = 'fas fa-chevron-down';
            }
        });
    });
</script>

</body>
</html>