<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('setoran', function (Blueprint $table) {
            // Tambahkan kolom yang dibutuhkan
            $table->foreignId('jenis_sampah_id')
                  ->nullable()
                  ->after('pelanggan_id')
                  ->constrained('jenis_sampahs')
                  ->onDelete('set null');

            $table->decimal('berat', 10, 2)->default(0)->after('jenis_sampah_id');
            $table->decimal('total_harga', 12, 2)->default(0)->after('berat');
            $table->date('tanggal')->nullable()->after('total_harga');
            $table->text('alamat')->nullable()->after('tanggal');
        });
    }

    public function down(): void
    {
        Schema::table('setoran', function (Blueprint $table) {
            $table->dropForeign(['jenis_sampah_id']);
            $table->dropColumn(['jenis_sampah_id', 'berat', 'total_harga', 'tanggal', 'alamat']);
        });
    }
};