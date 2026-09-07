<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EcoPoint — Tukar Poin</title>
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

        /* NAVBAR */
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

        .mobile-divider, .mobile-actions { display: none; }

        /* ===== CONTENT ===== */
        .poin-page {
            padding: 40px 0 60px;
            background: #f0f7f2;
            min-height: 70vh;
        }
        .poin-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .poin-header h1 {
            font-size: 28px;
            color: #1a4532;
            font-weight: 800;
        }
        .poin-header p {
            color: #4d7a63;
            font-size: 16px;
            margin-top: 4px;
        }
        .poin-balance {
            background: white;
            border-radius: 20px;
            padding: 20px 30px;
            max-width: 400px;
            margin: 0 auto 32px;
            text-align: center;
            border: 1px solid #d4e8db;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }
        .poin-balance span {
            font-size: 14px;
            color: #6c7d74;
        }
        .poin-balance strong {
            font-size: 32px;
            color: #2e7d5a;
            display: block;
            margin-top: 4px;
        }

        /* GRID PAKET */
        .package-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }
        .package-card {
            background: white;
            border-radius: 16px;
            padding: 20px 16px;
            text-align: center;
            border: 2px solid #e8f0ec;
            cursor: pointer;
            transition: 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
        .package-card:hover {
            border-color: #6fcf97;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46,125,90,0.08);
        }
        .package-card.selected {
            border-color: #2e7d5a;
            background: #f6fcf9;
            box-shadow: 0 4px 16px rgba(46,125,90,0.12);
        }
        .package-card .points {
            font-size: 28px;
            font-weight: 800;
            color: #1a4532;
        }
        .package-card .points-label {
            font-size: 12px;
            color: #6c7d74;
            font-weight: 600;
        }
        .package-card .amount {
            font-size: 18px;
            font-weight: 700;
            color: #2e7d5a;
            margin: 6px 0 4px;
        }
        .package-card .badge {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 20px;
            background: #e8f0ec;
            color: #2d5a43;
        }
        .package-card .check {
            display: none;
            color: #2e7d5a;
            font-size: 18px;
            margin-top: 6px;
        }
        .package-card.selected .check {
            display: block;
        }
        .package-card input[type="radio"] {
            display: none;
        }

        /* FORM */
        .form-card {
            background: white;
            border-radius: 24px;
            padding: 28px 24px;
            border: 1px solid #d4e8db;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
            max-width: 600px;
            margin: 0 auto;
        }
        .form-card h3 {
            font-size: 18px;
            color: #1a4532;
            margin-bottom: 16px;
        }

        .form-group {
            margin-bottom: 16px;
        }
        .form-group label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 4px;
            color: #2d5a43;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d4e8db;
            border-radius: 12px;
            font-size: 15px;
            transition: 0.2s;
            background: white;
        }
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #2e7d5a;
            box-shadow: 0 0 0 4px rgba(46,125,90,0.08);
        }

        /* Metode Pembayaran */
        .method-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 10px;
            margin-bottom: 16px;
        }
        .method-item {
            background: white;
            border: 2px solid #e8f0ec;
            border-radius: 12px;
            padding: 12px 8px;
            text-align: center;
            cursor: pointer;
            transition: 0.2s;
            font-size: 13px;
            font-weight: 600;
            color: #2d5a43;
        }
        .method-item:hover {
            border-color: #6fcf97;
        }
        .method-item.active {
            border-color: #2e7d5a;
            background: #f6fcf9;
        }
        .method-item i {
            font-size: 22px;
            display: block;
            margin-bottom: 4px;
            color: #2e7d5a;
        }
        .method-item input[type="radio"] {
            display: none;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 16px;
            font-weight: 600;
            font-size: 14px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .btn-submit {
            display: inline-block;
            padding: 14px 32px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 16px;
            text-decoration: none;
            transition: 0.2s;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: center;
            background: #2e7d5a;
            color: white;
        }
        .btn-submit:hover {
            background: #1a4532;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46,125,90,0.3);
        }
        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-back {
            display: inline-block;
            padding: 12px 32px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            transition: 0.2s;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: center;
            background: white;
            color: #2d5a43;
            border: 1px solid #d4e8db;
            margin-top: 10px;
        }
        .btn-back:hover {
            background: #f0f7f2;
            border-color: #6fcf97;
        }

        /* FOOTER */
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

        /* RESPONSIVE */
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
            .package-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }
            .method-grid {
                grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            }
            .method-item {
                font-size: 11px;
                padding: 10px 6px;
            }
            .method-item i {
                font-size: 18px;
            }
            .poin-balance strong {
                font-size: 28px;
            }
            .form-card {
                padding: 20px 16px;
            }
        }

        @media (max-width: 480px) {
            .container { padding: 0 12px; }
            .logo { font-size: 22px; }
            .package-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .method-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
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

<!-- ===== CONTENT ===== -->
<div class="poin-page">
    <div class="container">
        <div class="poin-header">
            <h1><i class="fas fa-hand-holding-usd" style="color:#2e7d5a;"></i> Tukar Poin</h1>
            <p>Pilih paket di bawah untuk menukar poin menjadi uang</p>
        </div>

        <div class="poin-balance">
            <span>Total Poin Anda</span>
            <strong>{{ Auth::user()->points ?? 0 }}</strong>
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="max-width:600px; margin:0 auto 16px;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger" style="max-width:600px; margin:0 auto 16px;">{{ session('error') }}</div>
        @endif

        <form action="{{ route('user.withdraw.store') }}" method="POST" id="withdrawForm">
            @csrf

            <div class="form-card">
                <h3><i class="fas fa-box"></i> Pilih Paket</h3>
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
                    <p style="grid-column:1/-1; text-align:center; color:#6c7d74; padding:20px;">
                        Belum ada paket penukaran. Silakan cek kembali nanti.
                    </p>
                    @endforelse
                </div>

                <hr style="border: none; border-top: 1px solid #e8f0ec; margin: 20px 0;">

                <h3><i class="fas fa-wallet"></i> Metode Pembayaran</h3>
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

                <!-- Field dinamis -->
                <div id="dynamicFields">
                    <!-- Bank fields -->
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

                    <!-- E-Wallet fields (DANA, GoPay, OVO, QRIS) -->
                    <div id="ewalletFields" style="display:none;">
                        <div class="form-group">
                            <label for="phone">Nomor HP / ID</label>
                            <input type="text" name="phone" id="phone" placeholder="Masukkan nomor HP (contoh: 08123456789)">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit" id="submitBtn" disabled>
                    <i class="fas fa-exchange-alt"></i> Tukar Sekarang
                </button>
                <a href="{{ route('user.poin') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali ke Poin
                </a>
            </div>
        </form>
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
        // HAMBURGER TOGGLE
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

        // ===== PAKET =====
        const packageCards = document.querySelectorAll('.package-card');
        const packageRadios = document.querySelectorAll('input[name="package_id"]');

        packageCards.forEach(card => {
            card.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                    // Hapus selected dari semua card
                    packageCards.forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');
                }
                checkFormValidity();
            });
        });

        // ===== METODE =====
        const methodItems = document.querySelectorAll('.method-item');
        const methodRadios = document.querySelectorAll('input[name="payment_method"]');

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

        // ===== TOGGLE FIELDS =====
        function toggleMethodFields() {
            const selected = document.querySelector('input[name="payment_method"]:checked');
            const bankFields = document.getElementById('bankFields');
            const ewalletFields = document.getElementById('ewalletFields');

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
                // update label
                const label = document.querySelector('#ewalletFields label');
                if (label) {
                    if (method === 'qris') label.textContent = 'ID QRIS / Nomor HP';
                    else if (method === 'dana') label.textContent = 'Nomor DANA';
                    else if (method === 'gopay') label.textContent = 'Nomor GoPay';
                    else if (method === 'ovo') label.textContent = 'Nomor OVO';
                }
            } else {
                bankFields.style.display = 'none';
                ewalletFields.style.display = 'none';
            }
        }

        // ===== VALIDASI =====
        function checkFormValidity() {
            const packageSelected = document.querySelector('input[name="package_id"]:checked');
            const methodSelected = document.querySelector('input[name="payment_method"]:checked');
            const submitBtn = document.getElementById('submitBtn');

            if (packageSelected && methodSelected) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }

        // Panggil toggle saat halaman load (untuk mengisi default)
        toggleMethodFields();

        // ===== SUBMIT =====
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