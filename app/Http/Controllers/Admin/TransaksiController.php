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

        if ($request->has('pelanggan_id') && $request->pelanggan_id != '') {
            $query->where('pelanggan_id', $request->pelanggan_id);
        }

        $transaksis = $query->orderBy('id', 'desc')->paginate(15);
        $transaksis->appends($request->query());

        return view('admin.transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        $jenisSampahs = JenisSampah::all();
        return view('admin.transaksi.create', compact('pelanggans', 'jenisSampahs'));
    }

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

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'jenisSampah'])->findOrFail($id);
        return view('admin.pelanggan.show', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $pelanggans = Pelanggan::all();
        $jenisSampahs = JenisSampah::all();
        return view('admin.transaksi.edit', compact('transaksi', 'pelanggans', 'jenisSampahs'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'jenis_sampah_id' => 'required|exists:jenis_sampahs,id',
            'berat' => 'required|numeric|min:0.01',
            'alamat' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'status' => 'nullable|in:pending,approved,rejected,completed,cancelled',
        ]);

        $jenisSampah = JenisSampah::findOrFail($request->jenis_sampah_id);
        $totalHarga = $request->berat * $jenisSampah->harga_per_kg;

        // Update poin jika berat berubah
        if ($transaksi->berat != $request->berat) {
            $pelanggan = Pelanggan::find($transaksi->pelanggan_id);
            $pelanggan->decrement('poin', (int) $transaksi->berat * 10);
            $pelanggan->increment('poin', (int) $request->berat * 10);
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

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        // Kurangi poin jika transaksi dihapus
        if (in_array($transaksi->status, ['approved', 'completed'])) {
            $pelanggan = Pelanggan::find($transaksi->pelanggan_id);
            $pelanggan->decrement('poin', (int) ($transaksi->berat * 10));
        }
        $transaksi->delete();
        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
    }

    public function verify($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update(['status' => 'completed']);
        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil diverifikasi!');
    }

    /**
     * Approve a transaksi (setujui setoran) - menggunakan berat akhir dari input admin
     */
    public function approve(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Cegah double approve
        if (!in_array($transaksi->status, ['pending', 'waiting'])) {
            return back()->with('error', 'Transaksi sudah diproses sebelumnya.');
        }

        $request->validate([
            'berat_akhir' => 'required|numeric|min:0.01',
        ]);

        DB::beginTransaction();
        try {
            // Update berat akhir sesuai input admin
            $beratAkhir = (float) $request->berat_akhir;
            $transaksi->berat = $beratAkhir;
            $transaksi->berat_aktual = $beratAkhir;

            // Ubah status menjadi 'completed' agar poin terhitung di dashboard user
            $transaksi->status = 'completed';
            $transaksi->save();

            // Tambah poin ke pelanggan (1 kg = 10 poin)
            $pelanggan = $transaksi->pelanggan;
            if ($pelanggan) {
                $poin = (int) floor($beratAkhir * 10);
                $pelanggan->poin += $poin;
                $pelanggan->save();
            }

            DB::commit();

            return redirect()->route('admin.pelanggan.show', $transaksi->pelanggan_id)
                             ->with('success', 'Setoran berhasil disetujui! Berat akhir: ' . number_format($beratAkhir, 2) . ' kg, Poin: ' . $poin);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyetujui setoran: ' . $e->getMessage());
        }
    }

    /**
     * Reject a transaksi (tolak setoran)
     */
    public function reject(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if (!in_array($transaksi->status, ['pending', 'waiting'])) {
            return back()->with('error', 'Transaksi sudah diproses sebelumnya.');
        }

        $transaksi->status = 'rejected';
        $transaksi->save();

        return redirect()->route('admin.pelanggan.show', $transaksi->pelanggan_id)
                         ->with('success', 'Setoran ditolak.');
    }
}