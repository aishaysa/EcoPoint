<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class XenditWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Verifikasi token webhook
        $callbackToken = $request->header('x-callback-token');
        $expectedToken = env('XENDIT_CALLBACK_TOKEN');

        if ($callbackToken !== $expectedToken) {
            Log::warning('Webhook token tidak cocok', ['received' => $callbackToken]);
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $event = $request->input('event');
        $data  = $request->input('data');
        $refId = $data['reference_id'] ?? null;

        Log::info('WEBHOOK MASUK:', ['event' => $event, 'reference_id' => $refId]);

        if (!$refId) {
            return response()->json(['message' => 'No reference_id'], 400);
        }

        $withdrawal = Withdrawal::where('reference_id', $refId)->first();

        if (!$withdrawal) {
            return response()->json(['message' => 'Not found'], 404);
        }

        if ($event === 'v3_payout.succeeded') {
            $withdrawal->update([
                'status'       => 'completed',
                'processed_at' => now(),
            ]);
            Log::info('Payout SUKSES:', ['reference_id' => $refId]);

        } elseif (in_array($event, ['v3_payout.failed', 'v3_payout.reversed'])) {
            $withdrawal->update(['status' => 'failed']);

            // Kembalikan poin ke user
            $user = \App\Models\User::find($withdrawal->user_id);
            if ($user) {
                \App\Helpers\PoinHelper::catat(
                    $user,
                    $withdrawal->points,
                    'refund',
                    'Refund karena payout gagal: ' . $event,
                    null
                );
            }
            Log::info('Payout GAGAL:', ['reference_id' => $refId, 'event' => $event]);
        }

        return response()->json(['message' => 'OK']);
    }
}