@extends('layouts.user')

@section('title', 'Beranda - EcoPoint')

@section('content')
    <!-- ====== HERO ====== -->
    <section class="bg-light py-5 fade-in-up show">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    {{-- Tampilkan sapaan hanya untuk user yang sudah login --}}
                    @auth
                        <div class="mb-2">
                            <span class="text-success fw-semibold fs-5">
                                <i class="fas fa-hand-peace me-2"></i>
                                Selamat Datang Kembali, {{ Auth::user()->first_name ?? 'Pecinta Bumi' }}!
                            </span>
                        </div>
                    @endauth

                    <span class="badge bg-success bg-opacity-10 text-success fw-semibold px-3 py-2 mb-3">
                        <i class="fas fa-recycle me-1"></i> Ramah Lingkungan
                    </span>
                    <h1 class="display-4 fw-bold text-dark">
                        Hidup Berkelanjutan dengan <br>
                        <span class="text-success">EcoPoint</span>
                    </h1>
                    <p class="lead text-secondary mt-3">
                        Setor sampah daur ulang, kumpulkan poin, dan tukarkan dengan uang tunai. 
                        Mudah, cepat, dan berdampak.
                    </p>
                    <div class="mt-4 d-flex flex-wrap gap-3">
                        <a href="{{ route('user.setoran') }}" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-recycle me-2"></i> Setor Sekarang
                        </a>
                        <a href="#carakerja" class="btn btn-outline-primary btn-lg px-4">
                            <i class="fas fa-play-circle me-2"></i> Cara Kerja
                        </a>
                    </div>
                    <div class="mt-4 d-flex gap-4 text-secondary">
                        <i class=></i> 
                        <i class=></i> 
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle p-5 d-inline-block shadow-lg">
                        <i class="fas fa-trash-alt fa-7x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== FITUR ====== -->
    <section id="fitur" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <span class="text-success fw-semibold">FITUR UNGGULAN</span>
                <h2 class="display-6 fw-bold text-dark">Kenapa Harus EcoPoint?</h2>
                <p class="text-secondary">Kami hadir untuk memudahkan Anda berkontribusi menjaga bumi.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card card-hover p-4 h-100 text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle mx-auto mb-3" style="width:70px;height:70px;line-height:70px;">
                            <i class="fas fa-trash-alt fa-2x text-success"></i>
                        </div>
                        <h5 class="fw-bold">Setor Sampah</h5>
                        <p class="text-secondary">Setor botol plastik, kardus, kaca, dan berbagai jenis sampah daur ulang.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-hover p-4 h-100 text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle mx-auto mb-3" style="width:70px;height:70px;line-height:70px;">
                            <i class="fas fa-coins fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Kumpulkan Poin</h5>
                        <p class="text-secondary">Setiap 1 kg sampah = 10 poin. Semakin banyak setor, semakin besar poin.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-hover p-4 h-100 text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle mx-auto mb-3" style="width:70px;height:70px;line-height:70px;">
                            <i class="fas fa-money-bill-wave fa-2x text-warning"></i>
                        </div>
                        <h5 class="fw-bold">Tukar Uang</h5>
                        <p class="text-secondary">50 poin = Rp 5.000, 100 poin = Rp 10.000, dan seterusnya.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== CARA KERJA ====== -->
    <section id="carakerja" class="py-5 bg-light rounded-4">
        <div class="container">
            <div class="text-center mb-5">
                <span class="text-success fw-semibold">PANDUAN</span>
                <h2 class="display-6 fw-bold text-dark">Cara Kerja EcoPoint</h2>
                <p class="text-secondary">Hanya 3 langkah mudah untuk mulai berkontribusi.</p>
            </div>
            <div class="row g-4 text-center position-relative">
                <!-- Garis penghubung (Desktop) -->
                <div class="d-none d-md-block position-absolute top-50 start-0 w-100 bg-success bg-opacity-25" style="height:2px;transform:translateY(-50%);z-index:0;"></div>

                <div class="col-md-4 position-relative" style="z-index:1;">
                    <div class="bg-success text-white rounded-circle fw-bold mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:50px;height:50px;font-size:22px;">1</div>
                    <h5 class="fw-bold">Setor Sampah</h5>
                    <p class="text-secondary">Bawa sampah daur ulang ke titik kumpul terdekat.</p>
                </div>
                <div class="col-md-4 position-relative" style="z-index:1;">
                    <div class="bg-success text-white rounded-circle fw-bold mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:50px;height:50px;font-size:22px;">2</div>
                    <h5 class="fw-bold">Dapatkan Poin</h5>
                    <p class="text-secondary">Setelah setor, poin langsung masuk ke akun Anda.</p>
                </div>
                <div class="col-md-4 position-relative" style="z-index:1;">
                    <div class="bg-success text-white rounded-circle fw-bold mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:50px;height:50px;font-size:22px;">3</div>
                    <h5 class="fw-bold">Tukarkan Poin</h5>
                    <p class="text-secondary">Kumpulkan poin dan tukarkan dengan uang tunai.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== TENTANG ====== -->
    <section id="tentang" class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 fade-in-up">
                    <h2 class="display-6 fw-bold text-dark">Tentang EcoPoint</h2>
                    <p class="text-secondary">EcoPoint adalah platform inovatif yang memudahkan masyarakat untuk berpartisipasi dalam daur ulang sampah. Dengan sistem poin yang transparan, setiap kontribusi Anda akan dihargai.</p>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Mudah digunakan dan ramah pengguna.</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Mendukung lingkungan dan keberlanjutan.</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Memberikan insentif nyata bagi pengguna.</li>
                    </ul>
                </div>
                <div class="col-lg-6 text-center fade-in-up">
                    <img src="{{ asset('image/sampah.jpg') }}" alt="Tentang EcoPoint" class="img-fluid rounded-4 shadow-lg" onerror="this.src='https://placehold.co/600x400/11998e/white?text=EcoPoint'">
                </div>
            </div>
        </div>
    </section>

    <!-- ====== CTA BANNER ====== -->
    <section class="py-5 bg-success rounded-4 text-center text-white">
        <div class="container">
            @guest
                {{-- Untuk pengunjung yang belum login --}}
                <h2 class="fw-bold">Siap Berkontribusi untuk Bumi?</h2>
                <p class="lead">Mulai setor sampah dan kumpulkan poin sekarang!</p>
                <a href="{{ route('register') }}" class="btn btn-light text-success fw-bold px-5 py-3 rounded-pill shadow-lg mt-2">
                    <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
                </a>
            @else
                {{-- Untuk user yang sudah login --}}
                <h2 class="fw-bold">Ayo Setor Sekarang!</h2>
                <p class="lead">Kumpulkan lebih banyak poin dan tukarkan dengan uang tunai.</p>
                <a href="{{ route('user.setoran') }}" class="btn btn-light text-success fw-bold px-5 py-3 rounded-pill shadow-lg mt-2">
                    <i class="fas fa-recycle me-2"></i> Setor Sekarang
                </a>
            @endguest
        </div>
    </section>
@endsection