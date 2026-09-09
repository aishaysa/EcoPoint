<?php

namespace App\Http\Controllers;

use App\Helpers\PoinHelper;
use App\Models\Setoran;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class RiwayatPoinController extends Controller
{
public function approveWithdraw($id)
{
    $withdrawal = Withdrawal::with('user')->findOrFail($id);

    if ($withdrawal->status !== 'pending') {
        return redirect()->back()->with('error', 'Penarikan sudah diproses.');
    }

    $user = $withdrawal->user;

    // Catat riwayat poin (poin berkurang)
    PoinHelper::catat(
        $user,
        -$withdrawal->points, // jumlah negatif
        'penarikan',
        'Penarikan poin sebesar ' . number_format($withdrawal->points) . ' poin',
        $withdrawal
    );

    $withdrawal->status = 'completed';
    $withdrawal->processed_at = now();
    $withdrawal->save();

    return redirect()->back()->with('success', 'Penarikan berhasil disetujui! Poin telah dikurangi.');
}

public function rejectWithdraw(Request $request, $id)
{
    $withdrawal = Withdrawal::findOrFail($id);

    if ($withdrawal->status !== 'pending') {
        return redirect()->back()->with('error', 'Penarikan sudah diproses.');
    }

    $user = $withdrawal->user;

    //  Catat riwayat refund (poin kembali)
    PoinHelper::catat(
        $user,
        $withdrawal->points, // jumlah positif
        'refund',
        'Refund penarikan poin sebesar ' . number_format($withdrawal->points) . ' poin',
        $withdrawal
    );

    $withdrawal->status = 'failed';
    $withdrawal->admin_note = $request->note ?? 'Ditolak oleh admin';
    $withdrawal->save();

    return redirect()->back()->with('success', 'Penarikan ditolak. Poin dikembalikan.');
}

public function approve($id, Request $request)
{
    $setoran = Setoran::findOrFail($id);
    $setoran->status = 'approved'; 
    $setoran->save();

    $beratAkhir = $request->berat_akhir ?? $setoran->berat;
    $poinDidapat = $beratAkhir * 10; 

    $user = User::find($setoran->user_id);
    if ($user) {
        //  Catat riwayat poin (poin bertambah)
        PoinHelper::catat(
            $user,
            $poinDidapat,
            'setoran',
            'Setoran sampah seberat ' . number_format($beratAkhir, 2) . ' kg',
            $setoran
        );
    }

    // ... update pelanggan (bisa pakai helper juga)

    if ($setoran->pelanggan_id) {
        return redirect()->route('admin.pelanggan.show', $setoran->pelanggan_id)
                         ->with('success', 'Transaksi berhasil disetujui!');
    }

    return redirect()->route('admin.transaksi.index')
                     ->with('success', 'Transaksi berhasil disetujui!');
}

}
