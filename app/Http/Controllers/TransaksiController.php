<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setoran;
use App\Models\Withdrawal;
use App\Models\Setting;
use GlennRaya\Xendivel\Xendivel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Menampilkan semua transaksi (setoran + penarikan) dengan filter
     */
    public function index(Request $request)
    {
        // 1. Query untuk SETORAN
        $setoran = Setoran::select(
            'id',
            'user_id',
            'tanggal',
            'metode',
            DB::raw('berat_aktual as berat'),
            DB::raw('0 as total'),
            'status',
            DB::raw("'setoran' as type"),
            DB::raw("NULL as account_number"),
            DB::raw("NULL as payment_method"),
            DB::raw("0 as amount"),
            DB::raw("NULL as admin_note")
        );

        // 2. Query untuk WITHDRAW
        $withdraw = Withdrawal::select(
            'id',
            'user_id',
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

        // 3. Filter
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

    /**
     * Detail transaksi (setoran atau withdraw)
     */
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

    /**
     * Edit transaksi (khusus setoran)
     */
    public function edit($id)
    {
        $setoran = Setoran::with('user.pelanggan')->findOrFail($id);
        return view('admin.transaksi.edit', compact('setoran'));
    }

    /**
     * Update transaksi (setoran) - otomatis tambah poin jika status berubah
     */
    public function update(Request $request, $id)
    {
        $setoran = Setoran::with('user')->findOrFail($id);
        $oldStatus = $setoran->status;

        $setoran->update($request->all());

        // Jika status berubah ke approved/completed dan sebelumnya belum
        if (in_array($setoran->status, ['approved', 'completed']) && !in_array($oldStatus, ['approved', 'completed'])) {
            $poinPerKg = Setting::get('poin_per_kg', 100);
            $poin = $setoran->berat_aktual * $poinPerKg;
            $user = $setoran->user;
            if ($user) {
                $user->points = ($user->points ?? 0) + $poin;
                $user->save();
            }
        }

        return redirect()->route('admin.transaksi.index')->with('success', 'Setoran berhasil diupdate.');
    }

    /**
     * Hapus transaksi (setoran)
     */
    public function destroy($id)
    {
        $setoran = Setoran::findOrFail($id);
        $setoran->delete();
        return redirect()->route('admin.transaksi.index')->with('success', 'Setoran berhasil dihapus.');
    }

    // ============================================================
    // APPROVE SETORAN (OTOMATIS TAMBAH POIN)
    // ============================================================
    public function approveSetoran($id)
    {
        $setoran = Setoran::with('user')->findOrFail($id);

        if (in_array($setoran->status, ['approved', 'completed'])) {
            return redirect()->back()->with('error', 'Setoran sudah disetujui sebelumnya.');
        }

        $poinPerKg = Setting::get('poin_per_kg', 100);
        $poin = $setoran->berat_aktual * $poinPerKg;

        $user = $setoran->user;
        if ($user) {
            $user->points = ($user->points ?? 0) + $poin;
            $user->save();
        }

        $setoran->status = 'approved';
        $setoran->save();

        return redirect()->back()->with('success', "✅ Setoran disetujui! +{$poin} poin ditambahkan.");
    }

    // ============================================================
    // FUNGSI APPROVE / REJECT WITHDRAW
    // ============================================================

    public function approveWithdraw($id)
    {
        $withdrawal = Withdrawal::with('user')->findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'Penarikan sudah diproses.');
        }

        try {
            $xendit = new Xendivel();

            $channelMap = [
                'dana' => 'DANA',
                'ovo' => 'OVO',
                'gopay' => 'GOPAY',
                'qris' => 'DANA',
                'bank' => 'BANK_TRANSFER',
            ];
            $channel = $channelMap[$withdrawal->payment_method] ?? 'DANA';

            $payload = [
                'reference_id' => 'wd_' . $withdrawal->id . '_' . time(),
                'currency' => 'IDR',
                'amount' => (int) $withdrawal->amount,
                'channel_code' => $channel,
                'channel_properties' => [
                    'mobile_number' => $withdrawal->account_number,
                ],
            ];

            if ($withdrawal->payment_method === 'bank') {
                $payload['channel_properties'] = [
                    'account_holder_name' => $withdrawal->account_name ?? $withdrawal->user->name,
                    'account_number' => $withdrawal->account_number,
                    'bank_code' => $this->getBankCode($withdrawal->bank_name),
                ];
            }

            $response = $xendit->ewallet()->createEWalletCharge($payload);

            if ($response['status'] == 'SUCCEEDED') {
                $withdrawal->status = 'success';
                $withdrawal->processed_at = now();
                $withdrawal->admin_note = 'Sukses via Xendit';
                $withdrawal->save();

                return redirect()->back()->with('success', '💰 Penarikan berhasil dikirim ke e-wallet user!');
            } elseif ($response['status'] == 'PENDING') {
                $withdrawal->status = 'processing';
                $withdrawal->save();
                return redirect()->back()->with('info', '⏳ Penarikan sedang diproses.');
            } else {
                throw new \Exception('Status dari Xendit: ' . ($response['status'] ?? 'unknown'));
            }
        } catch (\Exception $e) {
            $user = $withdrawal->user;
            $user->points += $withdrawal->points;
            $user->save();

            $withdrawal->status = 'failed';
            $withdrawal->admin_note = 'Error: ' . $e->getMessage();
            $withdrawal->save();

            return redirect()->back()->with('error', '❌ Gagal kirim uang: ' . $e->getMessage());
        }
    }

    public function rejectWithdraw(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'Penarikan sudah diproses.');
        }

        $user = $withdrawal->user;
        $user->points += $withdrawal->points;
        $user->save();

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