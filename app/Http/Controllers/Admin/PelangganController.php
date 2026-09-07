<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::withCount('transaksis')->get();
        return view('admin.pelanggan.index', compact('pelanggans'));
    }
public function show($id)
{
    $pelanggan = \App\Models\Pelanggan::with([
        'transaksis.jenisSampahs',
        'transaksis.titikKumpul',
    ])->findOrFail($id);

    $transaksis = \App\Models\Transaksi::where(
        'pelanggan_id',
        $pelanggan->id
    )
        ->with([
            'pelanggan',
            'jenisSampahs',
            'titikKumpul',
        ])
        ->latest()
        ->get();

    return view(
        'admin.pelanggan.show',
        compact(
            'pelanggan',
            'transaksis'
        )
    );
}
    /**
     * Update status transaksi dan tambah poin jika selesai
     */
    public function updateStatus($pelangganId, $transaksiId, $action)
    {
        $pelanggan = Pelanggan::findOrFail($pelangganId);
        $transaksi = Transaksi::where('pelanggan_id', $pelangganId)->findOrFail($transaksiId);

        $oldStatus = $transaksi->status;
        $newStatus = $oldStatus;
        $pointsEarned = 0;

        switch ($action) {
            case 'approve':
                if ($oldStatus !== 'pending') {
                    return response()->json(['error' => 'Status sudah tidak menunggu.'], 400);
                }
                $newStatus = 'approved';
                break;
            case 'reject':
                if ($oldStatus !== 'pending') {
                    return response()->json(['error' => 'Status sudah tidak menunggu.'], 400);
                }
                $newStatus = 'rejected';
                break;
            case 'complete':
                if ($oldStatus !== 'approved') {
                    return response()->json(['error' => 'Setoran harus disetujui terlebih dahulu.'], 400);
                }
                $newStatus = 'completed';
                // Hitung poin: setiap Rp 100 = 1 poin (atau sesuai aturan)
                $pointsEarned = (int) round($transaksi->total_harga / 100);
                $pelanggan->poin += $pointsEarned;
                $pelanggan->save();
                break;
            case 'cancel':
                if ($oldStatus !== 'approved') {
                    return response()->json(['error' => 'Hanya setoran yang disetujui yang bisa dibatalkan.'], 400);
                }
                $newStatus = 'pending';
                break;
            default:
                return response()->json(['error' => 'Aksi tidak dikenali.'], 400);
        }

        // Update status transaksi
        $transaksi->status = $newStatus;
        $transaksi->save();

        return response()->json([
            'success' => true,
            'new_status' => $newStatus,
            'points_earned' => $pointsEarned,
            'total_points' => $pelanggan->poin,
            'message' => 'Status berhasil diperbarui.'
        ]);
    }
public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'no_hp' => 'required|string|max:20',
    ]);

    return redirect()
        ->route('admin.pelanggan.index');
        }

public function destroy($id)
{
    $pelanggan = Pelanggan::findOrFail($id);

    $pelanggan->delete();

    return redirect()
        ->route('admin.pelanggan.index')
        ->with('success', 'Data pelanggan berhasil dihapus.');
}
}