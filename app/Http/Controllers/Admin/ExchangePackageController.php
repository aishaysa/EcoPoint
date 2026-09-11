<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExchangePackage;
use Illuminate\Http\Request;

class ExchangePackageController extends Controller
{
    /**
     * ============================================================
     * LIST PAKET PENUKARAN (dengan pagination)
     * ============================================================
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $packages = ExchangePackage::orderBy('id', 'desc')
                                    ->paginate($perPage)
                                    ->withQueryString();

        return view('admin.exchange-package.index', compact('packages', 'perPage'));
    }

    /**
     * ============================================================
     * FORM TAMBAH
     * ============================================================
     */
    public function create()
    {
        return view('admin.exchange-package.create');
    }

    /**
     * ============================================================
     * SIMPAN BARU
     * ✅ FIX: default is_active = true biar langsung muncul di user
     * ============================================================
     */
    public function store(Request $request)
    {
        $request->validate([
            'points'      => 'required|integer|min:1',
            'amount'      => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        ExchangePackage::create([
            'points'      => $request->points,
            'amount'      => $request->amount,
            'description' => $request->description,
            // ✅ Default AKTIF kalau checkbox gak ada / gak di-centang
            // (checkbox cuma buat nonaktifin manual)
            'is_active'   => $request->has('is_active') ? $request->boolean('is_active') : true,
        ]);

        return redirect()->route('admin.exchange-package.index')
                         ->with('success', 'Paket penukaran berhasil ditambahkan.');
    }

    /**
     * ============================================================
     * FORM EDIT
     * ============================================================
     */
    public function edit($id)
    {
        $package = ExchangePackage::findOrFail($id);
        return view('admin.exchange-package.edit', compact('package'));
    }

    /**
     * ============================================================
     * UPDATE
     * ✅ FIX: sama seperti store
     * ============================================================
     */
    public function update(Request $request, $id)
    {
        $package = ExchangePackage::findOrFail($id);

        $request->validate([
            'points'      => 'required|integer|min:1',
            'amount'      => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $package->update([
            'points'      => $request->points,
            'amount'      => $request->amount,
            'description' => $request->description,
            // Kalau checkbox gak ada di form, tetap ikut value lama
            // Kalau ada checkbox, ikuti value-nya
            'is_active'   => $request->has('is_active') 
                                ? $request->boolean('is_active') 
                                : $package->is_active,
        ]);

        return redirect()->route('admin.exchange-package.index')
                         ->with('success', 'Paket penukaran berhasil diperbarui.');
    }

    /**
     * ============================================================
     * HAPUS
     * ============================================================
     */
    public function destroy($id)
    {
        $package = ExchangePackage::findOrFail($id);
        $package->delete();

        return redirect()->route('admin.exchange-package.index')
                         ->with('success', 'Paket penukaran berhasil dihapus.');
    }

    /**
     * ============================================================
     * TOGGLE STATUS AKTIF/NONAKTIF (opsional)
     * Bisa dipanggil dari tombol quick-toggle di list
     * ============================================================
     */
    public function toggleStatus($id)
    {
        $package = ExchangePackage::findOrFail($id);
        $package->is_active = !$package->is_active;
        $package->save();

        $status = $package->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Paket berhasil {$status}.");
    }
}