<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setoran;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Status yang dianggap "menunggu diproses"
     */
    private function pendingSetoranStatuses(): array
    {
        return ['pending', 'menunggu', 'waiting', 'baru', 'new', 'process', 'processing', 'review'];
    }

    private function pendingWithdrawStatuses(): array
    {
        return ['pending', 'menunggu', 'waiting', 'process', 'processing'];
    }

    /**
     * GET /admin/notifications
     */
    public function index()
    {
        try {
            $setoranStatuses  = $this->pendingSetoranStatuses();
            $withdrawStatuses = $this->pendingWithdrawStatuses();

            $setoranPending = Setoran::with('user')
                ->whereIn('status', $setoranStatuses)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($s) {
                    $berat = $s->berat_aktual > 0 ? $s->berat_aktual : $s->berat;
                    return [
                        'id'         => 'setoran-' . $s->id,
                        'type'       => 'setoran',
                        'title'      => 'Setoran Baru #' . $s->id,
                        'message'    => ($s->user->name ?? 'User') . ' mengajukan setoran ' .
                                        number_format($berat ?? 0, 2) . ' kg — Status: ' . ucfirst($s->status),
                        'url'        => route('admin.transaksi.index', ['filter' => 'setoran']),
                        'icon'       => 'inbox',
                        'color'      => 'blue',
                        'created_at' => $s->created_at->toIso8601String(),
                        'time_ago'   => $s->created_at->diffForHumans(),
                    ];
                });

            $withdrawPending = Withdrawal::with('user')
                ->whereIn('status', $withdrawStatuses)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($w) {
                    return [
                        'id'         => 'withdraw-' . $w->id,
                        'type'       => 'withdraw',
                        'title'      => 'Penarikan Baru #' . $w->id,
                        'message'    => ($w->user->name ?? 'User') . ' mengajukan penarikan Rp ' .
                                        number_format($w->amount, 0, ',', '.') . ' — Status: ' . ucfirst($w->status),
                        'url'        => route('admin.transaksi.index', ['filter' => 'withdraw']),
                        'icon'       => 'cash',
                        'color'      => 'yellow',
                        'created_at' => $w->created_at->toIso8601String(),
                        'time_ago'   => $w->created_at->diffForHumans(),
                    ];
                });

            $notifications = $setoranPending
                ->merge($withdrawPending)
                ->sortByDesc('created_at')
                ->values();

            return response()->json([
                'count'         => $notifications->count(),
                'notifications' => $notifications,
            ]);

        } catch (\Throwable $e) {
            Log::error('Notif error: ' . $e->getMessage());
            return response()->json([
                'count'         => 0,
                'notifications' => [],
                'error'         => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * GET /admin/notifications/count
     */
    public function count()
    {
        try {
            $setoranCount  = Setoran::whereIn('status', $this->pendingSetoranStatuses())->count();
            $withdrawCount = Withdrawal::whereIn('status', $this->pendingWithdrawStatuses())->count();

            return response()->json(['count' => $setoranCount + $withdrawCount]);

        } catch (\Throwable $e) {
            Log::error('Notif count error: ' . $e->getMessage());
            return response()->json(['count' => 0, 'error' => $e->getMessage()], 500);
        }
    }
}