<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Tambahkan kolom poin_didapat (integer, nullable)
            $table->integer('poin_didapat')->nullable()->after('berat');
        });

        // Jika kolom poin di tabel pelanggan belum ada, tambahkan juga
        if (!Schema::hasColumn('pelanggans', 'poin')) {
            Schema::table('pelanggans', function (Blueprint $table) {
                $table->integer('poin')->default(0);
            });
        }
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn('poin_didapat');
        });
    }
};