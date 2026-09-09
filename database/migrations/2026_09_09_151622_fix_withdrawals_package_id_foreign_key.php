<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('withdrawals', function (Blueprint $table) {
        // Hapus foreign key constraint yang salah
        $table->dropForeign(['package_id']);
        // Tambahkan ulang dengan referensi ke withdraw_packages
        $table->foreign('package_id')->references('id')->on('withdraw_packages')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('withdrawals', function (Blueprint $table) {
        $table->dropForeign(['package_id']);
        $table->foreign('package_id')->references('id')->on('exchange_packages')->onDelete('set null');
    });
}
};
