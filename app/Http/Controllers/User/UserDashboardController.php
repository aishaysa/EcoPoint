<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\JenisSampah;
use App\Models\Pelanggan;
use App\Models\TitikKumpul;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    /**
     * ============================================================
     * HOME
     * ============================================================
     */
    public function home()
    {
        return view('user.home');
    }


    /**
     * ============================================================
     * DASHBOARD
     * ============================================================
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('user.login');
        }


        $pelanggan = $this->getOrCreatePelanggan($user);


        $transaksi = Transaksi::where(
            'pelanggan_id',
            $pelanggan->id
        )
            ->with([
                'jenisSampahs',
                'titikKumpul',
            ])
            ->latest()
            ->get();


        $poin = $pelanggan->poin ?? 0;


        return view(
            'user.home',
            compact(
                'user',
                'pelanggan',
                'transaksi',
                'poin'
            )
        );
    }


    /**
     * ============================================================
     * HALAMAN SETORAN
     * ============================================================
     */
    public function setoran()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('user.login');
        }


        $pelanggan =
            $this->getOrCreatePelanggan($user);


        /*
         * ========================================================
         * DAFTAR TRANSAKSI
         * ========================================================
         */
        $transaksis = Transaksi::where(
            'pelanggan_id',
            $pelanggan->id
        )
            ->with([
                'pelanggan',
                'jenisSampahs',
                'titikKumpul',
            ])
            ->latest()
            ->paginate(9)
            ->withQueryString();


        /*
         * ========================================================
         * SEMUA TRANSAKSI UNTUK STATISTIK
         * ========================================================
         */
        $allTransaksi = Transaksi::where(
            'pelanggan_id',
            $pelanggan->id
        )
            ->with('jenisSampahs')
            ->get();


        /*
         * TOTAL SETORAN
         */
        $totalSetoran =
            $allTransaksi->count();


        /*
         * ========================================================
         * TOTAL BERAT
         * ========================================================
         *
         * Prioritas:
         * 1. berat aktual pada pivot
         * 2. berat estimasi pada pivot
         * 3. kolom berat pada transaksi
         */
        $totalBerat = 0;


        foreach ($allTransaksi as $transaksi) {

            /*
             * Kalau ada data pada pivot.
             */
            if ($transaksi->jenisSampahs->count() > 0) {

                foreach (
                    $transaksi->jenisSampahs
                    as $sampah
                ) {

                    $beratAktual =
                        (float) (
                            $sampah->pivot->berat_aktual
                            ?? 0
                        );


                    $beratEstimasi =
                        (float) (
                            $sampah->pivot->berat_estimasi
                            ?? 0
                        );


                    $totalBerat +=
                        $beratAktual > 0
                        ? $beratAktual
                        : $beratEstimasi;
                }

            } else {

                /*
                 * Fallback untuk transaksi lama.
                 */
                $totalBerat +=
                    (float) (
                        $transaksi->berat
                        ?? 0
                    );
            }
        }


        /*
         * ========================================================
         * TOTAL POIN
         * ========================================================
         */
        $totalPoin = 0;


        foreach ($allTransaksi as $transaksi) {

            /*
             * Hanya transaksi selesai.
             */
            if (
                $transaksi->status !== 'completed'
            ) {
                continue;
            }


            /*
             * Kalau ada pivot.
             */
            if ($transaksi->jenisSampahs->count() > 0) {

                foreach (
                    $transaksi->jenisSampahs
                    as $sampah
                ) {

                    $beratAktual =
                        (float) (
                            $sampah->pivot->berat_aktual
                            ?? 0
                        );


                    $totalPoin +=
                        floor(
                            $beratAktual * 10
                        );
                }

            } else {

                /*
                 * Fallback transaksi lama.
                 */
                $beratAktual =
                    (float) (
                        $transaksi->berat_aktual
                        ?? 0
                    );


                $totalPoin +=
                    floor(
                        $beratAktual * 10
                    );
            }
        }


        return view(
            'user.setoran.index',
            compact(
                'transaksis',
                'totalSetoran',
                'totalBerat',
                'totalPoin'
            )
        );
    }


    /**
     * ============================================================
     * FORM SETORAN BARU
     * ============================================================
     */
    public function createTransaksi()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('user.login');
        }


        /*
         * Jenis sampah dari database.
         */
        $jenisSampahs =
            JenisSampah::orderBy(
                'nama'
            )->get();


        /*
         * Titik kumpul dari database.
         * Hanya yang aktif.
         */
        $titikKumpuls = TitikKumpul::where('is_active', true)
            ->orderBy('nama')
            ->get();


        /*
         * Cabang dari database.
         */
        $cabangs =
            Cabang::orderBy(
                'nama'
            )->get();


        /*
         * Koordinat awal peta.
         */
        $centerLat =
            -0.2154;

        $centerLng =
            100.4147;


        /*
         * Hitung jarak cabang.
         */
        foreach (
            $cabangs as $cabang
        ) {

            if (
                $cabang->latitude !== null &&
                $cabang->longitude !== null
            ) {

                $cabang->jarak =
                    $this->haversine(
                        $centerLat,
                        $centerLng,
                        $cabang->latitude,
                        $cabang->longitude
                    );

            } else {

                $cabang->jarak = null;
            }
        }


        return view(
            'user.transaksi.create',
            compact(
                'jenisSampahs',
                'titikKumpuls',
                'cabangs',
                'centerLat',
                'centerLng'
            )
        );
    }


    /**
     * ============================================================
     * SIMPAN TRANSAKSI
     * ============================================================
     */
    public function storeTransaksi(
        Request $request
    ) {

        /*
         * ========================================================
         * VALIDASI
         * ========================================================
         */
        $request->validate(
            [

                'nama_pengirim' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'no_hp' => [
                    'required',
                    'string',
                    'min:10',
                    'max:15',
                ],

                'metode' => [
                    'required',
                    'in:jemput,antar',
                ],

                'alamat_jemput' => [
                    'required_if:metode,jemput',
                    'nullable',
                    'string',
                ],

                'latitude' => [
                    'required_if:metode,jemput',
                    'nullable',
                    'numeric',
                ],

                'longitude' => [
                    'required_if:metode,jemput',
                    'nullable',
                    'numeric',
                ],

                'titik_kumpul_id' => [
                    'required_if:metode,antar',
                    'nullable',
                    'exists:titik_kumpuls,id', // <-- PERBAIKAN: tabelnya plural
                ],

                'jenis_sampah_data' => [
                    'required',
                    'array',
                    'min:1',
                ],

                'jenis_sampah_data.*' => [
                    'required',
                    'numeric',
                    'min:0.1',
                ],

            ],
            [

                'nama_pengirim.required' =>
                    'Nama pengirim wajib diisi.',

                'no_hp.required' =>
                    'Nomor HP wajib diisi.',

                'no_hp.min' =>
                    'Nomor HP minimal 10 digit.',

                'no_hp.max' =>
                    'Nomor HP maksimal 15 digit.',

                'metode.required' =>
                    'Silakan pilih metode setoran.',

                'alamat_jemput.required_if' =>
                    'Alamat jemput wajib diisi.',

                'latitude.required_if' =>
                    'Lokasi jemput wajib dipilih.',

                'longitude.required_if' =>
                    'Lokasi jemput wajib dipilih.',

                'titik_kumpul_id.required_if' =>
                    'Silakan pilih titik kumpul.',

                'titik_kumpul_id.exists' =>
                    'Titik kumpul tidak ditemukan.',

                'jenis_sampah_data.required' =>
                    'Pilih minimal satu jenis sampah.',

                'jenis_sampah_data.min' =>
                    'Pilih minimal satu jenis sampah.',

                'jenis_sampah_data.*.numeric' =>
                    'Berat sampah harus berupa angka.',

                'jenis_sampah_data.*.min' =>
                    'Berat minimal 0.1 kg.',

            ]
        );


        /*
         * ========================================================
         * USER
         * ========================================================
         */
        $user = Auth::user();


        if (!$user) {
            return redirect()->route('user.login');
        }


        /*
         * ========================================================
         * PELANGGAN
         * ========================================================
         */
        $pelanggan =
            $this->getOrCreatePelanggan(
                $user,
                $request->no_hp,
                $request->alamat_jemput
            );


        /*
         * ========================================================
         * FILTER JENIS SAMPAH
         * ========================================================
         */
        $jenisSampahDipilih =
            collect(
                $request->jenis_sampah_data
            )
            ->filter(
                function ($berat) {

                    return (float) $berat > 0;
                }
            );


        /*
         * Tidak boleh kosong.
         */
        if (
            $jenisSampahDipilih->isEmpty()
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Pilih minimal satu jenis sampah.'
                );
        }


        /*
         * ========================================================
         * TOTAL BERAT ESTIMASI
         * ========================================================
         */
        $totalBeratEstimasi =
            $jenisSampahDipilih->sum(
                function ($berat) {

                    return (float) $berat;
                }
            );


        /*
         * ========================================================
         * JENIS SAMPAH UTAMA
         * ========================================================
         *
         * Karena transaksis masih mempunyai
         * jenis_sampah_id yang wajib,
         * gunakan pilihan pertama sebagai jenis utama.
         */
        $jenisSampahUtamaId =
            (int) $jenisSampahDipilih
                ->keys()
                ->first();


        /*
         * Pastikan jenis sampah ada.
         */
        $jenisSampahUtama =
            JenisSampah::find(
                $jenisSampahUtamaId
            );


        if (!$jenisSampahUtama) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Jenis sampah tidak ditemukan.'
                );
        }


        /*
         * ========================================================
         * TRANSACTION DATABASE
         * ========================================================
         */
        DB::beginTransaction();


        try {

            /*
             * ====================================================
             * SIMPAN TRANSAKSI UTAMA
             * ====================================================
             */
            $transaksi =
                Transaksi::create([

                    /*
                     * Tidak memakai user_id
                     * karena kolom tersebut tidak ada.
                     */
                    'pelanggan_id' =>
                        $pelanggan->id,


                    /*
                     * Jenis utama.
                     */
                    'jenis_sampah_id' =>
                        $jenisSampahUtamaId,


                    /*
                     * DATA PENGIRIM
                     */
                    'nama_pengirim' =>
                        $request->nama_pengirim,


                    'no_hp' =>
                        $request->no_hp,


                    /*
                     * METODE
                     */
                    'metode' =>
                        $request->metode,


                    /*
                     * ALAMAT JEMPUT
                     */
                    'alamat_jemput' =>
                        $request->metode === 'jemput'
                            ? $request->alamat_jemput
                            : null,


                    /*
                     * KOORDINAT
                     */
                    'latitude' =>
                        $request->metode === 'jemput'
                            ? $request->latitude
                            : null,


                    'longitude' =>
                        $request->metode === 'jemput'
                            ? $request->longitude
                            : null,


                    /*
                     * TITIK KUMPUL
                     */
                    'titik_kumpul_id' =>
                        $request->metode === 'antar'
                            ? $request->titik_kumpul_id
                            : null,


                    /*
                     * BERAT ESTIMASI TOTAL
                     */
                    'berat' =>
                        $totalBeratEstimasi,


                    /*
                     * BERAT AKTUAL
                     */
                    'berat_aktual' =>
                        0,


                    /*
                     * HARGA
                     */
                    'total_harga' =>
                        0,


                    /*
                     * STATUS
                     */
                    'status' =>
                        'pending',


                    /*
                     * TANGGAL
                     */
                    'tanggal' =>
                        now()->toDateString(),


                    /*
                     * ALAMAT LAMA (untuk kompatibilitas)
                     */
                    'alamat' =>
                        $request->metode === 'jemput'
                            ? $request->alamat_jemput
                            : null,

                ]);


            /*
             * ====================================================
             * SIMPAN DETAIL JENIS SAMPAH KE PIVOT
             * ====================================================
             */
            foreach (
                $jenisSampahDipilih
                as $jenisId => $berat
            ) {

                $berat =
                    (float) $berat;


                if ($berat <= 0) {
                    continue;
                }


                $transaksi
                    ->jenisSampahs()
                    ->attach(

                        $jenisId,

                        [

                            'berat_estimasi' =>
                                $berat,

                            'berat_aktual' =>
                                0,

                        ]

                    );
            }


            /*
             * ====================================================
             * UPDATE PELANGGAN
             * ====================================================
             */
            $pelanggan->no_hp =
                $request->no_hp;


            if (
                $request->metode === 'jemput' &&
                $request->filled('alamat_jemput')
            ) {

                $pelanggan->alamat =
                    $request->alamat_jemput;
            }


            $pelanggan->save();


            /*
             * ====================================================
             * COMMIT
             * ====================================================
             */
            DB::commit();


            /*
             * ====================================================
             * REDIRECT
             * ====================================================
             */
            return redirect()
                ->route('user.setoran')
                ->with(
                    'success',
                    'Setoran berhasil diajukan.'
                );


        } catch (\Throwable $e) {

            /*
             * ====================================================
             * ROLLBACK
             * ====================================================
             */
            DB::rollBack();


            return back()
                ->withInput()
                ->with(
                    'error',
                    'Setoran gagal disimpan: ' .
                    $e->getMessage()
                );
        }
    }


    /**
     * ============================================================
     * DETAIL TRANSAKSI
     * ============================================================
     */
    public function transaksiDetail($id)
    {
        $user = Auth::user();


        if (!$user) {
            return redirect()->route('user.login');
        }


        $pelanggan =
            $this->getOrCreatePelanggan(
                $user
            );


        $transaksi =
            Transaksi::with([
                'pelanggan',
                'jenisSampahs',
                'titikKumpul',
            ])
            ->where(
                'pelanggan_id',
                $pelanggan->id
            )
            ->findOrFail($id);


        return view(
            'user.setoran.detail',
            compact('transaksi')
        );
    }


    /**
     * ============================================================
     * TRANSAKSI
     * ============================================================
     */
    public function transaksi()
    {
        return $this->setoran();
    }


    /**
     * ============================================================
     * CETAK TRANSAKSI
     * ============================================================
     */
    public function cetakTransaksi($id)
    {
        $user = Auth::user();


        if (!$user) {
            return redirect()->route('user.login');
        }


        $pelanggan =
            $this->getOrCreatePelanggan(
                $user
            );


        $transaksi =
            Transaksi::with([
                'pelanggan',
                'jenisSampahs',
                'titikKumpul',
            ])
            ->where(
                'pelanggan_id',
                $pelanggan->id
            )
            ->findOrFail($id);


        return view(
            'user.transaksi.cetak',
            compact('transaksi')
        );
    }


    /**
     * ============================================================
     * CETAK PDF
     * ============================================================
     */
    public function cetakTransaksiPDF($id)
    {
        $user = Auth::user();


        if (!$user) {
            return redirect()->route('user.login');
        }


        $pelanggan =
            $this->getOrCreatePelanggan(
                $user
            );


        $transaksi =
            Transaksi::with([
                'pelanggan',
                'jenisSampahs',
                'titikKumpul',
            ])
            ->where(
                'pelanggan_id',
                $pelanggan->id
            )
            ->findOrFail($id);


        $pdf =
            Pdf::loadView(
                'user.transaksi.cetak-pdf',
                compact('transaksi')
            );


        return $pdf->download(
            'transaksi-' .
            $transaksi->id .
            '.pdf'
        );
    }


    /**
     * ============================================================
     * POIN
     * ============================================================
     */
    public function poin()
    {
        $user = Auth::user();


        if (!$user) {
            return redirect()->route('user.login');
        }


        $poin =
            $user->pelanggan?->poin ?? 0;


        return view(
            'user.poin',
            compact('poin')
        );
    }


    /**
     * ============================================================
     * PROFILE
     * ============================================================
     */
    public function profile()
    {
        $user = Auth::user();


        if (!$user) {
            return redirect()->route('user.login');
        }


        return view(
            'user.profile',
            compact('user')
        );
    }


    /**
     * ============================================================
     * EDIT PROFILE
     * ============================================================
     */
    public function editProfile()
    {
        $user = Auth::user();


        if (!$user) {
            return redirect()->route('user.login');
        }


        return view(
            'user.profile-edit',
            compact('user')
        );
    }


    /**
     * ============================================================
     * UPDATE PROFILE
     * ============================================================
     */
    public function updateProfile(
        Request $request
    ) {

        $user = Auth::user();


        if (!$user) {
            return redirect()->route('user.login');
        }


        $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'no_hp' => [
                'nullable',
                'string',
                'max:15',
            ],

            'alamat' => [
                'nullable',
                'string',
            ],

        ]);


        /*
         * USER
         */
        $user->name =
            $request->name;


        $user->email =
            $request->email;


        if (
            $request->has('no_hp')
        ) {

            $user->no_hp =
                $request->no_hp;
        }


        if (
            $request->has('alamat')
        ) {

            $user->alamat =
                $request->alamat;
        }


        $user->save();


        /*
         * PELANGGAN
         */
        $pelanggan =
            $user->pelanggan;


        if ($pelanggan) {

            $pelanggan->nama =
                $user->name;


            $pelanggan->email =
                $user->email;


            if (
                $request->has('no_hp')
            ) {

                $pelanggan->no_hp =
                    $request->no_hp;
            }


            if (
                $request->has('alamat')
            ) {

                $pelanggan->alamat =
                    $request->alamat;
            }


            $pelanggan->save();
        }


        return redirect()
            ->route('user.profile')
            ->with(
                'success',
                'Profil berhasil diperbarui.'
            );
    }


    /**
     * ============================================================
     * HELPER PELANGGAN
     * ============================================================
     */
    private function getOrCreatePelanggan(
        $user,
        ?string $noHp = null,
        ?string $alamat = null
    ) {

        $pelanggan =
            $user->pelanggan;


        if (!$pelanggan) {

            $pelanggan =
                Pelanggan::create([

                    'user_id' =>
                        $user->id,

                    'nama' =>
                        $user->name,

                    'email' =>
                        $user->email,

                    'password' =>
                        $user->password,

                    'no_hp' =>
                        $noHp ??
                        $user->no_hp ??
                        '',

                    'alamat' =>
                        $alamat ??
                        $user->alamat ??
                        '',

                    'poin' =>
                        0,

                ]);
        }


        return $pelanggan;
    }


    /**
     * ============================================================
     * HAVERSINE
     * ============================================================
     */
    private function haversine(
        $lat1,
        $lon1,
        $lat2,
        $lon2
    ) {

        $R = 6371;


        $dLat =
            deg2rad(
                $lat2 - $lat1
            );


        $dLon =
            deg2rad(
                $lon2 - $lon1
            );


        $a =
            sin($dLat / 2) *
            sin($dLat / 2) +

            cos(
                deg2rad($lat1)
            ) *

            cos(
                deg2rad($lat2)
            ) *

            sin($dLon / 2) *
            sin($dLon / 2);


        $c =
            2 *
            atan2(
                sqrt($a),
                sqrt(1 - $a)
            );


        return $R * $c;
    }
}