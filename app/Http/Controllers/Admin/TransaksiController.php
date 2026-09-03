<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\JenisSampah;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class TransaksiController extends Controller
{
            /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaksi::with(['pelanggan', 'jenisSampah']);

        // Filter by pelanggan jika ada parameter
        if ($request->has('pelanggan_id') && $request->pelanggan_id != '') {
            $query->where('pelanggan_id', $request->pelanggan_id);
        }

        // 🔥 PERUBAHAN: gunakan paginate(15) bukan get()
        $transaksis = $query->orderBy('id', 'desc')->paginate(15);

        // 🔥 PERUBAHAN: pertahankan filter saat paginasi
        $transaksis->appends($request->query());

        return view('admin.transaksi.index', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pelanggans = Pelanggan::all();
        $jenisSampahs = JenisSampah::all();
        return view('admin.transaksi.create', compact('pelanggans', 'jenisSampahs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'jenis_sampah_id' => 'required|exists:jenis_sampahs,id',
            'berat' => 'required|numeric|min:0.01',
            'alamat' => 'nullable|string',
            'tanggal' => 'nullable|date',
        ]);

        $jenisSampah = JenisSampah::findOrFail($request->jenis_sampah_id);
        $totalHarga = $request->berat * $jenisSampah->harga_per_kg;

        $transaksi = Transaksi::create([
            'pelanggan_id' => $request->pelanggan_id,
            'jenis_sampah_id' => $request->jenis_sampah_id,
            'berat' => $request->berat,
            'total_harga' => $totalHarga,
            'alamat' => $request->alamat,
            'tanggal' => $request->tanggal ?? now(),
            'status' => 'pending',
        ]);

        // Tambah poin ke pelanggan (misal 1 poin per 1 kg)
        $pelanggan = Pelanggan::find($request->pelanggan_id);
        $pelanggan->increment('poin', (int) $request->berat);

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'jenisSampah'])->findOrFail($id);
        return view('admin.pelanggan.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $pelanggans = Pelanggan::all();
        $jenisSampahs = JenisSampah::all();
        return view('admin.transaksi.edit', compact('transaksi', 'pelanggans', 'jenisSampahs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'jenis_sampah_id' => 'required|exists:jenis_sampahs,id',
            'berat' => 'required|numeric|min:0.01',
            'alamat' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'status' => 'nullable|in:pending,selesai,batal',
        ]);

        $jenisSampah = JenisSampah::findOrFail($request->jenis_sampah_id);
        $totalHarga = $request->berat * $jenisSampah->harga_per_kg;

        // Update poin jika berat berubah
        if ($transaksi->berat != $request->berat) {
            $pelanggan = Pelanggan::find($transaksi->pelanggan_id);
            $pelanggan->decrement('poin', (int) $transaksi->berat);
            $pelanggan->increment('poin', (int) $request->berat);
        }

        $transaksi->update([
            'pelanggan_id' => $request->pelanggan_id,
            'jenis_sampah_id' => $request->jenis_sampah_id,
            'berat' => $request->berat,
            'total_harga' => $totalHarga,
            'alamat' => $request->alamat,
            'tanggal' => $request->tanggal ?? $transaksi->tanggal,
            'status' => $request->status ?? $transaksi->status,
        ]);

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        // Kurangi poin jika transaksi dihapus (jika status selesai atau pending?)
        if ($transaksi->status != 'batal') {
            $pelanggan = Pelanggan::find($transaksi->pelanggan_id);
            $pelanggan->decrement('poin', (int) $transaksi->berat);
        }
        $transaksi->delete();
        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
    }

    /**
     * Verify transaksi (ubah status menjadi selesai)
     */
    public function verify($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update(['status' => 'selesai']);
        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil diverifikasi!');
    }

        /**
     * Approve a transaksi and add points to the pelanggan.
     */
public function approve(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:disetujui,ditolak',
        'berat_akhir' => 'nullable|numeric|min:0',
    ]);

    $transaksi = Transaksi::with('pelanggan')->findOrFail($id);

    // Cegah double approve
    if ($transaksi->status === 'disetujui' || $transaksi->status === 'approved') {
        return back()->with('error', 'Transaksi ini sudah diproses.');
    }

    DB::beginTransaction();

    try {
        // Jika admin ubah berat
        if ($request->has('berat_akhir')) {
            $transaksi->berat = $request->berat_akhir;
        }

        // ✅ PASTIKAN STATUS DISET
        $transaksi->status = $request->status; // 'disetujui' atau 'ditolak'

        // Jika disetujui, tambahkan poin
        if ($transaksi->status === 'disetujui') {
            $poinPerKg = 10;
            $poinDidapat = $transaksi->berat * $poinPerKg;

            $pelanggan = $transaksi->pelanggan;
            $pelanggan->poin += $poinDidapat;
            $pelanggan->save();

            $transaksi->poin_didapat = $poinDidapat;
        }

        $transaksi->save();

        DB::commit();

        return redirect()->route('admin.pelanggan.show', $transaksi->pelanggan_id)
                         ->with('success', 'Transaksi berhasil diproses.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal: ' . $e->getMessage());
    }
}        

}