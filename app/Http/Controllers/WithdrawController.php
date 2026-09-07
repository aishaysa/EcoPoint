<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use App\Models\ExchangePackage;

class WithdrawController extends Controller
{
public function index()
{
    $user = Auth::user();
    // Ambil paket yang aktif saja
    $packages = ExchangePackage::where('is_active', true)->get();
    
    return view('user.withdraw', compact('user', 'packages'));
}
    public function store(Request $request)
    {
        $request->validate([
            'points' => 'required|integer|min:10',
        ]);

        $user = Auth::user();
        $points = $request->points;

        // Cek poin cukup
        if ($user->points < $points) {
            return back()->with('error', 'Poin tidak cukup!');
        }

        // Kurs: 120 poin = Rp 10.000
        $amount = ($points / 120) * 10000;

        // Kurangi poin user
        $user->points -= $points;
        $user->save();

        // Simpan ke database
        Withdrawal::create([
            'user_id' => $user->id,
            'points' => $points,
            'amount' => $amount,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'status' => 'pending',
        ]);

        return redirect()->route('user.withdraw')->with('success', 'Pengajuan berhasil!');
    }
}