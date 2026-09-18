<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\TitikKumpul;
use App\Models\Transaksi;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama - pakai SQL aggregation
        $totalPelanggan   = Pelanggan::count();
        $totalTitikKumpul = TitikKumpul::count();
        $totalTransaksi   = Transaksi::count();
        $totalPendapatan  = Transaksi::sum('total_harga') ?: 0;

        // Payout
        $totalPayout        = Withdrawal::where('status', 'completed')->sum('amount') ?: 0;
        $totalPayoutPending = Withdrawal::where('status', 'pending')->count();

        // Aktivitas terbaru - cuma ambil 5
        $aktivitasTerbaru = Transaksi::with(['pelanggan', 'jenisSampah'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($transaksi) {
                return (object) [
                    'user'    => $transaksi->pelanggan->nama ?? 'Unknown',
                    'aksi'    => 'Setoran ' . ($transaksi->jenisSampah->nama ?? 'sampah') . ' - ' . $transaksi->berat . ' kg',
                    'tanggal' => optional($transaksi->created_at)->diffForHumans() ?? '-',
                ];
            });

        return view('admin.dashboard', compact(
            'totalPelanggan',
            'totalTransaksi',
            'totalPendapatan',
            'totalTitikKumpul',
            'totalPayout',
            'totalPayoutPending',
            'aktivitasTerbaru'
        ));
    }

    /**
     * HALAMAN PROFIL ADMIN
     */
    public function profile()
    {
        $admin = Auth::guard('admin')->user() ?? Auth::user();
        if (!$admin) return redirect()->route('admin.login');

        return view('admin.profile', compact('admin'));
    }

    /**
     * UPDATE PROFIL ADMIN
     */
    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user() ?? Auth::user();
        if (!$admin) return redirect()->route('admin.login');

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $admin->name  = $request->name;
        $admin->email = $request->email;

        // Update password kalau diisi
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}