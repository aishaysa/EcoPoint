<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\JenisSampah;
use App\Models\Pelanggan;
use App\Models\RiwayatPoin;
use App\Models\TitikKumpul;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\PoinHelper;

class UserDashboardController extends Controller
{
    public function home()
    {
        return view('user.home');
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('user.login');

        $pelanggan = $this->getOrCreatePelanggan($user);
        $transaksi = Transaksi::where('pelanggan_id', $pelanggan->id)->with(['jenisSampahs', 'titikKumpul'])->latest()->get();
        $poin = $pelanggan->poin ?? 0;

        return view('user.dashboard', compact('user', 'pelanggan', 'transaksi', 'poin'));
    }

    public function setoran()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('user.login');

        $pelanggan = $this->getOrCreatePelanggan($user);
        $transaksis = Transaksi::where('pelanggan_id', $pelanggan->id)
                                ->with(['pelanggan', 'jenisSampahs', 'titikKumpul'])
                                ->latest()
                                ->paginate(9)
                                ->withQueryString();

        $allTransaksi = Transaksi::where('pelanggan_id', $pelanggan->id)
                                  ->with('jenisSampahs')
                                  ->get();

        $totalSetoran = $allTransaksi->count();
        $totalBerat = $allTransaksi->sum('berat');

        $totalPoin = 0;
        foreach ($allTransaksi as $transaksi) {
            if (!in_array($transaksi->status, ['completed', 'approved'])) continue;
            $beratPoin = ($transaksi->berat_aktual > 0) ? $transaksi->berat_aktual : $transaksi->berat;
            $totalPoin += floor((float) $beratPoin * 10);
        }

        return view('user.setoran.index', compact('transaksis', 'totalSetoran', 'totalBerat', 'totalPoin'));
    }

    public function createTransaksi()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('user.login');

        $jenisSampahs = JenisSampah::orderBy('nama')->get();
        $titikKumpuls = TitikKumpul::orderBy('nama')->get();
        $cabangs = Cabang::orderBy('nama')->get();

        $centerLat = -0.2154;
        $centerLng = 100.4147;

        foreach ($cabangs as $cabang) {
            if ($cabang->latitude && $cabang->longitude) {
                $cabang->jarak = $this->haversine($centerLat, $centerLng, $cabang->latitude, $cabang->longitude);
            } else {
                $cabang->jarak = null;
            }
        }

        return view('user.transaksi.create', compact('jenisSampahs', 'titikKumpuls', 'cabangs', 'centerLat', 'centerLng'));
    }

    public function storeTransaksi(Request $request)
    {
        $request->validate([
            'nama_pengirim'   => ['required', 'string', 'max:255'],
            'no_hp'           => ['required', 'string', 'min:10', 'max:15'],
            'metode'          => ['required', 'in:jemput,antar'],
            'alamat_jemput'   => ['required_if:metode,jemput', 'nullable', 'string'],
            'latitude'        => ['required', 'numeric', 'between:-90,90'],
            'longitude'       => ['required', 'numeric', 'between:-180,180'],
            'jenis_sampah_data' => ['required', 'array', 'min:1'],
            'jenis_sampah_data.*' => ['required', 'numeric', 'min:0.1'],
        ], [
            'latitude.required' => 'Lokasi Anda wajib dipilih (gunakan peta atau tombol lokasi).',
            'longitude.required' => 'Lokasi Anda wajib dipilih.',
            'jenis_sampah_data.required' => 'Pilih minimal satu jenis sampah.',
            'jenis_sampah_data.*.min' => 'Berat minimal 0.1 kg.',
        ]);

        $titikKumpulId = $request->titik_kumpul_id;
        $titik = null;

        if ($titikKumpulId) {
            $titik = TitikKumpul::find($titikKumpulId);
        }

        if (!$titik) {
            $allTitik = TitikKumpul::all();
            $terdekat = null;
            $jarakTerdekat = PHP_INT_MAX;

            foreach ($allTitik as $t) {
                if ($t->latitude && $t->longitude) {
                    $jarak = $this->haversine($request->latitude, $request->longitude, $t->latitude, $t->longitude);
                    if ($jarak < $jarakTerdekat) {
                        $jarakTerdekat = $jarak;
                        $terdekat = $t;
                    }
                }
            }

            if ($terdekat && $jarakTerdekat <= 30) {
                $titik = $terdekat;
                $request->merge(['titik_kumpul_id' => $titik->id]);
            } else {
                return back()->withInput()->withErrors([
                    'titik_kumpul_id' => 'Tidak ada titik kumpul dalam radius 30 km dari lokasi Anda.'
                ]);
            }
        }

        $jarak = $this->haversine(
            $request->latitude,
            $request->longitude,
            $titik->latitude,
            $titik->longitude
        );

        if ($jarak > 30) {
            return back()->withInput()->withErrors([
                'titik_kumpul_id' => 'Jarak ke titik kumpul terlalu jauh (' . round($jarak, 2) . ' km). Maksimal 30 km.'
            ]);
        }

        $user = Auth::user();
        if (!$user) return redirect()->route('user.login');

        $pelanggan = $this->getOrCreatePelanggan($user, $request->no_hp, $request->alamat_jemput);

        $jenisSampahDipilih = collect($request->jenis_sampah_data)->filter(function ($berat) {
            return (float) $berat > 0;
        });

        if ($jenisSampahDipilih->isEmpty()) {
            return back()->withInput()->with('error', 'Pilih minimal satu jenis sampah.');
        }

        $totalBeratEstimasi = $jenisSampahDipilih->sum();

        $jenisSampahUtamaId = (int) $jenisSampahDipilih->keys()->first();
        $jenisSampahUtama = JenisSampah::find($jenisSampahUtamaId);
        if (!$jenisSampahUtama) {
            return back()->withInput()->with('error', 'Jenis sampah tidak ditemukan.');
        }

        DB::beginTransaction();

        try {
            $transaksi = Transaksi::create([
                'pelanggan_id'    => $pelanggan->id,
                'user_id'         => $user->id,
                'jenis_sampah_id' => $jenisSampahUtamaId,
                'nama_pengirim'   => $request->nama_pengirim,
                'no_hp'           => $request->no_hp,
                'metode'          => $request->metode,
                'alamat_jemput'   => $request->metode === 'jemput' ? $request->alamat_jemput : null,
                'latitude'        => $request->latitude,
                'longitude'       => $request->longitude,
                'titik_kumpul_id' => $titik->id,
                'berat'           => $totalBeratEstimasi,
                'total_harga'     => 0,
                'berat_aktual'    => 0,
                'status'          => 'pending',
                'tanggal'         => now()->toDateString(),
                'alamat'          => $request->metode === 'jemput' ? $request->alamat_jemput : null,
            ]);

            foreach ($jenisSampahDipilih as $jenisId => $berat) {
                $berat = (float) $berat;
                if ($berat <= 0) continue;
                $transaksi->jenisSampahs()->attach($jenisId, [
                    'berat_estimasi' => $berat,
                    'berat_aktual'   => 0,
                ]);
            }

            $pelanggan->no_hp = $request->no_hp;
            if ($request->metode === 'jemput' && $request->filled('alamat_jemput')) {
                $pelanggan->alamat = $request->alamat_jemput;
            }
            $pelanggan->save();

            DB::commit();

            return redirect()->route('user.setoran')->with('success', 'Setoran berhasil diajukan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Setoran gagal disimpan: ' . $e->getMessage());
        }
    }

    public function transaksiDetail($id)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('user.login');
        $pelanggan = $this->getOrCreatePelanggan($user);
        $transaksi = Transaksi::with(['pelanggan', 'jenisSampahs', 'titikKumpul'])->where('pelanggan_id', $pelanggan->id)->findOrFail($id);
        return view('user.setoran.detail', compact('transaksi'));
    }

    public function transaksi()
    {
        return $this->setoran();
    }

    public function cetakTransaksi($id)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('user.login');
        $pelanggan = $this->getOrCreatePelanggan($user);
        $transaksi = Transaksi::with(['pelanggan', 'jenisSampahs', 'titikKumpul'])->where('pelanggan_id', $pelanggan->id)->findOrFail($id);
        return view('user.transaksi.cetak', compact('transaksi'));
    }

    public function cetakTransaksiPDF($id)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('user.login');
        $pelanggan = $this->getOrCreatePelanggan($user);
        $transaksi = Transaksi::with(['pelanggan', 'jenisSampahs', 'titikKumpul'])->where('pelanggan_id', $pelanggan->id)->findOrFail($id);
        $pdf = Pdf::loadView('user.transaksi.cetak-pdf', compact('transaksi'));
        return $pdf->download('transaksi-' . $transaksi->id . '.pdf');
    }

    /**
     * HALAMAN POIN (RIWAYAT POIN)
     */
