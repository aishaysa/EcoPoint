<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * ============================================================
     * LIST PELANGGAN (dengan pagination)
     * ============================================================
     */
    public function index(Request $request)
    {
        // Jumlah per halaman (default 10, bisa diubah via ?per_page=25)
        $perPage = $request->get('per_page', 10);

        // Batasi biar gak kegedean
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        // Ambil pelanggan + jumlah setoran (pakai withCount)
        $pelanggans = Pelanggan::withCount('setorans')
                               ->orderBy('id', 'desc')
                               ->paginate($perPage)
                               ->withQueryString();  // ← penting: filter tetap aktif saat pindah halaman

        return view('admin.pelanggan.index', compact('pelanggans', 'perPage'));
    }

    /**
     * ============================================================
     * FORM TAMBAH PELANGGAN
     * ============================================================
     */
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    /**
     * ============================================================
     * SIMPAN PELANGGAN BARU
     * ============================================================
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:255',
            'no_hp'  => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'email'  => 'nullable|email|max:255',
        ]);

        Pelanggan::create([
            'nama'   => $request->nama,
            'no_hp'  => $request->no_hp,
            'alamat' => $request->alamat,
            'email'  => $request->email,
            'poin'   => 0,
        ]);

        return redirect()->route('admin.pelanggan.index')
                         ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    /**
     * ============================================================
     * DETAIL PELANGGAN
     * ============================================================
     */
    public function show($id)
    {
        $pelanggan = Pelanggan::with(['setorans' => function ($query) {
            $query->latest();
        }])->findOrFail($id);

        // Ambil transaksi dari relasi setorans
        $transaksis = $pelanggan->setorans;

        return view('admin.pelanggan.show', compact('pelanggan', 'transaksis'));
    }

    /**
     * ============================================================
     * FORM EDIT PELANGGAN
     * ============================================================
     */
    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    /**
     * ============================================================
     * UPDATE PELANGGAN
     * ============================================================
     */
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $request->validate([
            'nama'   => 'required|string|max:255',
            'no_hp'  => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'email'  => 'nullable|email|max:255',
        ]);

        $pelanggan->update([
            'nama'   => $request->nama,
            'no_hp'  => $request->no_hp,
            'alamat' => $request->alamat,
            'email'  => $request->email,
        ]);

        return redirect()->route('admin.pelanggan.index')
                         ->with('success', 'Pelanggan berhasil diperbarui.');
    }

    /**
     * ============================================================
     * HAPUS PELANGGAN
     * ============================================================
     */
    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->route('admin.pelanggan.index')
                         ->with('success', 'Pelanggan berhasil dihapus.');
    }
}