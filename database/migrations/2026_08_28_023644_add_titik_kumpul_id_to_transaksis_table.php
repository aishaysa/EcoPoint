<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('transaksis', 'titik_kumpul_id')) {

            Schema::table('transaksis', function (Blueprint $table) {
                $table->foreignId('titik_kumpul_id')
                    ->nullable()
                    ->after('longitude')
                    ->constrained('titik_kumpul')
                    ->nullOnDelete();
            });

        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('transaksis', 'titik_kumpul_id')) {

            Schema::table('transaksis', function (Blueprint $table) {
                $table->dropForeign([
                    'titik_kumpul_id'
                ]);

                $table->dropColumn(
                    'titik_kumpul_id'
                );
            });

        }
    }
};