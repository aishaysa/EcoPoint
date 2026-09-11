<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSampah;
use Illuminate\Http\Request;

class JenisSampahController extends Controller
{
    /**
     * ============================================================
     * LIST JENIS SAMPAH (dengan pagination)
     * ============================================================
     */
    public function index(Request $request)
    {
        // Jumlah per halaman (default 10, bisa diubah via ?per_page=25)
        $perPage = $request->get('per_page', 10);
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $jenisSampahs = JenisSampah::orderBy('id', 'desc')
                                    ->paginate($perPage)
                                    ->withQueryString();

        return view('admin.jenis-sampah.index', compact('jenisSampahs', 'perPage'));
    }

    /**
     * ============================================================
     * FORM TAMBAH
     * ============================================================
     */
    public function create()
    {
        return view('admin.jenis-sampah.create');
    }

    /**
     * ============================================================
     * SIMPAN BARU
     * ============================================================
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'poin_per_kg'  => 'required|integer|min:0',
            'deskripsi'    => 'nullable|string',
        ]);

        JenisSampah::create([
            'nama'        => $request->nama,
            'poin_per_kg' => $request->poin_per_kg,
            'deskripsi'   => $request->deskripsi,
        ]);

        return redirect()->route('admin.jenis-sampah.index')
                         ->with('success', 'Jenis sampah berhasil ditambahkan.');
    }

    /**
     * ============================================================
     * FORM EDIT
     * ============================================================
     */
    public function edit($id)
    {
        $jenisSampah = JenisSampah::findOrFail($id);
        return view('admin.jenis-sampah.edit', compact('jenisSampah'));
    }

    /**
     * ============================================================
     * UPDATE
     * ============================================================
     */
    public function update(Request $request, $id)
    {
        $jenisSampah = JenisSampah::findOrFail($id);

        $request->validate([
            'nama'         => 'required|string|max:255',
            'poin_per_kg'  => 'required|integer|min:0',
            'deskripsi'    => 'nullable|string',
        ]);

        $jenisSampah->update([
            'nama'        => $request->nama,
            'poin_per_kg' => $request->poin_per_kg,
            'deskripsi'   => $request->deskripsi,
        ]);

        return redirect()->route('admin.jenis-sampah.index')
                         ->with('success', 'Jenis sampah berhasil diperbarui.');
    }

    /**
     * ============================================================
     * HAPUS
     * ============================================================
     */
    public function destroy($id)
    {
        $jenisSampah = JenisSampah::findOrFail($id);
        $jenisSampah->delete();

        return redirect()->route('admin.jenis-sampah.index')
                         ->with('success', 'Jenis sampah berhasil dihapus.');
    }
}