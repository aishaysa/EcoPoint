<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JenisSampahController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\TitikKumpulController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\SetoranController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\User\UserDashboardController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/

Route::get('/', [UserDashboardController::class, 'home'])
    ->name('home');
Route::get('/dashboard', [UserDashboardController::class, 'home'])
    ->name('dashboard');

Route::view('/user/transaksi/create', 'user.transaksi.create');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
|
| Admin login menggunakan:
| users + role_id = 1
|
*/

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        // LOGIN ADMIN
        Route::get('/login', [LoginController::class, 'showLoginForm'])
            ->name('login');

        Route::post('/login', [LoginController::class, 'login'])
            ->name('login.post');

        Route::post('/logout', [LoginController::class, 'logout'])
            ->name('logout');


        /*
        |--------------------------------------------------------------------------
        | AREA ADMIN
        |--------------------------------------------------------------------------
        */
        Route::middleware(['auth:admin'])->group(function () {

            /*
            |--------------------------------------------------------------------------
            | DASHBOARD
            |--------------------------------------------------------------------------
            */
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])
                ->name('dashboard');


            /*
            |--------------------------------------------------------------------------
            | TITIK KUMPUL
            |--------------------------------------------------------------------------
            */
            Route::resource('titik-kumpul', TitikKumpulController::class);

            Route::patch(
                'titik-kumpul/{id}/toggle-status',
                [TitikKumpulController::class, 'toggleStatus']
            )->name('titik-kumpul.toggle-status');


            /*
            |--------------------------------------------------------------------------
            | PELANGGAN
            |--------------------------------------------------------------------------
            */
            Route::resource('pelanggan', PelangganController::class);

            // Route tambahan yang memang sudah ada di project
            Route::get(
                'pelanggan/index',
                [PelangganController::class, 'index']
            )->name('pelanggan.index');

            Route::get(
                'pelanggan/create',
                [PelangganController::class, 'create']
            )->name('pelanggan.create');

            Route::post(
                'pelanggan/store',
                [PelangganController::class, 'store']
            )->name('pelanggan.store');

            Route::get(
                'pelanggan/{id}/edit',
                [PelangganController::class, 'edit']
            )->name('pelanggan.edit');

            Route::put(
                'pelanggan/{id}',
                [PelangganController::class, 'update']
            )->name('pelanggan.setoran.update');

            Route::delete(
                'pelanggan/{id}',
                [PelangganController::class, 'destroy']
            )->name('pelanggan.destroy');

            Route::get(
                'pelanggan/{id}',
                [PelangganController::class, 'show']
            )->name('pelanggan.show');


            /*
            |--------------------------------------------------------------------------
            | SETORAN
            |--------------------------------------------------------------------------
            */
            Route::put(
                'setoran/{id}/selesaikan',
                [PelangganController::class, 'selesaikanSetoran']
            )->name('setoran.selesaikan');


            /*
            |--------------------------------------------------------------------------
            | JENIS SAMPAH
            |--------------------------------------------------------------------------
            */
            Route::resource('jenis-sampah', JenisSampahController::class);

            // Route tambahan yang memang sudah ada di project
            Route::get(
                'jenis-sampah/index',
                [JenisSampahController::class, 'index']
            )->name('jenis-sampah.index');

            Route::get(
                'jenis-sampah/create',
                [JenisSampahController::class, 'create']
            )->name('jenis-sampah.create');

            Route::post(
                'jenis-sampah/store',
                [JenisSampahController::class, 'store']
            )->name('jenis-sampah.store');

            Route::get(
                'jenis-sampah/{id}/edit',
                [JenisSampahController::class, 'edit']
            )->name('jenis-sampah.edit');

            Route::put(
                'jenis-sampah/{id}',
                [JenisSampahController::class, 'update']
            )->name('jenis-sampah.update');

            Route::delete(
                'jenis-sampah/{id}',
                [JenisSampahController::class, 'destroy']
            )->name('jenis-sampah.destroy');

            Route::get(
                'jenis-sampah/{id}',
                [JenisSampahController::class, 'show']
            )->name('jenis-sampah.show');


            /*
            |--------------------------------------------------------------------------
            | TRANSAKSI
            |--------------------------------------------------------------------------
            */
            Route::resource('transaksi', TransaksiController::class);

            // Route tambahan yang memang sudah ada di project
            Route::get(
                'transaksi/index',
                [TransaksiController::class, 'index']
            )->name('transaksi.index');

            Route::get(
                'transaksi/create',
                [TransaksiController::class, 'create']
            )->name('transaksi.create');

            Route::post(
                'transaksi/store',
                [TransaksiController::class, 'store']
            )->name('transaksi.store');

            Route::get(
                'transaksi/{id}/edit',
                [TransaksiController::class, 'edit']
            )->name('transaksi.edit');

            Route::put(
                'transaksi/{id}',
                [TransaksiController::class, 'update']
            )->name('transaksi.update');

            Route::delete(
                'transaksi/{id}',
                [TransaksiController::class, 'destroy']
            )->name('transaksi.destroy');

            Route::get(
                'transaksi/{id}',
                [TransaksiController::class, 'show']
            )->name('transaksi.show');

            Route::patch(
                'transaksi/{id}/approve',
                [TransaksiController::class, 'approve']
            )->name('transaksi.approve');


            /*
            |--------------------------------------------------------------------------
            | UPDATE STATUS TRANSAKSI DARI PELANGGAN
            |--------------------------------------------------------------------------
            */
            Route::post(
                'pelanggan/{pelangganId}/transaksi/{transaksiId}/{action}',
                [PelangganController::class, 'updateStatus']
            )->name('Pelanggan.updateStatus');
        });
    });


