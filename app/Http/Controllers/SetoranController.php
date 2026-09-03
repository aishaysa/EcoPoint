<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use App\Models\Setoran;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetoranController extends Controller
{
    // 1. Menampilkan Form Setoran
    public function setoranCreate()
    {
        $jenisSampahs = JenisSampah::all();
        return view('user.setoran.create', compact('jenisSampahs'));
    }

    // 2. Menyimpan Setoran
// app/Http/Controllers/User/SetoranController.php
public function store(Request $request)
{
    $request->validate([
        'nama_pengirim' => 'required',
        'no_hp' => 'required',
        'metode' => 'required|in:jemput,antar',
        'alamat_jemput' => 'required_if:metode,jemput',
        'latitude' => 'required_if:metode,jemput|numeric',
        'longitude' => 'required_if:metode,jemput|numeric',
        'titik_kumpul_id' => 'required_if:metode,antar|exists:titik_kumpul,id',
        'jenis_sampah_data' => 'required|array',
    ]);

    $transaksi = Transaksi::create([
        'user_id' => auth()->id(),
        'nama_pengirim' => $request->nama_pengirim,
        'no_hp' => $request->no_hp,
        'metode' => $request->metode,
        'alamat_jemput' => $request->alamat_jemput,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'titik_kumpul_id' => $request->titik_kumpul_id,
        'status' => 'pending',
        'berat_aktual' => 0,
    ]);

    foreach ($request->jenis_sampah_data as $jenisId => $berat) {
        if ($berat > 0) {
            $transaksi->jenisSampahs()->attach($jenisId, [
                'berat_estimasi' => $berat,
                'berat_aktual' => 0,
            ]);
        }
    }

    return redirect()->route('user.setoran.index')->with('success', 'Setoran berhasil diajukan!');
}
    // ===== TAMBAHAN BARU: Method untuk menampilkan DETAIL SETORAN =====
public function show($id = null) // Tambahkan = null
{
    // Jika ID kosong atau user mengetik URL manual tanpa ID, lempar balik ke halaman setoran
    if (!$id) {
        return redirect()->route('user.setoran')->with('error', 'ID Setoran tidak ditemukan.');
    }

    // Kode normal kamu
    $setoran = Setoran::where('user_id', Auth::id())
                      ->with('jenisSampahs')
                      ->findOrFail($id);

    return view('user.setoran.show', compact('setoran'));
}
}