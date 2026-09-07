<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EcoPoint — Riwayat Setoran</title>
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

        /* Elemen Kanan (Akun) - Desktop */
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
        }
        .nav-right .btn-account:hover { color: #6fcf97; background: rgba(255,255,255,0.05); }

        /* Elemen Mobile */
        .mobile-divider, .mobile-actions { display: none; }

        /* ===== CONTENT PAGE ===== */
        .riwayat-page { padding: 40px 0 60px; min-height: 70vh; }
        
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 20px;
            gap: 12px;
        }
        .header-section h2 {
            font-size: 28px;
            font-weight: 800;
            margin: 0;
            color: #0d2b1f;
        }

        /* Statistik */
        .stat-box {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-item {
            background: #fff;
            border: 1px solid #d4e8db;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }
        .stat-item .number {
            font-size: 2rem;
            font-weight: 800;
            color: #2e7d5a;
            line-height: 1.2;
        }
        .stat-item .label {
            font-size: 0.85rem;
            color: #4d7a63;
            margin-top: 6px;
        }

        /* Tabel */
        .card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #d4e8db;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            padding: 20px;
        }
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        table {
            width: 100%;
            min-width: 700px;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0ece5;
            font-size: 0.9rem;
        }
        th {
            background: #f0f7f2;
            color: #1a2e24;
            font-weight: 700;
        }
        
        .badge-status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-selesai { background: #d4edda; color: #155724; }
        .badge-proses { background: #fff3cd; color: #856404; }
        .badge-ditolak { background: #f8d7da; color: #721c24; }

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
            
            .header-section {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 12px;
            }
            .header-section a {
                width: 100%;
                text-align: center;
            }

            .stat-box {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .stat-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: left;
                padding: 14px 16px;
            }
            .stat-item .number { font-size: 1.5rem; }
            .stat-item .label { margin-top: 0; font-size: 0.8rem; }
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
                        <i class="fas fa-user"></i> Akun
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
                    <i class="fas fa-user"></i> Akun
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

<!-- ===== CONTENT RIWAYAT ===== -->
<div class="container riwayat-page">
    <div class="header-section">
        <h2>
            <i class="fas fa-history" style="color:#2e7d5a;"></i> Riwayat Setoran
        </h2>
        <a href="{{ route('user.transaksi.create') }}" class="btn-primary btn-success" style="background:#2e7d5a; color:white; padding:10px 20px; border-radius:40px; text-decoration:none; font-weight:700; font-size:0.9rem;">
            <i class="fas fa-plus"></i> Setor Baru
        </a>
    </div>

    <!-- Statistik -->
    <div class="stat-box">
        <div class="stat-item">
            <div class="number">{{ $totalSetoran }}</div>
            <div class="label">Total Setoran</div>
        </div>
        <div class="stat-item">
            <div class="number">{{ number_format($totalBerat, 2) }} kg</div>
            <div class="label">Total Berat</div>
        </div>
        <div class="stat-item">
            <div class="number">{{ number_format($totalPoin) }}</div>
            <div class="label">Total Poin</div>
        </div>
    </div>

    <!-- Tabel -->
    <div class="card">
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
                                <a href="{{ route('user.transaksiDetail', $trx->id) }}" class="btn-primary btn-sm" style="background:#6fcf97; color:#0d2b1f; padding:6px 12px; border-radius:20px; text-decoration:none; font-weight:700; font-size:0.8rem;">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <a href="{{ route('user.cetakTransaksi', $trx->id) }}" class="btn-primary btn-sm btn-outline" style="background:transparent; border:1px solid #6fcf97; color:#2e7d5a; padding:6px 12px; border-radius:20px; text-decoration:none; font-weight:700; font-size:0.8rem; margin-top:4px; display:inline-block;">
                                    <i class="fas fa-print"></i> Cetak
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:40px 0; color:#2d5a43;">
                                <i class="fas fa-box-open" style="font-size:40px; display:block; margin-bottom:8px;"></i>
                                Belum ada setoran. Yuk, mulai setor sekarang!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($transaksis->hasPages())
            <div style="margin-top:20px; display:flex; justify-content:center;">
                {{ $transaksis->links() }}
            </div>
        @endif
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