<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $poinPerKg = Setting::get('poin_per_kg', 100);
        return view('admin.settings.index', compact('poinPerKg'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'poin_per_kg' => 'required|integer|min:1',
        ]);

        Setting::set('poin_per_kg', $request->poin_per_kg);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan poin berhasil diupdate!');
    }
}