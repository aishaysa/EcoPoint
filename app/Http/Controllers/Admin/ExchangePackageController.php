<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExchangePackage;
use Illuminate\Http\Request;

class ExchangePackageController extends Controller
{
    public function index()
    {
        $packages = ExchangePackage::latest()->get();
        return view('admin.exchange-packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.exchange-packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'points' => 'required|integer|min:1',
            'amount' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        ExchangePackage::create([
            'points' => $request->points,
            'amount' => $request->amount,
            'description' => $request->description ?? $request->points . ' Poin',
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.exchange-packages.index')
            ->with('success', 'Paket berhasil ditambahkan!');
    }

    public function edit(ExchangePackage $exchangePackage)
    {
        return view('admin.exchange-packages.edit', compact('exchangePackage'));
    }

    public function update(Request $request, ExchangePackage $exchangePackage)
    {
        $request->validate([
            'points' => 'required|integer|min:1',
            'amount' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $exchangePackage->update([
            'points' => $request->points,
            'amount' => $request->amount,
            'description' => $request->description ?? $request->points . ' Poin',
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.exchange-packages.index')
            ->with('success', 'Paket berhasil diperbarui!');
    }

    public function destroy(ExchangePackage $exchangePackage)
    {
        // Cek apakah paket sudah dipakai di penarikan
        if ($exchangePackage->withdrawals()->count() > 0) {
            return back()->with('error', 'Paket tidak bisa dihapus karena sudah digunakan dalam penarikan.');
        }

        $exchangePackage->delete();
        return redirect()->route('admin.exchange-packages.index')
            ->with('success', 'Paket berhasil dihapus!');
    }

}