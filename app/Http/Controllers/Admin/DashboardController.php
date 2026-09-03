<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\TitikKumpul;
use App\Models\Transaksi;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalPelanggan = Pelanggan::count();
        $totalTitikKumpul = TitikKumpul::count();

        // Ambil semua transaksi, gunakan eager loading
        $transaksis = Transaksi::with(['pelanggan', 'jenisSampah'])->get();

        $totalTransaksi = $transaksis->count();
        $totalPendapatan = $transaksis->sum('total_harga') ?: 0; // jika null, jadikan 0
        $rataRating = round($transaksis->avg('rating') ?: 0, 1);

        // Aktivitas terbaru (5 terakhir)
        $aktivitasTerbaru = $transaksis
            ->sortByDesc('created_at')
            ->take(5)
            ->map(function ($transaksi) {
                return (object) [
                    'user' => $transaksi->pelanggan->nama ?? 'Unknown',
                    'aksi' => 'Setoran ' . ($transaksi->jenisSampah->nama ?? 'sampah') . ' - ' . $transaksi->berat . ' kg',
                    'tanggal' => optional($transaksi->created_at)->diffForHumans() ?? '-',
                ];
            });

        // Jika tidak ada transaksi, isi dengan pesan
        if ($aktivitasTerbaru->isEmpty()) {
            $aktivitasTerbaru = collect([
                (object) ['user' => 'Belum ada aktivitas', 'aksi' => '-', 'tanggal' => '-']
            ]);
        }

        return view('admin.dashboard', compact(
            'totalPelanggan',
            'totalTransaksi',
            'totalPendapatan',
            'rataRating',
            'totalTitikKumpul',
            'aktivitasTerbaru'
        ));
    }
}