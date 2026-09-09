<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EcoPoint — Poin Saya</title>
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
        .page-hero {
            background: linear-gradient(145deg, #0d2b1f, #1a4532);
            padding: 40px 0 60px;
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
            width: 350px;
            height: 350px;
            background: rgba(111,207,151,0.06);
            border-radius: 50%;
        }
        .page-hero::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: -5%;
            width: 250px;
            height: 250px;
            background: rgba(111,207,151,0.04);
            border-radius: 50%;
        }
        .page-hero .container { position: relative; z-index: 1; text-align: center; }
        .page-hero h1 {
            color: #fff;
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
        }
        .page-hero h1 i { color: #6fcf97; font-size: 36px; }
        .page-hero p {
            color: rgba(255,255,255,0.7);
            font-size: 16px;
            margin-top: 6px;
        }

        /* ===== BALANCE CARD ===== */
        .balance-wrapper {
            display: flex;
            justify-content: center;
            margin: -32px auto 32px;
            position: relative;
            z-index: 2;
        }
        .balance-card {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(16px);
            border-radius: 32px;
            padding: 24px 36px;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 16px 48px rgba(13,43,31,0.12);
            border: 1px solid rgba(255,255,255,0.5);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: 0.3s;
        }
        .balance-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 64px rgba(13,43,31,0.15);
        }
        .balance-card .info .label {
            font-size: 14px;
            font-weight: 500;
            color: #5a7f6e;
        }
        .balance-card .info .value {
            font-size: 38px;
            font-weight: 800;
            color: #1a4532;
            letter-spacing: -0.5px;
        }
        .balance-card .info .value small {
            font-size: 16px;
            font-weight: 600;
            color: #6c7d74;
            margin-left: 4px;
        }
        .balance-card .icon-wrap {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #e1f0e8, #cde0d6);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #2e7d5a;
        }

        /* ===== RIWAYAT ===== */
        .history-section {
            max-width: 820px;
            margin: 0 auto 40px;
        }
        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .history-header h2 {
            font-size: 20px;
            font-weight: 700;
            color: #1a4532;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .history-header h2 i { color: #2e7d5a; }

        .history-card {
            background: white;
            border-radius: 28px;
            border: 1px solid #eaf1ed;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            padding: 20px 0 4px;
            overflow: hidden;
        }
        .history-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .history-table th {
            text-align: left;
            padding: 12px 20px;
            background: #f6faf8;
            color: #2d5a43;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e8f0ec;
        }
        .history-table td {
            padding: 14px 20px;
            border-bottom: 1px solid #edf3ef;
            color: #1a2e24;
        }
        .history-table tr:last-child td { border-bottom: none; }
        .history-table .status {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 12px;
        }
        .status-success { background: #def5e6; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-failed { background: #fde8e8; color: #721c24; }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c7d74;
        }
        .empty-state i {
            font-size: 48px;
            color: #cde0d6;
            margin-bottom: 12px;
            display: block;
        }
        .empty-state p { font-size: 15px; }

        /* ===== TOMBOL AKSI ===== */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-top: 8px;
        }
        .btn-poin {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 36px;
            border-radius: 60px;
            font-weight: 700;
            font-size: 15px;
            text-decoration: none;
            transition: 0.25s ease;
            border: none;
            cursor: pointer;
        }
        .btn-poin-primary {
            background: linear-gradient(135deg, #2e7d5a, #1a4532);
            color: white;
            box-shadow: 0 6px 24px rgba(46,125,90,0.25);
        }
        .btn-poin-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 36px rgba(46,125,90,0.35);
        }
        .btn-poin-secondary {
            background: white;
            color: #2d5a43;
            border: 1.5px solid #d4e8db;
        }
        .btn-poin-secondary:hover {
            background: #f0f7f2;
            border-color: #6fcf97;
            transform: translateY(-3px);
            box-shadow: 0 8px 28px rgba(0,0,0,0.04);
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

            .page-hero { padding: 30px 0 50px; border-radius: 0 0 28px 28px; }
            .page-hero h1 { font-size: 26px; }

            .balance-card { padding: 18px 22px; max-width: 360px; flex-wrap: wrap; gap: 10px; }
            .balance-card .info .value { font-size: 30px; }
            .balance-card .icon-wrap { width: 50px; height: 50px; font-size: 24px; }

            .history-section { padding: 0 4px; }
            .history-table th, .history-table td { padding: 10px 14px; font-size: 13px; }
            .action-buttons { flex-direction: column; align-items: stretch; }
            .btn-poin { width: 100%; justify-content: center; }
        }

        @media (max-width: 480px) {
            .container { padding: 0 12px; }
            .logo { font-size: 22px; }
            .balance-card { flex-direction: column; text-align: center; }
            .balance-card .icon-wrap { align-self: center; }
            .history-table th, .history-table td { padding: 8px 10px; font-size: 12px; }
            .history-table .status { font-size: 10px; padding: 2px 10px; }
        }

        /* ===== ANIMASI ===== */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .balance-card { animation: fadeUp 0.5s ease both; }
        .history-card { animation: fadeUp 0.5s ease 0.15s both; }
        .action-buttons { animation: fadeUp 0.5s ease 0.2s both; }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar">
    <div class="container">
        <a href="{{ route('user.dashboard') }}" class="logo"><i class="fas fa-recycle"></i> EcoPoint</a>

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
<section class="page-hero">
    <div class="container">
        <h1><i class="fas fa-coins"></i> Poin Saya</h1>
        <p>Kelola dan pantau poin serta riwayat penukaran Anda</p>
    </div>
</section>

<!-- ===== CONTENT ===== -->
<div class="poin-page" style="padding: 0 0 40px; background: #f0f7f2; flex:1;">
    <div class="container">

        <!-- Balance Card -->
        <div class="balance-wrapper">
            <div class="balance-card">
                <div class="info">
                    <div class="label">Total Poin</div>
                    <div class="value">{{ Auth::user()->points ?? 0 }} <small>poin</small></div>
                </div>
                <div class="icon-wrap">
                    <i class="fas fa-coins"></i>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="action-buttons" style="margin-bottom: 32px;">
            <a href="{{ route('user.withdraw') }}" class="btn-poin btn-poin-primary">
                <i class="fas fa-exchange-alt"></i> Tukar Poin
            </a>
            <a href="{{ route('user.setoran') }}" class="btn-poin btn-poin-secondary">
                <i class="fas fa-recycle"></i> Lihat Setoran
            </a>
        </div>

        <!-- Riwayat Penukaran -->
        <div class="history-section">
@isset($histories)
    <span style="font-size:14px; color:#6c7d74;">{{ $histories->count() }} transaksi</span>
@else
    <span style="font-size:14px; color:#6c7d74;">0 transaksi</span>
@endisset
            <div class="history-card">
                @if(isset($histories) && $histories->count() > 0)
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Poin</th>
                                <th>Jumlah</th>
                                <th>Metode</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($histories as $history)
                            <tr>
                                <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $history->points }}</td>
                                <td>Rp {{ number_format($history->amount, 0, ',', '.') }}</td>
                                <td>{{ strtoupper($history->payment_method) }}</td>
                                <td>
                                    <span class="status 
                                        @if($history->status == 'success') status-success
                                        @elseif($history->status == 'pending') status-pending
                                        @else status-failed @endif">
                                        {{ ucfirst($history->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>Belum ada riwayat penukaran.<br>Mulai tukar poin Anda sekarang!</p>
                    </div>
                @endif
            </div>
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