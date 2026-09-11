<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\ExchangePackage;
use App\Helpers\PoinHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'package_id'     => 'required|exists:exchange_packages,id',
            'payment_method' => 'required|in:dana,ovo,gopay,qris,bank',
            'phone'          => 'required_if:payment_method,dana,ovo,gopay,qris|nullable|string',
            'bank_name'      => 'required_if:payment_method,bank|nullable|string',
            'account_number' => 'required_if:payment_method,bank|nullable|string',
            'account_name'   => 'required_if:payment_method,bank|nullable|string',
        ]);

        $user = Auth::user();
        $package = ExchangePackage::findOrFail($request->package_id);

        if (($user->points ?? 0) < $package->points) {
            return redirect()->back()->with('error', 'Poin tidak mencukupi');
        }

        PoinHelper::catat(
            $user,
            -$package->points,
            'penarikan',
            'Penarikan paket ' . $package->points . ' poin (Rp ' . number_format($package->amount, 0, ',', '.') . ')',
            null
        );

        $accountNumber = $request->phone ?? $request->account_number ?? null;
        $accountName   = $request->account_name ?? $user->name;
        $bankName      = $request->bank_name ?? null;

        Withdrawal::create([
            'user_id'        => $user->id,
            'package_id'     => $package->id,
            'points'         => $package->points,
            'amount'         => $package->amount,
            'payment_method' => $request->payment_method,
            'account_number' => $accountNumber,
            'account_name'   => $accountName,
            'bank_name'      => $bankName,
            'status'         => 'pending',
        ]);

return redirect()->route('user.poin')
    ->with('success', 'Pengajuan penarikan berhasil. Tunggu proses admin.');
        }
}