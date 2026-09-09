<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setoran;
use App\Models\Withdrawal;
use App\Models\User;
use App\Models\Pelanggan;
use App\Helpers\PoinHelper;
use GlennRaya\Xendivel\Xendivel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $setoran = Setoran::select(
            'id',
            'user_id',
            'pelanggan_id',
            'tanggal',
            'metode',
            DB::raw('berat as berat'),
            DB::raw('0 as total'),
            'status',
            DB::raw("'setoran' as type"),
            DB::raw("NULL as account_number"),
            DB::raw("NULL as payment_method"),
            DB::raw("0 as amount"),
            DB::raw("NULL as admin_note")
        );

        $withdraw = Withdrawal::select(
            'id',
            'user_id',
            DB::raw('NULL as pelanggan_id'),
            DB::raw('created_at as tanggal'),
            DB::raw("'withdraw' as metode"),
            DB::raw('0 as berat'),
            'amount as total',
            'status',
            DB::raw("'withdraw' as type"),
            'account_number',
            'payment_method',
            'amount',
            'admin_note'
        );

        $filter = $request->filter ?? 'all';
        
        if ($filter == 'setoran') {
            $allTransactions = $setoran->orderBy('tanggal', 'desc')->paginate(20);
        } elseif ($filter == 'withdraw') {
            $allTransactions = $withdraw->orderBy('tanggal', 'desc')->paginate(20);
        } else {
            $allTransactions = $setoran->union($withdraw)
                ->orderBy('tanggal', 'desc')
                ->paginate(20);
        }

        return view('admin.transaksi.index', compact('allTransactions', 'filter'));
    }

    public function show(Request $request, $id)
    {
        $type = $request->query('type', 'setoran');

        if ($type == 'withdraw') {
            $data = Withdrawal::with('user')->findOrFail($id);
            return view('admin.transaksi.show', compact('data'))->with('type', 'withdraw');
        } else {
            $data = Setoran::with('user.pelanggan')->findOrFail($id);
            return view('admin.transaksi.show', compact('data'))->with('type', 'setoran');
        }
    }

    public function edit($id)
    {
        $setoran = Setoran::with('user.pelanggan')->findOrFail($id);
        return view('admin.transaksi.edit', compact('setoran'));
    }

    public function update(Request $request, $id)
    {
        $setoran = Setoran::findOrFail($id);
        $setoran->update($request->all());
        return redirect()->route('admin.transaksi.index')->with('success', 'Setoran berhasil diupdate.');
    }

    public function destroy($id)
    {
        $setoran = Setoran::findOrFail($id);
        $setoran->delete();
        return redirect()->route('admin.transaksi.index')->with('success', 'Setoran berhasil dihapus.');
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

        $pelanggan = Pelanggan::find($setoran->pelanggan_id);
        if ($pelanggan) {
            if (in_array('points', $pelanggan->getFillable()) || \Schema::hasColumn('pelanggan', 'points')) {
                $pelanggan->increment('points', $poinDidapat);
            } else {
                $pelanggan->increment('poin', $poinDidapat); 
            }
        }

        if ($setoran->pelanggan_id) {
            return redirect()->route('admin.pelanggan.show', $setoran->pelanggan_id)
                             ->with('success', 'Transaksi berhasil disetujui.');
        }

        return redirect()->route('admin.transaksi.index')
                         ->with('success', 'Transaksi berhasil disetujui.');
    }

    public function reject($id, Request $request)
    {
        $setoran = Setoran::findOrFail($id);
        $setoran->status = 'rejected'; 
        $setoran->save();

        if ($setoran->pelanggan_id) {
            return redirect()->route('admin.pelanggan.show', $setoran->pelanggan_id)
                             ->with('success', 'Transaksi berhasil ditolak.');
        }

        return redirect()->route('admin.transaksi.index')
                         ->with('success', 'Transaksi berhasil ditolak.');
    }

    // ============================================================
    // WITHDRAW
    // ============================================================

    public function approveWithdraw($id)
    {
        $withdrawal = Withdrawal::with('user')->findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'Penarikan sudah diproses.');
        }

        //  Status diubah menjadi completed (poin sudah dikurangi saat user mengajukan)
        $withdrawal->status = 'completed';
        $withdrawal->processed_at = now();
        $withdrawal->save();

        return redirect()->back()->with('success', 'Penarikan berhasil disetujui!');
    }

    public function rejectWithdraw(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'Penarikan sudah diproses.');
        }

        $user = $withdrawal->user;

        // Catat riwayat refund (poin kembali) 
        PoinHelper::catat(
            $user,
            $withdrawal->points,
            'refund',
            'Refund penarikan paket ' . $withdrawal->points . ' poin',
            $withdrawal
        );

        $withdrawal->status = 'failed';
        $withdrawal->admin_note = $request->note ?? 'Ditolak oleh admin';
        $withdrawal->save();

        return redirect()->back()->with('success', 'Penarikan ditolak. Poin dikembalikan.');
    }

    private function getBankCode($bankName)
    {
        $banks = [
            'bca' => 'BCA',
            'bni' => 'BNI',
            'bri' => 'BRI',
            'mandiri' => 'MANDIRI',
            'cimb' => 'CIMB',
            'danamon' => 'DANAMON',
            'permata' => 'PERMATA',
            'btn' => 'BTN',
            'maybank' => 'MAYBANK',
            'bsi' => 'BSI',
            'mega' => 'MEGA',
            'sinarmas' => 'SINARMAS',
        ];
        return $banks[strtolower($bankName)] ?? strtoupper($bankName);
    }
}