public function poin()
{
    $user = Auth::user();
    if (!$user) return redirect()->route('user.login');

    $riwayat = RiwayatPoin::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('user.poin', compact('riwayat'));
}
    public function riwayatPoin()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('user.login');

        $riwayat = RiwayatPoin::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('user.riwayat-poin', compact('riwayat'));
    }

    public function detailPoin($id)
{
    $user = Auth::user();
    if (!$user) return redirect()->route('user.login');

    $riwayat = RiwayatPoin::where('user_id', $user->id)
        ->where('id', $id)
        ->firstOrFail();

    return view('user.poin-detail', compact('riwayat'));
}

    public function profile()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('user.login');
        return view('user.profile', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('user.login');
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('user.login');
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:15'],
            'alamat' => ['nullable', 'string'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->has('no_hp')) $user->no_hp = $request->no_hp;
        if ($request->has('alamat')) $user->alamat = $request->alamat;
        $user->save();

        $pelanggan = $user->pelanggan;
        if ($pelanggan) {
            $pelanggan->nama = $user->name;
            $pelanggan->email = $user->email;
            if ($request->has('no_hp')) $pelanggan->no_hp = $request->no_hp;
            if ($request->has('alamat')) $pelanggan->alamat = $request->alamat;
            $pelanggan->save();
        }

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    private function getOrCreatePelanggan($user, ?string $noHp = null, ?string $alamat = null)
    {
        $pelanggan = $user->pelanggan;
        if (!$pelanggan) {
            $pelanggan = Pelanggan::create([
                'user_id'  => $user->id,
                'nama'     => $user->name,
                'email'    => $user->email,
                'password' => $user->password,
                'no_hp'    => $noHp ?? $user->no_hp ?? '',
                'alamat'   => $alamat ?? $user->alamat ?? '',
                'poin'     => 0,
            ]);
        }
        return $pelanggan;
    }

    private function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $R * $c;
    }
}