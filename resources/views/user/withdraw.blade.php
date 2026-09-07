<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EcoPoint — Tukar Poin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f9f6;
            color: #1a2e24;
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            background: #0d2b1f;
            padding: 14px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
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
        .logo i {
            color: #a8e6c1;
        }
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
            font-size: 14px;
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
            gap: 18px;
        }
        .nav-right .btn-account {
            background: rgba(255,255,255,0.06);
            color: #cde8d6;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 40px;
            transition: 0.25s;
            border: 1px solid transparent;
        }
        .nav-right .btn-account:hover {
            background: rgba(111,207,151,0.12);
            border-color: #6fcf97;
            color: #6fcf97;
        }
        .btn-nav {
            background: #6fcf97;
            color: #0d2b1f !important;
            padding: 8px 20px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            transition: 0.25s;
        }
        .btn-nav:hover {
            background: #5bbf85;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(111,207,151,0.3);
        }
        .mobile-divider, .mobile-actions { display: none; }

        /* ===== HERO ===== */
        .page-hero {
            background: linear-gradient(145deg, #0d2b1f 0%, #1a4532 100%);
            padding: 36px 0 48px;
            position: relative;
            overflow: hidden;
            border-radius: 0 0 40px 40px;
            margin-bottom: 0;
        }
        .page-hero::before {
            content: '';
            position: absolute;
            top: -40%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(111,207,151,0.05);
            border-radius: 50%;
        }
        .page-hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 250px;
            height: 250px;
            background: rgba(111,207,151,0.04);
            border-radius: 50%;
        }
        .page-hero .container { position: relative; z-index: 1; }
        .page-hero h1 {
            color: #fff;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            gap: 12px;
            justify-content: center;
            text-align: center;
        }
        .page-hero h1 i { color: #6fcf97; }
        .page-hero p {
            color: rgba(255,255,255,0.7);
            font-size: 15px;
            margin-top: 4px;
            text-align: center;
        }

        /* ===== BALANCE CARD ===== */
        .balance-wrapper {
            display: flex;
            justify-content: center;
            margin: -28px auto 24px;
        }
        .balance-card {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            border-radius: 28px;
            padding: 18px 28px;
            max-width: 380px;
            width: 100%;
            box-shadow: 0 12px 40px rgba(13,43,31,0.12);
            border: 1px solid rgba(255,255,255,0.6);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .balance-card .label {
            font-size: 13px;
            font-weight: 500;
            color: #5a7f6e;
        }
        .balance-card .value {
            font-size: 32px;
            font-weight: 800;
            color: #1a4532;
            letter-spacing: -0.5px;
        }
        .balance-card .value small {
            font-size: 14px;
            font-weight: 600;
            color: #6c7d74;
            margin-left: 4px;
        }
        .balance-card .icon-wrap {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #e1f0e8, #cde0d6);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #2e7d5a;
        }

        /* ===== ALERT ===== */
        .alert {
            padding: 12px 18px;
            border-radius: 14px;
            margin-bottom: 16px;
            font-weight: 600;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: 560px;
            margin-left: auto;
            margin-right: auto;
        }
        .alert-success {
            background: #def5e6;
            color: #155724;
            border: 1px solid #b8dfc6;
        }
        .alert-danger {
            background: #fde8e8;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert i { font-size: 16px; }

        /* ===== FORM CARD ===== */
        .form-wrapper {
            display: flex;
            justify-content: center;
        }
        .form-card {
            background: white;
            border-radius: 28px;
            padding: 28px 24px;
            border: 1px solid #eaf1ed;
            box-shadow: 0 4px 24px rgba(0,0,0,0.02);
            max-width: 560px;
            width: 100%;
            transition: 0.3s;
        }
        .form-card:hover {
            box-shadow: 0 8px 40px rgba(0,0,0,0.04);
        }

        .section-title {
            font-size: 17px;
            font-weight: 700;
            color: #1a4532;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title i {
            color: #2e7d5a;
            font-size: 18px;
        }
        .divider {
            border: none;
            border-top: 1.5px solid #edf3ef;
            margin: 20px 0;
        }

        /* ===== PACKAGE GRID ===== */
        .package-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 12px;
        }
        .package-card {
            background: #fafcfa;
            border: 2px solid #e8f0ec;
            border-radius: 18px;
            padding: 16px 12px 14px;
            text-align: center;
            cursor: pointer;
            transition: all 0.25s ease;
            position: relative;
        }
        .package-card:hover {
            border-color: #b8d9c8;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(46,125,90,0.06);
        }
        .package-card.selected {
            border-color: #2e7d5a;
            background: #f2fbf6;
            box-shadow: 0 6px 20px rgba(46,125,90,0.10);
            transform: translateY(-3px);
        }
        .package-card .points {
            font-size: 30px;
            font-weight: 800;
            color: #1a4532;
            line-height: 1.1;
        }
        .package-card .points-label {
            font-size: 11px;
            font-weight: 600;
            color: #8baa99;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .package-card .amount {
            font-size: 16px;
            font-weight: 700;
            color: #2e7d5a;
            margin: 4px 0 4px;
        }
        .package-card .badge {
            display: inline-block;
            font-size: 9px;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 40px;
            background: #e8f0ec;
            color: #2d5a43;
        }
        .package-card .check {
            display: none;
            color: #2e7d5a;
            font-size: 18px;
            margin-top: 4px;
        }
        .package-card.selected .check { display: block; }
        .package-card input[type="radio"] { display: none; }

        /* ===== METHOD GRID ===== */
        .method-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
            gap: 8px;
            margin-bottom: 16px;
        }
        .method-item {
            background: #fafcfa;
            border: 2px solid #e8f0ec;
            border-radius: 16px;
            padding: 12px 6px 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.25s ease;
            font-size: 12px;
            font-weight: 600;
            color: #2d5a43;
        }
        .method-item:hover {
            border-color: #b8d9c8;
            transform: translateY(-2px);
        }
        .method-item.active {
            border-color: #2e7d5a;
            background: #f2fbf6;
            box-shadow: 0 4px 14px rgba(46,125,90,0.08);
        }
        .method-item i {
            font-size: 22px;
            display: block;
            margin-bottom: 4px;
            color: #2e7d5a;
        }
        .method-item input[type="radio"] { display: none; }

        /* ===== DYNAMIC FIELDS ===== */
        #dynamicFields .form-group {
            margin-bottom: 14px;
        }
        #dynamicFields .form-group label {
            display: block;
            font-weight: 600;
            font-size: 13px;
            color: #2d5a43;
            margin-bottom: 4px;
        }
        #dynamicFields .form-group input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e0eae4;
            border-radius: 14px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: 0.25s;
            background: #fafcfa;
        }
        #dynamicFields .form-group input:focus {
            outline: none;
            border-color: #2e7d5a;
            background: white;
            box-shadow: 0 0 0 4px rgba(46,125,90,0.06);
        }
        #dynamicFields .form-group input::placeholder {
            color: #b0c4b8;
        }

        /* ===== BUTTONS ===== */
        .btn-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 28px;
            border-radius: 60px;
            font-weight: 700;
            font-size: 15px;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: center;
            background: linear-gradient(135deg, #2e7d5a, #1a4532);
            color: white;
            box-shadow: 0 4px 16px rgba(46,125,90,0.25);
            transition: 0.3s;
        }
        .btn-submit:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 8px 28px rgba(46,125,90,0.35);
        }
        .btn-submit:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: 60px;
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: center;
            background: transparent;
            color: #2d5a43;
            border: 1.5px solid #e0eae4;
            margin-top: 8px;
            transition: 0.25s;
        }
        .btn-back:hover {
            background: #f2f7f4;
            border-color: #b8d9c8;
        }
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-top: 4px;
        }

        /* ===== FOOTER ===== */
        .footer {
            background: #071a12;
            padding: 28px 0 24px;
            text-align: center;
            color: #8baa99;
            font-size: 13px;
            border-top: 1px solid #1e4533;
            margin-top: auto;
        }
        .footer a { color: #6fcf97; text-decoration: none; }
        .footer .social {
            margin-top: 12px;
            display: flex;
            justify-content: center;
            gap: 20px;
            font-size: 20px;
        }
        .footer .social a {
            color: #5a7f6e;
            transition: 0.25s;
        }
        .footer .social a:hover {
            color: #6fcf97;
            transform: translateY(-2px);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hamburger { display: flex; }
            .nav-links {
                display: none;
                flex-direction: column;
                width: 100%;
                gap: 12px;
                padding: 18px 0 10px;
                border-top: 1px solid #1e4533;
                margin-top: 10px;
            }
            .nav-links.open { display: flex; }
            .nav-links a { font-size: 15px; width: 100%; text-align: center; padding: 6px 0; }
            .nav-links a::after { display: none; }
            .nav-right { display: none; }
            .mobile-divider {
                display: block;
                height: 1px;
                background: #1e4533;
                width: 100%;
                margin: 6px 0;
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
                font-size: 15px;
                text-decoration: none;
                padding: 10px 0;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 100%;
                gap: 8px;
            }
            .mobile-actions form button {
                background: transparent;
                border: none;
                color: #cde8d6;
                font-weight: 600;
                font-size: 15px;
                width: 100%;
                padding: 10px 0;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }

            .page-hero {
                padding: 28px 0 40px;
                border-radius: 0 0 28px 28px;
            }
            .page-hero h1 { font-size: 24px; }
            .page-hero p { font-size: 14px; }

            .balance-card {
                padding: 16px 20px;
                max-width: 340px;
            }
            .balance-card .value { font-size: 28px; }
            .balance-card .icon-wrap { width: 44px; height: 44px; font-size: 20px; }

            .form-card { padding: 22px 16px; border-radius: 24px; max-width: 480px; }
            .package-grid { grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 10px; }
            .package-card .points { font-size: 26px; }
            .method-grid { grid-template-columns: repeat(auto-fill, minmax(75px, 1fr)); gap: 6px; }
            .method-item { font-size: 10px; padding: 10px 4px; border-radius: 14px; }
            .method-item i { font-size: 18px; }
            .container { padding: 0 16px; }
        }

        @media (max-width: 480px) {
            .page-hero h1 { font-size: 20px; }
            .package-grid { grid-template-columns: repeat(2, 1fr); }
            .method-grid { grid-template-columns: repeat(3, 1fr); }
            .balance-card { flex-direction: column; text-align: center; padding: 14px 16px; max-width: 100%; }
            .balance-card .icon-wrap { align-self: center; }
            .form-card { padding: 16px 12px; }
            .form-card .section-title { font-size: 15px; }
        }

        /* ===== ANIMATION ===== */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .form-card { animation: fadeUp 0.5s ease both; }
        .balance-card { animation: fadeUp 0.4s ease 0.1s both; }
        .package-card, .method-item { transition: all 0.25s ease; }
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
                    <a href="{{ route('register') }}" class="btn-nav" style="display:inline-block; width:auto; padding:10px 24px;">Daftar</a>
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
            <h1><i class="fas fa-hand-holding-usd"></i> Tukar Poin</h1>
            <p>Pilih paket di bawah untuk menukar poin menjadi uang tunai</p>
        </div>
    </section>

    <!-- ===== CONTENT ===== -->
    <div class="poin-page">
        <div class="container">

            <!-- Balance Card -->
            <div class="balance-wrapper">
                <div class="balance-card">
                    <div>
                        <div class="label">Total Poin Anda</div>
                        <div class="value">{{ Auth::user()->points ?? 0 }} <small>poin</small></div>
                    </div>
                    <div class="icon-wrap">
                        <i class="fas fa-coins"></i>
                    </div>
                </div>
            </div>

            <!-- Alert -->
            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
            @endif

            <!-- Form -->
            <div class="form-wrapper">
                <form action="{{ route('user.withdraw.store') }}" method="POST" id="withdrawForm" style="width:100%; display:contents;">
                    @csrf

                    <div class="form-card">
                        <!-- Paket -->
                        <div class="section-title">
                            <i class="fas fa-box"></i> Pilih Paket
                        </div>
                        <div class="package-grid">
                            @forelse($packages as $pkg)
                            <label class="package-card" data-package-id="{{ $pkg->id }}">
                                <input type="radio" name="package_id" value="{{ $pkg->id }}">
                                <div class="points">{{ $pkg->points }}</div>
                                <div class="points-label">Poin</div>
                                <div class="amount">Rp {{ number_format($pkg->amount, 0, ',', '.') }}</div>
                                <div class="badge">{{ $pkg->description }}</div>
                                <div class="check"><i class="fas fa-check-circle"></i></div>
                            </label>
                            @empty
                            <p style="grid-column:1/-1; text-align:center; color:#6c7d74; padding:20px 0; font-size:14px;">
                                <i class="fas fa-info-circle" style="margin-right:6px;"></i>
                                Belum ada paket penukaran.
                            </p>
                            @endforelse
                        </div>

                        <hr class="divider">

                        <!-- Metode -->
                        <div class="section-title">
                            <i class="fas fa-wallet"></i> Metode Pembayaran
                        </div>
                        <div class="method-grid" id="methodGrid">
                            <label class="method-item" data-method="qris">
                                <input type="radio" name="payment_method" value="qris">
                                <i class="fas fa-qrcode"></i>
                                QRIS
                            </label>
                            <label class="method-item" data-method="dana">
                                <input type="radio" name="payment_method" value="dana">
                                <i class="fas fa-wallet"></i>
                                DANA
                            </label>
                            <label class="method-item" data-method="gopay">
                                <input type="radio" name="payment_method" value="gopay">
                                <i class="fas fa-money-bill"></i>
                                GoPay
                            </label>
                            <label class="method-item" data-method="ovo">
                                <input type="radio" name="payment_method" value="ovo">
                                <i class="fas fa-mobile-alt"></i>
                                OVO
                            </label>
                            <label class="method-item" data-method="bank">
                                <input type="radio" name="payment_method" value="bank">
                                <i class="fas fa-university"></i>
                                Bank
                            </label>
                        </div>

                        <!-- Dynamic Fields -->
                        <div id="dynamicFields">
                            <!-- Bank -->
                            <div id="bankFields" style="display:none;">
                                <div class="form-group">
                                    <label for="bank_name">Nama Bank</label>
                                    <input type="text" name="bank_name" id="bank_name" placeholder="BCA, BNI, BRI, Mandiri, dll">
                                </div>
                                <div class="form-group">
                                    <label for="account_number">Nomor Rekening</label>
                                    <input type="text" name="account_number" id="account_number" placeholder="Masukkan nomor rekening">
                                </div>
                            </div>
                            <!-- E-Wallet -->
                            <div id="ewalletFields" style="display:none;">
                                <div class="form-group">
                                    <label for="phone" id="phoneLabel">Nomor HP / ID</label>
                                    <input type="text" name="phone" id="phone" placeholder="Masukkan nomor HP (contoh: 08123456789)">
                                </div>
                            </div>
                        </div>

                        <div class="btn-group">
                            <button type="submit" class="btn-submit" id="submitBtn" disabled>
                                <i class="fas fa-exchange-alt"></i> Tukar Sekarang
                            </button>
                            <a href="{{ route('user.poin') }}" class="btn-back">
                                <i class="fas fa-arrow-left"></i> Kembali ke Poin
                            </a>
                        </div>
                    </div>
                </form>
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

    <!-- ===== SCRIPT ===== -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ---- HAMBURGER ----
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

            // ---- PAKET ----
            const packageCards = document.querySelectorAll('.package-card');
            packageCards.forEach(card => {
                card.addEventListener('click', function() {
                    const radio = this.querySelector('input[type="radio"]');
                    if (radio) {
                        radio.checked = true;
                        packageCards.forEach(c => c.classList.remove('selected'));
                        this.classList.add('selected');
                    }
                    checkFormValidity();
                });
            });

            // ---- METODE ----
            const methodItems = document.querySelectorAll('.method-item');
            methodItems.forEach(item => {
                item.addEventListener('click', function() {
                    const radio = this.querySelector('input[type="radio"]');
                    if (radio) {
                        radio.checked = true;
                        methodItems.forEach(m => m.classList.remove('active'));
                        this.classList.add('active');
                    }
                    toggleMethodFields();
                    checkFormValidity();
                });
            });

            // ---- TOGGLE FIELDS ----
            function toggleMethodFields() {
                const selected = document.querySelector('input[name="payment_method"]:checked');
                const bankFields = document.getElementById('bankFields');
                const ewalletFields = document.getElementById('ewalletFields');
                const phoneLabel = document.getElementById('phoneLabel');

                if (!selected) {
                    bankFields.style.display = 'none';
                    ewalletFields.style.display = 'none';
                    return;
                }

                const method = selected.value;
                if (method === 'bank') {
                    bankFields.style.display = 'block';
                    ewalletFields.style.display = 'none';
                } else if (['qris', 'dana', 'gopay', 'ovo'].includes(method)) {
                    bankFields.style.display = 'none';
                    ewalletFields.style.display = 'block';
                    const labels = {
                        qris: 'ID QRIS / Nomor HP',
                        dana: 'Nomor DANA',
                        gopay: 'Nomor GoPay',
                        ovo: 'Nomor OVO'
                    };
                    if (phoneLabel) phoneLabel.textContent = labels[method] || 'Nomor HP / ID';
                } else {
                    bankFields.style.display = 'none';
                    ewalletFields.style.display = 'none';
                }
            }

            // ---- VALIDASI ----
            function checkFormValidity() {
                const packageSelected = document.querySelector('input[name="package_id"]:checked');
                const methodSelected = document.querySelector('input[name="payment_method"]:checked');
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = !(packageSelected && methodSelected);
            }

            // Inisialisasi
            toggleMethodFields();
            const checkedPkg = document.querySelector('input[name="package_id"]:checked');
            if (checkedPkg) {
                const parent = checkedPkg.closest('.package-card');
                if (parent) parent.classList.add('selected');
            }
            const checkedMethod = document.querySelector('input[name="payment_method"]:checked');
            if (checkedMethod) {
                const parent = checkedMethod.closest('.method-item');
                if (parent) parent.classList.add('active');
                toggleMethodFields();
            }
            checkFormValidity();

            // ---- SUBMIT ----
            const form = document.getElementById('withdrawForm');
            form.addEventListener('submit', function(e) {
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            });

        });
    </script>

</body>
</html>