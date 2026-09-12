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
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class TransaksiController extends Controller
{
    /**
     * ============================================================
     * HALAMAN INDEX TRANSAKSI
     * ============================================================
     */
    public function index(Request $request)
    {
        $filter  = $request->get('filter', 'all');
        $search  = trim($request->get('search', ''));
        $tanggal = $request->get('tanggal');
        $bulan   = $request->get('bulan');
        $tahun   = $request->get('tahun');

        // Deteksi tabel & kolom nama pelanggan
        $pelangganTable   = null;
        $pelangganNameCol = null;

        if (Schema::hasTable('pelanggan')) {
            $pelangganTable = 'pelanggan';
        } elseif (Schema::hasTable('pelanggans')) {
            $pelangganTable = 'pelanggans';
        }

        if ($pelangganTable) {
            $cols = Schema::getColumnListing($pelangganTable);
            if (in_array('nama', $cols)) {
                $pelangganNameCol = 'nama';
            } elseif (in_array('name', $cols)) {
                $pelangganNameCol = 'name';
            }
        }

        // ✅ Deteksi SEMUA kolom berat yang mungkin ada
        $setoranCols = Schema::getColumnListing('setorans');
        $beratKandidat = [];
        foreach (['berat_aktual', 'berat', 'total_berat'] as $k) {
            if (in_array($k, $setoranCols)) {
                $beratKandidat[] = $k;
            }
        }

        // Deteksi tabel pivot jenis sampah
        $pivotTable = null;
        if (Schema::hasTable('setoran_jenis_sampah')) {
            $pivotTable = 'setoran_jenis_sampah';
        } elseif (Schema::hasTable('jenis_sampah_setoran')) {
            $pivotTable = 'jenis_sampah_setoran';
        }

        $collections = collect();

        // ============================================================
        // SETORAN
        // ============================================================
        if (in_array($filter, ['all', 'setoran'])) {
            // ✅ Eager load pivot juga
            $q = Setoran::with(['user', 'pelanggan', 'jenisSampahs'])->latest('tanggal');

            if ($search) {
                $q->where(function ($sq) use ($search, $pelangganNameCol, $pelangganTable, $beratKandidat) {
                    $sq->where('status', 'like', "%{$search}%")
                       ->orWhere('metode', 'like', "%{$search}%")
                       ->orWhere('id', 'like', "%{$search}%")
                       ->orWhereRaw("'setoran' LIKE ?", ["%{$search}%"])
                       ->orWhereHas('user', function ($u) use ($search) {
                           $u->where('name', 'like', "%{$search}%");
                       });

                    // Search ke semua kolom berat
                    foreach ($beratKandidat as $k) {
                        $sq->orWhere($k, 'like', "%{$search}%");
                    }

                    if ($pelangganTable && $pelangganNameCol) {
                        $sq->orWhereHas('pelanggan', function ($p) use ($search, $pelangganNameCol) {
                            $p->where($pelangganNameCol, 'like', "%{$search}%");
                        });
                    }
                });
            }

            if ($tanggal) $q->whereDay('tanggal', $tanggal);
            if ($bulan)   $q->whereMonth('tanggal', $bulan);
            if ($tahun)   $q->whereYear('tanggal', $tahun);

            $setoranItems = $q->get()->map(function ($item) use ($pelangganNameCol, $beratKandidat) {
                $nama = null;
                if ($item->pelanggan && $pelangganNameCol) {
                    $nama = $item->pelanggan->{$pelangganNameCol} ?? null;
                }
                if (!$nama && $item->user) {
                    $nama = $item->user->name;
                }

                // ✅ Cek semua kolom berat, ambil yang > 0
                $berat = 0;
                foreach ($beratKandidat as $k) {
                    $val = $item->{$k} ?? 0;
                    if ($val > 0) {
                        $berat = $val;
                        break;
                    }
                }

                // ✅ Fallback: hitung dari pivot jenis sampah
                if ($berat == 0 && $item->relationLoaded('jenisSampahs') && $item->jenisSampahs && $item->jenisSampahs->count()) {
                    $berat = $item->jenisSampahs->sum(function ($js) {
                        return $js->pivot->berat_aktual ?? $js->pivot->berat ?? 0;
                    });
                }

                return (object) [
                    'id'             => $item->id,
                    'user_id'        => $item->user_id,
                    'pelanggan_id'   => $item->pelanggan_id,
                    'user_name'      => $nama ?? 'Tanpa Nama',
                    'tanggal'        => $item->tanggal,
                    'metode'         => $item->metode,
                    'berat'          => $berat,
                    'total'          => 0,
                    'status'         => $item->status,
                    'type'           => 'setoran',
                    'account_number' => null,
                    'payment_method' => null,
                    'amount'         => 0,
                    'admin_note'     => null,
                ];
            });

            $collections = $collections->merge($setoranItems);
        }

        // ============================================================
        // WITHDRAW
        // ============================================================
        if (in_array($filter, ['all', 'withdraw'])) {
            $q = Withdrawal::with('user')->latest('created_at');

            if ($search) {
                $q->where(function ($sq) use ($search) {
                    $sq->where('status', 'like', "%{$search}%")
                       ->orWhere('payment_method', 'like', "%{$search}%")
                       ->orWhere('account_number', 'like', "%{$search}%")
                       ->orWhere('amount', 'like', "%{$search}%")
                       ->orWhere('id', 'like', "%{$search}%")
                       ->orWhereRaw("'withdraw' LIKE ?", ["%{$search}%"])
                       ->orWhereHas('user', function ($u) use ($search) {
                           $u->where('name', 'like', "%{$search}%");
                       });
                });
            }

            if ($tanggal) $q->whereDay('created_at', $tanggal);
            if ($bulan)   $q->whereMonth('created_at', $bulan);
            if ($tahun)   $q->whereYear('created_at', $tahun);

            $withdrawItems = $q->get()->map(function ($item) {
                return (object) [
                    'id'             => $item->id,
                    'user_id'        => $item->user_id,
                    'pelanggan_id'   => null,
                    'user_name'      => $item->user->name ?? 'Tanpa Nama',
                    'tanggal'        => $item->created_at,
                    'metode'         => 'withdraw',
                    'berat'          => 0,
                    'total'          => $item->amount,
                    'status'         => $item->status,
                    'type'           => 'withdraw',
                    'account_number' => $item->account_number,
                    'payment_method' => $item->payment_method,
                    'amount'         => $item->amount,
                    'admin_note'     => $item->admin_note,
                ];
            });

            $collections = $collections->merge($withdrawItems);
        }

        // Sort & Pagination
        $collections = $collections->sortByDesc('tanggal')->values();
        $perPage      = 20;
        $currentPage  = Paginator::resolveCurrentPage();
        $currentItems = $collections->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $allTransactions = new LengthAwarePaginator(
            $currentItems,
            $collections->count(),
            $perPage,
            $currentPage,
            [
                'path'  => Paginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]
        );
        $allTransactions->withPath($request->url());
        $allTransactions->appends($request->query());

        return view('admin.transaksi.index', compact('allTransactions', 'filter'));
    }

    /**
     * ============================================================
     * DETAIL TRANSAKSI
     * ============================================================
     */
    public function show(Request $request, $id)
    {
        $type = $request->query('type', 'setoran');

        if ($type == 'withdraw') {
            $data = Withdrawal::with('user')->findOrFail($id);
            return view('admin.transaksi.show', compact('data'))->with('type', 'withdraw');
        } else {
            $data = Setoran::with(['user.pelanggan', 'jenisSampahs'])->findOrFail($id);
            return view('admin.transaksi.show', compact('data'))->with('type', 'setoran');
        }
    }

    /**
     * ============================================================
     * DETAIL WITHDRAW
     * ============================================================
     */
    public function showWithdrawDetail($id)
    {
        $withdrawal = Withdrawal::with('user')->findOrFail($id);
        return view('admin.transaksi.withdraw-detail', compact('withdrawal'));
    }

    /**
     * ============================================================
     * EDIT SETORAN
     * ============================================================
     */
    public function edit($id)
    {
        $setoran = Setoran::with(['user.pelanggan', 'jenisSampahs'])->findOrFail($id);
        return view('admin.transaksi.edit', compact('setoran'));
    }

    /**
     * ============================================================
     * UPDATE SETORAN
     * ============================================================
     */
    public function update(Request $request, $id)
    {
        $setoran = Setoran::findOrFail($id);
        $setoran->update($request->all());
        return redirect()->route('admin.transaksi.index')
                         ->with('success', 'Setoran berhasil diupdate.');
    }

    /**
     * ============================================================
     * HAPUS SETORAN
     * ============================================================
     */
    public function destroy($id)
    {
        $setoran = Setoran::findOrFail($id);
        $setoran->delete();
        return redirect()->route('admin.transaksi.index')
                         ->with('success', 'Setoran berhasil dihapus.');
    }

    /**
     * ============================================================
     * APPROVE SETORAN
     * ============================================================
     */
    public function approve($id, Request $request)
    {
        $setoran = Setoran::findOrFail($id);
        $setoran->status = 'approved';
        $setoran->save();

        // ✅ Ambil berat dari semua kolom yang mungkin ada
        $setoranCols = Schema::getColumnListing('setorans');
        $beratKandidat = [];
        foreach (['berat_aktual', 'berat', 'total_berat'] as $k) {
            if (in_array($k, $setoranCols)) {
                $beratKandidat[] = $k;
            }
        }

        $beratAkhir = $request->berat_akhir ?? 0;
        if ($beratAkhir == 0) {
            foreach ($beratKandidat as $k) {
                $val = $setoran->{$k} ?? 0;
                if ($val > 0) {
                    $beratAkhir = $val;
                    break;
                }
            }
        }
        // Fallback dari pivot
        if ($beratAkhir == 0) {
            $setoran->load('jenisSampahs');
            if ($setoran->jenisSampahs && $setoran->jenisSampahs->count()) {
                $beratAkhir = $setoran->jenisSampahs->sum(function ($js) {
                    return $js->pivot->berat_aktual ?? $js->pivot->berat ?? 0;
                });
            }
        }

        $poinDidapat = $beratAkhir * 10;

        $user = User::find($setoran->user_id);
        if ($user) {
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
            if (in_array('points', $pelanggan->getFillable()) || Schema::hasColumn('pelanggan', 'points')) {
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

    /**
     * ============================================================
     * REJECT SETORAN
     * ============================================================
     */
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

    /**
     * ============================================================
     * WITHDRAW - APPROVE
     * ============================================================
     */
    public function approveWithdraw($id)
    {
        $withdrawal = Withdrawal::with('user')->findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'Penarikan sudah diproses.');
        }

        $withdrawal->status = 'completed';
        $withdrawal->processed_at = now();
        $withdrawal->save();

        return redirect()->back()->with('success', 'Penarikan berhasil disetujui!');
    }

    /**
     * ============================================================
     * WITHDRAW - REJECT
     * ============================================================
     */
    public function rejectWithdraw(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'Penarikan sudah diproses.');
        }

        $user = $withdrawal->user;

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

    /**
     * ============================================================
     * HELPER: Kode Bank
     * ============================================================
     */
    private function getBankCode($bankName)
    {
        $banks = [
            'bca'      => 'BCA',
            'bni'      => 'BNI',
            'bri'      => 'BRI',
            'mandiri'  => 'MANDIRI',
            'cimb'     => 'CIMB',
            'danamon'  => 'DANAMON',
            'permata'  => 'PERMATA',
            'btn'      => 'BTN',
            'maybank'  => 'MAYBANK',
            'bsi'      => 'BSI',
            'mega'     => 'MEGA',
            'sinarmas' => 'SINARMAS',
        ];
        return $banks[strtolower($bankName)] ?? strtoupper($bankName);
    }
}