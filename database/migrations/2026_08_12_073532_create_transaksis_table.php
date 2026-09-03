<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ============================================================
     * CREATE TABLE TRANSAKSIS
     * ============================================================
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {

            /*
             * ID
             */
            $table->id();


            /*
             * PELANGGAN
             *
             * Setiap transaksi dimiliki oleh satu pelanggan.
             */
            $table->foreignId('pelanggan_id')
                ->constrained('pelanggans')
                ->cascadeOnDelete();


            /*
             * JENIS SAMPAH UTAMA
             *
             * Karena struktur database kamu masih
             * mewajibkan jenis_sampah_id.
             */
            $table->foreignId('jenis_sampah_id')
                ->constrained('jenis_sampahs')
                ->cascadeOnDelete();


            /*
             * DATA PENGIRIM
             */
            $table->string('nama_pengirim', 255);

            $table->string('no_hp', 15);


            /*
             * METODE SETORAN
             *
             * jemput = petugas mengambil
             * antar  = user mengantar ke titik kumpul
             */
            $table->enum('metode', [
                'jemput',
                'antar',
            ])->default('jemput');


            /*
             * ALAMAT PENJEMPUTAN
             */
            $table->text('alamat_jemput')
                ->nullable();


            /*
             * KOORDINAT
             */
            $table->decimal('latitude', 10, 8)
                ->nullable();

            $table->decimal('longitude', 11, 8)
                ->nullable();


            /*
             * TITIK KUMPUL
             *
             * Hanya digunakan ketika metode = antar.
             */
            $table->foreignId('titik_kumpul_id')
                ->nullable()
                ->constrained('titik_kumpul')
                ->nullOnDelete();


            /*
             * BERAT AKTUAL
             *
             * Diisi ketika petugas sudah menimbang.
             */
            $table->decimal('berat_aktual', 10, 2)
                ->default(0);


            /*
             * TOTAL HARGA
             */
            $table->decimal('total_harga', 12, 2)
                ->default(0);


            /*
             * STATUS
             *
             * HANYA SATU status.
             */
            $table->enum('status', [
                'pending',
                'approved',
                'completed',
                'rejected',
            ])->default('pending');


            /*
             * TANGGAL TRANSAKSI
             *
             * Tetap disediakan untuk kompatibilitas
             * dengan data / fitur lama.
             */
            $table->date('tanggal')
                ->nullable();


            /*
             * ALAMAT LAMA
             *
             * Dipertahankan agar kode lama
             * tidak langsung rusak.
             */
            $table->text('alamat')
                ->nullable();


            /*
             * BERAT LAMA
             *
             * Dibuat nullable karena berat utama
             * sekarang disimpan di pivot / berat_aktual.
             */
            $table->decimal('berat', 10, 2)
                ->nullable();


            /*
             * TIMESTAMPS
             */
            $table->timestamps();
        });
    }


    /**
     * ============================================================
     * DROP TABLE
     * ============================================================
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};