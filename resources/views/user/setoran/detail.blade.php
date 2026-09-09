<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EcoPoint — Detail Setoran #{{ $transaksi->id }}</title>
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
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

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
            border: none;
            cursor: pointer;
            font-family: inherit;
        }
        .nav-right .btn-account:hover { color: #6fcf97; background: rgba(255,255,255,0.05); }
        .mobile-divider, .mobile-actions { display: none; }

        /* ===== HERO ===== */
        .page-hero {
            background: linear-gradient(145deg, #0d2b1f, #1a4532);
            padding: 32px 0 40px;
            position: relative;
            overflow: hidden;
            border-radius: 0 0 40px 40px;
            margin-bottom: 0;
        }
        .page-hero::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(111,207,151,0.06);
            border-radius: 50%;
        }
        .page-hero::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: rgba(111,207,151,0.04);
            border-radius: 50%;
        }
        .page-hero .container { position: relative; z-index: 1; text-align: center; }
        .page-hero h1 {
            color: #fff;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }
        .page-hero h1 i { color: #6fcf97; font-size: 30px; }
        .page-hero p {
            color: rgba(255,255,255,0.7);
            font-size: 15px;
            margin-top: 4px;
        }

        /* ===== STRUK CARD ===== */
        .struk-wrapper {
            display: flex;
            justify-content: center;
            padding: 20px 16px 40px;
        }
        .struk-card {
            max-width: 580px;
            width: 100%;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            padding: 30px 28px 24px;
            border: 1px solid #e6ebf0;
            animation: fadeUp 0.5s ease both;
            position: relative;
            margin-top: -20px;
        }
        .struk-card::before {
            content: '';
            position: absolute;
            top: 12px;
            left: 20px;
            right: 20px;
            border-top: 2px dashed #dce1e6;
        }

        .struk-header {
            text-align: center;
            padding-bottom: 16px;
            margin-bottom: 16px;
            border-bottom: 2px dashed #dce1e6;
        }
        .struk-header h2 {
            font-size: 22px;
            font-weight: 800;
            color: #0d2b1f;
            letter-spacing: 0.5px;
        }
        .struk-header h2 i { color: #2e7d5a; margin-right: 6px; }
        .struk-header .sub {
            font-size: 13px;
            color: #6b7a8a;
            margin-top: 2px;
            font-weight: 500;
        }
        .struk-header .id-badge {
            display: inline-block;
            background: #eef2f6;
            padding: 4px 18px;
            border-radius: 30px;
            font-size: 14px;
            color: #1f3a4b;
            margin-top: 8px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .struk-body {
            margin-bottom: 12px;
        }
        .row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f3f6;
            font-size: 14px;
        }
        .row:last-child { border-bottom: none; }
        .label {
            color: #6b7a8a;
            font-weight: 600;
            flex-shrink: 0;
        }
        .value {
            color: #1f3a4b;
            font-weight: 500;
            text-align: right;
            word-break: break-word;
            max-width: 65%;
        }
        .divider {
            border-top: 2px dashed #dce1e6;
            margin: 14px 0;
        }

        .total-row {
            font-size: 17px;
            font-weight: 700;
            color: #0a6b4a;
            padding: 10px 0;
            border-top: 2px solid #0a6b4a;
            margin-top: 10px;
        }
        .total-row .label { color: #0a6b4a; }
        .total-row .value { color: #0a6b4a; }

        .status-badge {
            display: inline-block;
            padding: 3px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .status-pending { background: #fef3c7; color: #b45309; }
        .status-approved { background: #dbeafe; color: #1d4ed8; }
        .status-completed { background: #d1fae5; color: #065f46; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
        .status-menunggu { background: #fef3c7; color: #b45309; }
        .status-proses { background: #dbeafe; color: #1d4ed8; }
        .status-selesai { background: #d1fae5; color: #065f46; }
        .status-ditolak { background: #fee2e2; color: #991b1b; }

        .struk-footer {
            text-align: center;
            border-top: 2px dashed #dce1e6;
            padding-top: 16px;
            margin-top: 10px;
            font-size: 12px;
            color: #8a9aa8;
        }
        .struk-footer small {
            display: block;
            margin-top: 4px;
            color: #a0b0be;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 18px;
        }
        .btn-back {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px;
            background: #eef2f6;
            color: #1f3a4b;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: 0.2s;
            font-family: inherit;
        }
        .btn-back:hover { background: #dce1e6; }

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

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

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

            .page-hero { padding: 24px 0 32px; }
            .page-hero h1 { font-size: 24px; }
            .page-hero p { font-size: 14px; }

            .struk-card { padding: 24px 18px 20px; margin-top: -16px; }
            .row { font-size: 13px; padding: 6px 0; }
            .total-row { font-size: 15px; }
            .struk-header h2 { font-size: 20px; }
        }

        @media (max-width: 480px) {
            .container { padding: 0 12px; }
            .logo { font-size: 22px; }
            .page-hero h1 { font-size: 20px; }
            .struk-card { padding: 18px 14px 16px; border-radius: 16px; }
            .row { font-size: 12px; padding: 5px 0; }
            .value { max-width: 60%; }
            .btn-back { font-size: 13px; padding: 10px; }
        }

        /* Print styles (opsional, tetap ada untuk jika user print via browser) */
        @media print {
            body { background: white; }
            .navbar, .footer, .page-hero, .action-buttons { display: none !important; }
            .struk-wrapper { padding: 0; margin: 0; }
            .struk-card {
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
                padding: 20px;
                margin-top: 0;
            }
            .struk-card::before { display: none; }
        }
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
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-account">
                            <i class="fas fa-user"></i> {{ Auth::user()->name }}
                        </button>
                    </form>
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
    <section class="page-hero">
        <div class="container">
            <h1><i class="fas fa-receipt"></i> Detail Setoran</h1>
            <p>Informasi lengkap transaksi setoran sampah Anda</p>
        </div>
    </section>

    <!-- ===== STRUK CARD ===== -->
    <div class="struk-wrapper">
        <div class="struk-card">
            <div class="struk-header">
                <h2><i class="fas fa-leaf"></i> EcoPoint</h2>
                <div class="sub">Struk Setoran Sampah</div>
                <div class="id-badge">#{{ $transaksi->id }}</div>
            </div>

            <div class="struk-body">
                <!-- Tanggal -->
                <div class="row">
                    <span class="label">Tanggal</span>
                    <span class="value">{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y, H:i') }}</span>
                </div>

                <!-- Nama Pelanggan -->
                <div class="row">
                    <span class="label">Pelanggan</span>
                    <span class="value">{{ $transaksi->pelanggan->nama ?? $transaksi->nama_pengirim ?? '-' }}</span>
                </div>

                <!-- No HP -->
                <div class="row">
                    <span class="label">No HP</span>
                    <span class="value">{{ $transaksi->no_hp ?? '-' }}</span>
                </div>

                <!-- Metode -->
                <div class="row">
                    <span class="label">Metode</span>
                    <span class="value">
                        @if($transaksi->metode == 'jemput')
                            <i class="fas fa-home" style="color:#2e7d5a;"></i> Jemput
                        @else
                            <i class="fas fa-map-pin" style="color:#2e7d5a;"></i> Antar
                        @endif
                    </span>
                </div>

                <!-- Alamat / Titik Kumpul -->
                @if($transaksi->metode == 'jemput')
                <div class="row">
                    <span class="label">Alamat Jemput</span>
                    <span class="value">{{ $transaksi->alamat_jemput ?? '-' }}</span>
                </div>
                @else
                <div class="row">
                    <span class="label">Titik Kumpul</span>
                    <span class="value">{{ $transaksi->titikKumpul->nama ?? '-' }}</span>
                </div>
                @endif

                <div class="divider"></div>

                <!-- Daftar Jenis Sampah -->
                @if($transaksi->jenisSampahs && $transaksi->jenisSampahs->count())
                    @foreach($transaksi->jenisSampahs as $sampah)
                    <div class="row">
                        <span class="label">{{ $sampah->nama }}</span>
                        <span class="value">{{ number_format($sampah->pivot->berat_estimasi ?? 0, 2) }} kg</span>
                    </div>
                    @endforeach
                @else
                    <div class="row">
                        <span class="label">{{ $transaksi->jenisSampah->nama ?? 'Sampah' }}</span>
                        <span class="value">{{ number_format($transaksi->berat, 2) }} kg</span>
                    </div>
                @endif

                <div class="divider"></div>

                <!-- Total Berat -->
                <div class="row total-row">
                    <span class="label">Total Berat</span>
                    <span class="value">{{ number_format($transaksi->berat, 2) }} kg</span>
                </div>

                <!-- Status -->
                <div class="row" style="margin-top:8px;">
                    <span class="label">Status</span>
                    <span class="value">
                        @php
                            $status = $transaksi->status ?? 'menunggu';
                            $badgeClass = match($status) {
                                'selesai', 'approved', 'completed' => 'status-completed',
                                'proses', 'pending' => 'status-pending',
                                'ditolak', 'rejected' => 'status-rejected',
                                default => 'status-menunggu'
                            };
                        @endphp
                        <span class="status-badge {{ $badgeClass }}">
                            {{ ucfirst($status) }}
                        </span>
                    </span>
                </div>

                <!-- Berat Aktual (jika ada) -->
                @if($transaksi->berat_aktual > 0)
                <div class="row">
                    <span class="label">Berat Aktual</span>
                    <span class="value">{{ number_format($transaksi->berat_aktual, 2) }} kg</span>
                </div>
                @endif

                <!-- Total Harga (jika ada) -->
                @if($transaksi->total_harga > 0)
                <div class="row" style="font-weight:700;color:#0a6b4a;border-top:1px solid #dce1e6;padding-top:10px;margin-top:6px;">
                    <span class="label">Total Harga</span>
                    <span class="value">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
                @endif
            </div>

            <div class="struk-footer">
                <span>Terima kasih telah berkontribusi menjaga lingkungan</span>
                <small>EcoPoint — Daur Ulang untuk Lindungi Lingkungan</small>
            </div>

            <!-- Tombol Kembali (tanpa cetak) -->
            <div class="action-buttons">
                <a href="{{ route('user.setoran') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Setoran
                </a>
            </div>
        </div>
    </div>

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} <strong>EcoPoint</strong> — Daur Ulang untuk Lindungi Lingkungan.</p>
            <div class="social">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </footer>

    <!-- ===== SCRIPT ===== -->
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