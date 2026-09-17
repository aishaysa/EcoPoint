<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\TitikKumpul;
use App\Models\Transaksi;
use App\Models\Withdrawal;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalPelanggan   = Pelanggan::count();
        $totalTitikKumpul = TitikKumpul::count();

        // Ambil semua transaksi
        $transaksis = Transaksi::with(['pelanggan', 'jenisSampah'])->get();

        $totalTransaksi  = $transaksis->count();
        $totalPendapatan = $transaksis->sum('total_harga') ?: 0;
        $rataRating      = round($transaksis->avg('rating') ?: 0, 1);

        // ===== PAYOUT (UANG KELUAR) =====
        // Uang yang sudah benar-benar keluar (di-approve admin)
        $totalPayout = Withdrawal::where('status', 'completed')->sum('amount') ?: 0;

        // Jumlah withdraw yang masih pending (belum diproses admin)
        $totalPayoutPending = Withdrawal::where('status', 'pending')->count();

        // Aktivitas terbaru (5 terakhir)
        $aktivitasTerbaru = $transaksis
            ->sortByDesc('created_at')
            ->take(5)
            ->map(function ($transaksi) {
                return (object) [
                    'user'    => $transaksi->pelanggan->nama ?? 'Unknown',
                    'aksi'    => 'Setoran ' . ($transaksi->jenisSampah->nama ?? 'sampah') . ' - ' . $transaksi->berat . ' kg',
                    'tanggal' => optional($transaksi->created_at)->diffForHumans() ?? '-',
                ];
            });

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
            'totalPayout',
            'totalPayoutPending',
            'aktivitasTerbaru'
        ));
    }
}