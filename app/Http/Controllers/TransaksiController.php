<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Hapus tanda komentar di bawah ini jika Anda sudah membuat model Transaksi
// use App\Models\Transaksi; 

class TransaksiController extends Controller
{
    // FUNGSI INI YANG DIPANGGIL OLEH ROUTE GET /user/transaksi/create
    public function create()
    {
        // 'user.transaksi.create' artinya mengambil file view di:
        // resources/views/user/transaksi/create.blade.php
        // Pastikan file tersebut benar-benar ada!
        return view('user.transaksi.create');
    }

    // FUNGSI INI UNTUK MENYIMPAN DATA (Dipanggil oleh route POST)
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'nama' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        // Simpan ke database (HANYA jika Anda sudah punya Model 'Transaksi').
        // Jika belum punya model, biarkan baris ini di-comment dulu agar tidak error.
        // Transaksi::create([
        //     'nama' => $request->nama,
        //     'jumlah' => $request->jumlah,
        // ]);

        // Setelah berhasil, kembali lagi ke halaman create
        return redirect()->route('transaksi.create')->with('success', 'Transaksi berhasil ditambahkan!');
    }
}