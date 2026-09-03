<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('transaksi_jenis_sampah')) {
            Schema::create('transaksi_jenis_sampah', function (Blueprint $table) {

                $table->id();

                $table->foreignId('transaksi_id')
                    ->constrained('transaksis')
                    ->cascadeOnDelete();

                $table->foreignId('jenis_sampah_id')
                    ->constrained('jenis_sampahs')
                    ->cascadeOnDelete();

                $table->decimal('berat_estimasi', 10, 2)
                    ->default(0);

                $table->decimal('berat_aktual', 10, 2)
                    ->default(0);

                $table->timestamps();

                $table->unique([
                    'transaksi_id',
                    'jenis_sampah_id'
                ]);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_jenis_sampah');
    }
};