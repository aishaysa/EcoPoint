<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Helpers\PoinHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class XenditWebhookController extends Controller
{
    public function payout(Request $request)
    {
        Log::info('XENDIT WEBHOOK PAYOUT:', $request->all());

        // Verifikasi callback token (opsional, tapi disarankan)
        $callbackToken = $request->header('x-callback-token');
        if ($callbackToken !== env('XENDIT_CALLBACK_TOKEN')) {
            Log::warning('XENDIT WEBHOOK: Invalid callback token');
            return response()->json(['message' => 'Invalid token'], 403);
        }

        $referenceId = $request->input('reference_id');
        $status      = $request->input('status'); // ACCEPTED, COMPLETED, FAILED, REVERSED, dll

        $withdrawal = Withdrawal::where('reference_id', $referenceId)->first();

        if (!$withdrawal) {
            Log::warning('XENDIT WEBHOOK: Withdrawal not found', ['reference_id' => $referenceId]);
            return response()->json(['message' => 'Not found'], 404);
        }

        // Mapping status Xendit → status lokal
        switch (strtoupper($status)) {
            case 'COMPLETED':
            case 'SUCCEEDED':
                $withdrawal->update(['status' => 'completed']);
                break;

            case 'FAILED':
            case 'REVERSED':
            case 'CANCELLED':
                // Refund poin kalau gagal
                if ($withdrawal->status !== 'failed') {
                    PoinHelper::catat(
                        $withdrawal->user,
                        $withdrawal->points,
                        'refund',
                        'Refund karena payout gagal (webhook)',
                        $withdrawal
                    );
                }
                $withdrawal->update(['status' => 'failed']);
                break;

            case 'ACCEPTED':
            case 'PENDING':
            default:
                // Biarkan tetap pending
                break;
        }

        return response()->json(['message' => 'OK']);
    }
}