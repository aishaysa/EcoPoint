<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSampah;
use Illuminate\Http\Request;

class JenisSampahController extends Controller
{
    public function index()
    {
        $jenisSampahs = JenisSampah::latest()->get();

        return view('admin.jenis-sampah.index', compact('jenisSampahs'));
    }


    public function create()
    {
        return view('admin.jenis-sampah.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'poin_per_kg' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
        ]);


        JenisSampah::create([
            'nama' => $request->nama,
            'poin_per_kg' => $request->poin_per_kg,
            'deskripsi' => $request->deskripsi,
        ]);


        return redirect()
            ->route('admin.jenis-sampah.index')
            ->with('success', 'Jenis sampah berhasil ditambahkan.');
    }


    public function edit(JenisSampah $jenisSampah)
    {
        return view(
            'admin.jenis-sampah.edit',
            compact('jenisSampah')
        );
    }


    public function update(
        Request $request,
        JenisSampah $jenisSampah
    ) {

        $request->validate([
            'nama' => 'required|string|max:255',
            'poin_per_kg' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
        ]);


        $jenisSampah->update([
            'nama' => $request->nama,
            'poin_per_kg' => $request->poin_per_kg,
            'deskripsi' => $request->deskripsi,
        ]);


        return redirect()
            ->route('admin.jenis-sampah.index')
            ->with('success', 'Jenis sampah berhasil diperbarui.');
    }


    public function destroy(JenisSampah $jenisSampah)
    {
        $jenisSampah->delete();

        return redirect()
            ->route('admin.jenis-sampah.index')
            ->with('success', 'Jenis sampah berhasil dihapus.');
    }
}