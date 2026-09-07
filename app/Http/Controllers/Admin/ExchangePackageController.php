<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawPackage;
use Illuminate\Http\Request;

class ExchangePackageController extends Controller
{
    public function index()
    {
        $packages = WithdrawPackage::orderBy('points', 'asc')->get();
        return view('admin.exchange-package.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.exchange-package.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'points' => 'required|integer|min:1',
            'amount' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        WithdrawPackage::create($request->all());

        return redirect()->route('admin.exchange-package.index')
            ->with('success', 'Paket berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $package = WithdrawPackage::findOrFail($id);
        return view('admin.exchange-package.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'points' => 'required|integer|min:1',
            'amount' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $package = WithdrawPackage::findOrFail($id);
        $package->update($request->all());

        return redirect()->route('admin.exchange-package.index')
            ->with('success', 'Paket berhasil diupdate!');
    }

    public function destroy($id)
    {
        $package = WithdrawPackage::findOrFail($id);
        $package->delete();

        return redirect()->route('admin.exchange-package.index')
            ->with('success', 'Paket berhasil dihapus!');
    }
}