<?php

namespace App\Helpers;

use App\Models\RiwayatPoin;
use App\Models\User;

class PoinHelper
{
    public static function catat(
        User $user,
        int $jumlah,
        string $jenis,
        ?string $deskripsi = null,
        $referensi = null
    ) {
        $saldoSebelumnya = $user->points ?? 0;
        $saldoSetelah = $saldoSebelumnya + $jumlah;

        $user->points = $saldoSetelah;
        $user->save();

        return RiwayatPoin::create([
            'user_id' => $user->id,
            'jumlah' => $jumlah,
            'jenis' => $jenis,
            'deskripsi' => $deskripsi,
            'saldo_sebelumnya' => $saldoSebelumnya,
            'saldo_setelah' => $saldoSetelah,
            'referensi_id' => $referensi ? $referensi->id : null,
            'referensi_type' => $referensi ? get_class($referensi) : null,
        ]);
    }
}