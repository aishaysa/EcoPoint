<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            // Tambahkan kolom package_id
            if (!Schema::hasColumn('withdrawals', 'package_id')) {
                $table->foreignId('package_id')->nullable()->constrained('exchange_packages')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
            $table->dropColumn('package_id');
        });
    }
};