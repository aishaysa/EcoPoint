<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('transaksis', 'berat_aktual')) {

            Schema::table('transaksis', function (Blueprint $table) {
                $table->decimal('berat_aktual', 10, 2)
                    ->default(0)
                    ->after('titik_kumpul_id');
            });

        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('transaksis', 'berat_aktual')) {

            Schema::table('transaksis', function (Blueprint $table) {
                $table->dropColumn('berat_aktual');
            });

        }
    }
};