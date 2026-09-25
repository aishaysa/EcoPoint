<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\ExchangePackage;
use App\Helpers\PoinHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WithdrawController extends Controller
{
    public function index()
    {
        $packages = ExchangePackage::where('is_active', true)
            ->orderBy('points', 'asc')
            ->get();

        $histories = Withdrawal::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.withdraw', compact('packages', 'histories'));
    }

    public function store(Request $request)
    {
        Log::info('=== CONTROLLER MASUK ===', $request->all());

        $request->validate([
            'package_id'     => 'required|exists:exchange_packages,id',
            'payment_method' => 'required|in:dana,ovo,gopay,bank',
            'phone'          => 'required_if:payment_method,dana,ovo,gopay|nullable|string',
            'bank_name'      => 'required_if:payment_method,bank|nullable|string',
            'account_number' => 'required_if:payment_method,bank|nullable|string',
            'account_name'   => 'required_if:payment_method,bank|nullable|string',
        ]);

        $user    = Auth::user();
        $package = ExchangePackage::findOrFail($request->package_id);

        if (($user->points ?? 0) < $package->points) {
            return redirect()->back()->with('error', 'Poin tidak mencukupi');
        }

        $isBank = ($request->payment_method === 'bank');

        // Minimum amount: bank Rp 10.000, e-wallet Rp 1.000
        $minimumAmount = $isBank ? 10000 : 1000;
        if ($package->amount < $minimumAmount) {
            $label = $isBank ? 'Bank' : 'E-Wallet';
            return redirect()->back()->with('error', "Nominal penarikan minimal {$label} Rp " . number_format($minimumAmount, 0, ',', '.') . '. Hubungi admin.');
        }

        // Siapkan data akun tujuan
        if ($isBank) {
            $accountNumber = preg_replace('/[^0-9]/', '', $request->account_number);
            $accountName   = $request->filled('account_name') ? $request->account_name : $user->name;

            $bankName = strtoupper(trim($request->bank_name));
            $bankName = str_replace(['BANK ', 'BANK'], '', $bankName);
            $bankName = trim($bankName);
        } else {
            $accountNumber = preg_replace('/[^0-9]/', '', $request->phone);
            // Xendit e-wallet minta format 08xxxxxxxxxx
            if (substr($accountNumber, 0, 2) === '62') {
                $accountNumber = '0' . substr($accountNumber, 2);
            }
            $accountName = $user->name;
            $bankName    = null;
        }

        // Potong poin user
        PoinHelper::catat(
            $user,
            -$package->points,
            'penarikan',
            'Penarikan paket ' . $package->points . ' poin (Rp ' . number_format($package->amount, 0, ',', '.') . ')',
            null
        );

        $referenceId = 'TRX-' . uniqid();

        $withdrawal = Withdrawal::create([
            'user_id'        => $user->id,
            'package_id'     => $package->id,
            'points'         => $package->points,
            'amount'         => $package->amount,
            'payment_method' => $request->payment_method,
            'account_number' => $accountNumber,
            'account_name'   => $accountName,
            'bank_name'      => $bankName,
            'status'         => 'pending',
            'reference_id'   => $referenceId,
        ]);

        try {
            if ($isBank) {
                // ===== BANK: PAKAI DISBURSEMENT API =====
Http::withBasicAuth(config('services.xendit.secret_key'), '')
                    ->withHeaders([
                        'Idempotency-key' => $referenceId,
                    ])
                    ->post('https://api.xendit.co/disbursements', [
                        'external_id'        => $referenceId,
                        'bank_code'          => $bankName,          // BCA, BNI, MANDIRI, dll
                        'account_holder_name'=> $accountName,
                        'account_number'     => $accountNumber,
                        'description'        => 'Penarikan saldo EcoPoint',
                        'amount'             => (int) $package->amount,
                    ]);

                Log::info('XENDIT DISBURSEMENT REQUEST:', [
                    'reference_id'   => $referenceId,
                    'bank_code'      => $bankName,
                    'account_number' => $accountNumber,
                    'account_name'   => $accountName,
                    'amount'         => $package->amount,
                ]);

            } else {
                // ===== E-WALLET: PAKAI PAYOUTS V3 API =====
                $channelMap = [
                    'dana'  => 'ID_DANA',
                    'ovo'   => 'ID_OVO',
                    'gopay' => 'ID_GOPAY',
                ];
                $routingValue = $channelMap[$request->payment_method]
                    ?? 'ID_' . strtoupper($request->payment_method);

                $response = Http::withBasicAuth(config('services.xendit.secret_key'), '')
                    ->withHeaders([
                        'api-version'     => '2025-09-01',
                        'Idempotency-key' => $referenceId,
                    ])
                    ->post('https://api.xendit.co/v3/payouts', [
                        'reference_id' => $referenceId,
                        'recipient'    => [
                            'type'         => 'INDIVIDUAL',
                            'given_name'   => $accountName,
                            'relationship' => 'CUSTOMER',
                            'address' => [
                                'country'       => 'ID',
                                'city'          => 'Jakarta',
                                'street_line_1' => 'Jl. Contoh No. 123',
                            ],
                            'account_details' => [
                                'account_holder_name' => $accountName,
                                'account_number'      => $accountNumber,
                                'currency'            => 'IDR',
                                'account_country'     => 'ID',
                                'routing_type_1'      => 'WALLET',
                                'routing_value_1'     => $routingValue,
                            ],
                        ],
                        'payout_details' => [
                            'source_currency'      => 'IDR',
                            'destination_currency' => 'IDR',
                            'source_amount'        => (int) $package->amount,
                        ],
                        'source_of_fund' => 'BUSINESS_REVENUE',
                        'purpose_code'   => 'OTHER',
                        'description'    => 'Penarikan saldo EcoPoint',
                    ]);

                Log::info('XENDIT PAYOUT REQUEST:', [
                    'reference_id'   => $referenceId,
                    'routing_value'  => $routingValue,
                    'account_number' => $accountNumber,
                    'account_name'   => $accountName,
                    'amount'         => $package->amount,
                ]);
            }

            // Log response (sama untuk dua API)
            Log::info('XENDIT RESPONSE:', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            if ($response->successful()) {
                return redirect()->route('user.poin')
                    ->with('success', 'Permintaan penarikan sedang diproses. Saldo akan masuk dalam beberapa menit.');
            }

            // Gagal → refund poin
            PoinHelper::catat(
                $user,
                $package->points,
                'refund',
                'Refund karena gagal penarikan',
                null
            );

            $withdrawal->update(['status' => 'failed']);

            $errorMsg  = $response->json('message') ?? 'Gagal memproses penarikan.';
            $errorList = $response->json('errors') ?? [];
            $fullError = $errorMsg;
            if (!empty($errorList)) {
                $fullError .= ' | ' . json_encode($errorList);
            }

            return redirect()->back()->with('error', 'Gagal: ' . $fullError);

        } catch (\Exception $e) {
            Log::error('XENDIT EXCEPTION:', [
                'message'      => $e->getMessage(),
                'reference_id' => $referenceId,
            ]);

            PoinHelper::catat(
                $user,
                $package->points,
                'refund',
                'Refund karena error koneksi ke Xendit',
                null
            );

            $withdrawal->update(['status' => 'failed']);

            return redirect()->back()->with('error', 'Terjadi kesalahan. Poin dikembalikan.');
        }
    }
}