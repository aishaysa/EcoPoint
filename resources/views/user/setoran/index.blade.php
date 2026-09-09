<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EcoPoint — Riwayat Setoran</title>
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
            padding: 40px 0 56px;
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

        /* ===== STATISTIK ===== */
        .stats-wrapper {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin: -28px auto 32px;
            max-width: 820px;
            width: 100%;
            position: relative;
            z-index: 2;
        }
        .stat-card {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            padding: 20px 18px;
            border: 1px solid rgba(255,255,255,0.5);
            box-shadow: 0 8px 32px rgba(13,43,31,0.08);
            text-align: center;
            transition: 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(13,43,31,0.12);
        }
        .stat-card .number {
            font-size: 28px;
            font-weight: 800;
            color: #1a4532;
            line-height: 1.2;
        }
        .stat-card .number small {
            font-size: 16px;
            font-weight: 600;
            color: #6c7d74;
        }
        .stat-card .label {
            font-size: 14px;
            color: #5a7f6e;
            margin-top: 4px;
            font-weight: 500;
        }
        .stat-card .icon {
            font-size: 24px;
            color: #2e7d5a;
            margin-bottom: 6px;
            display: block;
        }

        /* ===== TOMBOL AKSI ===== */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 24px;
            max-width: 820px;
            margin-left: auto;
            margin-right: auto;
        }
        .action-bar .title {
            font-size: 20px;
            font-weight: 700;
            color: #1a4532;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .action-bar .title i { color: #2e7d5a; }
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #2e7d5a, #1a4532);
            color: white;
            padding: 12px 28px;
            border-radius: 60px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            transition: 0.25s ease;
            box-shadow: 0 4px 16px rgba(46,125,90,0.25);
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 28px rgba(46,125,90,0.35);
        }

        /* ===== TABEL ===== */
        .table-card {
            background: white;
            border-radius: 28px;
            border: 1px solid #eaf1ed;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            padding: 20px 0 4px;
            max-width: 820px;
            margin: 0 auto;
            overflow: hidden;
            animation: fadeUp 0.5s ease 0.15s both;
        }
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            min-width: 640px;
        }
        th {
            text-align: left;
            padding: 14px 20px;
            background: #f6faf8;
            color: #2d5a43;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e8f0ec;
        }
        td {
            padding: 14px 20px;
            border-bottom: 1px solid #edf3ef;
            color: #1a2e24;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f9fcfb; }

        .badge-status {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 12px;
        }
        .badge-selesai, .badge-approved, .badge-completed { background: #def5e6; color: #155724; }
        .badge-proses, .badge-pending { background: #fff3cd; color: #856404; }
        .badge-ditolak, .badge-rejected { background: #fde8e8; color: #721c24; }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 16px;
            border-radius: 40px;
            background: #e8f0ec;
            color: #2d5a43;
            text-decoration: none;
            font-weight: 600;
            font-size: 12px;
            transition: 0.2s;
            border: none;
            cursor: pointer;
        }
        .btn-detail:hover {
            background: #6fcf97;
            color: #0d2b1f;
        }

        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: #6c7d74;
        }
        .empty-state i {
            font-size: 48px;
            color: #cde0d6;
            display: block;
            margin-bottom: 12px;
        }
        .empty-state p { font-size: 15px; }

        .pagination-wrapper {
            margin-top: 20px;
            display: flex;
            justify-content: center;
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

            .page-hero { padding: 28px 0 44px; border-radius: 0 0 28px 28px; }
            .page-hero h1 { font-size: 26px; }
            .page-hero p { font-size: 14px; }

            .stats-wrapper {
                grid-template-columns: 1fr;
                gap: 10px;
                margin-top: -20px;
                max-width: 400px;
            }
            .stat-card {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 14px 18px;
                text-align: left;
            }
            .stat-card .icon { margin-bottom: 0; font-size: 20px; }
            .stat-card .number { font-size: 24px; }
            .stat-card .label { margin-top: 0; font-size: 13px; }

            .action-bar { flex-direction: column; align-items: stretch; text-align: center; }
            .btn-primary { justify-content: center; }

            .table-card { border-radius: 20px; padding: 12px 0 0; }
            th, td { padding: 10px 14px; font-size: 13px; }
        }

        @media (max-width: 480px) {
            .container { padding: 0 12px; }
            .logo { font-size: 22px; }
            .page-hero h1 { font-size: 22px; }
            th, td { padding: 8px 10px; font-size: 12px; }
            .btn-detail { font-size: 11px; padding: 4px 12px; }
        }

        /* ===== ANIMASI ===== */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .stat-card { animation: fadeUp 0.5s ease both; }
        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.1s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }
        .action-bar { animation: fadeUp 0.5s ease 0.1s both; }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar">
    <div class="container">
        <a href="{{ route('user.dashboard') }}" class="logo">
            EcoPoint
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
<section class="page-hero">
    <div class="container">
        <h1><i class="fas fa-history"></i> Riwayat Setoran</h1>
        <p>Lihat semua setoran sampah yang telah Anda kirimkan</p>
    </div>
</section>

<!-- ===== CONTENT ===== -->
<div style="padding: 0 0 40px; background: #f0f7f2; flex:1;">
    <div class="container">

        <!-- Statistik -->
        <div class="stats-wrapper">
            <div class="stat-card">
                <div>
                    <span class="icon"><i class="fas fa-boxes"></i></span>
                    <div class="number">{{ $totalSetoran ?? 0 }}</div>
                    <div class="label">Total Setoran</div>
                </div>
            </div>
            <div class="stat-card">
                <div>
                    <span class="icon"><i class="fas fa-weight-hanging"></i></span>
                    <div class="number">{{ number_format($totalBerat ?? 0, 2) }} <small>kg</small></div>
                    <div class="label">Total Berat</div>
                </div>
            </div>
            <div class="stat-card">
                <div>
                    <span class="icon"><i class="fas fa-coins"></i></span>
                    <div class="number">{{ number_format($totalPoin ?? 0) }}</div>
                    <div class="label">Total Poin</div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi & Judul -->
        <div class="action-bar">
            <div class="title">
                <i class="fas fa-list-ul"></i> Daftar Setoran
            </div>
            <a href="{{ route('user.transaksi.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Setor Baru
            </a>
        </div>

        <!-- Tabel -->
        <div class="table-card">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Metode</th>
                            <th>Berat (kg)</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $trx)
                            <tr>
                                <td>#{{ $trx->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</td>
                                <td>{{ ucfirst($trx->metode) }}</td>
                                <td>{{ number_format($trx->berat, 2) }}</td>
                                <td>
                                    <span class="badge-status badge-{{ $trx->status }}">
                                        {{ ucfirst($trx->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('user.transaksi.detail', $trx->id) }}" class="btn-detail">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-box-open"></i>
                                        <p>Belum ada setoran. Yuk, mulai setor sekarang!</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($transaksis->hasPages())
                <div class="pagination-wrapper">
                    {{ $transaksis->links() }}
                </div>
            @endif
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