/*
|--------------------------------------------------------------------------
| LOGIN & REGISTER USER
|--------------------------------------------------------------------------
|
| User:
| users + role_id = 2
|
*/

Route::get('/login', [UserAuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [UserAuthController::class, 'login'])
    ->name('login.post');

Route::get('/register', [UserAuthController::class, 'showRegisterForm'])
    ->name('register');

Route::post('/register', [UserAuthController::class, 'register'])
    ->name('register.post');

Route::post('/logout', [UserAuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| AREA USER
|--------------------------------------------------------------------------
*/

Route::prefix('user')
    ->name('user.')
    ->middleware(['auth:web'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */
        Route::get('/dashboard', [
            UserDashboardController::class,
            'index'
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | SETORAN
        |--------------------------------------------------------------------------
        */
        Route::get('/setoran', [
            UserDashboardController::class,
            'setoran'
        ])->name('setoran');

        Route::get('/setoran/create', [
            SetoranController::class,
            'setoranCreate'
        ])->name('setoran.create');

        Route::post('/setoran/store', [
            SetoranController::class,
            'store'
        ])->name('setoran.store');

        Route::get('/setoran/{id}', [
            SetoranController::class,
            'show'
        ])->name('setoran.detail');


        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */
        Route::get('/profile', [
            UserDashboardController::class,
            'profile'
        ])->name('profile');

        Route::get('/profile/edit', [
            UserDashboardController::class,
            'editProfile'
        ])->name('profile-edit');

        Route::post('/profile/update', [
            UserDashboardController::class,
            'updateProfile'
        ])->name('profile.update');


        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI
        |--------------------------------------------------------------------------
        */
        Route::get('/transaksi/create', [
            UserDashboardController::class,
            'createTransaksi'
        ])->name('transaksi.create');

        Route::post('/transaksi/store', [
            UserDashboardController::class,
            'storeTransaksi'
        ])->name('transaksi.store');

        Route::get('/transaksi', [
            UserDashboardController::class,
            'transaksi'
        ])->name('transaksi');

        Route::get('/transaksi/{id}', [
            UserDashboardController::class,
            'transaksiDetail'
        ])->name('transaksi.detail');

        Route::get('/transaksi/{id}/cetak', [
            UserDashboardController::class,
            'cetakTransaksi'
        ])->name('transaksi.cetak');

        Route::get('/transaksi/{id}/cetak-pdf', [
            UserDashboardController::class,
            'cetakTransaksiPDF'
        ])->name('transaksi.cetak-pdf');


        /*
        |--------------------------------------------------------------------------
        | RIWAYAT
        |--------------------------------------------------------------------------
        */
        Route::get('/riwayat', [
            UserDashboardController::class,
            'riwayat'
        ])->name('riwayat');

        Route::get('/riwayat/{id}', [
            UserDashboardController::class,
            'riwayatDetail'
        ])->name('riwayat.detail');


        /*
        |--------------------------------------------------------------------------
        | POIN
        |--------------------------------------------------------------------------
        */
        Route::get('/poin', [
            UserDashboardController::class,
            'poin'
        ])->name('poin');


        /*
        |--------------------------------------------------------------------------
        | LOGOUT USER
        |--------------------------------------------------------------------------
        */
        Route::post('/logout', [
            UserAuthController::class,
            'logout'
        ])->name('logout');
});


/*
|--------------------------------------------------------------------------
| TEST
|--------------------------------------------------------------------------
*/

Route::get('/tes', function () {
    return 'SERVER INI JALAN!';
});