<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Tambah kolom poin_didapat jika belum ada
            if (!Schema::hasColumn('transaksis', 'poin_didapat')) {
                $table->integer('poin_didapat')->nullable()->after('berat');
            }

            // Ubah status menjadi VARCHAR(20) agar muat 'disetujui', 'ditolak', dll.
            // Jika sebelumnya ENUM, ini akan mengubahnya
            $table->string('status', 20)->default('pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn('poin_didapat');
            // Kembalikan status ke tipe semula jika diperlukan (opsional)
            // $table->enum('status', ['pending', 'approved', 'completed', 'rejected'])->change();
        });
    }
};