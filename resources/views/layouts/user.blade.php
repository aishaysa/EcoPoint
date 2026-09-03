<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EcoPoint - @yield('title', 'Platform Daur Ulang')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts (opsional) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz@14..32&display=swap" rel="stylesheet">

    @stack('css')
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

        /* NAVBAR BASE */
        .navbar-custom {
            padding: 15px 0;
        }

        /* --- EFEK BLUR TRANSPARAN (GLASSMORPHISM) SAAT SCROLL --- */
        #mainNavbar {
            transition: all 0.4s ease-in-out;
            background-color: rgba(255, 255, 255, 0.95) !important; /* Kondisi awal agak solid */
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        /* Saat di-scroll, warnanya ditipisin (0.6) dan diberi efek blur kaca */
        #mainNavbar.scrolled {
            background-color: rgba(255, 255, 255, 0.6) !important; 
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        /* --- SELESAI EFEK BLUR --- */

        .navbar-brand {
            font-weight: 700;
            color: #11998e !important;
            font-size: 22px;
        }
        .navbar-brand i {
            margin-right: 8px;
        }
        .nav-link {
            font-weight: 500;
            color: #555 !important;
            margin: 0 10px;
            transition: 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            color: #11998e !important;
        }
        .nav-link i {
            margin-right: 6px;
        }

        /* BUTTON */
        .btn-primary {
            background: #11998e;
            border: none;
            border-radius: 10px;
            padding: 8px 20px;
        }
        .btn-primary:hover {
            background: #0e8077;
        }
        .btn-outline-primary {
            border-color: #11998e;
            color: #11998e;
            border-radius: 10px;
        }
        .btn-outline-primary:hover {
            background: #11998e;
            color: #fff;
        }

        /* CARD */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            background: #fff;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid #eee;
            font-weight: 600;
            padding: 18px 25px;
        }
        .card-body {
            padding: 25px;
        }

        /* FOOTER */
        .footer-custom {
            background: #1e293b;
            color: #cbd5e1;
            padding: 40px 0 20px;
            margin-top: 40px;
        }
        .footer-custom a {
            color: #cbd5e1;
            text-decoration: none;
        }
        .footer-custom a:hover {
            color: white;
        }

        /* ANIMASI */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }
        .fade-in-up.show {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .navbar-custom { padding: 12px 15px; }
            .nav-link { margin: 5px 0; }
        }
    </style>
</head>
<body>

    <!-- ====== NAVBAR ====== -->
    <!-- Tambahkan id="mainNavbar" di sini agar efek blur berfungsi -->
    <nav id="mainNavbar" class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-recycle"></i> EcoPoint
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainMenu">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    @guest
                        <!-- Menu untuk pengunjung (belum login) -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="fas fa-home"></i> Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#fitur"><i class="fas fa-star"></i> Fitur</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#carakerja"><i class="fas fa-play-circle"></i> Cara Kerja</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tentang"><i class="fas fa-info-circle"></i> Tentang</a>
                        </li>
                        <li class="nav-item ms-lg-3">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-sign-in-alt"></i> Masuk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm text-white">
                                <i class="fas fa-user-plus"></i> Daftar
                            </a>
                        </li>
                    @else
                        <!-- Menu untuk user yang sudah login -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.setoran*') ? 'active' : '' }}" href="{{ route('user.setoran') }}">
                                <i class="fas fa-boxes"></i> Setoran
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.poin') ? 'active' : '' }}" href="{{ route('user.poin') }}">
                                <i class="fas fa-coins"></i> Poin
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i class="fas fa-user me-2"></i>Profil Saya</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('user.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Keluar</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- ====== KONTEN UTAMA ====== -->
    <main>
        @yield('content')
    </main>

    <!-- ====== FOOTER ====== -->
    <footer class="footer-custom">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <h5 class="text-white fw-bold"><i class="fas fa-leaf text-success"></i> EcoPoint</h5>
                    <p class="text-sm">Daur ulang untuk masa depan lebih baik.</p>
                </div>
                <div class="col-md-3 mb-3">
                    <h6 class="text-white fw-semibold">Navigasi</h6>
                    <ul class="list-unstyled">
                        <li><a href="#fitur">Fitur</a></li>
                        <li><a href="#carakerja">Cara Kerja</a></li>
                        <li><a href="#tentang">Tentang</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-3">
                    <h6 class="text-white fw-semibold">Akun</h6>
                    <ul class="list-unstyled">
                        @guest
                            <li><a href="{{ route('login') }}">Masuk</a></li>
                            <li><a href="{{ route('register') }}">Daftar</a></li>
                        @else
                            <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('user.profile') }}">Profil</a></li>
                        @endguest
                    </ul>
                </div>
                <div class="col-md-3 mb-3">
                    <h6 class="text-white fw-semibold">Kontak</h6>
                    <p><i class="fas fa-envelope"></i> support@ecopoint.id</p>
                    <p><i class="fas fa-phone"></i> +62 812 3456 7890</p>
                </div>
            </div>
            <div class="border-top border-secondary pt-3 text-center">
                &copy; {{ date('Y') }} EcoPoint. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Animasi Scroll Fade In -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                    }
                });
            }, { threshold: 0.1 });
            document.querySelectorAll('.fade-in-up').forEach(el => observer.observe(el));
        });
    </script>

    <!-- TAMBAHAN: JAVASCRIPT DETEKSI SCROLL UNTUK NAVBAR BLUR -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('mainNavbar');
            if (navbar) {
                window.addEventListener('scroll', function() {
                    // Jika scroll lebih dari 50px, tambahkan class 'scrolled'
                    if (window.scrollY > 50) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                });
            }
        });
    </script>

    @stack('js')
</body>
</html>