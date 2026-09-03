<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | TAMBAH KOLOM YANG BELUM ADA
        |--------------------------------------------------------------------------
        */

        Schema::table('transaksis', function (Blueprint $table) {

            if (!Schema::hasColumn('transaksis', 'nama_pengirim')) {
                $table->string('nama_pengirim', 255)
                    ->nullable()
                    ->after('jenis_sampah_id');
            }

            if (!Schema::hasColumn('transaksis', 'no_hp')) {
                $table->string('no_hp', 15)
                    ->nullable()
                    ->after('nama_pengirim');
            }

            if (!Schema::hasColumn('transaksis', 'metode')) {
                $table->enum('metode', [
                    'jemput',
                    'antar'
                ])
                ->default('jemput')
                ->after('no_hp');
            }

            if (!Schema::hasColumn('transaksis', 'alamat_jemput')) {
                $table->text('alamat_jemput')
                    ->nullable()
                    ->after('metode');
            }

            if (!Schema::hasColumn('transaksis', 'latitude')) {
                $table->decimal('latitude', 10, 8)
                    ->nullable()
                    ->after('alamat_jemput');
            }

            if (!Schema::hasColumn('transaksis', 'longitude')) {
                $table->decimal('longitude', 11, 8)
                    ->nullable()
                    ->after('latitude');
            }

        });


        /*
        |--------------------------------------------------------------------------
        | UBAH STATUS
        |--------------------------------------------------------------------------
        |
        | Struktur lama:
        | pending, selesai, batal
        |
        | Struktur yang sekarang dipakai controller:
        | pending, approved, completed, rejected
        |
        */

        DB::statement("
            ALTER TABLE transaksis
            MODIFY status ENUM(
                'pending',
                'approved',
                'completed',
                'rejected'
            )
            NOT NULL DEFAULT 'pending'
        ");


        /*
        |--------------------------------------------------------------------------
        | KETERSEDIAAN KOLOM LAMA
        |--------------------------------------------------------------------------
        |
        | Kolom lama tetap dipertahankan agar data lama
        | tidak langsung hilang.
        |
        */
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | HAPUS KOLOM YANG DITAMBAHKAN
        |--------------------------------------------------------------------------
        */

        Schema::table('transaksis', function (Blueprint $table) {

            $columns = [];

            foreach ([
                'nama_pengirim',
                'no_hp',
                'metode',
                'alamat_jemput',
                'latitude',
                'longitude',
            ] as $column) {

                if (Schema::hasColumn('transaksis', $column)) {
                    $columns[] = $column;
                }
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });


        /*
        |--------------------------------------------------------------------------
        | KEMBALIKAN STATUS LAMA
        |--------------------------------------------------------------------------
        */

        DB::statement("
            ALTER TABLE transaksis
            MODIFY status ENUM(
                'pending',
                'selesai',
                'batal'
            )
            NOT NULL DEFAULT 'pending'
        ");
    }
};