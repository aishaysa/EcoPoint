<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EcoPoint — Form Setoran</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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
        .page-hero .container {
            position: relative;
            z-index: 1;
            text-align: center;
        }
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

        /* ===== FORM CARD ===== */
        .form-wrapper {
            max-width: 820px;
            margin: -28px auto 40px;
            padding: 0 16px;
            position: relative;
            z-index: 2;
        }
        .form-card {
            background: rgba(255,255,255,0.94);
            backdrop-filter: blur(12px);
            border-radius: 32px;
            border: 1px solid rgba(255,255,255,0.5);
            box-shadow: 0 16px 48px rgba(13,43,31,0.08);
            overflow: hidden;
            animation: fadeUp 0.5s ease both;
        }
        .form-body { padding: 32px 32px 20px; }

        .section {
            padding-bottom: 24px;
            margin-bottom: 24px;
            border-bottom: 1px solid #eaf1ed;
        }
        .section:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: 0;
        }
        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #1a4532;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title i { color: #2e7d5a; font-size: 18px; }

        /* ===== FIELDS ===== */
        .field { margin-bottom: 14px; }
        .field:last-child { margin-bottom: 0; }
        .field label {
            display: block;
            font-weight: 600;
            font-size: 13px;
            color: #2d5a43;
            margin-bottom: 5px;
        }
        .input, .select, .textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e0eae4;
            border-radius: 14px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: 0.25s;
            background: #fafcfa;
            color: #1a2e24;
        }
        .input:focus, .select:focus, .textarea:focus {
            outline: none;
            border-color: #2e7d5a;
            background: white;
            box-shadow: 0 0 0 4px rgba(46,125,90,0.06);
        }
        .textarea { resize: vertical; min-height: 70px; }
        .readonly { background: #edf5f0 !important; color: #2d5a43; cursor: not-allowed; }
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* ===== METODE RADIO ===== */
        .method-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .method-input { position: absolute; opacity: 0; pointer-events: none; }
        .method-label {
            display: block;
            padding: 14px 16px;
            border: 1.5px solid #e0eae4;
            border-radius: 16px;
            cursor: pointer;
            transition: 0.25s ease;
            background: #fafcfa;
            text-align: center;
        }
        .method-input:checked + .method-label {
            border-color: #2e7d5a;
            background: #f2fbf6;
            box-shadow: 0 0 0 3px rgba(46,125,90,0.12);
        }
        .method-label strong {
            display: block;
            font-size: 15px;
            color: #1a4532;
            margin-bottom: 2px;
        }
        .method-label span {
            font-size: 12px;
            color: #5a7f6e;
        }

        /* ===== LOKASI ===== */
        .location-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 12px;
        }
        .location-button {
            border: 1.5px solid #d4e8db;
            border-radius: 40px;
            background: white;
            color: #2d5a43;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .location-button:hover { background: #2e7d5a; color: white; border-color: #2e7d5a; }
        .location-status {
            font-size: 13px;
            color: #5a7f6e;
            font-weight: 500;
            margin-bottom: 12px;
        }

        #map {
            width: 100%;
            height: 280px;
            border-radius: 16px;
            border: 1.5px solid #e0eae4;
            z-index: 1;
        }
        .coordinate-text {
            margin-top: 8px;
            font-size: 12px;
            color: #5a7f6e;
        }

        /* ===== CABANG / TITIK KUMPUL ===== */
        .branch-info, .pickup-info {
            display: none;
            margin-top: 12px;
            padding: 12px 16px;
            border-radius: 14px;
            background: #f2fbf6;
            border-left: 4px solid #2e7d5a;
        }
        .branch-info strong, .pickup-info strong { color: #1a4532; }
        .branch-info small, .pickup-info div {
            display: block;
            color: #2d5a43;
            margin-top: 3px;
            font-size: 13px;
        }
        .maps-button {
            display: inline-block;
            margin-top: 8px;
            padding: 6px 14px;
            border-radius: 40px;
            background: #2e7d5a;
            color: white;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            transition: 0.2s;
        }
        .maps-button:hover { background: #1a4532; }

        /* ===== JENIS SAMPAH ===== */
        .sampah-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .sampah-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border: 1.5px solid #e0eae4;
            border-radius: 14px;
            background: #fafcfa;
            transition: 0.2s;
        }
        .sampah-item:hover { background: #f0f7f2; }
        .sampah-item input[type="checkbox"] {
            flex-shrink: 0;
            accent-color: #2e7d5a;
            width: 18px;
            height: 18px;
        }
        .sampah-name {
            flex: 1;
            font-size: 13px;
            font-weight: 600;
            color: #1a4532;
            cursor: pointer;
        }
        .weight {
            width: 70px;
            padding: 6px 8px;
            border: 1.5px solid #e0eae4;
            border-radius: 10px;
            text-align: center;
            font-size: 13px;
            background: white;
            font-family: 'Inter', sans-serif;
        }
        .weight:focus {
            border-color: #2e7d5a;
            box-shadow: 0 0 0 3px rgba(46,125,90,0.08);
            outline: none;
        }
        .weight:disabled { background: #edf5f0; cursor: not-allowed; }

        /* ===== ALERT ===== */
        .alert {
            margin-bottom: 16px;
            padding: 12px 18px;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .alert-success { color: #155724; background: #def5e6; border: 1px solid #b8dfc6; }
        .alert-danger { color: #721c24; background: #fde8e8; border: 1px solid #f5c6cb; }
        .alert-danger ul { margin-top: 4px; padding-left: 20px; }

        /* ===== FOOTER ACTIONS ===== */
        .form-footer {
            padding: 16px 32px;
            background: #f7fbf9;
            border-top: 1px solid #eaf1ed;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            flex-wrap: wrap;
        }
        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 24px;
            border-radius: 60px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: 0.25s ease;
        }
        .button-cancel {
            background: white;
            color: #2d5a43;
            border: 1.5px solid #d4e8db;
        }
        .button-cancel:hover { background: #f0f7f2; border-color: #6fcf97; }
        .button-submit {
            background: linear-gradient(135deg, #2e7d5a, #1a4532);
            color: white;
            box-shadow: 0 4px 16px rgba(46,125,90,0.25);
        }
        .button-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(46,125,90,0.35);
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

        /* ===== ANIMASI ===== */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
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

            .page-hero { padding: 28px 0 44px; border-radius: 0 0 28px 28px; }
            .page-hero h1 { font-size: 26px; }
            .page-hero p { font-size: 14px; }

            .form-wrapper { padding: 0 12px; margin-top: -20px; }
            .form-body { padding: 20px 16px; }
            .form-footer { padding: 14px 16px; flex-direction: column; }
            .button { width: 100%; justify-content: center; }

            .grid-2, .method-grid, .sampah-grid { grid-template-columns: 1fr; }
            #map { height: 200px; }

            .branch-info, .pickup-info { font-size: 13px; }
            .location-button { font-size: 12px; padding: 6px 14px; }
        }

        @media (max-width: 480px) {
            .container { padding: 0 12px; }
            .logo { font-size: 22px; }
            .page-hero h1 { font-size: 22px; }
            .form-body { padding: 16px 12px; }
            .section-title { font-size: 15px; }
            .field label { font-size: 12px; }
            .input, .select, .textarea { font-size: 13px; padding: 8px 12px; }
            .weight { width: 60px; font-size: 12px; }
            .sampah-item { padding: 8px 10px; }
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
        <h1><i class="fas fa-plus-circle"></i> Form Setoran</h1>
        <p>Ajukan setoran sampah dengan lokasi otomatis</p>
    </div>
</section>

<!-- ===== FORM ===== -->
<div class="form-wrapper">
    <div class="form-card">
        <form action="{{ route('user.transaksi.store') }}" method="POST">
            @csrf
            <div class="form-body">
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
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Data belum lengkap.</strong>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- 01. Data Pengirim -->
                <div class="section">
                    <div class="section-title">
                        <i class="fas fa-user"></i> 01. Data Pengirim
                    </div>
                    <div class="grid-2">
                        <div class="field">
                            <label>Nama Pengirim</label>
                            <input type="text" name="nama_pengirim" class="input readonly" value="{{ auth()->user()->name }}" readonly>
                        </div>
                        <div class="field">
                            <label>Nomor HP</label>
                            <input type="text" name="no_hp" class="input" value="{{ old('no_hp', auth()->user()->pelanggan->no_hp ?? '') }}" placeholder="08xxxxxxxxxx" required>
                        </div>
                    </div>
                </div>

                <!-- 02. Metode Setoran -->
                <div class="section">
                    <div class="section-title">
                        <i class="fas fa-truck"></i> 02. Metode Setoran
                    </div>
                    <div class="method-grid">
                        <div>
                            <input type="radio" name="metode" value="jemput" id="metodeJemput" class="method-input" {{ old('metode','jemput') === 'jemput' ? 'checked' : '' }}>
                            <label for="metodeJemput" class="method-label">
                                <strong><i class="fas fa-home"></i> Jemput Sampah</strong>
                                <span>Petugas datang ke lokasi Anda</span>
                            </label>
                        </div>
                        <div>
                            <input type="radio" name="metode" value="antar" id="metodeAntar" class="method-input" {{ old('metode') === 'antar' ? 'checked' : '' }}>
                            <label for="metodeAntar" class="method-label">
                                <strong><i class="fas fa-map-pin"></i> Antar ke Titik Kumpul</strong>
                                <span>Anda mengantar langsung</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- 03. Lokasi -->
                <div class="section">
                    <div class="section-title">
                        <i class="fas fa-location-dot"></i> 03. Lokasi
                    </div>
                    <div id="locationStatus" class="location-status">Meminta izin lokasi...</div>
                    <div class="location-actions">
                        <button type="button" id="btnLocation" class="location-button">
                            <i class="fas fa-location-dot"></i> Gunakan Lokasi Saya
                        </button>
                        <button type="button" id="btnRefreshLocation" class="location-button">
                            <i class="fas fa-rotate"></i> Perbarui Lokasi
                        </button>
                    </div>

                    <div id="jemputArea">
                        <div class="field">
                            <label>Alamat Jemput <span style="color:red;">*</span></label>
                            <textarea name="alamat_jemput" id="alamat_jemput" class="textarea" placeholder="Alamat akan otomatis terisi dari lokasi Anda...">{{ old('alamat_jemput') }}</textarea>
                        </div>
                        <div id="cabangInfo" class="branch-info">
                            <strong>Cabang terdekat</strong>
                            <small id="cabangNama">-</small>
                            <small id="cabangJarak">-</small>
                        </div>
                    </div>

                    <div id="antarArea" style="display:none;">
                        <div class="field">
                            <label>Titik Kumpul <span style="color:red;">*</span></label>
                            <select name="titik_kumpul_id" id="titikKumpulSelect" class="select">
                                <option value="">Memuat titik kumpul...</option>
                                @foreach($titikKumpuls as $item)
                                    <option value="{{ $item->id }}" data-lat="{{ $item->latitude }}" data-lng="{{ $item->longitude }}" data-alamat="{{ $item->alamat }}" {{ old('titik_kumpul_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="titikInfo" class="pickup-info">
                            <strong id="titikNama">-</strong>
                            <div><strong>Alamat:</strong> <span id="titikAlamat">-</span></div>
                            <div><strong>Jarak:</strong> <span id="titikJarak">-</span></div>
                            <a href="#" id="mapsLink" target="_blank" class="maps-button">
                                <i class="fas fa-map-location-dot"></i> Buka Google Maps
                            </a>
                        </div>
                    </div>

                    <div style="margin-top:16px;">
                        <div id="map"></div>
                    </div>
                    <div class="coordinate-text">Koordinat: <span id="coordinateText">-</span></div>
                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                </div>

                <!-- 04. Jenis Sampah -->
                <div class="section">
                    <div class="section-title">
                        <i class="fas fa-recycle"></i> 04. Jenis Sampah
                    </div>
                    <div class="sampah-grid">
                        @forelse($jenisSampahs as $js)
                            <div class="sampah-item">
                                <input type="checkbox" class="sampah-check" id="check_{{ $js->id }}" data-id="{{ $js->id }}">
                                <label for="check_{{ $js->id }}" class="sampah-name">{{ $js->nama }}</label>
                                <input type="number" name="jenis_sampah_data[{{ $js->id }}]" id="berat_{{ $js->id }}" class="weight" min="0.1" step="0.1" value="{{ old('jenis_sampah_data.' . $js->id, 0) }}" disabled>
                                <span style="font-size:12px;color:#5a7f6e;">kg</span>
                            </div>
                        @empty
                            <div style="grid-column:1/-1; color:#5a7f6e; font-size:14px; text-align:center; padding:12px 0;">
                                Belum ada jenis sampah.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('user.setoran') }}" class="button button-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="button button-submit">
                    <i class="fas fa-paper-plane"></i> Ajukan Setoran
                </button>
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

<!-- ===== SCRIPTS ===== -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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

    // Data dari database
    const cabangs = @json($cabangs->values());
    const titikKumpuls = @json($titikKumpuls->values());

    // Element
    const metodeJemput = document.getElementById('metodeJemput');
    const metodeAntar  = document.getElementById('metodeAntar');
    const jemputArea   = document.getElementById('jemputArea');
    const antarArea    = document.getElementById('antarArea');
    const alamatInput  = document.getElementById('alamat_jemput');
    const titikSelect  = document.getElementById('titikKumpulSelect');
    const locationStatus = document.getElementById('locationStatus');
    const latInput     = document.getElementById('latitude');
    const lngInput     = document.getElementById('longitude');
    const coordText    = document.getElementById('coordinateText');

    // Map
    const defaultLat = {{ $centerLat }};
    const defaultLng = {{ $centerLng }};
    let currentLat = parseFloat(latInput.value) || defaultLat;
    let currentLng = parseFloat(lngInput.value) || defaultLng;
    const map = L.map('map').setView([currentLat, currentLng], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);
    let marker = L.marker([currentLat, currentLng], { draggable: true }).addTo(map);

    // Fungsi Jarak (Haversine)
    function distanceKm(lat1, lng1, lat2, lng2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLng = (lng2 - lng1) * Math.PI / 180;
        const a = Math.sin(dLat/2)**2 +
                  Math.cos(lat1 * Math.PI/180) * Math.cos(lat2 * Math.PI/180) *
                  Math.sin(dLng/2)**2;
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    // Update Lokasi
    function updateLocation(lat, lng) {
        currentLat = parseFloat(lat);
        currentLng = parseFloat(lng);
        latInput.value = currentLat.toFixed(8);
        lngInput.value = currentLng.toFixed(8);
        coordText.textContent = currentLat.toFixed(6) + ', ' + currentLng.toFixed(6);
        marker.setLatLng([currentLat, currentLng]);
        map.setView([currentLat, currentLng], 15);
        cariCabangTerdekat();
        cariTitikKumpulTerdekat();
    }

    // Reverse Geocode
    async function getAddress(lat, lng) {
        try {
            const response = await fetch(
                'https://nominatim.openstreetmap.org/reverse?' +
                new URLSearchParams({ format: 'json', lat: lat, lon: lng, zoom: 18, addressdetails: 1 })
            );
            if (!response.ok) throw new Error();
            const data = await response.json();
            return data.display_name || '';
        } catch {
            return '';
        }
    }

    // Cabang Terdekat
    function cariCabangTerdekat() {
        const info = document.getElementById('cabangInfo');
        if (!cabangs.length) { info.style.display = 'none'; return; }
        let terdekat = null;
        cabangs.forEach(cabang => {
            const lat = parseFloat(cabang.latitude);
            const lng = parseFloat(cabang.longitude);
            if (isNaN(lat) || isNaN(lng)) return;
            const jarak = distanceKm(currentLat, currentLng, lat, lng);
            if (!terdekat || jarak < terdekat.jarak) {
                terdekat = { nama: cabang.nama, jarak };
            }
        });
        if (!terdekat) { info.style.display = 'none'; return; }
        info.style.display = 'block';
        document.getElementById('cabangNama').textContent = terdekat.nama;
        document.getElementById('cabangJarak').textContent = terdekat.jarak.toFixed(2) + ' km dari lokasi Anda';
    }

    // Titik Kumpul Terdekat
    function cariTitikKumpulTerdekat() {
        if (!titikKumpuls.length) return;
        let terdekat = null;
        titikKumpuls.forEach(titik => {
            const lat = parseFloat(titik.latitude);
            const lng = parseFloat(titik.longitude);
            if (isNaN(lat) || isNaN(lng)) return;
            const jarak = distanceKm(currentLat, currentLng, lat, lng);
            if (!terdekat || jarak < terdekat.jarak) {
                terdekat = { id: titik.id, nama: titik.nama, alamat: titik.alamat, latitude: lat, longitude: lng, jarak };
            }
        });
        if (!terdekat) return;
        if (!titikSelect.dataset.userSelected) {
            titikSelect.value = terdekat.id;
        }
        updateTitikInfo();
    }

    // Info Titik Kumpul
    function updateTitikInfo() {
        const option = titikSelect.options[titikSelect.selectedIndex];
        if (!option || !option.value) {
            document.getElementById('titikInfo').style.display = 'none';
            return;
        }
        const lat = parseFloat(option.dataset.lat);
        const lng = parseFloat(option.dataset.lng);
        const alamat = option.dataset.alamat || '';
        const nama = option.textContent.trim();
        if (isNaN(lat) || isNaN(lng)) return;
        const jarak = distanceKm(currentLat, currentLng, lat, lng);
        document.getElementById('titikInfo').style.display = 'block';
        document.getElementById('titikNama').textContent = nama;
        document.getElementById('titikAlamat').textContent = alamat;
        document.getElementById('titikJarak').textContent = jarak.toFixed(2) + ' km dari lokasi Anda';
        document.getElementById('mapsLink').href = 'https://www.google.com/maps/dir/?api=1&origin=' + currentLat + ',' + currentLng + '&destination=' + lat + ',' + lng;
    }

    // Metode Toggle
    function updateMetode() {
        if (metodeJemput.checked) {
            jemputArea.style.display = 'block';
            antarArea.style.display = 'none';
            alamatInput.required = true;
            titikSelect.required = false;
        } else {
            jemputArea.style.display = 'none';
            antarArea.style.display = 'block';
            alamatInput.required = false;
            titikSelect.required = true;
            cariTitikKumpulTerdekat();
        }
        setTimeout(() => map.invalidateSize(), 200);
    }
    metodeJemput.addEventListener('change', updateMetode);
    metodeAntar.addEventListener('change', updateMetode);

    // Pilih Titik Manual
    titikSelect.addEventListener('change', function () {
        this.dataset.userSelected = '1';
        updateTitikInfo();
    });

    // Drag Marker
    marker.on('dragend', async function () {
        const pos = marker.getLatLng();
        updateLocation(pos.lat, pos.lng);
        const alamat = await getAddress(pos.lat, pos.lng);
        if (alamat && metodeJemput.checked) {
            alamatInput.value = alamat;
        }
    });

    // Klik Peta
    map.on('click', async function (e) {
        updateLocation(e.latlng.lat, e.latlng.lng);
        const alamat = await getAddress(e.latlng.lat, e.latlng.lng);
        if (alamat && metodeJemput.checked) {
            alamatInput.value = alamat;
        }
    });

    // Lokasi User
    function ambilLokasi() {
        if (!navigator.geolocation) {
            locationStatus.textContent = 'Browser tidak mendukung lokasi.';
            return;
        }
        locationStatus.textContent = 'Meminta izin lokasi...';
        navigator.geolocation.getCurrentPosition(
            async function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                updateLocation(lat, lng);
                locationStatus.textContent = 'Lokasi berhasil ditemukan.';
                const alamat = await getAddress(lat, lng);
                if (alamat && metodeJemput.checked) {
                    alamatInput.value = alamat;
                }
            },
            function (error) {
                if (error.code === error.PERMISSION_DENIED) {
                    locationStatus.textContent = 'Izin lokasi ditolak. Pilih lokasi dari peta.';
                } else {
                    locationStatus.textContent = 'Gagal mendapatkan lokasi.';
                }
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    }
    document.getElementById('btnLocation').addEventListener('click', ambilLokasi);
    document.getElementById('btnRefreshLocation').addEventListener('click', ambilLokasi);

    // Checkbox Jenis Sampah
    document.querySelectorAll('.sampah-check').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const id = this.dataset.id;
            const weight = document.getElementById('berat_' + id);
            weight.disabled = !this.checked;
            if (!this.checked) {
                weight.value = 0;
            } else {
                weight.focus();
            }
        });
    });

    // Inisialisasi
    updateMetode();
    ambilLokasi();
</script>
</body>
</html>