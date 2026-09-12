<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EcoPoint — Profil Saya</title>
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
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

        /* ===== NAVBAR RESPONSIVE ===== */
        .navbar {
            background: #0d2b1f;
            padding: 14px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .navbar-content {
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
            gap: 6px;
            order: 1;
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
            transition: 0.2s;
        }
        .nav-links a:hover { color: #6fcf97; }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
            order: 3;
        }
        .btn-logout {
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
            border: none;
            cursor: pointer;
            transition: 0.2s;
            font-family: inherit;
        }
        .btn-logout:hover { color: #6fcf97; background: rgba(255,255,255,0.05); }

        .mobile-divider, .mobile-actions { display: none; }

        /* ===== PAGE / PROFILE ===== */
        .profile-page { padding: 28px 16px 50px; background: #f0f7f2; }
        .profile-container { max-width: 820px; margin: 0 auto; }
        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .profile-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #0d2b1f;
            margin: 0;
        }
        .profile-subtitle { color: #2d5a43; font-size: 0.8rem; margin-top: 2px; }
        .btn-back {
            text-decoration: none;
            padding: 8px 14px;
            border: 1px solid #cde0d3;
            border-radius: 10px;
            background: #fff;
            color: #2d5a43;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: 0.2s;
        }
        .btn-back:hover { background: #e8f5e9; border-color: #6fcf97; }

        .profile-card {
            background: #ffffff;
            border: 1px solid #d4e8db;
            border-radius: 24px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
            padding: 28px 24px;
        }
        .profile-avatar {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 28px;
            padding-bottom: 24px;
            border-bottom: 1px solid #d4e8db;
            flex-wrap: wrap;
        }
        .profile-avatar img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #2e7d5a;
        }
        .default-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #e8f5e9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.6rem;
            color: #2e7d5a;
            border: 3px solid #2e7d5a;
        }
        .profile-name { font-size: 1.4rem; font-weight: 700; color: #0d2b1f; margin: 0; }
        .profile-email { color: #4d7a63; font-size: 0.85rem; margin: 0; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px 24px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group.full-width { grid-column: 1 / -1; }
        .form-group label {
            font-size: 0.7rem;
            font-weight: 700;
            color: #4d7a63;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .form-group .input, .form-group .file-input {
            border: 1px solid #d4e8db;
            border-radius: 16px;
            background: #fafffc;
            padding: 10px 14px;
            font-size: 0.9rem;
            color: #1a2e24;
            outline: none;
            transition: 0.2s;
            width: 100%;
        }
        .form-group .input:focus, .form-group .file-input:focus {
            border-color: #2e7d5a;
            box-shadow: 0 0 0 4px rgba(46, 125, 90, 0.12);
        }
        .form-group .help-text { font-size: 0.7rem; color: #4d7a63; margin-top: 3px; }

        .form-actions {
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid #d4e8db;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            flex-wrap: wrap;
        }
        .btn-submit {
            background: #2e7d5a;
            color: white;
            border: none;
            padding: 10px 28px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 0.8rem;
            cursor: pointer;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-submit:hover { background: #1a4532; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(46, 125, 90, 0.3); }
        .btn-cancel {
            background: white;
            border: 1px solid #d4e8db;
            color: #2d5a43;
            padding: 10px 20px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 0.8rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }
        .btn-cancel:hover { background: #f0f7f2; border-color: #6fcf97; }

        .alert { padding: 12px 16px; border-radius: 16px; margin-bottom: 20px; font-weight: 500; font-size: 0.8rem; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #b8d9b8; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-danger ul { margin-top: 5px; padding-left: 18px; }

        .footer {
            background: #071a12;
            padding: 30px 0;
            text-align: center;
            color: #8baa99;
            font-size: 14px;
            border-top: 1px solid #1e4533;
        }
        .footer a { color: #6fcf97; text-decoration: none; }
        .footer .social { margin-top: 12px; display: flex; justify-content: center; gap: 20px; font-size: 22px; }
        .footer .social a { color: #8baa99; transition: 0.2s; }
        .footer .social a:hover { color: #6fcf97; }

        /* ============================================================ */
        /* MODAL KONFIRMASI LOGOUT                                       */
        /* ============================================================ */
        .logout-modal {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(7, 26, 18, 0.6);
            backdrop-filter: blur(6px);
            padding: 20px;
            animation: fadeIn 0.25s ease-out;
        }
        .logout-modal.active {
            display: flex;
        }
        .logout-modal-content {
            background: #ffffff;
            border-radius: 28px;
            padding: 32px 28px;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            transform: scale(0.85);
            opacity: 0;
            animation: popIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        .logout-icon-wrap {
            width: 72px;
            height: 72px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulseIcon 1.8s ease-in-out infinite;
        }
        .logout-icon-wrap i {
            font-size: 32px;
            color: #dc2626;
        }
        .logout-modal-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: #0d2b1f;
            margin-bottom: 8px;
        }
        .logout-modal-text {
            font-size: 0.9rem;
            color: #4d7a63;
            margin-bottom: 24px;
            line-height: 1.5;
        }
        .logout-modal-buttons {
            display: flex;
            gap: 10px;
        }
        .logout-btn-cancel,
        .logout-btn-confirm {
            flex: 1;
            padding: 12px 20px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            transition: 0.25s;
            border: none;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .logout-btn-cancel {
            background: #f1f5f3;
            color: #2d5a43;
            border: 1.5px solid #d4e8db;
        }
        .logout-btn-cancel:hover {
            background: #e8f0ec;
            border-color: #b8d9c8;
        }
        .logout-btn-confirm {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.3);
        }
        .logout-btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.4);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes popIn {
            from { transform: scale(0.85); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        @keyframes pulseIcon {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.4); }
            50% { transform: scale(1.05); box-shadow: 0 0 0 12px rgba(220, 38, 38, 0); }
        }

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
            .mobile-actions .btn-logout,
            .mobile-actions form { width: 100%; margin: 0; display: flex; align-items: center; justify-content: center; }

            .mobile-actions .btn-logout {
                background: transparent;
                color: #cde8d6;
                font-weight: 600;
                font-size: 16px;
                text-decoration: none;
                padding: 12px 0;
                justify-content: center;
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

            .profile-avatar { flex-direction: column; text-align: center; gap: 16px; }
            .profile-avatar img, .default-avatar { width: 100px; height: 100px; }
            .form-grid { grid-template-columns: 1fr; gap: 16px; }
            .profile-card { padding: 20px 16px; }
            .profile-title { font-size: 1.3rem; }
            .form-actions { flex-direction: column-reverse; align-items: stretch; }
            .btn-submit, .btn-cancel { justify-content: center; padding: 12px; }
            .profile-header { flex-direction: column; align-items: flex-start; }
            .btn-back { align-self: flex-start; width: 100%; text-align: center; justify-content: center; }

            .logout-modal-content { padding: 24px 20px; border-radius: 24px; }
            .logout-icon-wrap { width: 60px; height: 60px; margin-bottom: 16px; }
            .logout-icon-wrap i { font-size: 26px; }
            .logout-modal-title { font-size: 1.15rem; }
            .logout-modal-buttons { flex-direction: column-reverse; }
        }

        @media (max-width: 480px) {
            .container { padding: 0 12px; }
            .profile-page { padding: 16px 8px 30px; }
            .profile-card { padding: 16px 12px; }
            .logo { font-size: 22px; }
        }
    </style>
</head>
<body>

<!-- NAVBAR RESPONSIVE -->
<nav class="navbar">
    <div class="container navbar-content">
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
                    {{-- ✅ TOMBOL LOGOUT MOBILE — pakai type="button" + onclick biar muncul popup --}}
                    <form method="POST" action="{{ route('logout') }}" id="logout-form-mobile">
                        @csrf
                        <button type="button" class="btn-logout" onclick="openLogoutModal()">
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
                {{-- ✅ TOMBOL LOGOUT DESKTOP — pakai type="button" + onclick biar muncul popup --}}
                <form method="POST" action="{{ route('logout') }}" id="logout-form-desktop">
                    @csrf
                    <button type="button" class="btn-logout" onclick="openLogoutModal()">
                        <i class="fas fa-sign-out-alt"></i> Logout
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

<!-- CONTENT (Profil) -->
<div class="profile-page">
    <div class="profile-container">
        <div class="profile-header">
            <div>
                <h1 class="profile-title"><i class="fas fa-user-circle" style="color:#2e7d5a; margin-right:8px;"></i> Profil Saya</h1>
                <div class="profile-subtitle">Kelola data akun Anda</div>
            </div>
            <a href="{{ route('user.dashboard') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
        </div>

        <div class="profile-card">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Perbaiki kesalahan berikut:</strong>
                    <ul>@foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
                </div>
            @endif

            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="profile-avatar">
                    @if(isset($user->foto) && $user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil">
                    @else
                        <div class="default-avatar"><i class="fas fa-user"></i></div>
                    @endif
                    <div>
                        <div class="profile-name">{{ $user->name }}</div>
                        <div class="profile-email">{{ $user->email }}</div>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="input" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="input" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">Nomor HP</label>
                        <input type="text" name="no_hp" id="no_hp" class="input" value="{{ old('no_hp', $user->pelanggan->no_hp ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="input" value="{{ old('alamat', $user->pelanggan->alamat ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input type="password" name="password" id="password" class="input" placeholder="Kosongkan jika tidak diganti">
                        <span class="help-text">Minimal 6 karakter</span>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="input" placeholder="Ulangi password baru">
                    </div>
                    <div class="form-group full-width">
                        <label for="foto">Foto Profil</label>
                        <input type="file" name="foto" id="foto" class="file-input" accept="image/*">
                        @if(isset($user->foto) && $user->foto)
                            <div class="foto-preview">
                                <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto saat ini">
                                <div style="font-size:0.7rem; color:#4d7a63; margin-top:4px;">Foto saat ini</div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('user.dashboard') }}" class="btn-cancel"><i class="fas fa-times"></i> Batal</a>
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- FOOTER -->
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

{{-- ============================================================ --}}
{{-- MODAL KONFIRMASI LOGOUT                                       --}}
{{-- ============================================================ --}}
<div class="logout-modal" id="logoutModal">
    <div class="logout-modal-content">
        <div class="logout-icon-wrap">
            <i class="fas fa-sign-out-alt"></i>
        </div>
        <h3 class="logout-modal-title">Yakin Ingin Keluar?</h3>
        <p class="logout-modal-text">
            Anda akan keluar dari akun <strong>{{ Auth::user()->name ?? 'ini' }}</strong>. 
            Pastikan semua pekerjaan sudah tersimpan.
        </p>
        <div class="logout-modal-buttons">
            <button type="button" class="logout-btn-cancel" onclick="closeLogoutModal()">
                <i class="fas fa-times"></i> Batal
            </button>
            <button type="button" class="logout-btn-confirm" onclick="confirmLogout()">
                <i class="fas fa-sign-out-alt"></i> Ya, Keluar
            </button>
        </div>
    </div>
</div>

<script>
    // ============================================================
    // HAMBURGER MENU
    // ============================================================
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

    // ============================================================
    // MODAL LOGOUT
    // ============================================================
    function openLogoutModal() {
        const modal = document.getElementById('logoutModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden'; // freeze scroll
    }

    function closeLogoutModal() {
        const modal = document.getElementById('logoutModal');
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }

    function confirmLogout() {
        // Submit form logout (prioritas desktop, fallback mobile)
        const form = document.getElementById('logout-form-desktop') 
                  || document.getElementById('logout-form-mobile');
        if (form) {
            form.submit();
        }
    }

    // Tutup modal saat klik overlay (di luar kotak putih)
    document.getElementById('logoutModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeLogoutModal();
        }
    });

    // Tutup modal saat tekan ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('logoutModal');
            if (modal && modal.classList.contains('active')) {
                closeLogoutModal();
            }
        }
    });
</script>

</body>
</html>