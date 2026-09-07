<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\WithdrawPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{
public function index()
{
    $packages = WithdrawPackage::where('is_active', true)
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
            'package_id' => 'required|exists:withdraw_packages,id',
            'payment_method' => 'required|in:dana,ovo,gopay,qris,bank',
            'phone' => 'required_if:payment_method,dana,ovo,gopay,qris|nullable|string',
            'bank_name' => 'required_if:payment_method,bank|nullable|string',
            'account_number' => 'required_if:payment_method,bank|nullable|string',
            'account_name' => 'required_if:payment_method,bank|nullable|string',
        ]);

        $user = Auth::user();
        $package = WithdrawPackage::findOrFail($request->package_id);

        if ($user->points < $package->points) {
            return redirect()->back()->with('error', 'Poin tidak mencukupi!');
        }

        $user->points -= $package->points;
        $user->save();

        $accountNumber = $request->phone ?? $request->account_number ?? null;
        $accountName = $request->account_name ?? $user->name;
        $bankName = $request->bank_name ?? null;

        Withdrawal::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'points' => $package->points,
            'amount' => $package->amount,
            'payment_method' => $request->payment_method,
            'account_number' => $accountNumber,
            'account_name' => $accountName,
            'bank_name' => $bankName,
            'status' => 'pending',
        ]);

        return redirect()->route('user.withdraw')
            ->with('success', 'Pengajuan penarikan berhasil! Tunggu proses admin.');
    }
}